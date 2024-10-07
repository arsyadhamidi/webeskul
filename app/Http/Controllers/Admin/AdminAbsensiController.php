<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jurusan;
use App\Models\OrangTua;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AdminAbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::latest()->get();

        return view('admin.absensi.index', [
            'absensis' => $absensis,
        ]);
    }

    public function create()
    {
        $siswas = Siswa::latest()->get();
        return view('admin.absensi.create', [
            'siswas' => $siswas,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'eskul_id' => 'required',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'eskul_id.required' => 'Ekstrakurikuler wajib diisi'
        ]);

        $siswas = Siswa::where('id', $request->siswa_id)->first();
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

        return redirect()->route('data-absensi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data');
    }

    public function edit($id)
    {
        $siswas = Siswa::latest()->get();
        $absensis = Absensi::where('id', $id)->first();
        return view('admin.absensi.edit', [
            'siswas' => $siswas,
            'absensis' => $absensis,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'siswa_id' => 'required',
            'eskul_id' => 'required',
        ], [
            'siswa_id.required' => 'Siswa wajib diisi',
            'eskul_id.required' => 'Ekstrakurikuler wajib diisi'
        ]);

        // Cari absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        // Cari data siswa dan orang tua
        $siswas = Siswa::where('id', $request->siswa_id)->first();
        $ortus = OrangTua::where('siswa_id', $siswas->id)->first();

        // Jika data orang tua siswa tidak ditemukan, kirim pesan error
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

        // Redirect ke halaman data absensi dengan pesan sukses
        return redirect()->route('data-absensi.index')->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cari data absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        // Hapus data absensi
        $absensi->delete();

        // Redirect ke halaman data absensi dengan pesan sukses
        return redirect()->route('data-absensi.index')->with('success', 'Data absensi berhasil dihapus');
    }


    public function jqueryEskul(Request $request)
    {
        $id_siswa = $request->id_siswa;

        // Mengambil data pendaftaran berdasarkan id_siswa
        $daftars = Pendaftaran::with('eskul')->where('siswa_id', $id_siswa)->get();

        foreach ($daftars as $daftar) {
            // Menampilkan data eskul yang diambil dari relasi model Pendaftaran
            $namas = $daftar->eskul->nama;
            $ids = $daftar->eskul->id;
            echo "<option value='$ids'>$namas</option>";
        }
    }
}
