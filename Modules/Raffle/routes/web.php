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

Route::prefix('raffles')->middleware(['auth', 'role:admin'])->name('raffles.')->group(function () {
    Route::get('/', [RaffleController::class, 'index'])->name('index');
    Route::get('/create', [RaffleController::class, 'create'])->name('create');
    Route::post('/store', [RaffleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RaffleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RaffleController::class, 'update'])->name('update');
    Route::delete('/{id}', [RaffleController::class, 'destroy'])->name('destroy');
});