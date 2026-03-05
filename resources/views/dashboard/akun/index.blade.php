@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- ✅ Alert sukses & error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Card daftar akun --}}
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
                                    {{-- Tombol Edit --}}
                                    <button class="btn btn-sm btn-outline-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditAkun"
                                        data-id="{{ $a->id }}" 
                                        data-nama="{{ $a->nama_akun }}"
                                        data-jenis="{{ $a->jenis }}" 
                                        data-saldo="{{ $a->saldo_awal }}">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('dashboard.akun.destroy', $a->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus akun ini?')">
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
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data akun keuangan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ Modal Tambah Akun --}}
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
                        <input type="text" name="nama_akun" class="form-control" placeholder="Contoh: Dompet Utama / Bank BCA" required>
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
                        <input type="number" name="saldo_awal" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Modal Edit Akun --}}
    <div class="modal fade" id="modalEditAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditAkun" method="POST" class="modal-content" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama_akun" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Akun</label>
                        <select name="jenis" id="edit-jenis" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="bank">Bank</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" name="saldo_awal" id="edit-saldo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const formEdit = document.getElementById('formEditAkun');
    const modalEdit = document.getElementById('modalEditAkun');
    const baseUrl = "{{ url('dashboard/akun') }}";

    // ✅ Saat modal edit dibuka
    modalEdit.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // tombol yang memicu modal
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const jenis = button.getAttribute('data-jenis');
        const saldo = button.getAttribute('data-saldo');

        // Isi data ke form
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-jenis').value = jenis;
        document.getElementById('edit-saldo').value = saldo;

        // Update URL action
        const actionUrl = `${baseUrl}/${id}`;
        formEdit.setAttribute('action', actionUrl);

        console.log('✅ Modal dibuka - Action URL:', actionUrl);
    });

    // ✅ Reset form setelah modal ditutup
    modalEdit.addEventListener('hidden.bs.modal', () => {
        formEdit.reset();
        formEdit.removeAttribute('action');
    });

    // ✅ Cegah submit tanpa ID
    formEdit.addEventListener('submit', e => {
        const action = formEdit.getAttribute('action');
        if (!action || !action.match(/\/dashboard\/akun\/\d+$/)) {
            e.preventDefault();
            alert('⚠️ Gagal update: ID akun tidak ditemukan.');
            console.error('❌ Action URL tidak valid:', action);
        }
    });
});
</script>
@endpush