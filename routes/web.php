<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\UserController;
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
    
    Route::get('dashboard', function () {
        return view('dashboard.home');
    });
    
    Route::get('profile', function() {
        return view('dashboard.profile');
    });

    Route::get('users', [UserController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout']);
});


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'attemptLogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [UserController::class, 'store']);
