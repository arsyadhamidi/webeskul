<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use App\Models\Pembina;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPembinaController extends Controller
{
    public function index()
    {
        $pembinas = Pembina::latest()->get();
        return view('admin.pembina.index', [
            'pembinas' => $pembinas,
        ]);
    }

    public function create()
    {
        $users = User::where('level_id', '2')->get();
        $eskuls = Eskul::latest()->get();
        return view('admin.pembina.create', [
            'users' => $users,
            'eskuls' => $eskuls,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required',
            'eskul_id' => 'required',
            'nip' => 'required|unique:pembinas,nip|max:255',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'eskul_id.required' => 'Ekstrakurikuler wajib diisi.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP lain.',
            'nip.max' => 'NIP tidak boleh lebih dari 255 karakter.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',
        ]);

        Pembina::create($validated);

        return redirect()->route('data-pembina.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $users = User::where('level_id', '2')->get();
        $pembinas = Pembina::where('id', $id)->first();
        $eskuls = Eskul::latest()->get();
        return view('admin.pembina.edit', [
            'pembinas' => $pembinas,
            'users' => $users,
            'eskuls' => $eskuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'users_id' => 'required',
            'eskul_id' => 'required',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
            'telp' => 'required|max:255',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'eskul_id.required' => 'Ekstrakurikuler wajib diisi.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.max' => 'Nomor telepon tidak boleh lebih dari 255 karakter.',
        ]);

        Pembina::where('id', $id)->update($validated);

        return redirect()->route('data-pembina.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $pembinas = Pembina::where('id', $id)->first();
        $pembinas->delete();

        return redirect()->route('data-pembina.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
