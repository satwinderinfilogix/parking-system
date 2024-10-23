<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function building(){
        return $this->hasOne(Building::class,'id','building_id');
    }
    public function parkings(){
        return $this->hasMany(BuildingParking::class,'building_id');
    }
}
