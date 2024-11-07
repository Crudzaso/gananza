<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/lottery-results', function () {
    return Inertia::render('LotteryResults', [
        'theme' => [
            'background' => '#f3f4f6',
            'cardBackground' => '#ffffff',
            'border' => '#e5e7eb',
            'primary' => '#1f2937',
            'textPrimary' => '#111827',
            'textSecondary' => '#6b7280',
            'emphasis' => '#d97706',
            'gradient' => 'linear-gradient(90deg, #d97706 0%, #fb923c 100%)'
        ]
    ]);
})->name('lottery-results');


Route::get('/auth/redirect/github', [AuthController::class, 'redirectToGitHub'])->name('github.login');
Route::get('/auth/callback/github', [AuthController::class, 'handleGitHubCallback'])->name('github.callback');

Route::get('/auth/redirect/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');


Route::middleware(['role:client'])->group(function () {
    Route::get('/test-client', function () {
        return Inertia::render('Profile/TestClient');
    });
});

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/crear-rifa', function () {
    return Inertia::render('RaffleCreate');
})->name('raffle-create');
