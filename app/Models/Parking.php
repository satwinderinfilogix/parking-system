<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function building(){
        return $this->hasOne(Building::class,'id','building_id');
    }
    
    public function unit(){
        return $this->hasOne(Unit::class,'id','unit_id');
    }
}
