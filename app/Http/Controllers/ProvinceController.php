<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\CreateProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\ProvinceItemsCollection;
use App\Http\Resources\ProvinceIndexCollection;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:province.index')->only('index');
        $this->middleware('can:province.create')->only('create');
        $this->middleware('can:province.store')->only('store');
        $this->middleware('can:province.edit')->only('edit');
        $this->middleware('can:province.update')->only('update');
        $this->middleware('can:province.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = (new Province)->searchBar(Rq::only('key','value'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Provinces/Index',[
            'cities' => count((new City)->displayFormattedOptions()),
            'parish' => count((new Parish)->displayFormattedOptions()),
            'circuits' => count((new Circuit)->displayFormattedOptions()),
            'subcircuits' => count((new Subcircuit)->displayFormattedOptions()),
            'modelList' => new ProvinceIndexCollection($model),
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Provinces/Create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProvinceRequest $request)
    {
        $model = Province::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        return to_route('province.index')->with('success', 'La provincia se ha creado con éxito');
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
        $model = Province::find($id);

        return Inertia::render('Provinces/Edit',[
            'modelInfo' => new ProvinceResource($model)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinceRequest $request, string $id)
    {
        $model = Province::find($id);
         
        $request->validate([
            'display_name' => ['required','string','max:255',Rule::unique(Province::class,'display_name')->ignore($model->id)],
            'name' => ['required','string','max:255',Rule::unique(Province::class,'name')->ignore($model->id)]
        ],[
   
            'display_name.unique' => 'La nombre de la provincia es requerido',
            'display_name.required' => 'El nombre de la provincia es requerido',
            'name.required' => 'El nombre es requerido',

        ]);

        $model->update([
            'display_name' => $request->display_name,
            'name' => $request->name,
            'province_id' => $request->dependence,
        ]);

        return to_route('province.index')->with('success', 'La provincia se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Province::find($id);
        $model->delete();
        return to_route('province.index')->with('success', 'La provincia se ha eliminado con éxito');
    }
}
