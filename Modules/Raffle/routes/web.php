<?php

use Illuminate\Support\Facades\Route;
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

Route::middleware(['auth', 'role:admin|organizador'])->prefix('raffles')->name('raffles.')->group(function () {
    Route::get('/admin/rifas', [RaffleController::class, 'index'])->name('index');
    Route::get('/admin/crear-rifa', [RaffleController::class, 'create'])->name('create');
    Route::post('/admin/actualizar-rifa', [RaffleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RaffleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RaffleController::class, 'update'])->name('update');
    Route::delete('/{id}', [RaffleController::class, 'destroy'])->name('destroy');
});