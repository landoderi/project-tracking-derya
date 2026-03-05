<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AkunKeuangan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunKeuanganController extends Controller
{
public function index()
{
    // Hanya tampilkan akun milik user yang sedang login
    $akun = AkunKeuangan::where('user_id', auth()->id())->get();
    return view('dashboard.akun.index', compact('akun'));
}

public function store(Request $request)
{
    // Simpan akun dengan user_id otomatis
    AkunKeuangan::create([
        'nama_akun' => $request->nama_akun,
        'jenis'     => $request->jenis,
        'saldo_awal'=> $request->saldo_awal,
        'user_id'   => auth()->id(), // Penting!
    ]);

    return redirect()->back()->with('success', 'Akun berhasil dibuat!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255',
            'jenis' => 'required|in:tunai,bank,e-wallet',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);

        // Perhitungan selisih saldo jika saldo_awal diubah
        $selisih = $request->saldo_awal - $akun->saldo_awal;

        $akun->update([
            'nama_akun' => $request->nama_akun,
            'jenis' => $request->jenis,
            'saldo_awal' => $request->saldo_awal,
            'saldo' => $akun->saldo + $selisih, // update saldo agar konsisten
        ]);

        return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($id);

        $transaksiCount = Transaksi::where('akun_id', $akun->id)->count();
        if ($transaksiCount > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun yang memiliki transaksi!');
        }

        $akun->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }
}