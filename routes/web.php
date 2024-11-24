<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Middleware\AdminPasswordVerification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Raffle\Http\Controllers\RaffleController;
use Modules\Ticket\Http\Controllers\TicketController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Ruta pública
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Grupo de rutas para testing con prefijo /test-error
Route::prefix('test-error')->group(function () {
    // Error 403 - Forbidden
    Route::get('/403', function () {
        throw new AccessDeniedHttpException('USER DOES NOT HAVE THE RIGHT ROLES.');
    })->name('test.403');

    // Error 401 - Unauthorized
    Route::get('/401', function () {
        throw new AuthenticationException('Usuario no autenticado');
    })->name('test.401');

    // Error 404 - Not Found
    Route::get('/404', function () {
        throw new NotFoundHttpException('Recurso no encontrado');
    })->name('test.404');

    // Error 500 - Server Error
    Route::get('/500', function () {
        throw new \Exception('Error interno del servidor');
    })->name('test.500');

    // Error de Autorización (también 403)
    Route::get('/forbidden', function () {
        throw new AuthorizationException('No tienes permiso para realizar esta acción');
    })->name('test.forbidden');

    // Error personalizado
    Route::get('/custom', function () {
        $errorMessage = [
            'error' => 'Error personalizado',
            'details' => 'Detalles adicionales del error',
            'timestamp' => now()->toIso8601String(),
        ];
        
        throw new \Exception(json_encode($errorMessage));
    })->name('test.custom');
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
    Route::get('/raffles/active', [UserController::class, 'activeRaffles'])->name('raffles.active');
});

Route::middleware(['auth'])->get('/profile/{user}', [UserController::class, 'showProfile'])->name('users.profile');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/raffles-actives', [RaffleController::class, 'getRaffles'])->name('raffles.actives');

Route::get('/raffles-last-chance', [RaffleController::class, 'getLastChanceRaffles'])->name('raffles.last-chance');

Route::get('/auth/redirect/github', [AuthController::class, 'redirectToGitHub'])->name('github.login');
Route::get('/auth/callback/github', [AuthController::class, 'handleGitHubCallback'])->name('github.callback');

Route::get('/auth/redirect/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/raffles-filtered', [RaffleController::class, 'getFilteredRaffles'])->name('raffles.filtered');



Route::middleware(['auth'])->group(function () {
    Route::get('/api/user-tickets/{userId}', [TicketController::class, 'getUserTickets'])->name('user.tickets');
    Route::get('/api/active-raffles', [RaffleController::class, 'getActiveRaffles'])->name('raffles.active');
    Route::get('/registro-organizador', [UserController::class, 'registerOrganizer'])->name('register.organizer');
    Route::post('/register-organizer', [UserController::class, 'storeOrganizer'])->name('organizer.register');

});


Route::post('/users/{user}/update-photo', [UserController::class, 'updateProfilePhoto'])->name('user.update-photo');

Route::post('/payment/create', [PaymentController::class, 'create']);
Route::post('/payment/store', [PaymentController::class, 'store']);

Route::post('/verify-payment', [PaymentVerificationController::class, 'verifyPayment']);


