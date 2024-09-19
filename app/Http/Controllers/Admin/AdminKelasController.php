<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    public function index()
    {
        $kelass = Kelas::orderBy('id', 'desc')->get();
        return view('admin.kelas.index', [
            'kelass' => $kelass,
        ]);
    }

    public function create()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.kelas.create', [
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'nama_kelas' => 'required|max:255',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',

            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max' => 'Nama Kelas tidak boleh lebih dari 255 karakter.'
        ]);

        Kelas::create($validated);

        return redirect()->route('data-kelas.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $jurusans = Jurusan::latest()->get();
        $kelass = Kelas::where('id', $id)->first();
        return view('admin.kelas.edit', [
            'kelass' => $kelass,
            'jurusans' => $jurusans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'nama_kelas' => 'required|max:255',
        ], [
            'jurusan_id.required' => 'Jurusan wajib diisi',

            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max' => 'Nama Kelas tidak boleh lebih dari 255 karakter.'
        ]);

        Kelas::where('id', $id)->update($validated);

        return redirect()->route('data-kelas.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $kelass = Kelas::where('id', $id)->first();
        $kelass->delete();

        return redirect()->route('data-kelas.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
