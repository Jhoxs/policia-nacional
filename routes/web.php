<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SubcircuitController;
use App\Http\Controllers\CircuitController;
use App\Http\Controllers\ParishController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SubcircuitUserController;
use App\Http\Controllers\SubcircuitVehicleController;
use App\Http\Controllers\UserVehicleController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('landingpage');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/rol', [RolController::class, 'index'])->name('rol.index');
    Route::get('/rol/create', [RolController::class, 'create'])->name('rol.create');
    Route::get('/rol/user-rol/{id}', [RolController::class, 'show'])->name('rol.show');
    Route::post('/rol', [RolController::class, 'store'])->name('rol.store');
    Route::get('/rol/{id}', [RolController::class, 'edit'])->name('rol.edit');
    Route::patch('/rol/{id}', [RolController::class, 'update'])->name('rol.update');
    Route::patch('/rol/user-rol/{id}', [RolController::class, 'updateUserRol'])->name('rol.updateUserRol');
    Route::delete('/rol/{id}', [RolController::class, 'destroy'])->name('rol.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
    Route::post('/vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::post('/vehicle/profile/{id}', [VehicleController::class, 'show'])->name('vehicle.show');
    Route::get('/vehicle/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::patch('/vehicle/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');
});
//Subcircuit
Route::middleware('auth')->group(function () {
    Route::get('/subcircuit', [SubcircuitController::class, 'index'])->name('subcircuit.index');
    Route::get('/subcircuit/create', [SubcircuitController::class, 'create'])->name('subcircuit.create');
    Route::post('/subcircuit', [SubcircuitController::class, 'store'])->name('subcircuit.store');
    Route::get('/subcircuit/{id}', [SubcircuitController::class, 'edit'])->name('subcircuit.edit');
    Route::patch('/subcircuit/{id}', [SubcircuitController::class, 'update'])->name('subcircuit.update');
    Route::delete('/subcircuit/{id}', [SubcircuitController::class, 'destroy'])->name('subcircuit.destroy');
});
//Circuit
Route::middleware('auth')->group(function () {
    Route::get('/circuit', [CircuitController::class, 'index'])->name('circuit.index');
    Route::get('/circuit/create', [CircuitController::class, 'create'])->name('circuit.create');
    Route::post('/circuit', [CircuitController::class, 'store'])->name('circuit.store');
    Route::get('/circuit/{id}', [CircuitController::class, 'edit'])->name('circuit.edit');
    Route::patch('/circuit/{id}', [CircuitController::class, 'update'])->name('circuit.update');
    Route::delete('/circuit/{id}', [CircuitController::class, 'destroy'])->name('circuit.destroy');
});
//Parish
Route::middleware('auth')->group(function () {
    Route::get('/parish', [ParishController::class, 'index'])->name('parish.index');
    Route::get('/parish/create', [ParishController::class, 'create'])->name('parish.create');
    Route::post('/parish', [ParishController::class, 'store'])->name('parish.store');
    Route::get('/parish/{id}', [ParishController::class, 'edit'])->name('parish.edit');
    Route::patch('/parish/{id}', [ParishController::class, 'update'])->name('parish.update');
    Route::delete('/parish/{id}', [ParishController::class, 'destroy'])->name('parish.destroy');
});
//City
Route::middleware('auth')->group(function () {
    Route::get('/city', [CityController::class, 'index'])->name('city.index');
    Route::get('/city/create', [CityController::class, 'create'])->name('city.create');
    Route::post('/city', [CityController::class, 'store'])->name('city.store');
    Route::get('/city/{id}', [CityController::class, 'edit'])->name('city.edit');
    Route::patch('/city/{id}', [CityController::class, 'update'])->name('city.update');
    Route::delete('/city/{id}', [CityController::class, 'destroy'])->name('city.destroy');
});
//Province
Route::middleware('auth')->group(function () {
    Route::get('/province', [ProvinceController::class, 'index'])->name('province.index');
    Route::get('/province/create', [ProvinceController::class, 'create'])->name('province.create');
    Route::post('/province', [ProvinceController::class, 'store'])->name('province.store');
    Route::get('/province/{id}', [ProvinceController::class, 'edit'])->name('province.edit');
    Route::patch('/province/{id}', [ProvinceController::class, 'update'])->name('province.update');
    Route::delete('/province/{id}', [ProvinceController::class, 'destroy'])->name('province.destroy');
});

//SubcircuitUser
Route::middleware('auth')->group(function () {
    Route::get('/subuser', [SubcircuitUserController::class, 'index'])->name('subuser.index');
    Route::get('/subuser/create', [SubcircuitUserController::class, 'create'])->name('subuser.create');
    Route::post('/subuser', [SubcircuitUserController::class, 'store'])->name('subuser.store');
    Route::get('/subuser/{id}', [SubcircuitUserController::class, 'edit'])->name('subuser.edit');
    Route::patch('/subuser/{id}', [SubcircuitUserController::class, 'update'])->name('subuser.update');
    Route::delete('/subuser/{id}', [SubcircuitUserController::class, 'destroy'])->name('subuser.destroy');
});

//SubcircuitVehicle
Route::middleware('auth')->group(function () {
    Route::get('/subvehicle', [SubcircuitVehicleController::class, 'index'])->name('subvehicle.index');
    Route::get('/subvehicle/create', [SubcircuitVehicleController::class, 'create'])->name('subvehicle.create');
    Route::post('/subvehicle', [SubcircuitVehicleController::class, 'store'])->name('subvehicle.store');
    Route::get('/subvehicle/{id}', [SubcircuitVehicleController::class, 'edit'])->name('subvehicle.edit');
    Route::patch('/subvehicle/{id}', [SubcircuitVehicleController::class, 'update'])->name('subvehicle.update');
    Route::delete('/subvehicle/{id}', [SubcircuitVehicleController::class, 'destroy'])->name('subvehicle.destroy');
});

//UserVehicle
Route::middleware('auth')->group(function () {
    Route::get('/uservehicle', [UserVehicleController::class, 'index'])->name('uservehicle.index');
    Route::get('/uservehicle/create', [UserVehicleController::class, 'create'])->name('uservehicle.create');
    Route::post('/uservehicle', [UserVehicleController::class, 'store'])->name('uservehicle.store');
    Route::get('/uservehicle/{id}', [UserVehicleController::class, 'edit'])->name('uservehicle.edit');
    Route::patch('/uservehicle/{id}', [UserVehicleController::class, 'update'])->name('uservehicle.update');
    Route::delete('/uservehicle/{id}', [UserVehicleController::class, 'destroy'])->name('uservehicle.destroy');
});


//Suggestion forms
Route::middleware('guest')->group(function () {
    Route::get('/suggestionform', [SuggestionController::class, 'indexFormSuggestion'])->name('suggestion.indexform');
    Route::post('/suggestionform', [SuggestionController::class, 'storeFormSuggestion'])->name('suggestion.storeform');
});

//UserVehicle
Route::middleware('auth')->group(function () {
    Route::get('/suggestion', [SuggestionController::class, 'index'])->name('suggestion.index');
    
});

require __DIR__.'/auth.php';
