<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrtuAbsensiController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        $ortus = OrangTua::where('users_id', $users->id)->first();
        $absensis = Absensi::where('siswa_id', $ortus->siswa_id)->latest()->get();
        return view('ortu.absensi.index', [
            'absensis' => $absensis,
        ]);
    }
}
