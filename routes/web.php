<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\PemulihanPasswordController;
use App\Http\Controllers\Auth\RegistrasiController;
use App\Http\Controllers\Dashboard\DashboardController;

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

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login-action', [LoginController::class, 'authenticate'])->name('login-action.authenticate');
Route::get('/logout-action', [LoginController::class, 'logout'])->name('logout.action');

// Registrasi
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
Route::post('/registrasi-action', [RegistrasiController::class, 'store'])->name('registrasi.store');

// Lupa Password
Route::get('/lupa-password', [LupaPasswordController::class, 'index'])->name('lupa-password.index');
Route::post('/lupa-password/store', [LupaPasswordController::class, 'store'])->name('lupa-password.store');

// Pemulihan Password
Route::get('/recorver-password', [PemulihanPasswordController::class, 'index'])->name('recorver-password.index');
Route::post('/recorver-password/store', [PemulihanPasswordController::class, 'store'])->name('recorver-password.store');

// Dashboard
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
