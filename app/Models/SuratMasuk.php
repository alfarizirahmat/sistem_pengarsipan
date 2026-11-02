<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat_pengirim',
        'pengirim',
        'perihal',
        'ringkasan_isi',
        'tanggal_surat',
        'tanggal_terima',
        'file_lampiran',
        'tahun_arsip',
        'lokasi_arsip_fisik',
        'disposisi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'tanggal_terima' => 'date',
            'tahun_arsip' => 'integer',
        ];
    }

    public function scopeTahun(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun_arsip', $tahun);
    }
}
