<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
class SettingController extends Controller
{
    public function index(){
        return view('admin.settings');
    }

    public function viewPrivacyPolicy(){
        $policy = PrivacyPolicy::first(); 
        return view('admin.privacy-policy.index',compact('policy'));
    }

    public function updatePrivacyPolicy(Request $request){
        $policy = PrivacyPolicy::first();
        if ($policy) {
            $policy->content = $request->content;
            $policy->disclaimer = $request->disclaimer;
        } else {
            $policy = new PrivacyPolicy();
            $policy->content = $request->content ?? '';
            $policy->disclaimer = $request->disclaimer  ?? '';
        }
        $policy->save();
        return redirect()->back()->with('success','Updated Successfully');
    }
    public function privacyPolicy(){
        $policy = PrivacyPolicy::first(); 
        $content = $policy->content ?? 'Policy not available';
        return view('frontend.privacy-policy',compact('content'));
    }
}
