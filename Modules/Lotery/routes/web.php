<?php

use Illuminate\Support\Facades\Route;
use Modules\Lotery\Http\Controllers\LoteryController;

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

Route::prefix('lotery')->middleware(['auth', 'role:admin'])->name('lotery.')->group(function () {
    Route::get('/', [LoteryController::class, 'index'])->name('index');
    Route::get('/create', [LoteryController::class, 'create'])->name('create');
    Route::post('/store', [LoteryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [LoteryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LoteryController::class, 'update'])->name('update');
    Route::delete('/{id}', [LoteryController::class, 'destroy'])->name('destroy');
});