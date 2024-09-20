<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminJadwalController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data eskul untuk ditampilkan pada dropdown filter
        $eskuls = Eskul::latest()->get();

        // Query dasar untuk jadwal
        $jadwals = Jadwal::query();

        // Filter berdasarkan eskul_id jika dipilih
        if ($request->eskul_id) {
            $jadwals->where('eskul_id', $request->eskul_id);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->tanggal) {
            // Misalnya format yang dipilih dari daterangepicker adalah 'YYYY-MM-DD - YYYY-MM-DD'
            $dates = explode(' - ', $request->tanggal);

            // Pastikan ada dua tanggal yang valid (start dan end)
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];

                // Filter jadwal yang berada di rentang tanggal
                $jadwals->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        // Dapatkan data yang sudah difilter
        $jadwals = $jadwals->orderBy('id', 'desc')->get();

        // Kembalikan view dengan data jadwal yang sudah difilter
        return view('admin.jadwal.index', [
            'jadwals' => $jadwals,
            'eskuls' => $eskuls,
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
