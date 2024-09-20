<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eskul;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Pembina;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminDokumentasiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data eskul untuk ditampilkan pada dropdown filter
        $eskuls = Eskul::latest()->get();

        // Query dasar untuk jadwal
        $dokumentasi = Dokumentasi::query();

        // Filter berdasarkan eskul_id jika dipilih
        if ($request->eskul_id) {
            $dokumentasi->where('eskul_id', $request->eskul_id);
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
                $dokumentasi->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        // Dapatkan data yang sudah difilter
        $dokumentasis = $dokumentasi->orderBy('id', 'desc')->get();

        // Kembalikan view dengan data jadwal yang sudah difilter
        return view('admin.dokumentasi.index', [
            'dokumentasis' => $dokumentasis,
            'eskuls' => $eskuls,
        ]);
    }

    public function create()
    {
        $eskuls = Eskul::latest()->get();
        $pembinas = Pembina::latest()->get();
        return view('admin.dokumentasi.create', [
            'eskuls' => $eskuls,
            'pembinas' => $pembinas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eskul_id' => 'required',                        // Field 'eskul_id' wajib diisi
            'pembina_id' => 'required',                      // Field 'pembina_id' wajib diisi, bukan date
            'kegiatan' => 'required|max:255',                // Field 'kegiatan' wajib diisi, maksimal 255 karakter
            'galeri' => 'required|mimes:png,jpg,jpeg|max:10240'  // File 'galeri' wajib dengan tipe tertentu dan ukuran maksimal 10MB
        ], [
            'eskul_id.required' => 'Ekskul wajib dipilih.',   // Pesan error jika 'eskul_id' kosong
            'pembina_id.required' => 'Pembina wajib dipilih.',// Pesan error jika 'pembina_id' kosong
            'kegiatan.required' => 'Kegiatan wajib diisi.',   // Pesan error jika 'kegiatan' kosong
            'kegiatan.max' => 'Kegiatan tidak boleh lebih dari 255 karakter.', // Pesan error jika 'kegiatan' lebih dari 255 karakter
            'galeri.required' => 'Galeri wajib diunggah.',    // Pesan error jika 'galeri' kosong
            'galeri.mimes' => 'Galeri harus berupa file berformat: png, jpg, jpeg.', // Pesan error jika format file tidak sesuai
            'galeri.max' => 'Galeri tidak boleh lebih dari 10MB.'  // Pesan error jika ukuran file lebih dari 10MB
        ]);

        $validated['tanggal'] = Carbon::now();

        if($request->file('galeri')){
            $validated['galeri'] = $request->file('galeri')->store('galeri');
        }

        Dokumentasi::create($validated);

        return redirect()->route('data-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $eskuls = Eskul::latest()->get();
        $pembinas = Pembina::latest()->get();
        $dokumentasis = Dokumentasi::where('id', $id)->first();
        return view('admin.dokumentasi.edit', [
            'dokumentasis' => $dokumentasis,
            'eskuls' => $eskuls,
            'pembinas' => $pembinas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'eskul_id' => 'required',                        // Field 'eskul_id' wajib diisi
            'pembina_id' => 'required',                      // Field 'pembina_id' wajib diisi, bukan date
            'kegiatan' => 'required|max:255',                // Field 'kegiatan' wajib diisi, maksimal 255 karakter
            'galeri' => 'nullable|mimes:png,jpg,jpeg|max:10240'  // File 'galeri' wajib dengan tipe tertentu dan ukuran maksimal 10MB
        ], [
            'eskul_id.required' => 'Ekskul wajib dipilih.',   // Pesan error jika 'eskul_id' kosong
            'pembina_id.required' => 'Pembina wajib dipilih.',// Pesan error jika 'pembina_id' kosong
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

        return redirect()->route('data-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::where('id', $id)->first();
        $dokumentasi->delete();

        return redirect()->route('data-dokumentasi.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function jqueryEskul(Request $request)
    {
        $id_eskul = $request->id_eskul;

        $pembinas = Pembina::where('eskul_id', $id_eskul)->get();

        foreach ($pembinas as $data) {
            echo "<option value='$data->id'>$data->nama</option>";
        }
    }
}
