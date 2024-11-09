<?php

use Illuminate\Support\Facades\Route;
use Modules\Reward\Http\Controllers\RewardController;

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


Route::prefix('rewards')->middleware(['auth', 'role:admin'])->name('rewards.')->group(function () {
    Route::get('/', [RewardController::class, 'index'])->name('index');
    Route::get('/create', [RewardController::class, 'create'])->name('create');
    Route::post('/store', [RewardController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RewardController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RewardController::class, 'update'])->name('update');
    Route::delete('/{id}', [RewardController::class, 'destroy'])->name('destroy');
});
