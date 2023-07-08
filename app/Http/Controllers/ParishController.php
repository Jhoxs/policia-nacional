<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\CreateParishRequest;
use App\Http\Requests\UpdateParishRequest;
use App\Http\Resources\ProvinceParishCollection;
use App\Http\Resources\ParishCollection;
use App\Http\Resources\ParishResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;

class ParishController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:parish.index')->only('index');
        $this->middleware('can:parish.create')->only('create');
        $this->middleware('can:parish.store')->only('store');
        $this->middleware('can:parish.edit')->only('edit');
        $this->middleware('can:parish.update')->only('update');
        $this->middleware('can:parish.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $circuit = (new Parish)->withDep()->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Parishes/Index',[
            'provinces' => count((new Province)->displayFormattedOptions()),
            'cities' => count((new City)->displayFormattedOptions()),
            'circuits' => count((new Circuit)->displayFormattedOptions()),
            'subcircuits' => count((new Subcircuit)->displayFormattedOptions()),
            'modelList' => new ParishCollection($circuit),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::whereHasParish()->get();
        return Inertia::render('Parishes/Create',[
            'provinces' => new ProvinceParishCollection($province),
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateParishRequest $request)
    {
        $model = Parish::create([
            'code' => $request->code,
            'name' => $request->name,
            'display_name' => $request->display_name,
            'city_id' => $request->dependence,
        ]);

        return to_route('parish.index')->with('success', 'La parroquia se ha creado con éxito');
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
        $model = Parish::withDep()->find($id);
        $province = Province::whereHasParish()->get();

        return Inertia::render('Parishes/Edit',[
            'provinces' => new ProvinceParishCollection($province),
            'modelInfo' => new ParishResource($model)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParishRequest $request, string $id)
    {
        $model = Parish::find($id);
         
        $request->validate([
            'code' => ['required','string','max:255',Rule::unique(Parish::class,'code')->ignore($model->id)],
            'display_name' => ['required','string','max:255','max:255',Rule::unique(Parish::class,'display_name')->ignore($model->id)],
            'name' => ['required','string','max:255','max:255',Rule::unique(Parish::class,'name')->ignore($model->id)]
        ],[
            'code.required' => 'El código es requerido',
            'display_name.unique' => 'La nombre de la parroquia es requerido',
            'name' => 'El nombre es requerido',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de la parroquia es requerido',
            'code.unique' => 'El código de la parroquia ya existe dentro de los registros',
            'code.required' => 'El código es requerido',
        ]);

        $model->update([
            'code' => $request->code,
            'display_name' => $request->display_name,
            'name' => $request->name,
            'city_id' => $request->dependence,
        ]);

        return to_route('parish.index')->with('success', 'La parroquia se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Parish::find($id);
        $model->delete();
        return to_route('parish.index')->with('success', 'La parroquia se ha eliminado con éxito');
    }
}
