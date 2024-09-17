<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();
        return view('admin.setting.index', [
            'users' => $users,
        ]);
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'telp' => 'required|digits_between:10,15',
        ], [
            'name.required' => 'Nama Lengkap wajib diisi',
            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'name' => $request->name ?? '-',
            'telp' => $request->telp ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui profile');
    }

    public function updateusername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan username lain.',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'username' => $request->username ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui alamat email');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'konfirmasipassword' => 'required|min:8|same:password',
        ], [
            'password.required' => 'Password wajib diisi',
            'konfirmasipassword.required' => 'Konfirmasi Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'konfirmasipassword.min' => 'Konfirmasi Password minimal 8 karakter',
            'konfirmasipassword.same' => 'Password dan Konfirmasi harus sama',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        $users->update([
            'password' => bcrypt($request->password) ?? '-',
        ]);

        return redirect('setting')->with('success', 'Selamat ! Anda berhasil memperbaharui password');
    }

    public function updategambar(Request $request)
    {
        $request->validate([
            'foto_profile' => 'required|mimes:png,jpg,jpeg|max:10240',
        ], [
            'foto_profile.required' => 'Foto Profile wajib diisi',
            'foto_profile.mimes' => 'Foto Profile memiliki format berupa PNG, JPEG, atau JPG',
            'foto_profile.max' => 'Foto Profile maximal 10 MB',
        ]);

        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        if ($request->file('foto_profile')) {
            // Hapus foto profil lama jika ada
            if ($users->foto_profile) {
                Storage::delete($users->foto_profile);
            }

            // Simpan foto profil baru
            $fotoProfile = $request->file('foto_profile')->store('foto_profile');
            $users->update([
                'foto_profile' => $fotoProfile,
            ]);
        }

        return redirect('setting')->with('success', 'Selamat! Anda berhasil memperbaharui foto profile');
    }

    public function hapusgambar()
    {
        $auth = Auth::user();
        $users = User::where('id', $auth->id)->first();

        if ($users->foto_profile) {
            Storage::delete($users->foto_profile);
        }

        $users->update([
            'foto_profile' => null,
        ]);

        return redirect('setting')->with('success', 'Selamat! Anda berhasil menghapus foto profile');
    }
}
