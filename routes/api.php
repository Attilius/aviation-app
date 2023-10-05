<?php

use App\Http\Controllers\Api\v1\CurrentTimeController;
use App\Http\Controllers\Api\v1\DestinationServiceController;
use App\Http\Controllers\Api\v1\FlightServiceController;
use App\Http\Controllers\Api\v1\PrivateJetRentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/search/offers', [PrivateJetRentController::class, 'index'])->name('plane-choosing');
Route::get('/time', CurrentTimeController::class);
Route::get('/{cityName}', DestinationServiceController::class);

Route::get('/flight/all', [FlightServiceController::class, 'index']);
Route::get('/flight/{id}', [FlightServiceController::class, 'getOnlyFlight']);
Route::post('/flight/create', [FlightServiceController::class, 'storeFlight']);
Route::patch('/flight/edit/{id}', [FlightServiceController::class, 'updateFlight']);
Route::delete('/flight/remove/{id}', [FlightServiceController::class, 'removeFlight']);
