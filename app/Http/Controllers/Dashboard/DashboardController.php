<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
// Sesuaikan dengan nama Model yang kamu miliki
use App\Models\AkunKeuangan; 
use App\Models\KategoriKeuangan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    $userId = Auth::id();

    // 1. Hitung Statistik Utama (Menggunakan nama Model yang benar)
    $totalSaldo = AkunKeuangan::where('user_id', $userId)->sum('saldo_awal');
    $totalKategori = KategoriKeuangan::where('user_id', $userId)->count();
    $totalAkun = AkunKeuangan::where('user_id', $userId)->count();
    $totalTransaksi = Transaksi::where('user_id', $userId)->count();
    
    // 2. Transaksi Terbaru
    $transaksiTerbaru = Transaksi::where('user_id', $userId)
                        ->orderBy('tanggal', 'desc')
                        ->limit(5)
                        ->get();

    // 3. Data Grafik 7 Hari Terakhir
    $pemasukanHarian = [];
    $pengeluaranHarian = [];
    $hariLabels = [];

    for ($i = 6; $i >= 0; $i--) {
        $tgl = now()->subDays($i)->format('Y-m-d');
        $hariLabels[] = now()->subDays($i)->translatedFormat('d M');

        $pemasukanHarian[] = (int) Transaksi::where('user_id', $userId)
            ->where('jenis', 'pemasukan')
            ->whereDate('tanggal', $tgl)
            ->sum('jumlah');

        $pengeluaranHarian[] = (int) Transaksi::where('user_id', $userId)
            ->where('jenis', 'pengeluaran')
            ->whereDate('tanggal', $tgl)
            ->sum('jumlah');
    }

    // Variabel cadangan agar grafik bulanan tidak error
    $pemasukan = $pemasukanHarian;
    $pengeluaran = $pengeluaranHarian;
    $bulanLabels = $hariLabels;

    return view('dashboard.index', compact(
        'totalSaldo', 'totalKategori', 'totalAkun', 'totalTransaksi', 
        'transaksiTerbaru', 'pemasukanHarian', 'pengeluaranHarian', 
        'hariLabels', 'pemasukan', 'pengeluaran', 'bulanLabels'
    ));
}
}