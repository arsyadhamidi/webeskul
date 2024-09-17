<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PemulihanPasswordController extends Controller
{
    public function index()
    {
        return view('auth.recorver-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'konfirmasipassword' => 'required|min:8|same:password',
        ], [
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 8 karakter.',
            'konfirmasipassword.required' => 'Konfirmasi Password wajib diisi!',
            'konfirmasipassword.min' => 'Konfirmasi Password minimal 8 karakter.',
            'konfirmasipassword.same' => 'Password and Konfirmasi Password harus sama.',
        ]);

        $user = Auth::user(); // Retrieve the authenticated user

        // Update the user's password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::logout(); // Log the user out after password change
        $request->session()->invalidate();

        return redirect('/login')->with('success', 'Password berhasil di perbaharui');
    }
}
