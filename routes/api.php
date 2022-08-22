<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthController::class, 'login']);


Route::get('/trips', [TripController::class, 'allTrips']);
Route::get('/avaliable-seats', [TripController::class, 'avaliableSeats']);
Route::post('/reservation/store', [TripController::class, 'storeReservation']);
