<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPlan extends Model
{
    use HasFactory;
    protected $table = 'unit_plans';
    protected $guarded = [];
}