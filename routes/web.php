<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Mail;

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

    Route::get('/parkings/add', [ParkingController::class, 'addNew'])->name('parking.addNew');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');

});

// Import Csv Files 
Route::post('units/import', [UnitController::class, 'import'])->name('units.import'); // Import Unit csv file

// Export Csv Files
Route::get('download-units-sample', function() {
    $file = public_path('assets/sample-unit/units.csv');
    return Response::download($file);
});

// Api Endpoint
Route::get('/units-by-building-id/{building_id}', [UnitController::class, 'unitByBuilding']);
Route::get('/units/data', [UnitController::class, 'getUnits']);
Route::get('/parkings/data', [ParkingController::class, 'getParking']);

Route::get('/test-email', function () {
    Mail::raw('This is a test email.', function ($message) {
        $message->to('nitika.ltr@gmail.com')->subject('Test Email');
    });

    return 'Email successfully sent!';
});

Route::get('/test-sms/{phoneNumber}', [ParkingController::class, 'sendMessage']);