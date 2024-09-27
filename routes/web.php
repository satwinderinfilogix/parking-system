<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\QRCodeController;

Route::get('/', [FrontendController::class, 'index']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/parking-booked/{parkingId}', [ParkingController::class, 'showBookedParking'])->name('booked-parking');
Route::get('/qrcode/{parkingId}', [QRCodeController::class, 'generate'])->name('generate-qrcode');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::resources([
        'dashboard'  => DashboardController::class,
        'building'  => BuildingController::class,
        'unit'  => UnitController::class,
        'parking' => ParkingController::class,
    ]);
});

// Api Endpoint
Route::get('/units-by-building-id/{building_id}', [UnitController::class, 'unitByBuilding']);
Route::get('/units/data', [UnitController::class, 'getUnits']);
