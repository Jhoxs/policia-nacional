<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
//Request
use App\Http\Requests\CreateSubcircuitRequest;
use App\Http\Requests\UpdateSubcircuitRequest;
use App\Http\Requests\MaintenanceOrderStartRequest;
//Intertia
use Inertia\Inertia;
use Inertia\Response;
//Resources
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\ContractCollection;
use App\Http\Resources\SpareCollection;
use App\Http\Resources\VehicleResource;

use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitResource;
use App\Http\Resources\ContractJResource;
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


class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:contract.index')->only('index');
        $this->middleware('can:contract.create')->only('create');
        $this->middleware('can:contract.store')->only('store');
        $this->middleware('can:contract.edit')->only('edit');
        $this->middleware('can:contract.update')->only('update');
        $this->middleware('can:contract.destroy')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelData = (new Contract)->searchBar(Rq::only('value','key'))->info()->paginate(10)->appends(Rq::all());

        return Inertia::render('Contracts/Index',[ 
            'modelData' => new ContractCollection($modelData)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modelData = Spare::paginate(15);
        
        return Inertia::render('Contracts/Create',[ 
            'modelInfo' => new SpareCollection($modelData)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => ['required','string','max:255','unique:App\Models\Contract,name'],
            'spareSelected'     => ['required','array','min:1','exists:App\Models\Spare,id'],
            //'price'             => ['required','decimal:0,2'],
            'detail'            => ['nullable','string','max:255'],
        ],[
            'name.required'     => 'El nombre del repuesto es requerido',
            'spareSelected.min' => 'Se requiere al menos un repuesto seleccionado',
            'spareSelected.required' => 'Los repuestos son requeridos',
            'brand.required'    => 'La marca es requerida',
            //'price.required'    => 'El precio es requerido',
        ]);

        $spares = Spare::whereIn('id',$request->spareSelected)->pluck('price')->toArray();

        $prices = array_reduce($spares, function($accum,$item){
            $accum += $item;
            return  $accum;  
        });

        $contract = Contract::create([
            'name'      => $request->name,
            'price'     => $prices,
            'detail'    => $request->detail ?? null
        ]);

        $contract->spares()->sync($request->spareSelected);

        return to_route('contract.index')->with('success', 'El contrato se ha creado con éxito');
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

        $contract = Contract::find($id);
        $sparesSelected = $contract->spares->pluck('id')->toArray();
        $modelData = Spare::paginate(15);
        
        return Inertia::render('Contracts/Edit',[
            'modelData'      => new ContractJResource($contract),
            'sparesSelected' => $sparesSelected,
            'modelInfo'      => new SpareCollection($modelData)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contract = Contract::find($id);

        $request->validate([
            'name'              => ['required','string','max:255',Rule::unique(Contract::class,'name')->ignore($contract->id)],
            'spareSelected'     => ['required','array','min:1','exists:App\Models\Spare,id'],
            'detail'            => ['nullable','string','max:255'],
        ],[
            'name.required'     => 'El nombre del repuesto es requerido',
            'spareSelected.min' => 'Se requiere al menos un repuesto seleccionado',
            'spareSelected.required' => 'Los repuestos son requeridos',
            'brand.required'    => 'La marca es requerida',
        ]);

        $spares = Spare::whereIn('id',$request->spareSelected)->pluck('price')->toArray();

        $prices = array_reduce($spares, function($accum,$item){
            $accum += $item;
            return  $accum;  
        });

        $contract->update([
            'name'      => $request->name,
            'detail'    => $request->detail,
            'price'     => $prices
        ]);

        $contract->spares()->sync($request->spareSelected);
        
        return to_route('contract.index')->with('success', 'El contrato actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = Contract::find($id);
        $contract->spares()->detach();
        $contract->delete();

        return to_route('contract.index')->with('success', 'El contrato se ha eliminado con éxito');
    }
}
