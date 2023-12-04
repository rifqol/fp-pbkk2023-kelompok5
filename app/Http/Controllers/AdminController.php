<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $public_product_count = Product::where('is_public', true)->count();
        $order_count = Order::count();
        $total_income = Order::whereIn('status', ['Paid', 'Shipping', 'Complete'])->sum('total');
        $user_count = User::count();
        return view('admin.dashboard')->with([
            'public_product_count' => $public_product_count,
            'order_count' => $order_count,
            'total_income' => $total_income,
            'user_count' => $user_count,
        ]);
    }

    public function orders()
    {
        $orders = Order::with(['seller', 'user', 'user.region'])
            ->latest()
            ->paginate(20)
            ->withQueryString();
        return view('admin.orders')->with(['orders' => $orders]);
    }
}
