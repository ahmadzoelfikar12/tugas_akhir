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
Route::post('/login', [AuthController::class, 'login']);
Route::get('/lupa_password', [AuthController::class, 'lupa_password'])->Middleware('guest')->name('lupa_password');
Route::post('/lupa_password',[AuthController::class, 'email_test'])->name('email_test');
Route::get('/reset_password/{token}', [AuthController::class,'showResetForm'])->name('reset_password');
Route::post('/reset_password', [AuthController::class, 'resetPassword'])->name('reset_password.update');

Route::get('/logout', [AuthController::class, 'logout']);

Route::resource('dashboard', DashboardController::class);
