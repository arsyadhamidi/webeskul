<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function isibiodatasiswa()
    {
        $jurusans = Jurusan::latest()->get();
        return view('siswa.isi-biodata', [
            'jurusans' => $jurusans,
        ]);
    }

    public function storebiodatasiswa(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nis' => 'required|unique:siswas,nis|max:255',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
        ], [

            'jurusan_id.required' => 'Jurusan wajib diisi.',

            'kelas_id.required' => 'Kelas wajib diisi.',

            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar, silakan gunakan NISN lain.',
            'nis.max' => 'NIS tidak boleh lebih dari 255 karakter.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',
        ]);

        $validated['users_id'] = Auth::user()->id;

        Siswa::create($validated);

        return redirect('/dashboard')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function editbiodatasiswa($id)
    {
        $siswas = Siswa::where('id', $id)->first();
        $jurusans = Jurusan::latest()->get();
        return view('siswa.edit-biodata', [
            'siswas' => $siswas,
            'jurusans' => $jurusans,
        ]);
    }

    public function updatebiodatasiswa(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'jurusan_id.required' => 'Jurusan wajib diisi.',

            'kelas_id.required' => 'Kelas wajib diisi.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',
        ]);

        $validated['users_id'] = Auth::user()->id;

        Siswa::where('id', $id)->update($validated);

        return redirect('/dashboard')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function jqueryKelas(Request $request)
    {
        $id_jurusan = $request->id_jurusan;

        $kelass = Kelas::where('jurusan_id', $id_jurusan)->get();

        foreach ($kelass as $kelas) {
            echo "<option value='$kelas->id'>$kelas->nama_kelas</option>";
        }
    }
}
