<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrtuPendaftaranController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        $ortus = OrangTua::where('users_id', $users->id)->first();
        $daftars = Pendaftaran::where('siswa_id', $ortus->siswa_id)->latest()->get();
        if (!$daftars) {
            return redirect('/dashboard')->withErrors(['error' => 'Data siswa mendaftar tidak ditemukan.']);
        }

        return view('ortu.pendaftaran.index', [
            'daftars' => $daftars,
        ]);
    }

    public function show($id)
    {
        $daftars = Pendaftaran::where('id', $id)->first();
        return view('ortu.pendaftaran.show', [
            'daftars' => $daftars,
        ]);
    }
}
