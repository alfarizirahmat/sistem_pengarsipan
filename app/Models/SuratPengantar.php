<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'warga_id',
        'jenis_surat',
        'keperluan',
        'dokumen_hilang',
        'tanggal_surat',
        'berlaku_sampai',
        'tahun_arsip',
        'penandatangan_nama',
        'penandatangan_jabatan',
        'tanda_tangan_jenis',
        'tanda_tangan_digital',
        'qr_token',
        'file_dokumen',
        'status',
        'lokasi_arsip_fisik',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'berlaku_sampai' => 'date',
            'tahun_arsip' => 'integer',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function scopeTahun(Builder $query, int $tahun): Builder
    {
        return $query->where('tahun_arsip', $tahun);
    }

    public function getTandaTanganUrlAttribute(): ?string
    {
        if (! $this->tanda_tangan_digital) {
            return null;
        }

        if (str_starts_with($this->tanda_tangan_digital, 'data:image') || str_starts_with($this->tanda_tangan_digital, 'http')) {
            return $this->tanda_tangan_digital;
        }

        return asset($this->tanda_tangan_digital);
    }

    public function getIsPdfSignatureAttribute(): bool
    {
        if ($this->tanda_tangan_jenis === 'pdf') {
            return true;
        }

        if ($this->tanda_tangan_digital && str_ends_with(strtolower($this->tanda_tangan_digital), '.pdf')) {
            return true;
        }

        return false;
    }

    public function getLabelJenisSuratAttribute(): string
    {
        return match ($this->jenis_surat) {
            'kehilangan_dokumen' => 'Surat Pengantar Kehilangan Dokumen (KTP/KK/Akta akibat Bencana/Banjir)',
            'ktp_baru' => 'Surat Pengantar Pembuatan / Rekam KTP Baru',
            'perubahan_kk' => 'Surat Pengantar Perubahan Data Kartu Keluarga',
            'pindah_domisili' => 'Surat Pengantar Pindah Domisili Keluar',
            'warga_datang' => 'Surat Keterangan Warga Datang / Masuk',
            'kematian' => 'Surat Keterangan Kematian',
            'keterangan_domisili' => 'Surat Keterangan Domisili Tinggal',
            'sktm' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'sku' => 'Surat Keterangan Usaha (SKU)',
            default => 'Surat Keterangan / Pengantar Lainnya',
        };
    }
}
