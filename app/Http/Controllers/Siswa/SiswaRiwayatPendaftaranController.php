<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiswaRiwayatPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query();
        $daftars = $query->orderBy('id', 'desc')->get();
        return view('siswa.riwayat-pendaftaran.index', [
            'daftars' => $daftars,
        ]);
    }

    public function show($id)
    {
        $daftars = Pendaftaran::where('id', $id)->first();
        return view('siswa.riwayat-pendaftaran.show', [
            'daftars' => $daftars,
        ]);
    }

    public function destroy($id)
    {
        $pendaftarans = Pendaftaran::where('id', $id)->first();
        $pendaftarans->delete();

        return redirect()->route('riwayat-pendaftaran.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
