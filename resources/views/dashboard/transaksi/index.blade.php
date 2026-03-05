@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
       <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h5 class="mb-0">Riwayat Transaksi</h5>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bx bx-plus"></i> Catat Transaksi
        </button>
        <a href="{{ route('dashboard.transaksi.export.pdf') }}" class="btn btn-outline-danger">
            <i class="bx bxs-file-pdf"></i> PDF
        </a>
        <a href="{{ route('dashboard.transaksi.export.excel') }}" class="btn btn-outline-success">
            <i class="bx bxs-file-export"></i> Excel
        </a>
    </div>
</div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Kategori</th>
                        <th>Akun</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $t->keterangan ?? '-' }}</strong><br>
                            <small class="text-muted">{{ ucfirst($t->jenis) }}</small>
                        </td>
                        <td>{{ $t->kategori->nama ?? 'Tanpa Kategori' }}</td>
                        <td><span class="badge bg-label-info">{{ $t->akun->nama_akun ?? 'Akun Dihapus' }}</span></td>
                        <td>
                            <span class="fw-bold {{ $t->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning btn-edit" 
                                data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="{{ $t->id }}" data-tanggal="{{ $t->tanggal }}"
                                data-kategori="{{ $t->kategori_id }}" data-akun="{{ $t->akun_id }}"
                                data-jumlah="{{ $t->jumlah }}" data-keterangan="{{ $t->keterangan }}">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('dashboard.transaksi.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('dashboard.transaksi.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Catat Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="row g-2">
                    <div class="col mb-3">
                        <label class="form-label">Akun</label>
                        <select name="akun_id" class="form-select" required>
                            @foreach($akun as $a)
                                <option value="{{ $a->id }}">{{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }} ({{ ucfirst($k->tipe) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEdit" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header"><h5>Edit Transaksi</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="edit-tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="edit-jumlah" class="form-control" required>
                </div>
                <div class="row g-2">
                    <div class="col mb-3">
                        <label class="form-label">Akun</label>
                        <select name="akun_id" id="edit-akun" class="form-select">
                            @foreach($akun as $a)
                                <option value="{{ $a->id }}">{{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" id="edit-kategori" class="form-select">
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }} ({{ ucfirst($k->tipe) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="edit-keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning w-100">Update Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            document.getElementById('edit-tanggal').value = this.getAttribute('data-tanggal');
            document.getElementById('edit-jumlah').value = this.getAttribute('data-jumlah');
            document.getElementById('edit-akun').value = this.getAttribute('data-akun');
            document.getElementById('edit-kategori').value = this.getAttribute('data-kategori');
            document.getElementById('edit-keterangan').value = this.getAttribute('data-keterangan');
            
            document.getElementById('formEdit').action = '/dashboard/transaksi/' + id;
        });
    });
</script>
@endsection