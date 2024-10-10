<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required',],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('parking');
        }
 
        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'change_password' => ['required', 'string', 'confirmed'],
            'change_password_confirmation' => 'required|string',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->change_password);
        $user->save();

        return redirect()->back()->with('success','Password reset successfully');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
