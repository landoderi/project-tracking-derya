<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        $kategori = KategoriKeuangan::all();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
        ]);

        KategoriKeuangan::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        KategoriKeuangan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
