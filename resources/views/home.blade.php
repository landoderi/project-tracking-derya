@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card shadow-sm border-0" style="background: linear-gradient(to right, #696cff, #8592ff);">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body text-white p-5">
                            <h2 class="card-title text-white fw-bold mb-3">Selamat Datang Kembali, {{ Auth::user()->name }}! 🎉</h2>
                            <p class="mb-4">
                                Progres keuanganmu minggu ini cukup stabil. Kamu sudah mencatat <span class="fw-bold">8 transaksi</span> baru. Jangan lupa cek pengeluaran hari ini ya!
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard.transaksi.index') }}" class="btn btn-white text-primary fw-bold" style="background: white;">
                                    <i class='bx bx-plus-circle'></i> Catat Sekarang
                                </a>
                                <a href="{{ route('dashboard.index') }}" class="btn btn-outline-white text-white border-white">
                                    Lihat Statistik
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/img/illustrations/man-with-laptop-light.png" height="200" alt="View Badge User">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-warning p-2"><i class='bx bx-bulb text-warning'></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Tips Keuangan</span>
                    <h4 class="card-title mb-2">Gunakan Aturan 50/30/20</h4>
                    <p class="small text-muted">Sisihkan 20% untuk tabungan sebelum mulai berbelanja kebutuhan lainnya.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Panduan Cepat</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-3 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="badge bg-label-primary p-2"><i class='bx bx-wallet'></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Atur Akun Keuangan</h6>
                                    <small class="text-muted">Tambahkan bank atau dompet digitalmu.</small>
                                </div>
                                <div class="user-progress"><i class='bx bx-chevron-right'></i></div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="badge bg-label-success p-2"><i class='bx bx-category'></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Kelola Kategori</h6>
                                    <small class="text-muted">Buat kategori pengeluaran agar lebih rapi.</small>
                                </div>
                                <div class="user-progress"><i class='bx bx-chevron-right'></i></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection