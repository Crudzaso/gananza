<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);       // Create a new user
    Route::put('/{id}', [UserController::class, 'update']);   // Update an existing user
    Route::delete('/{id}', [UserController::class, 'destroy']); // Delete a user
});