<?php

use Illuminate\Support\Facades\Route;
use Modules\OrganizerPanel\Http\Controllers\OrganizerPanelController;
use Modules\Raffle\Http\Controllers\RaffleController;

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

Route::middleware(['role:organizador'])->group(function () {
    // Rutas del panel del organizador
    Route::resource('organizerpanel', OrganizerPanelController::class)->names('organizerpanel');
    Route::get('admin/panel', [OrganizerPanelController::class, 'index'])->name('organizer.dashboard');
    
    // Rutas para rifas
    Route::get('/admin/crear-rifa', [RaffleController::class, 'create'])->name('create');
    Route::post('/admin/actualizar-rifa', [RaffleController::class, 'store'])->name('store');
    Route::get('/admin/rifas', [RaffleController::class, 'index'])->name('index');
});