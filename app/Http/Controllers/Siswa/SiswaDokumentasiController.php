<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Dokumentasi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class SiswaDokumentasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswas = Siswa::where('users_id', $user->id)->first();

        // Cek apakah data siswa ditemukan
        if (!$siswas) {
            return redirect()->back()->withErrors(['error' => 'Data siswa tidak ditemukan.']);
        }

        // Ambil pendaftaran dengan dokumentasi terkait menggunakan eager loading
        $daftars = Pendaftaran::with('dokumentasi')
            ->where('siswa_id', $siswas->id)
            ->where('status', 'Diterima')
            ->latest()
            ->get();

        // Gabungkan dokumentasi dari setiap pendaftaran ke dalam satu collection
        $allDokumentasis = collect();
        foreach ($daftars as $daftar) {
            $allDokumentasis = $allDokumentasis->merge($daftar->dokumentasi);
        }

        // Kembalikan view dengan data semua dokumentasi
        return view('siswa.dokumentasi.index', [
            'dokumentasis' => $allDokumentasis,
        ]);
    }
}
