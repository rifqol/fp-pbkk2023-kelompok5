<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = Cache::remember('users', 120, function() {
            return User::all();
        });
        return view('dashboard.users')->with('users', $users);
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $products = Product::where('is_deleted', false)
            ->where('seller_id', $user->id)
            ->limit(5)
            ->get();
        $incoming_orders = $user->incomingOrders()
            ->withCount('products')
            ->limit(5)
            ->get();
        // dd(array_map(function($item) {
        //     return ['quantity' => $item['pivot']['quantity']];
        // },$user->cart->toArray()));

        // dd($user->orders()->withCount(['products'])->get()->toArray());

        // dd($user->incomingOrders()
        // ->withCount('products')
        // ->get());

        return view('dashboard.index')->with([
            'products' => $products,
            'incoming_orders' => $incoming_orders,
        ]);
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

    public function show($id)
    {
        $user = User::find($id);
        $products = $user->products()->paginate(20)->withQueryString();

        return view('user.detail', ['user' => $user, 'products' => $products]);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
    
        return view('user.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'nullable|max:255',
            'username' => 'nullable|max:255',
            'email' => [
                'nullable',
                Rule::unique('users')->ignore($request->user()->id),
                'max:255',
            ],
            'phone' => 'nullable|max:20',
            'region_code' => 'nullable|max:13|exists:regions,code',
            'password' => 'nullable|min:4|max:255',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2048'
        ]);
        
        $user = User::find($id);
        $user->update($request->except('photo'));
        
        dd($user);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo_url = $photoPath;
        }
    
        $user->save();
        
        return redirect()->route('user.edit', $user->id)->with('success', 'User updated successfully');
    }
    
}
