<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = Cache::remember('users', 120, function() {
            return User::all();
        });
        return view('dashboard.users')->with('users', $users);
    }

    public function create()
    {
        return view('form');
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'region_code' => $data['region_code'],
        ]);
        
        $path = Storage::put('public/images', $data['photo']);
        $user->photo_url = url(Storage::url($path));
        $user->save();

        return redirect('login')->with('success', 'Succesfuly registered!');
    }
}
