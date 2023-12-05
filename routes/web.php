<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\UserController;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('test', function() {
    return view('login')->with('success', 'Succesfuly registered!');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function() {
        return redirect('/dashboard');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
        Route::get('/', [AdminController::class, 'dashboard']);
        Route::group(['prefix' => 'order'], function() {
            Route::get('/', [AdminController::class, 'orders']);
            Route::get('{id}', [OrderController::class, 'adminShowOrder'])->whereNumber('id');
            Route::post('{id}/mark-pending', [OrderController::class, 'adminMarkPending'])->whereNumber('id');
            Route::post('{id}/mark-paid', [OrderController::class, 'adminMarkPaid'])->whereNumber('id');
            Route::post('{id}/mark-shipping', [OrderController::class, 'adminMarkShipping'])->whereNumber('id');
            Route::post('{id}/mark-complete', [OrderController::class, 'adminMarkComplete'])->whereNumber('id');
            Route::post('{id}/mark-cancelled', [OrderController::class, 'adminMarkCancelled'])->whereNumber('id');
        });

        Route::group(['prefix' => 'product'], function() {
            Route::get('/', [AdminController::class, 'products']);
            Route::get('{id}/edit', [ProductController::class, 'edit'])->whereNumber('id');
            Route::post('{id}/edit', [ProductController::class, 'update'])->whereNumber('id');
            Route::post('{id}/remove', [ProductController::class, 'destroy'])->whereNumber('id');
            Route::post('image/{id}/add', [ProductImageController::class, 'store'])->whereNumber('id');
            Route::post('image/{id}/remove', [ProductImageController::class, 'destroy'])->whereNumber('id');
        });

        Route::group(['prefix' => 'user'], function() {
            Route::get('/', [AdminController::class, 'users']);
            // Route::get('{id}/edit', )
        });
    });
    
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('/', [UserController::class, 'dashboard']);
        Route::group(['prefix' => 'product'], function() {
            Route::get('/', [ProductController::class, 'userIndex']);
            Route::get('create', [ProductController::class, 'create']);
            Route::post('create', [ProductController::class, 'store']);
            Route::get('{id}/edit', [ProductController::class, 'edit'])->whereNumber('id');
            Route::post('{id}/edit', [ProductController::class, 'update'])->whereNumber('id');
            Route::post('{id}/remove', [ProductController::class, 'destroy'])->whereNumber('id');
            Route::post('image/{id}/add', [ProductImageController::class, 'store'])->whereNumber('id');
            Route::post('image/{id}/remove', [ProductImageController::class, 'destroy'])->whereNumber('id');
        });
        
        Route::group(['prefix' => 'order'], function() {
            Route::get('/', [OrderController::class, 'incomingOrders']);
            Route::get('{id}/edit', [OrderController::class, 'showIncomingOrder']);
            Route::post('{id}/update-tracking-number', [OrderController::class, 'markShipping']);
        });
    });
    
    
    Route::get('profile', function() {
        return view('dashboard.profile');
    });

    Route::get('users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.detail');

    Route::group(['prefix' => 'chats'], function() {
        Route::get('/', [ChatController::class, 'index']);
        Route::get('{id}', [ChatController::class, 'chat'])->whereNumber('id');
        Route::post('{id}/send', [ChatController::class, 'store'])->whereNumber('id');
        Route::get('{id}/reload', [ChatController::class, 'reloadChat'])->whereNumber('id');
    });

    Route::group(['prefix' => 'products'], function() {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('{id}', [ProductController::class, 'show'])->whereNumber('id');
        Route::post('{id}/addtocart', [CartController::class, 'addToCart'])->whereNumber('id');
        Route::post('{id}/editcart', [CartController::class, 'editCartItem'])->whereNumber('id');
        Route::post('{id}/removecart', [CartController::class, 'removeFromCart'])->whereNumber('id');
    });

    Route::group(['prefix' => 'cart'], function() {
        Route::get('/', [CartController::class, 'index']);
    });

    Route::group(['prefix' => 'orders'], function() {
        Route::get('/', [OrderController::class, 'orders']);
        Route::get('{id}', [OrderController::class, 'showOrder'])->whereNumber('id');
        Route::post('{id}/mark-complete', [OrderController::class, 'markComplete'])->whereNumber('id');
        Route::post('create', [OrderController::class, 'store']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'regions'], function() {
    Route::get('/', [RegionController::class, 'index']);
});


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'attemptLogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [UserController::class, 'store']);

