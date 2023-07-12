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
use App\Http\Requests\AssignVehicleSubcircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\SubcUserRequest;
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitResource;
use App\Http\Resources\AssignmentSubcCollection;
use App\Http\Resources\AssignmentSubResource;
use App\Http\Resources\UserResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;
use App\Models\User;

class SubcircuitVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subvehicle.index')->only('index');
        $this->middleware('can:subvehicle.create')->only('create');
        $this->middleware('can:subvehicle.store')->only('store');
        $this->middleware('can:subvehicle.edit')->only('edit');
        $this->middleware('can:subvehicle.update')->only('update');
        $this->middleware('can:subvehicle.destroy')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        $model = Vehicle::vehicleInfo()->searchBar(Rq::only('key','value','filter'))->withCity()->paginate(10)->appends(Rq::all());

        return Inertia::render('SubVehicles/Index',[
            'haveSubc' => Vehicle::haveSubc()->count(),
            'notSubc' => Vehicle::notSubc()->count(),
            'modelList' => new VehicleCollection($model),
            'filters' => Rq::all('key','value','filter')
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicle = Vehicle::vehicleInfo()->notSubc()->searchBar(Rq::only('key','value','filter'))->withCity()->paginate(10)->appends(Rq::all());
        $province = Province::withDepFull()->whereHasDepFull()->get();

        return Inertia::render('SubVehicles/Create',[
        'provinces' => new AssignmentSubcCollection($province),
        'modelInfo' =>  new VehicleCollection($vehicle)
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignVehicleSubcircuitRequest $request)
    {
        $model_list = Vehicle::whereIn('id',$request->modelSelected)->get();

        $model_list->each(function($model) use ($request){
            $model->subcircuits()->sync([$request->dependence]);
        });

        return to_route('subvehicle.index')->with('success', 'Se asignó el subcircuito a los vehículos con éxito');
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
    
        $province = Province::withDepFull()->whereHasDepFull()->get();
        $model = Vehicle::vehicleInfo()->withCity()->find($id);
        $model_subc = $model->subcircuits()->pluck('id')->toArray();
        $subcircuit = Subcircuit::withDep()->where('id',$model_subc)->first();

        return Inertia::render('SubVehicles/Edit',[
            'provinces' => new AssignmentSubcCollection($province),
            'subcircuitInfo' => isset($subcircuit) ? new AssignmentSubResource($subcircuit) : [],
            'modelInfo' =>  new VehicleResource($model)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcUserRequest $request, string $id)
    {
        
        $model = Vehicle::find($id);
        $model->subcircuits()->sync([$request->dependence]);

       return to_route('subvehicle.index')->with('success', 'El subcircuito se asignó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Vehicle::find($id);
        $model->subcircuits()->detach();
        return to_route('subvehicle.index')->with('success', 'El subcircuito se ha desasignado con éxito');
    }
}
