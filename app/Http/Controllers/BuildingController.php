<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\BuildingParking;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Building::all();
        return view('admin.building.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.building.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $building = Building::create([
            "name" => $request->name,
            "free" => $request->free_days,
            "every" => $request->every_days,
        ]);

        if(isset($request->periods)){
            foreach ($request->periods as $period) {
                BuildingParking::create([
                    "building_id" => $building->id,
                    "days" => $period['days'],
                    "price" => $period['price'],
                ]);
            }
        }

        return redirect()->route('building.index')->with('success','Building created successfully');
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
        $building = Building::with('parkings')->where('id',$id)->first();
        return view('admin.building.edit',compact('building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $building = Building::findOrFail($id);

        $building->update([
            "name" => $request->name,
            "free" => $request->free_days,
            "every" => $request->every_days,
        ]);

        if (isset($request->periods)) {
            BuildingParking::where('building_id', $building->id)->delete();

            foreach ($request->periods as $period) {
                BuildingParking::create([
                    "building_id" => $building->id,
                    "days" => $period['days'],
                    "price" => $period['price'],
                ]);
            }
        }
        return redirect()->route('building.index')->with('success','Building updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = Building::where('id',$id)->delete();
        BuildingParking::where('building_id',$id)->delete();
        return redirect()->route('building.index')->with('success','Building deleted successfully');

    }

    public function unitByBuildingPlan($building_id){
        $buildingParking = Building::with('parkings')->where('id',$building_id)->first();

        if($buildingParking){
            $data = [
                "success" => true,
                "plans" => $buildingParking
            ];
        }else{
            $data = [
                "message" => "No plans found for this building."
            ];
        }
        return response()->json($data);
    }
}
