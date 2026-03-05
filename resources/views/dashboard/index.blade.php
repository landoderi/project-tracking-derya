@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header Card --}}
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                Selamat datang kembali, Mas {{ Auth::user()->name }}! 🎉
                            </h5>
                            <p class="mb-4">Ayo kelola keuangan dengan lebih baik!</p>
                            <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus"></i> Catat Transaksi
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="User Illustration" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Saldo --}}
        <div class="col-lg-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white mb-1">Total Saldo</h5>
                            <h2 class="text-white mb-2">
                                Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="avatar">
                            <span class="badge bg-white p-2 rounded">
                                <i class="bx bx-wallet-alt text-primary fs-2"></i>
                            </span>
                        </div>
                    </div>
                    <p class="mb-0 text-white-50 small">Gabungan dari semua akun keuangan Anda</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="row">
        {{-- Total Kategori --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Kategori</span>
                    <h3 class="card-title mb-2">{{ $totalKategori ?? 0 }}</h3>
                    <small class="text-success fw-semibold"><i class="bx bx-check-circle"></i> Master Data</small>
                </div>
            </div>
        </div>

        {{-- Akun Aktif --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="wallet info" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Akun Aktif</span>
                    <h3 class="card-title mb-2">{{ $totalAkun ?? 0 }}</h3>
                    <small class="text-info fw-semibold"><i class="bx bx-credit-card"></i> Sumber Dana</small>
                </div>
            </div>
        </div>

        {{-- Total Transaksi --}}
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="transaction" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Transaksi</span>
                    <h3 class="card-title mb-2">{{ $totalTransaksi ?? 0 }}</h3>
                    <small class="text-primary fw-semibold"><i class="bx bx-time-five"></i> Riwayat Anda</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik & Transaksi Terbaru --}}
    <div class="row">
        {{-- Grafik --}}
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Grafik Keuangan</h5>
                    <small class="text-muted">Pemasukan vs Pengeluaran</small>
                </div>
                <div class="card-body">
                    <div id="totalRevenueChart" style="min-height: 280px;"></div>
                </div>
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Transaksi Terbaru</h5>
                    <a href="{{ route('dashboard.transaksi.index') }}" class="small text-primary">Lihat Semua</a>
                </div>
                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                    @forelse($transaksiTerbaru ?? [] as $t)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div>
                                <strong>{{ $t->keterangan ?? '-' }}</strong><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}</small>
                            </div>
                            <span class="fw-bold {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }}
                                Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-muted my-3">Belum ada transaksi terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var pemasukan = @json($pemasukan);
    var pengeluaran = @json($pengeluaran);
    var bulanLabels = @json($bulanLabels);

    console.log("Labels:", bulanLabels);
    console.log("Pemasukan:", pemasukan);
    console.log("Pengeluaran:", pengeluaran);

    if (pemasukan.every(v => v === 0) && pengeluaran.every(v => v === 0)) {
        document.querySelector("#totalRevenueChart").innerHTML =
            "<p class='text-center text-muted mt-4'>Belum ada data transaksi bulan ini.</p>";
        return;
    }

    var options = {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        plotOptions: {
            bar: { horizontal: false, columnWidth: '45%', borderRadius: 6 }
        },
        series: [
            { name: 'Pemasukan', data: pemasukan },
            { name: 'Pengeluaran', data: pengeluaran }
        ],
        colors: ['#28a745', '#dc3545'],
        dataLabels: { enabled: false },
        xaxis: {
            categories: bulanLabels,
            labels: { style: { fontSize: '13px' } }
        },
        yaxis: {
            title: { text: 'Jumlah (Rp)' },
            labels: { formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val) }
        },
        tooltip: {
            y: { formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val) }
        },
        legend: { position: 'top' },
        grid: { borderColor: '#f1f1f1' }
    };

    var chart = new ApexCharts(document.querySelector("#totalRevenueChart"), options);
    chart.render();
});
</script>
@endsection
