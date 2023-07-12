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
use App\Http\Requests\SubcUserRequest;
use App\Http\Requests\AssignUserSubcircuitRequest;
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

class SubcircuitUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subuser.index')->only('index');
        $this->middleware('can:subuser.create')->only('create');
        $this->middleware('can:subuser.store')->only('store');
        $this->middleware('can:subuser.edit')->only('edit');
        $this->middleware('can:subuser.update')->only('update');
        $this->middleware('can:subuser.destroy')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
        $user = User::userInfo()->searchBar(Rq::only('key','value','filter'))->paginate(10)->appends(Rq::all());

        return Inertia::render('SubUsers/Index',[
            'haveSubc' => User::haveSubc()->count(),
            'notSubc' => User::notSubc()->count(),
            'userList' => new UserCollection($user),
            'filters' => Rq::all('key','value','filter')
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::userInfo()->notSubc()->searchBar(Rq::only('key','value','filter'))->paginate(15)->appends(Rq::all());
        $province = Province::withDepFull()->whereHasDepFull()->get();

        return Inertia::render('SubUsers/Create',[
        'provinces' => new AssignmentSubcCollection($province),
        'modelInfo' =>  new UserCollection($user)
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignUserSubcircuitRequest $request)
    {
        $model_list = User::whereIn('id',$request->userSelected)->get();

        $model_list->each(function($model) use ($request){
            $model->subcircuits()->sync([$request->dependence]);
        });

        return to_route('subuser.index')->with('success', 'Se asignó el subcircuito a los usuarios con éxito');
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
        $user = User::userInfo()->withSubc()->find($id);
        $user_subc = $user->subcircuits()->pluck('id')->toArray();
        $subcircuit = Subcircuit::withDep()->where('id',$user_subc)->first();

        return Inertia::render('SubUsers/Edit',[
            'provinces' => new AssignmentSubcCollection($province),
            'subcircuitInfo' => isset($subcircuit) ? new AssignmentSubResource($subcircuit) : [],
            'modelInfo' =>  new UserResource($user)
        ]); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcUserRequest $request, string $id)
    {
        
        $user = User::find($id);
        $user->subcircuits()->sync([$request->dependence]);

       return to_route('subuser.index')->with('success', 'El subcircuito se asignó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->subcircuits()->detach();
        return to_route('subuser.index')->with('success', 'El subcircuito se ha desasignado con éxito');
    }
}
