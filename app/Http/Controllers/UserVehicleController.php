<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\CreateSubcircuitRequest;
use App\Http\Requests\UpdateSubcircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\SubcUserRequest;
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitResource;
use App\Http\Resources\AssignmentSubcCollection;
use App\Http\Resources\AssignmentSubResource;
use App\Http\Resources\UserAssignCollection;
use App\Http\Resources\UserVehicleResource;
use App\Http\Resources\UserResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;
use App\Models\User;
use App\Models\UserVehicle;
use Closure;

class UserVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:uservehicle.index')->only('index');
        $this->middleware('can:uservehicle.create')->only('create');
        $this->middleware('can:uservehicle.store')->only('store');
        $this->middleware('can:uservehicle.edit')->only('edit');
        $this->middleware('can:uservehicle.update')->only('update');
        $this->middleware('can:uservehicle.destroy')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        $model = Vehicle::vehicleInfo()->searchBar(Rq::only('key','value','filter'))->withCity()->paginate(10)->appends(Rq::all());

        return Inertia::render('VehiclesUsers/Index',[
            'haveSubc' => Vehicle::haveUser()->count(),
            'notSubc' => Vehicle::notUser()->count(),
            'modelList' => new VehicleCollection($model),
            'filters' => Rq::all('key','value','filter')
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubcircuitRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
        $model = Vehicle::vehicleInfo()->withCity()->find($id);
        $subcircuits = $model->subcircuits->first();
        $cities = $subcircuits->circuit->parish->city->id;
        
        //Usuarios dentro del mismo distrito que los vehículos
        $users = User::sameCity($cities)->notVehicle()->get();
       
        return Inertia::render('VehiclesUsers/Edit',[
            'modelInfo' =>  new UserVehicleResource($model),
            'userList' => new UserAssignCollection($users)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        
        $u_idList = User::whereIn('identification',$request->userVehicle)->pluck('id');
        $model = Vehicle::find($id);

        $request->validate([
            'userVehicle' => ['required',
                'array',
                'max:4',
                'exists:App\Models\User,identification',
                'distinct', function($attribute, $value, Closure $fail) use($u_idList,$model){
                   $countUser = UserVehicle::whereIn('user_id',$u_idList)->where('vehicle_id','!=',$model->id)->count();
                   if($countUser > count($u_idList)){
                        $fail("Las idenficaciones ya les pertecen a otros vehiculos");
                   }
                }],
        ],[

            'userVehicle.required' => 'Debes seleccionar al menos un Usuario',
            'userVehicle.exists' => 'La identificación seleccionada no coincide con nuestros registros',
            'max' => 'Solo se pueden asignar 4 usarios a este vehículo'
        ]);
        
        
        
        $model->users()->sync($u_idList);

       return to_route('uservehicle.index')->with('success', 'Los usuarios se asignaron con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Vehicle::find($id);
        $model->users()->detach();
        return to_route('uservehicle.index')->with('success', 'Los usuarios se han desasignado con éxito');
    }
}
