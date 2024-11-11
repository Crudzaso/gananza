<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminPasswordVerification;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Raffle\Http\Controllers\RaffleController;

// Ruta pública
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Grupo de rutas autenticadas
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Grupo de rutas para cliente
Route::middleware(['role:client'])->group(function () {
    Route::get('/test-client', function () {
        return Inertia::render('Profile/TestClient');
    });
});

// Grupo de rutas protegidas por el middleware de verificación de contraseña
Route::middleware(['auth', 'role:admin'])->get('dashboard/admin', function () {
    return Inertia::render('Admin/AdminDashboard');
})->name('admin.dashboard');

// Grupo de rutas para la gestión de usuarios
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/raffles-actives', [RaffleController::class, 'getRaffles'])->name('raffles.actives');

Route::get('/raffles-last-chance', [RaffleController::class, 'getLastChanceRaffles'])->name('raffles.last-chance');

Route::get('/auth/redirect/github', [AuthController::class, 'redirectToGitHub'])->name('github.login');
Route::get('/auth/callback/github', [AuthController::class, 'handleGitHubCallback'])->name('github.callback');

Route::get('/auth/redirect/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

    
