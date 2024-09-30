<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Unit;
use App\Imports\UnitsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildings = Building::latest()->get();
        return view('admin.unit.index', compact('buildings'));
    }

    public function getUnits(Request $request)
    {
        $columns = ['units.id', 'units.building_id', 'buildings.name AS building', 'units.unit_number', 'units.security_code', 'units.30_days_cost'];

        $query = Unit::select($columns)
            ->join('buildings', 'units.building_id', '=', 'buildings.id') // Adjust this line to match your foreign key relationship
            ->with('building');

        if($request->building){
            $query->where('units.building_id', $request->building);
        }

        // Check if the search parameter exists and is not empty
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('buildings.name', 'like', "%{$search}%")
                ->orWhere('units.unit_number', 'like', "%{$search}%")
                ->orWhere('units.security_code', 'like', "%{$search}%");
            });
        }

        // Get total records before filtering
        $totalRecords = $query->count();

        // Apply ordering if specified
        if ($request->has('order')) {
            $orderColumn = $columns[$request->order[0]['column']];
            $orderDirection = $request->order[0]['dir'];
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buildings = Building::all();
        return view('admin.unit.create', compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'building'   => 'required',
            'unit_number'   => 'required',
            'security_code' => 'required',
            '30_days_cost' => 'required'
        ]);

        $exist = Unit::where('building_id', $request->building)->where('unit_number', $request->unit_number)->first();
        if ($exist) {
            return redirect()->route('unit.create')->with('error', 'Unit already exist');
        } else {
            Unit::create([
                "building_id" => $request->building,
                "unit_number" => $request->unit_number,
                "security_code" => $request->security_code,
                "30_days_cost" => $request->input('30_days_cost'),
            ]);
            return redirect()->route('unit.index')->with('success', 'Unit created successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $units = Unit::with('building')->where('id', $id)->first();
        $buildings = Building::all();
        return view('admin.unit.edit', compact('buildings', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'building'   => 'required',
            'unit_number'   => 'required',
            'security_code' => 'required',
            '30_days_cost' => 'required'
        ]);

        Unit::where('id', $id)->update([
            "building_id" => $request->building,
            "unit_number" => $request->unit_number,
            "security_code" => $request->security_code,
            "30_days_cost" => $request->input('30_days_cost'),
        ]);
        return redirect()->route('unit.index', $id)->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::where('id', $id)->delete();
        return redirect()->route('unit.index')->with('success', 'unit deleted successfully');
    }


    public function unitByBuilding($buildingId)
    {
        $units = Unit::where('building_id', $buildingId)->get();

        if ($units->isEmpty()) {
            return response()->json(['message' => 'No units found for this building.'], 404);
        }

        return response()->json([
            'success' => true,
            'units'   => $units
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $import = new UnitsImport;
        Excel::import($import, $request->file('file'));

        if ($errors = $import->getErrors()) {
            $flattenedErrors = array_merge(...$errors);

            return redirect()->back()->withErrors($flattenedErrors)->withInput(); // Redirect back with errors
        }

        return redirect()->route('unit.index')->with('success', 'Units imported successfully.');
    }
}
