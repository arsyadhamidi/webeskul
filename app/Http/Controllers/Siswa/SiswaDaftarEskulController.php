<?php

namespace App\Http\Controllers\Siswa;

use Carbon\Carbon;
use App\Models\Eskul;
use App\Models\Siswa;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SiswaDaftarEskulController extends Controller
{
    public function index()
    {
        $eskuls = Eskul::latest()->get();

        return view('siswa.daftar-eskul.index', [
            'eskuls' => $eskuls,
        ]);
    }

    public function create($id)
    {
        $users = Auth::user();
        $siswas = Siswa::where('users_id', $users->id)->first();
        $eskuls = Eskul::where('id', $id)->first();
        return view('siswa.daftar-eskul.create', [
            'eskuls' => $eskuls,
            'siswas' => $siswas
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nis' => 'required|max:255',
            'nama' => 'required|max:255',
            'tmp_lahir' => 'required|max:255',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|max:255',
            'telp' => 'required|min:10|max:15',
            'email' => 'required|email|max:255',
            'alasan' => 'required|max:255',
            'alamat' => 'required|max:255',
            'berkas_pendaftaran' => 'required|mimes:pdf|max:10240', // Maksimal 10MB
        ], [
            // Custom error messages
            'nis.required' => 'NIS wajib diisi.',
            'nis.max' => 'NIS tidak boleh lebih dari 255 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tgl_lahir.date' => 'Tanggal Lahir harus berupa format tanggal yang valid.',
            'jk.required' => 'Jenis Kelamin wajib dipilih.',
            'telp.required' => 'Nomor Telepon wajib diisi.',
            'telp.min' => 'Nomor Telepon harus minimal 10 angka.',
            'telp.max' => 'Nomor Telepon tidak boleh lebih dari 15 angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format Email tidak valid.',
            'alasan.required' => 'Alasan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'berkas_pendaftaran.required' => 'Berkas Pendaftaran wajib diunggah.',
            'berkas_pendaftaran.mimes' => 'Berkas Pendaftaran harus berupa file PDF.',
            'berkas_pendaftaran.max' => 'Berkas Pendaftaran tidak boleh lebih dari 10 MB.'
        ]);

        // Proses file upload jika ada
        if ($request->file('berkas_pendaftaran')) {
            $validated['berkas_pendaftaran'] = $request->file('berkas_pendaftaran')->store('berkas_pendaftaran');
        }

        // Ambil data siswa berdasarkan ID
        $siswa = Siswa::where('users_id', Auth::user()->id)->first();
        $daftars = Pendaftaran::count();
        $totCount = $daftars + 1;

        $carbons = Carbon::now();
        $toDays = $carbons->format('dmY');

        // Set data tambahan ke dalam array validated
        $validated['eskul_id'] = $request->eskul_id;
        $validated['siswa_id'] = $siswa->id;
        $validated['jurusan_id'] = $siswa->jurusan_id;
        $validated['kelas_id'] = $siswa->kelas_id;
        $validated['nomor_pendaftaran'] = 'EKS' . $toDays . $totCount;
        $validated['tgl_pendaftaran'] = $carbons;
        $validated['status'] = 'Proses';

        // Simpan data pendaftaran
        Pendaftaran::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('daftar-eskul.index')->with('success', 'Selamat! Anda berhasil menambahkan data!');
    }
}
