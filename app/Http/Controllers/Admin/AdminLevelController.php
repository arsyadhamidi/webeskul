<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class AdminLevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('id', 'desc')->get();
        return view('admin.level.index', [
            'levels' => $levels,
        ]);
    }

    public function create()
    {
        return view('admin.level.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_level' => 'required|max:255',
            'namalevel' => 'required|max:255'
        ], [
            'id_level.required' => 'ID Level wajib diisi.',
            'id_level.max' => 'ID Level tidak boleh lebih dari 255 karakter.',
            'namalevel.required' => 'Nama Level wajib diisi.',
            'namalevel.max' => 'Nama Level tidak boleh lebih dari 255 karakter.'
        ]);

        Level::create($validated);

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $levels = Level::where('id', $id)->first();
        return view('admin.level.edit', [
            'levels' => $levels,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_level' => 'required|max:255',
            'namalevel' => 'required|max:255'
        ], [
            'id_level.required' => 'ID Level wajib diisi.',
            'id_level.max' => 'ID Level tidak boleh lebih dari 255 karakter.',
            'namalevel.required' => 'Nama Level wajib diisi.',
            'namalevel.max' => 'Nama Level tidak boleh lebih dari 255 karakter.'
        ]);

        Level::where('id', $id)->update($validated);

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $levels = Level::where('id', $id)->first();
        $levels->delete();

        return redirect()->route('data-level.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
