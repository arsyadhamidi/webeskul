<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Level;
use App\Models\OrangTua;
use App\Models\Pembina;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $levels = Level::count();
        $jurusans = Jurusan::count();
        $kelas = Kelas::count();
        $pembinas = Pembina::count();
        $ortus = OrangTua::count();
        $siswas = Siswa::count();
        $eskuls = Siswa::count();
        $jadwals = Jadwal::count();
        $pendaftarans = Pendaftaran::count();
        $dokumentasis = Jadwal::count();

        // Menghitung pendaftaran per bulan untuk tahun berjalan
        $pendaftarPerBulan = Pendaftaran::selectRaw('MONTH(tgl_pendaftaran) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', date('Y'))  // Mengambil data hanya untuk tahun berjalan
            ->groupBy('bulan')
            ->pluck('jumlah', 'bulan');           // Menghasilkan array dengan key = bulan dan value = jumlah pendaftar

        // Data untuk chart
        $dataPendaftar = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPendaftar[] = $pendaftarPerBulan->get($i, 0);  // Jika tidak ada data untuk bulan tersebut, set 0
        }
        return view('admin.dashboard.index', [
            'users' => $users,
            'levels' => $levels,
            'jurusans' => $jurusans,
            'kelas' => $kelas,
            'pembinas' => $pembinas,
            'ortus' => $ortus,
            'siswas' => $siswas,
            'eskuls' => $eskuls,
            'jadwals' => $jadwals,
            'dokumentasis' => $dokumentasis,
            'pendaftarans' => $pendaftarans,
            'dataPendaftar' => $dataPendaftar,
        ]);
    }

    public function isibiodatasiswa()
    {
        $jurusans = Jurusan::latest()->get();
        return view('siswa.isi-biodata', [
            'jurusans' => $jurusans,
        ]);
    }

    public function storebiodatasiswa(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nis' => 'required|unique:siswas,nis|max:255',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
        ], [

            'jurusan_id.required' => 'Jurusan wajib diisi.',

            'kelas_id.required' => 'Kelas wajib diisi.',

            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar, silakan gunakan NISN lain.',
            'nis.max' => 'NIS tidak boleh lebih dari 255 karakter.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',
        ]);

        $validated['users_id'] = Auth::user()->id;

        Siswa::create($validated);

        return redirect('/dashboard')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function editbiodatasiswa($id)
    {
        $siswas = Siswa::where('id', $id)->first();
        $jurusans = Jurusan::latest()->get();
        return view('siswa.edit-biodata', [
            'siswas' => $siswas,
            'jurusans' => $jurusans,
        ]);
    }

    public function updatebiodatasiswa(Request $request, $id)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
            'nama' => 'required|max:255',
            'jk' => 'required|max:255',
        ], [
            'users_id.required' => 'ID Pengguna wajib diisi.',

            'jurusan_id.required' => 'Jurusan wajib diisi.',

            'kelas_id.required' => 'Kelas wajib diisi.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jk.required' => 'Jenis kelamin wajib diisi.',
            'jk.max' => 'Jenis kelamin tidak boleh lebih dari 255 karakter.',
        ]);

        $validated['users_id'] = Auth::user()->id;

        Siswa::where('id', $id)->update($validated);

        return redirect('/dashboard')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function jqueryKelas(Request $request)
    {
        $id_jurusan = $request->id_jurusan;

        $kelass = Kelas::where('jurusan_id', $id_jurusan)->get();

        foreach ($kelass as $kelas) {
            echo "<option value='$kelas->id'>$kelas->nama_kelas</option>";
        }
    }
}
