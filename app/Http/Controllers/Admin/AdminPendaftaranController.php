<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eskul;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class AdminPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dari request
        $eskulId = $request->input('eskul_id');
        $jurusanId = $request->input('jurusan_id');
        $kelasId = $request->input('kelas_id');
        $status = $request->input('status');

        // Query dasar untuk mengambil data pendaftaran
        $query = Pendaftaran::query();

        // Filter berdasarkan Ekskul jika dipilih
        if (!empty($eskulId)) {
            $query->where('eskul_id', $eskulId);
        }

        // Filter berdasarkan Jurusan jika dipilih
        if (!empty($jurusanId)) {
            $query->where('jurusan_id', $jurusanId);
        }

        // Filter berdasarkan Kelas jika dipilih
        if (!empty($kelasId)) {
            $query->where('kelas_id', $kelasId);
        }

        // Filter berdasarkan Status jika dipilih
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Dapatkan hasil dengan filter yang diterapkan
        $daftars = $query->orderBy('id', 'desc')->get();

        // Dapatkan semua eskul dan jurusan untuk pilihan filter
        $eskuls = Eskul::latest()->get();
        $jurusans = Jurusan::latest()->get();

        // Kirim data ke view
        return view('admin.pendaftaran.index', [
            'daftars' => $daftars,
            'eskuls' => $eskuls,
            'jurusans' => $jurusans,
        ]);
    }

    public function generatepdf()
    {
    	$daftars = Pendaftaran::latest()->get();

    	$pdf = PDF::loadview('admin.pendaftaran.export-pdf',['daftars'=>$daftars])->setPaper('A4', 'Potrait');
    	return $pdf->stream('laporan-pendaftaran.pdf');
    	// return $pdf->download('laporan-siswa.pdf');
    }

    public function create()
    {
        $eskuls = Eskul::latest()->get();
        $siswas = Siswa::latest()->get();
        return view('admin.pendaftaran.create', [
            'eskuls' => $eskuls,
            'siswas' => $siswas,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'eskul_id' => 'required',
            'siswa_id' => 'required',
            'nis' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|min:10|max:15',
            'email' => 'required|email|max:255',
            'status' => 'required|max:255',
            'alasan' => 'required|max:255',
            'alamat' => 'required|max:255',
            'berkas_pendaftaran' => 'required|mimes:pdf|max:10240',  // Maksimal 10MB
        ], [
            // Custom error messages
            'eskul_id.required' => 'Ekstrakurikuler wajib dipilih.',
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.max' => 'NIS tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tmp_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Tanggal Lahir harus berupa format tanggal yang valid.',
            'jk.required' => 'Jenis Kelamin wajib dipilih.',
            'jk.max' => 'Jenis Kelamin tidak boleh lebih dari 255 karakter.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.min' => 'Nomor Telepon harus minimal 10 angka.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 15 angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Status wajib diisi.',
            'alasan.required' => 'Alasan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'berkas_pendaftaran.required' => 'Berkas Pendaftaran wajib diunggah.',
            'berkas_pendaftaran.mimes' => 'Berkas Pendaftaran harus berupa file PDF.',
            'berkas_pendaftaran.max' => 'Berkas Pendaftaran tidak boleh lebih dari 10 MB.'
        ]);

        if ($request->file('berkas_pendaftaran')) {
            $validated['berkas_pendaftaran'] = $request->file('berkas_pendaftaran')->store('berkas_pendaftaran');
        }

        // Ambil data siswa berdasarkan ID
        $siswa = Siswa::findOrFail($request->siswa_id);
        $daftars = Pendaftaran::count();
        $totCount = $daftars + 1;

        $carbons = Carbon::now();
        $toDays = $carbons->format('dmY');

        // Set jurusan dan kelas dari data siswa
        $validated['jurusan_id'] = $siswa->jurusan_id;
        $validated['kelas_id'] = $siswa->kelas_id;
        $validated['nomor_pendaftaran'] = 'EKS' . $toDays . $totCount;
        $validated['tgl_pendaftaran'] = $carbons;

        // Simpan data pendaftaran
        Pendaftaran::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('data-pendaftaran.index')->with('success', 'Selamat! Anda berhasil menambahkan data!');
    }

    public function show($id)
    {
        $daftars = Pendaftaran::where('id', $id)->first();
        return view('admin.pendaftaran.show', [
            'daftars' => $daftars,
        ]);
    }

    public function edit($id)
    {
        $eskuls = Eskul::latest()->get();
        $siswas = Siswa::latest()->get();
        $daftars = Pendaftaran::where('id', $id)->first();
        return view('admin.pendaftaran.edit', [
            'daftars' => $daftars,
            'eskuls' => $eskuls,
            'siswas' => $siswas,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'eskul_id' => 'required',
            'siswa_id' => 'required',
            'nis' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|min:10|max:15',
            'email' => 'required|email|max:255',
            'status' => 'required|max:255',
            'alasan' => 'required|max:255',
            'alamat' => 'required|max:255',
            'berkas_pendaftaran' => 'nullable|mimes:pdf|max:10240',  // Maksimal 10MB
        ], [
            // Custom error messages
            'eskul_id.required' => 'Ekstrakurikuler wajib dipilih.',
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.max' => 'NIS tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tmp_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Tanggal Lahir harus berupa format tanggal yang valid.',
            'jk.required' => 'Jenis Kelamin wajib dipilih.',
            'jk.max' => 'Jenis Kelamin tidak boleh lebih dari 255 karakter.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.min' => 'Nomor Telepon harus minimal 10 angka.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 15 angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Status wajib diisi.',
            'alasan.required' => 'Alasan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'berkas_pendaftaran.mimes' => 'Berkas Pendaftaran harus berupa file PDF.',
            'berkas_pendaftaran.max' => 'Berkas Pendaftaran tidak boleh lebih dari 10 MB.'
        ]);

        $pendaftarans = Pendaftaran::where('id', $id)->first();
        if ($request->file('berkas_pendaftaran')) {
            if ($pendaftarans->berkas_pendaftaran) {
                Storage::delete($pendaftarans->berkas_pendaftaran);
            }
            $validated['berkas_pendaftaran'] = $request->file('berkas_pendaftaran')->store('berkas_pendaftaran');
        } else {
            $validated['berkas_pendaftaran'] = $pendaftarans->berkas_pendaftaran;
        }

        // Ambil data siswa berdasarkan ID
        $siswa = Siswa::findOrFail($request->siswa_id);

        // Set jurusan dan kelas dari data siswa
        $validated['jurusan_id'] = $siswa->jurusan_id;
        $validated['kelas_id'] = $siswa->kelas_id;

        // Simpan data pendaftaran
        $pendaftarans->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('data-pendaftaran.index')->with('success', 'Selamat! Anda berhasil menambahkan data!');
    }

    public function destroy($id)
    {

        $pendaftarans = Pendaftaran::where('id', $id)->first();
        $pendaftarans->delete();

        return redirect()->route('data-pendaftaran.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
