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
use App\Http\Requests\CreateCircuitRequest;
use App\Http\Requests\UpdateCircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\CircuitCollection;
use App\Http\Resources\ProvinceCircuitCollection;
use App\Http\Resources\CircuitResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;

class CircuitController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:circuit.index')->only('index');
        $this->middleware('can:circuit.create')->only('create');
        $this->middleware('can:circuit.store')->only('store');
        $this->middleware('can:circuit.edit')->only('edit');
        $this->middleware('can:circuit.update')->only('update');
        $this->middleware('can:circuit.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $circuit = (new Circuit)->withDep()->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Circuits/Index',[
            'provinces' => count((new Province)->displayFormattedOptions()),
            'cities' => count((new City)->displayFormattedOptions()),
            'parishes' => count((new Parish)->displayFormattedOptions()),
            'subcircuits' => count((new Subcircuit)->displayFormattedOptions()),
            'modelList' => new CircuitCollection($circuit),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::whereHasCircuit()->get();
        return Inertia::render('Circuits/Create',[
            'provinces' => new ProvinceCircuitCollection($province),
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCircuitRequest $request)
    {
        $subcircuits = Circuit::create([
            'code' => $request->code,
            'name' => $request->name,
            'display_name' => $request->display_name,
            'parish_id' => $request->dependence,
        ]);

        return to_route('circuit.index')->with('success', 'El circuito se ha creado con éxito');
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
        $model = Circuit::withDep()->find($id);
        $province = Province::whereHasCircuit()->get();

        return Inertia::render('Circuits/Edit',[
            'provinces' => new ProvinceCircuitCollection($province),
            'modelInfo' => new CircuitResource($model)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCircuitRequest $request, string $id)
    {
        $model = Circuit::find($id);
         
        $request->validate([
            'code' => ['required','string','max:255',Rule::unique(Circuit::class,'code')->ignore($model->id)],
            'display_name' => ['required','string','max:255','max:255',Rule::unique(Circuit::class,'display_name')->ignore($model->id)],
            'name' => ['required','string','max:255','max:255',Rule::unique(Circuit::class,'name')->ignore($model->id)]
        ],[
            'code.required' => 'El código es requerido',
            'display_name.unique' => 'La nombre de circuito es requerido',
            'name' => 'El nombre es requerido',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de circuito es requerido',
            'code.unique' => 'El código del circuito ya existe dentro de los registros',
            'code.required' => 'El código es requerido',
        ]);

        $model->update([
            'code' => $request->code,
            'display_name' => $request->display_name,
            'name' => $request->name,
            'parish_id' => $request->dependence,
        ]);

        return to_route('circuit.index')->with('success', 'El circuito se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Circuit::find($id);
        $model->delete();
        return to_route('circuit.index')->with('success', 'El circuito se ha eliminado con éxito');
    }
}
