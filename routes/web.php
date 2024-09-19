<?php

use App\Http\Controllers\Admin\AdminEskulController;
use App\Http\Controllers\Admin\AdminJurusanController;
use App\Http\Controllers\Admin\AdminKelasController;
use App\Http\Controllers\Admin\AdminLevelController;
use App\Http\Controllers\Admin\AdminOrangTuaController;
use App\Http\Controllers\Admin\AdminPembinaController;
use App\Http\Controllers\Admin\AdminSiswaController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Middleware\CekLevel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrasiController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Auth\PemulihanPasswordController;

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

    // Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/updateprofile', [SettingController::class, 'updateprofile'])->name('setting.updateprofile');
    Route::post('/setting/updateusername', [SettingController::class, 'updateusername'])->name('setting.updateusername');
    Route::post('/setting/updatepassword', [SettingController::class, 'updatepassword'])->name('setting.updatepassword');
    Route::post('/setting/updategambar', [SettingController::class, 'updategambar'])->name('setting.updategambar');
    Route::post('/setting/hapusgambar', [SettingController::class, 'hapusgambar'])->name('setting.hapusgambar');

    // Admin
    Route::group(['middleware' => [CekLevel::class . ':1']], function () {

        // Data Kelas
        Route::get('data-kelas', [AdminKelasController::class, 'index'])->name('data-kelas.index');
        Route::get('data-kelas/create', [AdminKelasController::class, 'create'])->name('data-kelas.create');
        Route::post('data-kelas/store', [AdminKelasController::class, 'store'])->name('data-kelas.store');
        Route::get('data-kelas/edit/{id}', [AdminKelasController::class, 'edit'])->name('data-kelas.edit');
        Route::post('data-kelas/update/{id}', [AdminKelasController::class, 'update'])->name('data-kelas.update');
        Route::post('data-kelas/destroy/{id}', [AdminKelasController::class, 'destroy'])->name('data-kelas.destroy');

        // Data Jurusan
        Route::get('data-jurusan', [AdminJurusanController::class, 'index'])->name('data-jurusan.index');
        Route::get('data-jurusan/create', [AdminJurusanController::class, 'create'])->name('data-jurusan.create');
        Route::post('data-jurusan/store', [AdminJurusanController::class, 'store'])->name('data-jurusan.store');
        Route::get('data-jurusan/edit/{id}', [AdminJurusanController::class, 'edit'])->name('data-jurusan.edit');
        Route::post('data-jurusan/update/{id}', [AdminJurusanController::class, 'update'])->name('data-jurusan.update');
        Route::post('data-jurusan/destroy/{id}', [AdminJurusanController::class, 'destroy'])->name('data-jurusan.destroy');

        // Eskul
        Route::get('data-eskul', [AdminEskulController::class, 'index'])->name('data-eskul.index');
        Route::get('data-eskul/create', [AdminEskulController::class, 'create'])->name('data-eskul.create');
        Route::post('data-eskul/store', [AdminEskulController::class, 'store'])->name('data-eskul.store');
        Route::get('data-eskul/edit/{id}', [AdminEskulController::class, 'edit'])->name('data-eskul.edit');
        Route::post('data-eskul/update/{id}', [AdminEskulController::class, 'update'])->name('data-eskul.update');
        Route::post('data-eskul/destroy/{id}', [AdminEskulController::class, 'destroy'])->name('data-eskul.destroy');

        // Siswa
        Route::get('data-siswa', [AdminSiswaController::class, 'index'])->name('data-siswa.index');
        Route::get('data-siswa/create', [AdminSiswaController::class, 'create'])->name('data-siswa.create');
        Route::post('data-siswa/store', [AdminSiswaController::class, 'store'])->name('data-siswa.store');
        Route::get('data-siswa/edit/{id}', [AdminSiswaController::class, 'edit'])->name('data-siswa.edit');
        Route::post('data-siswa/update/{id}', [AdminSiswaController::class, 'update'])->name('data-siswa.update');
        Route::post('data-siswa/destroy/{id}', [AdminSiswaController::class, 'destroy'])->name('data-siswa.destroy');
        Route::post('/jquery-kelas', [AdminSiswaController::class, 'jqueryKelas']);

        // Orang Tua
        Route::get('data-ortu', [AdminOrangTuaController::class, 'index'])->name('data-ortu.index');
        Route::get('data-ortu/create', [AdminOrangTuaController::class, 'create'])->name('data-ortu.create');
        Route::post('data-ortu/store', [AdminOrangTuaController::class, 'store'])->name('data-ortu.store');
        Route::get('data-ortu/edit/{id}', [AdminOrangTuaController::class, 'edit'])->name('data-ortu.edit');
        Route::post('data-ortu/update/{id}', [AdminOrangTuaController::class, 'update'])->name('data-ortu.update');
        Route::post('data-ortu/destroy/{id}', [AdminOrangTuaController::class, 'destroy'])->name('data-ortu.destroy');

        // Pembina
        Route::get('data-pembina', [AdminPembinaController::class, 'index'])->name('data-pembina.index');
        Route::get('data-pembina/create', [AdminPembinaController::class, 'create'])->name('data-pembina.create');
        Route::post('data-pembina/store', [AdminPembinaController::class, 'store'])->name('data-pembina.store');
        Route::get('data-pembina/edit/{id}', [AdminPembinaController::class, 'edit'])->name('data-pembina.edit');
        Route::post('data-pembina/update/{id}', [AdminPembinaController::class, 'update'])->name('data-pembina.update');
        Route::post('data-pembina/destroy/{id}', [AdminPembinaController::class, 'destroy'])->name('data-pembina.destroy');

        // Users
        Route::get('data-users', [AdminUsersController::class, 'index'])->name('data-users.index');
        Route::get('data-users/create', [AdminUsersController::class, 'create'])->name('data-users.create');
        Route::post('data-users/store', [AdminUsersController::class, 'store'])->name('data-users.store');
        Route::get('data-users/edit/{id}', [AdminUsersController::class, 'edit'])->name('data-users.edit');
        Route::post('data-users/update/{id}', [AdminUsersController::class, 'update'])->name('data-users.update');
        Route::post('data-users/destroy/{id}', [AdminUsersController::class, 'destroy'])->name('data-users.destroy');

        // Level
        Route::get('data-level', [AdminLevelController::class, 'index'])->name('data-level.index');
        Route::get('data-level/create', [AdminLevelController::class, 'create'])->name('data-level.create');
        Route::post('data-level/store', [AdminLevelController::class, 'store'])->name('data-level.store');
        Route::get('data-level/edit/{id}', [AdminLevelController::class, 'edit'])->name('data-level.edit');
        Route::post('data-level/update/{id}', [AdminLevelController::class, 'update'])->name('data-level.update');
        Route::post('data-level/destroy/{id}', [AdminLevelController::class, 'destroy'])->name('data-level.destroy');
    });
});
