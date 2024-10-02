<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Support\Facades\Auth;

class SiswaJadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswas = Siswa::where('users_id', $user->id)->first();

        // Cek apakah data siswa ditemukan
        if (!$siswas) {
            return redirect()->back()->withErrors(['error' => 'Data siswa tidak ditemukan.']);
        }

        // Ambil semua data pendaftaran siswa terkait yang statusnya "Diterima"
        $daftars = Pendaftaran::where('siswa_id', $siswas->id)
            ->where('status', 'Diterima') // Tambahkan kondisi status "Diterima"
            ->latest()
            ->get();

        // Siapkan array atau collection untuk menyimpan semua jadwal
        $allJadwals = collect();

        // Loop untuk mendapatkan jadwal dari setiap pendaftaran
        foreach ($daftars as $daftar) {
            $jadwals = Jadwal::where('eskul_id', $daftar->eskul_id)
                ->latest()
                ->get();
            // Gabungkan jadwal ke dalam collection
            $allJadwals = $allJadwals->merge($jadwals);
        }

        $eskuls = Eskul::latest()->get();

        // Kembalikan view dengan data semua jadwal
        return view('siswa.jadwal.index', [
            'jadwals' => $allJadwals,
            'eskuls' => $eskuls,
        ]);
    }
}
