<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class FrontendController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->get();

        return view('frontend.index', compact('buildings'));
    }
}
