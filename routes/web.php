<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminPasswordVerification;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Grupo de rutas para verificación de contraseña de administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/verify-password', [AdminAuthController::class, 'showVerification'])
        ->name('admin.verify-password');
    Route::post('/admin/verify-password', [AdminAuthController::class, 'verifyPassword'])
        ->name('admin.verify-password.check');
    Route::get('/clear-verification', [AdminAuthController::class, 'clearVerification'])
        ->name('admin.clear-verification');
});

// Grupo de rutas protegidas por el middleware de verificación de contraseña
Route::middleware(['auth', 'role:admin', AdminPasswordVerification::class])->group(function () {
    // Panel de administración personalizado
    Route::get('/dashboard/admin', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');
});

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
