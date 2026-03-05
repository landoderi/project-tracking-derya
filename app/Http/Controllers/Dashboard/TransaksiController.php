<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\KategoriKeuangan;
use App\Models\AkunKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
// ... namespace dan imports

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['kategori', 'akun'])
            ->where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        // ✅ PERBAIKAN: Hanya tampilkan kategori milik user ini
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->get();
        $akun = AkunKeuangan::where('user_id', Auth::id())->get();

        return view('dashboard.transaksi.index', compact('transaksi', 'kategori', 'akun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            // ✅ PERBAIKAN: Validasi kategori harus milik user login
            'kategori_id' => [
                'required',
                'exists:kategori_keuangan,id,user_id,' . Auth::id()
            ],
            // ✅ PERBAIKAN: Validasi akun harus milik user login
            'akun_id' => [
                'required',
                'exists:akun_keuangan,id,user_id,' . Auth::id()
            ],
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil data kategori & akun dengan pengaman user_id
        $kategori = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($request->kategori_id);
        $akun = AkunKeuangan::where('user_id', Auth::id())->findOrFail($request->akun_id);

        $transaksi = Transaksi::create([
            'tanggal' => $request->tanggal,
            'kategori_id' => $request->kategori_id,
            'akun_id' => $request->akun_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
            'jenis' => $kategori->tipe,
        ]);

        // Update saldo
        if ($kategori->tipe === 'pemasukan') {
            $akun->saldo_awal += $request->jumlah;
        } else {
            $akun->saldo_awal -= $request->jumlah;
        }
        $akun->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }
    
    public function exportPdf()
{
    $user = Auth::user();
    $transaksi = Transaksi::with(['kategori', 'akun'])
        ->where('user_id', $user->id)
        ->orderBy('tanggal', 'desc')
        ->get();

    $pdf = Pdf::loadView('dashboard.transaksi.export-pdf', compact('transaksi', 'user'));
    return $pdf->download('riwayat_transaksi_' . $user->name . '.pdf');
}

public function exportExcel()
{
    return Excel::download(new TransaksiExport(Auth::id()), 'riwayat_transaksi.xlsx');
}
    public function update(Request $request, Transaksi $transaksi)
    {
        // Pastikan transaksi milik user login
        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => [
                'required',
                'exists:kategori_keuangan,id,user_id,' . Auth::id()
            ],
            'akun_id' => [
                'required',
                'exists:akun_keuangan,id,user_id,' . Auth::id()
            ],
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Revert efek saldo transaksi lama
        $oldAkun = AkunKeuangan::where('user_id', Auth::id())->find($transaksi->akun_id);
        if ($oldAkun) {
            if ($transaksi->jenis === 'pemasukan') {
                $oldAkun->saldo_awal -= $transaksi->jumlah;
            } else {
                $oldAkun->saldo_awal += $transaksi->jumlah;
            }
            $oldAkun->save();
        }

        // Ambil data kategori & akun baru
        $kategoriBaru = KategoriKeuangan::where('user_id', Auth::id())->findOrFail($request->kategori_id);
        $akunBaru = AkunKeuangan::where('user_id', Auth::id())->findOrFail($request->akun_id);

        // Update data transaksi
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'kategori_id' => $request->kategori_id,
            'akun_id' => $request->akun_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'jenis' => $kategoriBaru->tipe,
        ]);

        // Terapkan efek saldo transaksi baru
        if ($kategoriBaru->tipe === 'pemasukan') {
            $akunBaru->saldo_awal += $request->jumlah;
        } else {
            $akunBaru->saldo_awal -= $request->jumlah;
        }
        $akunBaru->save();

        return redirect()->back()->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user login
        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Revert efek saldo
        $akun = AkunKeuangan::where('user_id', Auth::id())->find($transaksi->akun_id);
        if ($akun) {
            if ($transaksi->jenis === 'pemasukan') {
                $akun->saldo_awal -= $transaksi->jumlah;
            } else {
                $akun->saldo_awal += $transaksi->jumlah;
            }
            $akun->save();
        }

        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}