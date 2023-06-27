<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
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
});

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

require __DIR__.'/auth.php';
