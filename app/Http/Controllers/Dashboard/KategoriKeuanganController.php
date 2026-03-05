<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller; 
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
public function index()
{
    // Hanya ambil data milik user yang sedang login
    $kategori = KategoriKeuangan::where('user_id', auth()->id())->get();
    return view('dashboard.kategori.index', compact('kategori'));
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
        'user_id' => auth()->id(), // Pastikan user_id tersimpan otomatis
    ]);

    return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
        ]);

        // Pastikan hanya bisa update kategori milik sendiri
        $kategori = KategoriKeuangan::where('user_id', auth()->id())->findOrFail($id);
        
        $kategori->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Pastikan hanya bisa hapus kategori milik sendiri
        $kategori = KategoriKeuangan::where('user_id', auth()->id())->findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}