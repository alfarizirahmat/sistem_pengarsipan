<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeamanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'kategori',
        'judul',
        'lokasi',
        'petugas_ronda',
        'keterangan',
        'status',
        'tindakan',
        'pelapor',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }
}
