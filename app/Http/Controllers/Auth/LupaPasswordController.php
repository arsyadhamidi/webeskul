<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LupaPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required',
        ], [
            'username.required' => 'Username wajib diisi!',
        ]);

        $user = User::where('username', $validated['username'])->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/recorver-password');
        }

        return back()->with('error', 'Username tidak ditermukan!');
    }
}
