<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::orderBy('id', 'desc')->get();
        return view('admin.jadwal.index', [
            'jadwals' => $jadwals,
        ]);
    }

    public function create()
    {
        $eskuls = Eskul::latest()->get();
        return view('admin.jadwal.create', [
            'eskuls' => $eskuls,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eskul_id' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required|max:255',
            'deskripsi' => 'required'
        ], [
            'eskul_id.required' => 'Ekskul wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus dalam format yang valid.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.'
        ]);

        Jadwal::create($validated);

        return redirect()->route('data-jadwal.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $eskuls = Eskul::latest()->get();
        $jadwals = Jadwal::where('id', $id)->first();
        return view('admin.jadwal.edit', [
            'jadwals' => $jadwals,
            'eskuls' => $eskuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'eskul_id' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required|max:255',
            'deskripsi' => 'required'
        ], [
            'eskul_id.required' => 'Ekskul wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus dalam format yang valid.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.'
        ]);


        Jadwal::where('id', $id)->update($validated);

        return redirect()->route('data-jadwal.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {
        $jadwals = Jadwal::where('id', $id)->first();
        $jadwals->delete();

        return redirect()->route('data-jadwal.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
