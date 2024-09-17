<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEskulController extends Controller
{
    public function index()
    {
        $eskuls = Eskul::orderBy('id', 'desc')->get();
        return view('admin.eskul.index', [
            'eskuls' => $eskuls,
        ]);
    }

    public function create()
    {
        return view('admin.eskul.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'gambar_eskul' => 'required|mimes:jpg,png,jpeg|max:10240',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'gambar_eskul.required' => 'Gambar wajib diisi',
            'gambar_eskul.mimes' => 'Gambar harus memiliki format JPG, PNG, atau JPEG',
            'gambar_eskul.max' => 'Gambar ukuran maksimal 10 MB',
        ]);

        if($request->file('gambar_eskul')){
            $validated['gambar_eskul'] = $request->file('gambar_eskul')->store('gambar_eskul');
        }

        Eskul::create($validated);

        return redirect()->route('data-eskul.index')->with('success', 'Selamat ! Anda berhasil menambahkan data !');
    }

    public function edit($id)
    {
        $eskuls = Eskul::where('id', $id)->first();
        return view('admin.eskul.edit', [
            'eskuls' => $eskuls,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'gambar_eskul' => 'nullable|mimes:jpg,png,jpeg|max:10240',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'gambar_eskul.mimes' => 'Gambar harus memiliki format JPG, PNG, atau JPEG',
            'gambar_eskul.max' => 'Gambar ukuran maksimal 10 MB',
        ]);

        $eskuls = Eskul::where('id', $id)->first();

        if($request->file('gambar_eskul')){
            if($eskuls->gambar_eskul){
                Storage::delete($eskuls->gambar_eskul);
            }
            $validated['gambar_eskul'] = $request->file('gambar_eskul')->store('gambar_eskul');
        }else{
            $validated['gambar_eskul'] = $eskuls->gambar_eskul;
        }

        $eskuls->update($validated);

        return redirect()->route('data-eskul.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }

    public function destroy($id)
    {

        $eskuls = Eskul::where('id', $id)->first();
        $eskuls->delete();

        return redirect()->route('data-eskul.index')->with('success', 'Selamat ! Anda berhasil memperbaharui data !');
    }
}
