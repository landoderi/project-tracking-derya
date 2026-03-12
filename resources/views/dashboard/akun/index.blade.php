@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Akun Keuangan</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
                <i class="bx bx-plus"></i> Tambah Akun
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Akun</th>
                            <th>Jenis</th>
                            <th>Saldo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($akun as $a)
                        <tr>
                            <td><strong>{{ $a->nama_akun }}</strong></td>
                            <td><span class="badge bg-label-info">{{ ucfirst($a->jenis) }}</span></td>
                            <td>Rp {{ number_format($a->saldo_awal, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Edit: Panggil fungsi siapkanEdit langsung --}}
                                    <button class="btn btn-sm btn-outline-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editAkunModal"
                                        onclick="siapkanEdit('{{ $a->id }}', '{{ $a->nama_akun }}', '{{ $a->jenis }}', '{{ $a->saldo_awal }}')">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>

                                    <form action="{{ route('dashboard.akun.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data akun keuangan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('dashboard.akun.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama_akun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Akun</label>
                        <select name="jenis" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="bank">Bank</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" name="saldo_awal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editAkunModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editAkunForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama_akun" id="edit_nama_akun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select name="jenis" id="edit_jenis" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="bank">Bank</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" name="saldo_awal" id="edit_saldo_awal" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function siapkanEdit(id, nama, jenis, saldo) {
        const form = document.getElementById('editAkunForm');
        // Set Action URL: dashboard/akun/{id}
        form.action = "{{ url('dashboard/akun') }}/" + id;

        // Isi inputan modal
        document.getElementById('edit_nama_akun').value = nama;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_saldo_awal').value = saldo;

        console.log("Action form berubah ke: " + form.action);
    }
</script>
@endsection