<?php

namespace App\Http\Controllers\Ortu;

use App\Models\OrangTua;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\Auth;

class OrtuDokumentasiController extends Controller
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
        $daftars = Pendaftaran::with('dokumentasi')
            ->where('siswa_id', $ortu->siswa_id)
            ->where('status', 'Diterima')
            ->latest()
            ->get();

        // Siapkan array atau collection untuk menyimpan semua dokumentasi
        $allDokumentasis = collect();

        // Loop untuk mendapatkan dokumentasi dari setiap pendaftaran
        foreach ($daftars as $daftar) {
            $dokumentasis = Dokumentasi::where('eskul_id', $daftar->eskul_id)->latest()->get();
            // Gabungkan dokumentasi ke dalam collection
            $allDokumentasis = $allDokumentasis->merge($dokumentasis);
        }

        // Kembalikan view dengan data semua dokumentasi
        return view('ortu.dokumentasi.index', [
            'dokumentasis' => $allDokumentasis,
        ]);
    }
}
