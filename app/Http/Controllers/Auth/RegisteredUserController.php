<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rank;
use App\Models\BloodType;
use App\Models\City;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RegisteredUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $combobox_options = [
            'ranks' => (new Rank)->displayFormattedOptions(),
            'blood_types' => (new BloodType)->displayFormattedOptions(),
            'cities' => (new City)->displayFormattedOptions(),
        ];
        return Inertia::render('Auth/Register',$combobox_options);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'identification' => $request->identification,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate_string,
            'city_id' => $request->city,
            'blood_type_id' => $request->blood_type,
            'rank_id' => $request->rank,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
