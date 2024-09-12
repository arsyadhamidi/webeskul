<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('id', 'desc')->get();
        return view('auth.registrasi', [
            'levels' => $levels,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'level_id' => 'required',
            'password' => 'required|string|min:8',
            'telp' => 'required|digits_between:10,15',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan username lain.',
            'level_id.required' => 'Status wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.',
        ]);

        $validated['password'] = bcrypt($request->password);

        User::create($validated);

        return redirect()->route('/login')->with('success', 'Selamat ! Anda berhasil melakukan registrasi');
    }
}
