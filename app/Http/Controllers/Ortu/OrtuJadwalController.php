<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\OrangTua;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrtuJadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $ortu = OrangTua::where('users_id', $user->id)->first();

        // Cek apakah data orang tua ditemukan
        if (!$ortu) {
            return redirect()->back()->withErrors(['error' => 'Data orang tua tidak ditemukan.']);
        }

        // Ambil semua data pendaftaran siswa terkait
        $daftars = Pendaftaran::where('siswa_id', $ortu->siswa_id)->latest()->get();

        // Siapkan array atau collection untuk menyimpan semua jadwal
        $allJadwals = collect();

        // Loop untuk mendapatkan jadwal dari setiap pendaftaran
        foreach ($daftars as $daftar) {
            $jadwals = Jadwal::where('eskul_id', $daftar->eskul_id)->latest()->get();
            // Gabungkan jadwal ke dalam collection
            $allJadwals = $allJadwals->merge($jadwals);
        }

        // Kembalikan view dengan data semua jadwal
        return view('ortu.jadwal.index', [
            'jadwals' => $allJadwals,
        ]);
    }
}
