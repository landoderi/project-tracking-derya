<h3>Riwayat Transaksi - {{ $user->name }}</h3>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
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
        @foreach($transaksi as $t)
        <tr>
            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $t->keterangan ?? '-' }}</td>
            <td>{{ $t->kategori->nama ?? '-' }}</td>
            <td>{{ $t->akun->nama_akun ?? '-' }}</td>
            <td align="right">
                {{ $t->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>