@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light"></span> History Transaksi: {{ $user->name }}
        </h4>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="history-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Kategori</th>
                            <th>Akun</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->transaksi as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $t->keterangan ?? '-' }}</strong><br>
                                <small class="text-muted">{{ ucfirst($t->jenis) }}</small>
                            </td>
                            <td>{{ $t->kategori->nama ?? '-' }}</td>
                            <td><span class="badge bg-label-info">{{ $t->akun->nama_akun ?? '-' }}</span></td>
                            <td>
                                <span class="fw-bold {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                    {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat transaksi untuk pengguna ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#history-table').DataTable({
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_ data" }
        });
    });
</script>
@endpush