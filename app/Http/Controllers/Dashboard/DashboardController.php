<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AkunKeuangan;
use App\Models\KategoriKeuangan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // ⬅️ penting untuk format bulan

class DashboardController extends Controller
{
   public function index()
{
    $userId = Auth::id();

    // ✅ Total saldo hanya milik user login
    $totalSaldo = AkunKeuangan::where('user_id', $userId)->sum('saldo_awal');

    // ✅ Total kategori, akun, dan transaksi berdasarkan user login
    $totalKategori = KategoriKeuangan::where('user_id', $userId)->count();
    $totalAkun = AkunKeuangan::where('user_id', $userId)->count();
    $totalTransaksi = Transaksi::where('user_id', $userId)->count();

    // ✅ Transaksi terbaru user login
    $transaksiTerbaru = Transaksi::where('user_id', $userId)
        ->orderBy('tanggal', 'desc')
        ->take(5)
        ->get();

    // ✅ Grafik keuangan per bulan
    $dataBulanan = Transaksi::selectRaw("
            DATE_FORMAT(tanggal, '%Y-%m') as bulan,
            SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as total_pengeluaran
        ")
        ->where('user_id', $userId)
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get();

    $bulanLabels = $dataBulanan->map(function ($item) {
        return Carbon::createFromFormat('Y-m', $item->bulan)->translatedFormat('M Y');
    })->toArray();

    $pemasukan = $dataBulanan->pluck('total_pemasukan')->map(fn($v) => (float)$v);
    $pengeluaran = $dataBulanan->pluck('total_pengeluaran')->map(fn($v) => (float)$v);

    return view('dashboard.index', compact(
        'totalSaldo',
        'totalKategori',
        'totalAkun',
        'totalTransaksi',
        'transaksiTerbaru',
        'bulanLabels',
        'pemasukan',
        'pengeluaran'
    ));
}
}
