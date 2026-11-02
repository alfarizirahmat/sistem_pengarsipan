<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IuranWarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'keluarga_id',
        'bulan',
        'tahun',
        'nominal_posyandu',
        'nominal_rw',
        'nominal_kematian',
        'nominal_sampah',
        'total_iuran',
        'status',
        'tanggal_bayar',
        'metode_pembayaran',
        'petugas_penarik',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'bulan' => 'integer',
            'tahun' => 'integer',
            'nominal_posyandu' => 'decimal:2',
            'nominal_rw' => 'decimal:2',
            'nominal_kematian' => 'decimal:2',
            'nominal_sampah' => 'decimal:2',
            'total_iuran' => 'decimal:2',
            'tanggal_bayar' => 'date',
        ];
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function getNamaBulanAttribute(): string
    {
        $bulanMap = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $bulanMap[$this->bulan] ?? 'Bulan '.$this->bulan;
    }
}
