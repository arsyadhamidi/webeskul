<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\OrangTua;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaAbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::where('users_id', Auth::user()->id)->latest()->get();

        return view('siswa.absensi.index', [
            'absensis' => $absensis,
        ]);
    }

    public function create()
    {
        $siswas = Siswa::where('users_id', Auth::user()->id)->first();
        $eskuls = Pendaftaran::where('siswa_id', $siswas->id)->latest()->get();
        return view('siswa.absensi.create', [
            'eskuls' => $eskuls,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'eskul_id' => 'required',
        ], [
            'eskul_id.required' => 'Ekstrakurikuler wajib diisi'
        ]);

        $users = Auth::user();
        $siswas = Siswa::where('users_id', $users->id)->first();
        $ortus = OrangTua::where('siswa_id', $siswas->id)->first();

        if (empty($ortus)) {
            return back()->with('error', 'Data orang tua siswa tidak ditemukan!');
        }

        Absensi::create([
            'siswa_id' => $siswas->id,
            'ortu_id' => $ortus->id,
            'eskul_id' => $request->eskul_id,
            'jurusan_id' => $siswas->jurusan_id,
            'kelas_id' => $siswas->kelas_id,
            'users_id' => $siswas->users_id,
            'nis' => $siswas->nis,
            'nama' => $siswas->nama,
            'status' => $request->status,
        ]);

        return redirect()->route('siswa-absensi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $siswas = Siswa::where('users_id', Auth::user()->id)->first();
        $eskuls = Pendaftaran::where('siswa_id', $siswas->id)->latest()->get();
        $absensis = Absensi::where('id', $id)->first();
        return view('siswa.absensi.edit', [
            'eskuls' => $eskuls,
            'absensis' => $absensis,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'eskul_id' => 'required',
        ], [
            'eskul_id.required' => 'Ekstrakurikuler wajib diisi'
        ]);

        // Cari data absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        // Ambil data pengguna yang sedang login
        $users = Auth::user();

        // Cari data siswa berdasarkan users_id
        $siswas = Siswa::where('users_id', $users->id)->first();

        // Cari data orang tua berdasarkan siswa_id
        $ortus = OrangTua::where('siswa_id', $siswas->id)->first();

        // Jika data orang tua tidak ditemukan, tampilkan pesan error
        if (empty($ortus)) {
            return back()->with('error', 'Data orang tua siswa tidak ditemukan!');
        }

        // Update data absensi
        $absensi->update([
            'siswa_id' => $siswas->id,
            'ortu_id' => $ortus->id,
            'eskul_id' => $request->eskul_id,
            'jurusan_id' => $siswas->jurusan_id,
            'kelas_id' => $siswas->kelas_id,
            'users_id' => $siswas->users_id,
            'nis' => $siswas->nis,
            'nama' => $siswas->nama,
            'status' => $request->status,
        ]);

        // Redirect ke halaman absensi dengan pesan sukses
        return redirect()->route('siswa-absensi.index')->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cari data absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        // Hapus data absensi
        $absensi->delete();

        // Redirect ke halaman absensi dengan pesan sukses
        return redirect()->route('siswa-absensi.index')->with('success', 'Data absensi berhasil dihapus');
    }
}
