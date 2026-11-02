<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasRt extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori',
        'nominal',
        'keterangan',
        'nomor_bukti',
        'file_bukti',
        'dicatat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'nominal' => 'decimal:2',
        ];
    }

    public function scopePemasukan(Builder $query): Builder
    {
        return $query->where('jenis', 'pemasukan');
    }

    public function scopePengeluaran(Builder $query): Builder
    {
        return $query->where('jenis', 'pengeluaran');
    }
}
