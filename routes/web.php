<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('/dashboard');
    }
    return view('Auth.login');
});

//untuk Login
Route::get('/login', [AuthController::class, 'index'])->Middleware('guest')->name('login');
Route::get('/lupa_password', [AuthController::class, 'lupa_password'])->Middleware('guest')->name('lupa_password');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::resource('dashboard', DashboardController::class);
