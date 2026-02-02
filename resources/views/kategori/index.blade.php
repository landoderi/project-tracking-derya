@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Master /</span> Kategori Keuangan</h4>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card: Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Kategori Keuangan</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="bx bx-plus"></i> Tambah Kategori
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Tipe</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->tipe == 'pemasukan' ? 'success' : 'danger' }}">
                                        {{ ucfirst($k->tipe) }}
                                    </span>
                                </td>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada kategori keuangan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('kategori.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Gaji, Makan, Tagihan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Kategori</label>
                        <select name="tipe" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
