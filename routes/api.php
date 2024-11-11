<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lottery\Http\Controllers\LotteryController;
use App\Http\Controllers\RaffleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/loterias',[LotteryController::class,'index']);


Route::post('/raffles',[RaffleController::class,'store']);