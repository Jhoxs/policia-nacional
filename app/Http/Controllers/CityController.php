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
use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\ProvinceItemsCollection;
use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:city.index')->only('index');
        $this->middleware('can:city.create')->only('create');
        $this->middleware('can:city.store')->only('store');
        $this->middleware('can:city.edit')->only('edit');
        $this->middleware('can:city.update')->only('update');
        $this->middleware('can:city.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $circuit = (new City)->withDep()->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Cities/Index',[
            'provinces' => count((new Province)->displayFormattedOptions()),
            'parish' => count((new Parish)->displayFormattedOptions()),
            'circuits' => count((new Circuit)->displayFormattedOptions()),
            'subcircuits' => count((new Subcircuit)->displayFormattedOptions()),
            'modelList' => new CityCollection($circuit),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::all();
        return Inertia::render('Cities/Create',[
            'provinces' => new ProvinceItemsCollection($province),
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCityRequest $request)
    {
        $model = City::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'province_id' => $request->dependence,
        ]);

        return to_route('city.index')->with('success', 'La ciudad se ha creado con éxito');
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
        $model = City::withDep()->find($id);
        $province = Province::all();

        return Inertia::render('Cities/Edit',[
            'provinces' => new ProvinceItemsCollection($province),
            'modelInfo' => new CityResource($model)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, string $id)
    {
        $model = City::find($id);
         
        $request->validate([
            'display_name' => ['required','string','max:255',Rule::unique(City::class,'display_name')->ignore($model->id)],
            'name' => ['required','string','max:255',Rule::unique(City::class,'name')->ignore($model->id)]
        ],[
   
            'display_name.unique' => 'La nombre de la ciudad es requerido',
            'display_name.required' => 'El nombre de la ciudad es requerido',
            'name.required' => 'El nombre es requerido',

        ]);

        $model->update([
            'display_name' => $request->display_name,
            'name' => $request->name,
            'province_id' => $request->dependence,
        ]);

        return to_route('city.index')->with('success', 'La ciudad se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = City::find($id);
        $model->delete();
        return to_route('city.index')->with('success', 'La ciudad se ha eliminado con éxito');
    }
}
