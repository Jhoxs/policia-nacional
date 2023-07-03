<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Rank;
use App\Models\BloodType;
use App\Models\City;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\CreateUserMailAlert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.index')->only('index');
        $this->middleware('can:user.create')->only('create');
        $this->middleware('can:user.store')->only('store');
        $this->middleware('can:user.show')->only('show');
        $this->middleware('can:user.edit')->only('edit');
        $this->middleware('can:user.update')->only('update');
        $this->middleware('can:user.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {    
        $usersData = (new User)->userInfo()->SearchBar(Rq::all('value','key'))->paginate(10);

        return Inertia::render('Users/Index',[ 
            'usersData' => new UserCollection($usersData)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return Inertia::render('Users/Create',[ 
            'ranks' => (new Rank)->displayFormattedOptions(),
            'blood_types' => (new BloodType)->displayFormattedOptions(),
            'cities' => (new City)->displayFormattedOptions(),
            'roles' => Role::select('name as value','name as label')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $password = Str::password(12);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'identification' => $request->identification,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'city_id' => $request->city,
            'blood_type_id' => $request->blood_type,
            'rank_id' => $request->rank,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        event(new Registered($user));

        $user->syncRoles($request->roles);

        $mail_info = (object)[];
        $mail_info->name = $request->name;
        $mail_info->email = $request->email;
        $mail_info->password = $password;

        Notification::sendNow($user, new CreateUserMailAlert($mail_info));

        
        return to_route('user.index')->with('success', 'El usuario se ha creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = (new User)->show_user_info($id);
        
        return Inertia::render('Users/Edit',[
            'ranks' => (new Rank)->displayFormattedOptions(),
            'blood_types' => (new BloodType)->displayFormattedOptions(),
            'cities' => (new City)->displayFormattedOptions(),
            'roles' => Role::select('name as value','name as label')->get(),
            'userInfo' => new UserResource($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $user)
    {
        $user = User::find($user);

        $request->validate([
            'phone' => ['required','numeric','max_digits:10',Rule::unique('users','phone')->ignore($user->id)],
            'email' => ['required','string','email','max:255',Rule::unique('users','email')->ignore($user->id)],
            'identification' => ['required','numeric','max_digits:10',Rule::unique('users','identification')->ignore($user->id)],
        ],[
            'identification.required' => 'La identificación es requerida',
            'identification.max_digits' => 'La identificación no puede tener más de diez digitos',
            'identification.numeric' => 'La identificación solo acepta elementos numéricos',
            'identification.unique' => 'La identificación ya existe dentro del sistema',
            'phone.required' => 'El teléfono es requerido',
            'phone.max_digits' => 'La teléfono no puede tener más de diez digitos',
            'phone.numeric' => 'El teléfono solo acepta elementos numéricos',
            'phone.unique' => 'El teléfono ya existe dentro del sistema',
            'email.required' => 'El email es requerido',
            'email.unique' => 'El email ya existe dentro del sistema',
        ]);
        
        $user->update([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'identification' => $request->identification,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'city_id' => $request->city,
            'blood_type_id' => $request->blood_type,
            'rank_id' => $request->rank,
            'email' => $request->email,
        ]);
        
        $user->syncRoles($request->roles);
        
        return to_route('user.index')->with('success', 'El usuario se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $user = User::find($user);
        $user->delete();

        return to_route('user.index')->with('success', 'El usuario se ha eliminado con éxito');
    }
}
