<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembinaAbsensiController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        $pembinas = Pembina::where('users_id', $users->id)->first();
        $absensis = Absensi::where('eskul_id', $pembinas->eskul_id)->latest()->get();
        return view('pembina.absensi.index', [
            'absensis' => $absensis,
        ]);
    }
}
