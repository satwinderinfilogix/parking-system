<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class ParkingController extends Controller
{
    public function create(Request $equest)
    {
        $parking = Parking::create([
            'building_id' => $request->building_id,
            'unit_id'     => $request->unit_id,
            'plan'        => $request->plan,
            'start_date'  => $request->start_date,
            'car_brand'   => $request->car_brand,
            'model'       => $request->model,
            'color'       => $erquest->color,
            'license_plate'=> $request->license_plate,
            'email'        => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parking created successfully.',
            'data'    => $parking
        ]);
    }
}
