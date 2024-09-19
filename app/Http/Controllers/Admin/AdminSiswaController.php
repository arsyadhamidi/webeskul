<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::latest()->get();
        return view('admin.siswa.index', [
            'siswas' => $siswas,
        ]);
    }

    public function create()
    {
        $users = User::where('level_id', '4')->get();
        $jurusans = Jurusan::latest()->get();
        return view('admin.siswa.create', [
            'users' => $users,
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required',
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nis' => 'required|unique:siswas,nis|max:255',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

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

        Siswa::create($validated);

        return redirect()->route('data-siswa.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $users = User::where('level_id', '4')->get();
        $siswas = Siswa::where('id', $id)->first();
        $jurusans = Jurusan::latest()->get();
        return view('admin.siswa.edit', [
            'siswas' => $siswas,
            'users' => $users,
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'users_id' => 'required',
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

        Siswa::where('id', $id)->update($validated);

        return redirect()->route('data-siswa.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $siswas = Siswa::where('id', $id)->first();
        $siswas->delete();

        return redirect()->route('data-siswa.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
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
