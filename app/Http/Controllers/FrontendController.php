<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\PrivacyPolicy;

class FrontendController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->get();
        $policy = PrivacyPolicy::first();
        $disclaimer = $policy->disclaimer;
        return view('frontend.index', compact('buildings','disclaimer'));
    }
}
