<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
//REQUEST
use App\Http\Requests\CreateSubcircuitRequest;
use App\Http\Requests\UpdateSubcircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\MaintenanceFormRequest;
use App\Http\Requests\MaintenanceOrderStartRequest;
use App\Http\Requests\MaintenanceOrderEndRequest;
//NOTIFICATION
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\RequestVehicleMailAlert;
use App\Notifications\Maintenance\RegisterMaintenanceReport;
//RESOURCES
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\MaintenanceCollection;
use App\Http\Resources\UserResourcePreview;
use App\Http\Resources\VehicleResourcePreview;
use App\Http\Resources\DependencePreviewResource;
use App\Http\Resources\MaintenanceResource;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\SubcircuitResource;
//MODELS
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\User;
use App\Models\WorkingCalendar;
use App\Models\Maintenance;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\MaintenanceType;
use App\Models\Contract;
use App\Models\RecordStartMaintenance;
use App\Models\RecordEndMaintenance;
//HELPERS
use App\Helpers\StatusHelper;


class MaintenanceController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:maintenance.index')->only('index');
        $this->middleware('can:maintenance.create')->only('create');
        $this->middleware('can:maintenance.store')->only('store');
        $this->middleware('can:maintenance.show')->only('show');
        $this->middleware('can:maintenance.edit')->only('edit');
        $this->middleware('can:maintenance.update')->only('update');
        $this->middleware('can:maintenance.destroy')->only('destroy');
        $this->middleware('can:maintenance.manager')->only('storeOrderStart');
        $this->middleware('can:maintenance.manager')->only('finishOrderJob');
        $this->middleware('can:maintenance.manager')->only('storeOrderEnd');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $user = Auth::user();
        $p_maintenance = Maintenance::userManager($user)->info()->searchBar($request->only('key','value','filter'))->progressing()->paginate(10);
        $f_maintenance = Maintenance::userManager($user)->info()->searchBar($request->only('key','value','filter'))->finished()->paginate(10);
        $t_progress = Maintenance::where('user_id',$user->id)->progressing()->count();

        return Inertia::render('Maintenance/Index',[ 
            'vehicleUser'   => $user->vehicles ?? [],
            'p_maintenance' => new MaintenanceCollection($p_maintenance),
            'f_maintenance' => new MaintenanceCollection($f_maintenance),
            'filters'       => $request->all('key','value','filter'),
            't_progress'    => $t_progress, 
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function reqVehicle(Request $request)
    {   

        $user =  User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'Administrador')->toArray()
        );

        Notification::sendNow($user, new RequestVehicleMailAlert($request->user()));
        return to_route('maintenance.index')->with('success', 'Se ha notificado al encargado con éxito');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $shifts_available = [];
        $vehicle        = isset(Auth::user()->vehicles[0]) ? new VehicleResourcePreview(Auth::user()->vehicles[0]):  [];
        $dependence     = isset(Auth::user()->subcircuits[0]) ? new DependencePreviewResource(Auth::user()->subcircuits[0]) : [];
        $date_string    =  $request->only('filterDate');
        
        if(isset($date_string['filterDate']) && !empty($date_string['filterDate']))
        {
            $date           = Carbon::createFromFormat('Y-m-d', $date_string['filterDate']);
            $dayOfWeek      = $date->format('l');
            $work_days      = WorkingCalendar::isActive()->first()->calendar ?? null;  
            $maintenances   = Maintenance::shiftDate($date_string['filterDate'])->notRejected()->pluck('shift_time_range')->toArray();
            
            if(isset($work_days[$dayOfWeek])){
                foreach($work_days[$dayOfWeek] as $key => $shift_range){
                    $shift = (object)[];
                    $shift->range           = $shift_range;
                    $shift->is_available    = true;
                    if(count($maintenances) && in_array($shift_range,$maintenances)){
                        $shift->is_available = false;
                    }
                    array_push($shifts_available ,$shift);
                }
            }
        }
       
        return Inertia::render('Maintenance/Create',[ 
            'userInfo'          => new UserResourcePreview(Auth::user()),
            'vehicleInfo'       => $vehicle,
            'dependeceInfo'     => $dependence,
            'shiftsAvaliable'   => $shifts_available

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaintenanceFormRequest $request)
    {
        $user       = Auth::user();
        $user_id    = $user->id ?? 1;
        $vehicle_id = Auth::user()->vehicles[0]->id ?? 1;
        $range      = explode('-',$request->shift_range);
        $vehicle    = Vehicle::find($vehicle_id);
        $mileage    = $vehicle->mileage ?? 0;
        $dependence = $user->subcircuits[0] ?? [];

        $request->validate([
            'mileage' => ['gte:'.$mileage]
        ],[
            'mileage.gte' => 'El kilometrage debe ser superior al actual' 
        ]);

        $infoMaintenance = (object)[];
        $infoMaintenance->user          = $user;
        $infoMaintenance->vehicle       = $vehicle;
        $infoMaintenance->dependence    = $dependence;
        $infoMaintenance->maintenance   = $request->all();

        $admin_user =  User::with('roles')->get()->filter(
            fn ($admin_user) => $admin_user->roles->where('name', 'Administrador')->toArray()
        );

        //Send from email status maintenance in pdf
        Notification::sendNow($admin_user, new RegisterMaintenanceReport($infoMaintenance));
        
        $maintenance = Maintenance::create([
            'user_id'           => $user_id,
            'vehicle_id'        => $vehicle_id,
            'shift_date'        => $request->shift_date,
            'shift_time_from'   => trim($range[0]),
            'shift_time_to'     => trim($range[1]),
            'shift_time_range'  => $request->shift_range,
            'description'       => $request->details,
            'in_progress'       => true
        ]);

        $vehicle->update([
            'mileage' => $request->mileage
        ]);

        return to_route('maintenance.index')->with('success', 'La solicitud de mantenimiento se ha creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function storeOrderStart(MaintenanceOrderStartRequest $request)
    {
        $u_data         = User::byIdentification($request->identification)->first();
        $maintenance    = Maintenance::find($request->maintenance_id);
        $vehicle        = Vehicle::find($request->vehicle_id);

        $identification = strval($u_data->identification ?? 'guest');
        $path_info = 'user/'.$identification.'/maintenance';
        
        $path_img_vehicle = $request->file('img_vehicle.file.originFileObj')->store($path_info,'public');
        $path_signature = $request->file('signature_responsibility.file.originFileObj')->store($path_info,'public');

        //$url_img_vehicle = asset('/storage/'.$path_img_vehicle);
        //$url_signature = asset('/storage/'.$path_signature );
        

        $record_start_maintenance = RecordStartMaintenance::create([
            'user_id'                   => $u_data->id,
            'vehicle_id'                => $request->vehicle_id,
            'img_vehicle'               => $path_img_vehicle,
            'signature_responsibility'  => $path_signature,
            'detail'                    => $request->detail,
            'admission_date'            => $request->admission_date_str,
            'current_mileage'           => $request->current_mileage
        ]);
        
        
        $maintenance->update([
            'record_start_maintenance_id' => $record_start_maintenance->id,
            'price'                       => $request->price
        ]);

        $maintenance->contracts()->sync($request->c_selected);
        $maintenance->maintenance_types()->sync($request->m_types_selected);

        $vehicle->update([
            'mileage' => $request->current_mileage
        ]);

        

        return to_route('maintenance.show',$maintenance->id)->with('success', 'La orden fue creada con éxito');
    }

    /**
     * Descarga de reporte en pdf.
     */
    public function downloadOrderJob(Request $request)
    {
        $maintenance = $request->all();
       
        foreach($maintenance['maintenance_types'] as $key => $mt){
            if(in_array($maintenance['vehicle']['vehicle_type'],$mt['detail']['discard_type'])){
                foreach($mt['detail']['discard_list'] as $dl){
                    $k = array_search($dl,$mt['detail']['list']);
                    unset($mt['detail']['list'][$k]);
                } 

                $price = array_reduce($mt['detail']['discard_price'], function($prev, $curr){
                    return $prev= $prev - $curr;
                }, $mt['price']);

                $mt['price'] = $price;

                $maintenance['maintenance_types'][$key] = $mt;    
            }
            
        }

        $sum_contract = collect($maintenance['contracts'])->sum('price');
        $sum_m_types  = collect($maintenance['maintenance_types'])->sum('price');

        $prices = [];
        $prices['subtotal'] = round(($sum_contract + $sum_m_types),2);
        $prices['iva']      = round(($prices['subtotal']*.12),2);
        $prices['total']    = round(($prices['subtotal'] + $prices['iva'] ),2);
    
        $pdf = Pdf::loadView('PDF.report-order-start',compact(['maintenance','prices']));

        return $pdf->download('reporte-orden-trabajo.pdf');
    }

    /**
     * Descarga de reporte global en pdf.
     */
    public function downloadReportMaintenance(Request $request)
    {
        $maintenance = $request->all();
        
        foreach($maintenance['maintenance_types'] as $key => $mt){
            if(in_array($maintenance['vehicle']['vehicle_type'],$mt['detail']['discard_type'])){
                foreach($mt['detail']['discard_list'] as $dl){
                    $k = array_search($dl,$mt['detail']['list']);
                    unset($mt['detail']['list'][$k]);
                } 

                $price = array_reduce($mt['detail']['discard_price'], function($prev, $curr){
                    return $prev= $prev - $curr;
                }, $mt['price']);

                $mt['price'] = $price;

                $maintenance['maintenance_types'][$key] = $mt;    
            }
            
        }

        $sum_contract = collect($maintenance['contracts'])->sum('price');
        $sum_m_types  = collect($maintenance['maintenance_types'])->sum('price');

        $prices = [];
        $prices['subtotal'] = round(($sum_contract + $sum_m_types),2);
        $prices['iva']      = round(($prices['subtotal']*.12),2);
        $prices['total']    = round(($prices['subtotal'] + $prices['iva'] ),2);

        $pdf = Pdf::loadView('PDF.report-maintenance',compact(['maintenance','prices']));

        return $pdf->download('reporte-orden-trabajo.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function finishOrderJob(Request $request)
    {   
        $request->validate([
            'key' => [ 'required','exists:App\Models\Maintenance,id']
        ],[
            'key.required' => 'El mantenimiento es requerido' 
        ]);

        $id = $request->only('key');
        
        $maintenance = Maintenance::find($id['key']);
        $maintenance->update([  
            'status' => 3
        ]);

        return to_route('maintenance.show',$maintenance->id)->with('success', 'La trabajo ha finalizado.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request)
    {
        $maintenance = Maintenance::find($request->id);
        $user = Auth::user();

        if(empty($maintenance)){ return Inertia::render('Result/Unauthorized',['response' => StatusHelper::statusCodeDictionary('404')]); } //Redirigimos cuando no exista mantenimiento
        if(!$user->can('maintenance.manager') && $maintenance->user_id != $user->id){ return Inertia::render('Result/Unauthorized',['response' => StatusHelper::statusCodeDictionary('403')]); }//Redirigimos cuando no tenga permiso para ver esa ruta

        $record_start_maintenance = $maintenance->record_start_maintenance;
        $maintenance_types = MaintenanceType::all()->toArray();
        $contracts = Contract::all()->toArray();

        return Inertia::render('Maintenance/Show',[ 
            'maintenance'       => new MaintenanceResource($maintenance),
            'maintenance_types' => $maintenance_types,
            'contracts'         => $contracts
        ]);
    }

    /**
     * store order end.
     */
    public function storeOrderEnd(MaintenanceOrderEndRequest $request)
    {
        $user           = User::byIdentification($request->identification)->first();
        $maintenance    = Maintenance::find($request->maintenance_id);
        $vehicle        = Vehicle::find($request->vehicle_id);
        
        $record_end = RecordEndMaintenance::create([
            'user_id'           => $user->id,
            'vehicle_id'        => $vehicle->id,
            'detail'            => $request->detail,
            'next_mileage'      => $request->next_mileage,
            'departure_date'    => $request->admission_date_str,  
        ]);

        $maintenance->update([
            'record_end_maintenance_id' => $record_end->id,
            'status'                    => 4,
            'in_progress'               => 0
        ]);

        $vehicle->update([
            'next_mileage' => $request->next_mileage
        ]);

        return to_route('maintenance.show',$maintenance->id)->with('success', 'La orden de recepcion fue creada con éxito');
    }


}
