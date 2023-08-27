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
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

class VehicleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:vehicle.index')->only('index');
        $this->middleware('can:vehicle.create')->only('create');
        $this->middleware('can:vehicle.store')->only('store');
        $this->middleware('can:vehicle.show')->only('show');
        $this->middleware('can:vehicle.edit')->only('edit');
        $this->middleware('can:vehicle.update')->only('update');
        $this->middleware('can:vehicle.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicleData = (new Vehicle)->vehicleInfo()->withCity()->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Vehicles/Index',[
            'modelData' => new VehicleCollection($vehicleData)
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Vehicles/Create',[ 
            'vehicle_type' => VehicleType::select('id as value','display_name as label')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateVehicleRequest $request)
    {
        $vehicle = Vehicle::create([
            'plate' => $request->plate,
            'chassis' => $request->chassis,
            'brand' => $request->brand,
            'model' => $request->model,
            'motor' => $request->motor,
            'mileage' => $request->mileage,
            'cylinder_capacity' => $request->cylinder_capacity,
            'loading_capacity' => $request->loading_capacity,
            'passenger_capacity' => $request->passenger_capacity,
            'vehicle_type_id' => $request->vehicle_type,
        ]);

        return to_route('vehicle.index')->with('success', 'El vehículo se ha creado con éxito');
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
        $vehicle = Vehicle::find($id);

        return Inertia::render('Vehicles/Edit',[
            'vehicle_type' => VehicleType::select('id as value','display_name as label')->get(),
            'vehicleInfo' => new VehicleResource($vehicle)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, string $id)
    {

        $vehicle = Vehicle::find($id);
         
        $request->validate([
            'plate' => ['required','string','max:255',Rule::unique('vehicles')->ignore($vehicle->id)],
        ],[
            'plate.required' => 'La placa es requerida',
            'plate.unique' => 'La placa debe ser única',
        ]);

        $vehicle->update([
            'plate' => $request->plate,
            'chassis' => $request->chassis,
            'brand' => $request->brand,
            'model' => $request->model,
            'motor' => $request->motor,
            'mileage' => $request->mileage,
            'cylinder_capacity' => $request->cylinder_capacity,
            'loading_capacity' => $request->loading_capacity,
            'passenger_capacity' => $request->passenger_capacity,
            'vehicle_type_id' => $request->vehicle_type,
        ]);


        return to_route('vehicle.index')->with('success', 'La información del vehículo se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $info = $request->only('reason','typeRequest');

        $vehicle = Vehicle::find($id);

        (new \App\Http\Controllers\AuditLogController)->store(new Request([
            'model'     => $vehicle,
            'action'    => 'eliminar',
            'detail'    => $info['reason'] ?? 'El vehículo ha sido eliminado'
        ]));

        $vehicle->delete();

        return to_route('vehicle.index')->with('success', 'El vehículo se ha eliminado con éxito');
    }
}
