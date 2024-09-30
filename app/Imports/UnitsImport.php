<?php

namespace App\Imports;

use App\Models\Unit;
use App\Models\Building;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitsImport implements ToModel, WithHeadingRow
{
    protected $errors = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'building_name' => 'required',
            'unit_name'     => 'required',
            'security_code'     => 'required',
            '30_days_cost'  => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $this->errors[] = $validator->errors()->all();
            return null;
        }

        $building = Building::where('name', $row['building_name'])->first();

        if ($building) {
            $buildingId = $building->id;
        } else {
            $newBuilding = Building::create([
                'name' => $row['building_name'],
            ]);
            $buildingId = $newBuilding->id;
        }

        $unit = Unit::where('building_id', $buildingId)->where('unit_number', $row['unit_name'])->first();
        if (!$unit) {
            Unit::create([
                'building_id'   => $buildingId,
                'unit_number'   => $row['unit_name'],
                'security_code' => $row['security_code'],
                '30_days_cost'  => $row['30_days_cost']
            ]);
        } else {
            $unit->update([
                'security_code' => $row['security_code'],
                '30_days_cost'  => $row['30_days_cost']
            ]);
        }

        return null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
