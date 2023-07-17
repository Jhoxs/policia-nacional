<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use App\Models\Subcircuit;
use App\Models\Circuit;
use App\Models\CatalogItem;
use App\Http\Resources\SuggCreateCollection;
use App\Http\Resources\SuggestCollection;
use App\Http\Requests\SuggFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class SuggestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:suggestion.index')->only('index');
    }


    /**
     * Display a form to suggestion.
     */
    public function indexFormSuggestion()
    {   
        $circuit =  Circuit::withSubcircuit()->whereHasSubc()->get();
        $typeSuggestion = CatalogItem::select('id as value','value as label')->suggest()->get();

        return Inertia::render('Suggestions/Show',[ 
            'typeSugg' => $typeSuggestion,
            'circuitList' => new SuggCreateCollection($circuit),
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function storeFormSuggestion(SuggFormRequest $request)
    {

        $suggestion = Suggestion::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'description' => $request->description,
            'subcircuit_id' => $request->dependence,
            'catalog_item_id' => $request->type_suggestion,
        ]);
        
        return to_route('landingpage')->with('success', 'La sugerencia / reclamo se registró con éxito');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [];
        $filters['from_date'] = $request->filterDate[0] ?? date('Y-m-d');
        $filters['to_date'] = $request->filterDate[1] ?? date('Y-m-d');

        $model = DB::table('suggestions as s')->selectRaw('COUNT(s.subcircuit_id) as total, ci.value as tipo, s2.display_name as subcircuito, c.display_name as circuito')
                ->join('catalog_items as ci', 's.catalog_item_id', '=', 'ci.id')
                ->join('subcircuits as s2', 's.subcircuit_id', '=', 's2.id')
                ->join('circuits as c', 's2.circuit_id', '=', 'c.id')
                ->whereBetween('s.created_at', [$filters['from_date'].' 00:00:00', $filters['to_date'].' 23:59:59'])
                ->groupBy('s.subcircuit_id', 's.catalog_item_id')
                ->when($request->filter ?? null, function($query, $filter){
                    if($filter == 'sugg'){
                        $query->where('s.catalog_item_id','1');
                    }elseif($filter == 'reclaim'){
                        $query->where('s.catalog_item_id','2');
                    }
                })
                ->paginate(20);

        //Añadimos la key para la tabla del antd
        $model->map(function($value, $key) use($filters) {
            $value->key = $key;
            $value->from_date = $filters['from_date'];
            $value->to_date = $filters['to_date'];
        });

        return Inertia::render('Suggestions/Index',[
            'claim' => Suggestion::haveClaim()->count(),
            'suggestion' => Suggestion::haveSugg()->count(),
            'modelList' => $model,
            'filters' => Rq::all('key','value','filter','filterDate')
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
