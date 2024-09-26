<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate(Request $request, $parkingId)
    {
        // Specify the link you want the QR code to open
        $link = route('booked-parking', $parkingId);

        // Generate the QR code
        $qrCode = QrCode::generate($link);

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
