<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return Transaksi::with(['kategori', 'akun'])
            ->where('user_id', $this->userId)
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function map($t): array
    {
        return [
            \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y'),
            $t->keterangan,
            $t->kategori->nama ?? '-',
            $t->akun->nama_akun ?? '-',
            ($t->jenis == 'pemasukan' ? '+' : '-') . ' ' . number_format($t->jumlah, 0, ',', '.'),
        ];
    }

    public function headings(): array
    {
        return ['Tanggal', 'Keterangan', 'Kategori', 'Akun', 'Jumlah'];
    }
}