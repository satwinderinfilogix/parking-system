<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parkings(){
        return $this->hasMany(BuildingParking::class,'building_id');
    }
}
