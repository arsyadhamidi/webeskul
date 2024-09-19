<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrangTuaController extends Controller
{
    public function index()
    {
        $ortus = OrangTua::latest()->get();
        return view('admin.ortu.index', [
            'ortus' => $ortus,
        ]);
    }

    public function create()
    {
        $users = User::where('level_id', '3')->get();
        $siswas = Siswa::latest()->get();
        return view('admin.ortu.create', [
            'users' => $users,
            'siswas' => $siswas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required',
            'siswa_id' => 'required',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
            'alamat' => 'required',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'siswa_id.required' => 'ID Siswa wajib diisi.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',

            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        OrangTua::create($validated);

        return redirect()->route('data-ortu.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $users = User::where('level_id', '3')->get();
        $ortus = OrangTua::where('id', $id)->first();
        $siswas = Siswa::latest()->get();
        return view('admin.ortu.edit', [
            'ortus' => $ortus,
            'users' => $users,
            'siswas' => $siswas
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'users_id' => 'required',
            'siswa_id' => 'required',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
            'alamat' => 'required',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'siswa_id.required' => 'ID Siswa wajib diisi.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',

            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        OrangTua::where('id', $id)->update($validated);

        return redirect()->route('data-ortu.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $ortus = OrangTua::where('id', $id)->first();
        $ortus->delete();

        return redirect()->route('data-ortu.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
