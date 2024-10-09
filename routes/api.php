<?php

use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('reset-free-parkings', [ParkingController::class, 'reset']);
Route::post('plans', [ParkingController::class, 'plans']);
Route::post('/create-parking', [ParkingController::class, 'create']);
Route::post('/process-payment', [ParkingController::class, 'processPayment']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
