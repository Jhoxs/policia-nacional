<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
//Request
use App\Http\Requests\CreateSubcircuitRequest;
use App\Http\Requests\UpdateSubcircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
//Intertia
use Inertia\Inertia;
use Inertia\Response;
//Resources
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\SpareCollection;
use App\Http\Resources\SpareResource;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\SubcircuitResource;
//Models
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use App\Models\Subcircuit;
use App\Models\Spare;
use App\Models\Contract;

class SpareController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:spare.index')->only('index');
        $this->middleware('can:spare.create')->only('create');
        $this->middleware('can:spare.store')->only('store');
        $this->middleware('can:spare.edit')->only('edit');
        $this->middleware('can:spare.update')->only('update');
        $this->middleware('can:spare.destroy')->only('destroy');
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelData = (new Spare)->SearchBar(Rq::only('value','key'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Spares/Index',[ 
            'modelData' => new SpareCollection($modelData)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Spares/Create',[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('spares','name')->where(function($query) use ($request){
                            return $query->where('brand',$request->brand);
                        })
            ],
            'brand'     => ['required','string','max:255'],
            'price'     => ['required','decimal:0,2'],
            'detail'    => ['nullable','string','max:255'],
        ],[
            'name.required'     => 'El nombre del repuesto es requerido',
            'brand.required'    => 'La marca es requerida',
            'price.required'    => 'El precio es requerido',
        ]);

        $spare = Spare::create([
            'name'      => $request->name,
            'brand'     => $request->brand,
            'price'     => $request->price,
            'detail'    => $request->detail ?? null
        ]);

        return to_route('spare.index')->with('success', 'El repuesto se ha creado con éxito');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Spare::find($id);

        return Inertia::render('Spares/Edit',[
            'modelData' => new SpareResource($model),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = Spare::find($id);

        $request->validate([
            'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('spares','name')->where(function($query) use ($request){
                            return $query->where('brand',$request->brand);
                        })->ignore($model->id)
            ],
            'brand'     => ['required','string','max:255'],
            'price'     => ['required','decimal:0,2'],
            'detail'    => ['nullable','string','max:255'],
        ],[
            'name.required'     => 'El nombre del repuesto es requerido',
            'brand.required'    => 'La marca es requerida',
            'price.required'    => 'El precio es requerido',
        ]);

        $model->update([
            'name'      => $request->name,
            'brand'     => $request->brand,
            'price'     => $request->price,
            'detail'    => $request->detail ?? null
        ]);

        //Actualizar precios de los contratos
        $contracts = $model->contracts;
        $contracts->each(function($model) use ($request){
            $spares = $model->spares->pluck('price')->toArray();

            $prices = array_reduce($spares, function($accum,$item){
                $accum += $item;
                return  $accum;  
            });

            $model->update([
                'price' => $prices
            ]);
        });

        return to_route('spare.index')->with('success', 'El repuesto se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Spare::find($id);
        $model->delete();

        return to_route('spare.index')->with('success', 'El repuesto se ha eliminado con éxito');
    }
}
