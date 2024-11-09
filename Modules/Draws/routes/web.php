<?php

use Illuminate\Support\Facades\Route;
use Modules\Draws\Http\Controllers\DrawsController;

Route::prefix('draws')->middleware(['auth', 'role:admin'])->name('draws.')->group(function () {
    Route::get('/', [DrawsController::class, 'index'])->name('index');
    Route::get('/create', [DrawsController::class, 'create'])->name('create');
    Route::post('/store', [DrawsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DrawsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DrawsController::class, 'update'])->name('update');
    Route::delete('/{id}', [DrawsController::class, 'destroy'])->name('destroy');
});
