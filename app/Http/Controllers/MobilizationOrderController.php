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
use App\Http\Resources\UserAssignCollection;
use App\Http\Resources\UserResourcePreview;
use App\Http\Resources\VehicleResourcePreview;
use App\Http\Resources\DependencePreviewResource;
use App\Http\Resources\MaintenanceResource;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\SubcircuitResource;
use App\Http\Resources\MorderCollection;
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
use App\Models\MovilizationOrder;

//HELPERS
use App\Helpers\StatusHelper;

use App\Notifications\Maintenance\GenericOrder;


class MobilizationOrderController extends Controller
{
    public function __construct()
    {   
        /* $this->middleware('can:maintenance.index')->only('index');
        $this->middleware('can:maintenance.create')->only('create');
        $this->middleware('can:maintenance.store')->only('store');
        $this->middleware('can:maintenance.show')->only('show');
        $this->middleware('can:maintenance.edit')->only('edit');
        $this->middleware('can:maintenance.update')->only('update');
        $this->middleware('can:maintenance.destroy')->only('destroy');
        $this->middleware('can:maintenance.manager')->only('storeOrderStart');
        $this->middleware('can:maintenance.manager')->only('finishOrderJob');
        $this->middleware('can:maintenance.manager')->only('storeOrderEnd'); */
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
        $orders = MovilizationOrder::userManager($user)->paginate(10);

        return Inertia::render('Mobilization/Index',[ 
            'vehicleUser'   => $user->vehicles ?? [],
            'p_maintenance' => new MaintenanceCollection($p_maintenance),
            'f_maintenance' => new MaintenanceCollection($f_maintenance),
            'filters'       => $request->all('key','value','filter'),
            't_progress'    => $t_progress, 
            'orders'        => new MorderCollection($orders), 
        ]);
    }

   

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $vehicle        = isset(Auth::user()->vehicles[0]) ? new VehicleResourcePreview(Auth::user()->vehicles[0]):  [];
        $dependence     = isset(Auth::user()->subcircuits[0]) ? new DependencePreviewResource(Auth::user()->subcircuits[0]) : [];
        $users          = User::all();

        return Inertia::render('Mobilization/Create',[ 
            'userInfo'          => new UserResourcePreview(Auth::user()),
            'vehicleInfo'       => $vehicle,
            'dependeceInfo'     => $dependence,
            'userList'          => new UserAssignCollection($users)

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user       = Auth::user();
        $user_id    = $user->id ?? 1;
        $vehicle_id = Auth::user()->vehicles[0]->id ?? 1;
        $vehicle    = Vehicle::find($vehicle_id);
        $mileage    = $vehicle->mileage ?? 0;
        $dependence = $user->subcircuits[0] ?? [];

        
        
        $request->validate([
            'mileage'   => ['required'],
            'pasajeros' => ['required'],
            'shift_range'   => ['required'],
            'driver_id'     => ['required'],
            'shift_date'    => ['required'],
            'motivos'       => ['required'],
            'rutes'         => ['required']
            
        ],[
            'mileage.gte' => 'El kilometrage debe ser superior al actual' 
        ]);

        $c_date = date('Y-m-d', strtotime($request->shift_date));
        $c_time = strtotime($request->range_date);
        $driver = User::find($request->driver_id);
        $d_id   = $driver->id ?? $user->id;
        $pasajeros = count($request->pasajeros) ? implode(',',$request->pasajeros) : '';

        $infoMaintenance = (object)[];
        $infoMaintenance->user          = $user;
        $infoMaintenance->vehicle       = $vehicle;
        $infoMaintenance->dependence    = $dependence;
        $infoMaintenance->order         = $request->all();

        $mileage = intval($request->mileage);
        //Send from email status maintenance in pdf
        //Notification::sendNow($user, new GenericOrder($user, 'Se ha enviado una solicitud a los administradores'));
        
        $maintenance = MovilizationOrder::create([
            'user_id'           => $user_id,
            'vehicle_id'        => $vehicle_id,
            'driver_id'         => $d_id,
            'status'            => 0,
            'in_progress'       => true,
            'departure_date'    => $c_date,
            'departure_time'    => $request->shift_range,
            'description'       => $request->details,
            'reason'            => $request->motivos,
            'rute'              => $request->rutes,
            'passengers'        => $pasajeros,
            'reason_reject'     => 'Ninguna',
            'current_mileage'    => $mileage

        ]);

        $vehicle->update([
            'mileage' => $request->mileage
        ]);

        return to_route('morder.index')->with('success', 'La solicitud se genero con exito');
    }

   
    public function storeRequest(Request $request)
    {
        $m_info = $request->all();
        
        $maintenance = MovilizationOrder::find($m_info['idMaintenance']);
        switch($m_info['typeRequest'])
        {
            case 'accept':
                $maintenance->update([  
                    'status' => 2
                ]);
                //Send notify 
                Notification::sendNow($maintenance->user, new GenericOrder($maintenance->user,'Se acepto tu solicitud'));

                return to_route('morder.index')->with('success', 'La solicitud se aceptó con éxito');
                break;
            case 'reject':
                $maintenance->update([
                    'status' => 1,
                    'in_progress' => 0,
                    'reason_reject' => $m_info['reasonReject'] ?? null
                ]);
                //Send notify
                Notification::sendNow($maintenance->user, new GenericOrder($maintenance->user,'Se denego tu solicitud'));
                
                return to_route('morder.index')->with('success', 'La solicitud ha sido rechazada');
                break;
            default:
                return to_route('morder.index')->with('success', 'No se procesaron solicitudes');
        }
    }

}
