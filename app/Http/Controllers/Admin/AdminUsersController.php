<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $levels = Level::latest()->get();
        return view('admin.users.create', [
            'levels' => $levels,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users,username|max:255',
            'level_id' => 'required',
            'telp' => 'required|digits_between:10,15',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',

            'level_id.required' => 'ID Level wajib diisi.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.',
        ]);

        $validated['password'] = bcrypt('12345678');

        User::create($validated);

        return redirect()->route('data-users.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $levels = Level::latest()->get();
        $users = User::where('id', $id)->first();
        return view('admin.users.edit', [
            'users' => $users,
            'levels' => $levels,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'level_id' => 'required',
            'telp' => 'required|digits_between:10,15',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'level_id.required' => 'ID Level wajib diisi.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.digits_between' => 'Nomor telepon harus antara 10 hingga 15 digit.',
        ]);

        User::where('id', $id)->update($validated);

        return redirect()->route('data-users.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $users = User::where('id', $id)->first();
        $users->delete();

        return redirect()->route('data-users.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
