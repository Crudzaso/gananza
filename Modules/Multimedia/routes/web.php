<?php

use Illuminate\Support\Facades\Route;
use Modules\Multimedia\Http\Controllers\MultimediaController;

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

Route::prefix('multimedia')->middleware(['auth', 'role:admin'])->name('multimedia.')->group(function () {
    Route::get('/', [MultimediaController::class, 'index'])->name('index');
    Route::get('/create', [MultimediaController::class, 'create'])->name('create');
    Route::post('/store', [MultimediaController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [MultimediaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [MultimediaController::class, 'update'])->name('update');
    Route::delete('/{id}', [MultimediaController::class, 'destroy'])->name('destroy');
});