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
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;

class SubcircuitController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subcircuit.index')->only('index');
        $this->middleware('can:subcircuit.create')->only('create');
        $this->middleware('can:subcircuit.store')->only('store');
        $this->middleware('can:subcircuit.edit')->only('edit');
        $this->middleware('can:subcircuit.update')->only('update');
        $this->middleware('can:subcircuit.destroy')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcircuit = (new Subcircuit)->withDep()->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Subcircuits/Index',[
            'provinces' => count((new Province)->displayFormattedOptions()),
            'cities' => count((new City)->displayFormattedOptions()),
            'parishes' => count((new Parish)->displayFormattedOptions()),
            'circuits' => count((new Circuit)->displayFormattedOptions()),
            'subcList' => new SubcircuitCollection($subcircuit),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::whereHasDep()->get();
        return Inertia::render('Subcircuits/Create',[
            'provinces' => new ProvinceCollection($province),
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubcircuitRequest $request)
    {
        $subcircuits = Subcircuit::create([
            'code' => $request->code,
            'name' => $request->name,
            'display_name' => $request->display_name,
            'circuit_id' => $request->dependence,
        ]);

        return to_route('subcircuit.index')->with('success', 'El subcircuito se ha creado con éxito');
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
        $subcircuit = Subcircuit::withDep()->find($id);
        $province = Province::whereHasDep()->get();

        return Inertia::render('Subcircuits/Edit',[
            'provinces' => new ProvinceCollection($province),
            'subcircuitInfo' => new SubcircuitResource($subcircuit)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcircuitRequest $request, string $id)
    {
        $subcircuit = Subcircuit::find($id);
         
        $request->validate([
            'code' => ['required','string','max:255',Rule::unique(Subcircuit::class,'code')->ignore($subcircuit->id)],
            'display_name' => ['required','string','max:255','max:255',Rule::unique(Subcircuit::class,'display_name')->ignore($subcircuit->id)],
            'name' => ['required','string','max:255','max:255',Rule::unique(Subcircuit::class,'name')->ignore($subcircuit->id)]
        ],[
            'code.required' => 'El código es requerido',
            'display_name.unique' => 'La nombre de subcircuito es requerido',
            'name' => 'El nombre es requerido',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de subcircuito es requerido',
            'code.unique' => 'El código del subcircuito ya existe dentro de los registros',
            'code.required' => 'El código es requerido',
        ]);

        $subcircuit->update([
            'code' => $request->code,
            'display_name' => $request->display_name,
            'name' => $request->name,
            'circuit_id' => $request->dependence,
        ]);

        return to_route('subcircuit.index')->with('success', 'El subcircuito se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcircuit = Subcircuit::find($id);
        $subcircuit->delete();
        return to_route('subcircuit.index')->with('success', 'El subcircuito se ha eliminado con éxito');
    }
}
