<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Middleware\AdminPasswordVerification;
use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Telescope\Telescope;
use Modules\Raffle\Http\Controllers\RaffleController;
use Modules\Ticket\Http\Controllers\TicketController;

// Rutas públicas
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

// Rutas autenticadas
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Rutas para cliente
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/test-client', function () {
        return Inertia::render('Profile/TestClient');
    });
});

// Rutas para administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard/admin', function () {
        return Inertia::render('Admin/AdminDashboard');
    })->name('admin.dashboard');

    // Gestión de usuarios
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

// Rutas autenticadas generales
Route::middleware(['auth'])->group(function () {
    // Perfil de usuario
    Route::get('/profile/{user}', [UserController::class, 'showProfile'])->name('users.profile');
    Route::post('/users/{user}/update-photo', [UserController::class, 'updateProfilePhoto'])->name('user.update-photo');

    // Rifas
    Route::get('/raffles-actives', [RaffleController::class, 'getRaffles'])->name('raffles.actives');
    Route::get('/raffles-last-chance', [RaffleController::class, 'getLastChanceRaffles'])->name('raffles.last-chance');
    Route::get('/raffles-filtered', [RaffleController::class, 'getFilteredRaffles'])->name('raffles.filtered');
    Route::get('/raffles/active', [UserController::class, 'activeRaffles'])->name('raffles.active');

    // Tickets
    Route::get('/api/user-tickets/{userId}', [TicketController::class, 'getUserTickets'])->name('user.tickets');
    Route::get('/api/active-raffles', [RaffleController::class, 'getActiveRaffles'])->name('raffles.active');
    Route::post('/ticket/create', [TicketController::class, 'store']);

    // Registro de organizador
    Route::get('/registro-organizador', [UserController::class, 'registerOrganizer'])->name('register.organizer');
    Route::post('/register-organizer', [UserController::class, 'storeOrganizer'])->name('organizer.register');

    // Autenticación con terceros
    Route::get('/auth/redirect/github', [AuthController::class, 'redirectToGitHub'])->name('github.login');
    Route::get('/auth/callback/github', [AuthController::class, 'handleGitHubCallback'])->name('github.callback');
    Route::get('/auth/redirect/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Rutas de pago
Route::post('/payment/create', [PaymentController::class, 'create']);
Route::post('/payment/createPayment', [PaymentController::class, 'createPayment']);
Route::post('/payment/store', [PaymentController::class, 'store']);
Route::post('/verify-payment', [PaymentVerificationController::class, 'verifyPayment']);