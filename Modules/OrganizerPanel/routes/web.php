<?php

use Illuminate\Support\Facades\Route;
use Modules\OrganizerPanel\Http\Controllers\OrganizerPanelController;

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

Route::group([], function () {
    Route::resource('organizerpanel', OrganizerPanelController::class)->names('organizerpanel');
    Route::get('/panel', [OrganizerPanelController::class, 'index'])->name('organizer.dashboard');
});