<?php

namespace App\Http\Controllers\Pembina;

use App\Models\Eskul;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pembina;

class PembinaJadwalController extends Controller
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
        return view('pembina.jadwal.index', [
            'jadwals' => $jadwals,
            'eskuls' => $eskuls,
        ]);
    }

    public function create()
    {
        return view('pembina.jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $pembinas = Pembina::where('users_id', Auth()->user()->id)->first();
        $validated['eskul_id'] = $pembinas->eskul_id;

        Jadwal::create($validated);

        return redirect()->route('pembina-jadwal.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $jadwals = Jadwal::where('id', $id)->first();
        return view('pembina.jadwal.edit', [
            'jadwals' => $jadwals,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|max:255',
            'deskripsi' => 'required'
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus dalam format yang valid.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.max' => 'Lokasi tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.'
        ]);

        Jadwal::where('id', $id)->update($validated);

        return redirect()->route('pembina-jadwal.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {
        $jadwals = Jadwal::where('id', $id)->first();
        $jadwals->delete();

        return redirect()->route('pembina-jadwal.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
