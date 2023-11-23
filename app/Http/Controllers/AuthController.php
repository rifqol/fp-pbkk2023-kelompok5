<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function attemptLogin(Request $request)
    {
        $credetials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($credetials))
        {
            $request->session()->regenerate();
            return redirect('dashboard');
        }

        return back()->withErrors([
            'credentials' => 'Invalid Credentials!',
        ]);
    }

    public function register()
    {
        $provinces = Region::whereRaw('CHAR_LENGTH(code) = 2')->get();
        return view('form')->with(['provinces' => $provinces]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login');
    }
}
