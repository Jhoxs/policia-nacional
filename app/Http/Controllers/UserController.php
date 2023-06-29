<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\UserCollection;
use App\Models\Rank;
use App\Models\BloodType;
use App\Models\City;
use Spatie\Permission\Models\Role;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\CreateUserMailAlert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersData = (new User)->show_table_list(10);

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
