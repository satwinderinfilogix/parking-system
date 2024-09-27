<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParkingEmail;
use App\Models\Building;

class ParkingController extends Controller
{
    public function index()
    {
        $parkings = Parking::with('building', 'unit')->latest()->get();

        return view('admin.parking.index', compact('parkings'));
    }

    public function getParking(Request $request)
    {
        // Define the columns we want to select
        $columns = [
            'parkings.id',
            'buildings.name AS building',   // Building Name
            'units.unit_number',             // Unit Number
            'parkings.plan',                 // Plan
            'parkings.start_date',           // Start Date
            'parkings.license_plate',        // License Plate
            'parkings.email',                // Email
            'parkings.phone_number'          // Phone Number
        ];
    
        // Build the initial query with joins
        $query = Parking::select($columns)
            ->join('units', 'parkings.unit_id', '=', 'units.id') // Join with units
            ->join('buildings', 'units.building_id', '=', 'buildings.id'); // Join with buildings
    
        // Filter by building if specified
        if ($request->filled('building')) {
            $query->where('units.building_id', $request->building);
        }
    
        // Check if the search parameter exists and is not empty
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('buildings.name', 'like', "%{$search}%")
                  ->orWhere('units.unit_number', 'like', "%{$search}%")
                  ->orWhere('parkings.license_plate', 'like', "%{$search}%")
                  ->orWhere('parkings.email', 'like', "%{$search}%")
                  ->orWhere('parkings.phone_number', 'like', "%{$search}%");
            });
        }
    
        // Get total records before filtering
        $totalRecords = $query->count();
    
        // Apply ordering if specified
        if ($request->has('order')) {
            $orderColumnIndex = $request->order[0]['column'];
            $orderDirection = $request->order[0]['dir'];
    
            // Use the original column name instead of the alias
            $orderColumn = $columns[$orderColumnIndex]; // This will give you the alias, e.g., 'buildings.name AS building'
            
            // Extract the actual column name for ordering
            if (strpos($orderColumn, ' AS ') !== false) {
                $orderColumn = explode(' AS ', $orderColumn)[0]; // Get the part before ' AS '
            }
    
            $query->orderBy($orderColumn, $orderDirection);
        }
    
        // Get filtered records count
        $filteredRecords = $query->count();
    
        // Paginate the results
        $data = $query->skip($request->start)->take($request->length)->get();
    
        // Return the response as JSON
        return response()->json([
            "draw" => intval($request->draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ]);
    }

    public function create(Request $request)
    {
        $parkingDetail = Parking::create([
            'building_id' => $request->building_id,
            'unit_id'     => $request->unit_id,
            'plan'        => $request->plan,
            'start_date'  => $request->startDate,
            'car_brand'   => $request->brand,
            'model'       => $request->model,
            'color'       => $request->color,
            'license_plate'=> $request->licensePlate,
            'email'        => $request->email,
            'phone_number'  => $request->phone_number
        ]);

        if($request->email) {
            $parking = route('booked-parking', $parkingDetail->id);
            Mail::to($request->email)->send(new ParkingEmail($parking));
        }

        return response()->json([
            'success' => true,
            'message' => 'Parking created successfully.',
            'data'    => $parkingDetail,
            'parkingId' => $parkingDetail->id
        ]);
    }

    public function plans(Request $request)
    {
        $currentDate = now();
        $dateThirtyDaysAgo = now()->subDays(30);
        $plan = Parking::where('building_id', $request->building_id)
                    ->where('unit_id', $request->unit_id)
                    ->where('plan', '3days')
                    ->whereBetween('created_at', [$dateThirtyDaysAgo, $currentDate]) // Ensure it's within the last 30 days
                    ->get();
        if ($plan->isEmpty()) {
            return response()->json([
                'success' => false,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Existing 3days parking',
                'data'    => $plan
            ]);
        }
    }

    public function showBookedParking($parkingId){
        $parking = Parking::with('building', 'unit')->find($parkingId);

        return view('frontend.invoice', compact('parking'));
    }

    public function addNew()
    {
        $buildings = Building::all();

        return view('admin.parking.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $rules = [
            'building_id'   => 'required',
            'unit_number'   => 'required',
            'security_code' => 'required',
            'plan'          => 'required',
            'start_date'    => 'required',
            'car_brand'     => 'required',
            'model'         => 'required',
            'color'         => 'required',
            'license_plate' => 'required',
            'confirmation'  => 'required',
        ];
    
        if ($request->confirmation === 'Email') {
            $rules['email'] = 'required|email';
        } else if($request->confirmation === 'Text') {
            $rules['phone'] = 'required';
        }
        $request->validate($rules);

        $parkingDetail = Parking::create([
            'building_id' => $request->building_id,
            'unit_id'     => $request->unit_id,
            'plan'        => $request->plan,
            'start_date'  => $request->start_date,
            'car_brand'   => $request->car_brand,
            'model'       => $request->model,
            'color'       => $request->color,
            'license_plate'=> $request->licensePlate,
            'email'        => $request->email,
            'phone_number'  => $request->phone_number
        ]);

        return redirect()->route('parking.index')->with('success', 'Parking created successfully');
    }
}
