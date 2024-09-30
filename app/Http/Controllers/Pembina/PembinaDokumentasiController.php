<?php

namespace App\Http\Controllers\Pembina;

use Carbon\Carbon;
use App\Models\Eskul;
use App\Models\Pembina;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PembinaDokumentasiController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk jadwal
        $dokumentasi = Dokumentasi::query();

        // Filter berdasarkan rentang tanggal
        if ($request->tanggal) {
            // Misalnya format yang dipilih dari daterangepicker adalah 'YYYY-MM-DD - YYYY-MM-DD'
            $dates = explode(' - ', $request->tanggal);

            // Pastikan ada dua tanggal yang valid (start dan end)
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];

                // Filter jadwal yang berada di rentang tanggal
                $dokumentasi->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        // Dapatkan data yang sudah difilter
        $dokumentasis = $dokumentasi->orderBy('id', 'desc')->get();

        // Kembalikan view dengan data jadwal yang sudah difilter
        return view('pembina.dokumentasi.index', [
            'dokumentasis' => $dokumentasis,
        ]);
    }

    public function create()
    {
        $pembinas = Pembina::latest()->get();
        return view('pembina.dokumentasi.create', [
            'pembinas' => $pembinas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|max:255',                // Field 'kegiatan' wajib diisi, maksimal 255 karakter
            'galeri' => 'required|mimes:png,jpg,jpeg|max:10240'  // File 'galeri' wajib dengan tipe tertentu dan ukuran maksimal 10MB
        ], [
            'kegiatan.required' => 'Kegiatan wajib diisi.',   // Pesan error jika 'kegiatan' kosong
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 255 karakter.', // Pesan error jika 'kegiatan' lebih dari 255 karakter
            'galeri.required' => 'Galeri wajib diunggah.',    // Pesan error jika 'galeri' kosong
            'galeri.mimes' => 'Galeri harus berupa file berformat: png, jpg, jpeg.', // Pesan error jika format file tidak sesuai
            'galeri.max' => 'Galeri tidak boleh lebih dari 10MB.'  // Pesan error jika ukuran file lebih dari 10MB
        ]);

        $pembinas = Pembina::where('users_id', Auth()->user()->id)->first();
        $validated['pembina_id'] = $pembinas->id;
        $validated['eskul_id'] = $pembinas->eskul_id;
        $validated['tanggal'] = Carbon::now();

        if($request->file('galeri')){
            $validated['galeri'] = $request->file('galeri')->store('galeri');
        }

        Dokumentasi::create($validated);

        return redirect()->route('pembina-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $pembinas = Pembina::latest()->get();
        $dokumentasis = Dokumentasi::where('id', $id)->first();
        return view('pembina.dokumentasi.edit', [
            'dokumentasis' => $dokumentasis,
            'pembinas' => $pembinas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|max:255',                // Field 'kegiatan' wajib diisi, maksimal 255 karakter
            'galeri' => 'nullable|mimes:png,jpg,jpeg|max:10240'  // File 'galeri' wajib dengan tipe tertentu dan ukuran maksimal 10MB
        ], [
            'kegiatan.required' => 'Kegiatan wajib diisi.',   // Pesan error jika 'kegiatan' kosong
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 255 karakter.', // Pesan error jika 'kegiatan' lebih dari 255 karakter
            'galeri.mimes' => 'Galeri harus berupa file berformat: png, jpg, jpeg.', // Pesan error jika format file tidak sesuai
            'galeri.max' => 'Galeri tidak boleh lebih dari 10MB.'  // Pesan error jika ukuran file lebih dari 10MB
        ]);

        $dokumentasis = Dokumentasi::where('id', $id)->first();

        if($request->file('galeri')){
            if($dokumentasis->galeri){
                Storage::delete($dokumentasis->galeri);
            }
            $validated['galeri'] = $request->file('galeri')->store('galeri');
        }else{
            $validated['galeri'] = $dokumentasis->galeri;
        }

        Dokumentasi::where('id', $id)->update($validated);

        return redirect()->route('pembina-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::where('id', $id)->first();
        $dokumentasi->delete();

        return redirect()->route('pembina-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
