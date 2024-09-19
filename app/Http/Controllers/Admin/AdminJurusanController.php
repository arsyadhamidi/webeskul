<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminJurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('id', 'desc')->get();
        return view('admin.jurusan.index', [
            'jurusans' => $jurusans,
        ]);
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|max:255'
        ], [
            'nama_jurusan.required' => 'Nama Jurusan wajib diisi.',
            'nama_jurusan.max' => 'Nama Jurusan tidak boleh lebih dari 255 karakter.'
        ]);

        Jurusan::create($validated);

        return redirect()->route('data-jurusan.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $jurusans = Jurusan::where('id', $id)->first();
        return view('admin.jurusan.edit', [
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|max:255'
        ], [
            'nama_jurusan.required' => 'Nama Jurusan wajib diisi.',
            'nama_jurusan.max' => 'Nama Jurusan tidak boleh lebih dari 255 karakter.'
        ]);

        Jurusan::where('id', $id)->update($validated);

        return redirect()->route('data-jurusan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $jurusans = Jurusan::where('id', $id)->first();
        $jurusans->delete();

        return redirect()->route('data-jurusan.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
