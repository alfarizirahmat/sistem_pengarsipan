<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keluarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kk',
        'kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'status_tempat_tinggal',
        'nama_pemilik_kontrakan',
        'kontak_pemilik_kontrakan',
        'tgl_mulai_tinggal',
        'tgl_selesai_kontrak',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tgl_mulai_tinggal' => 'date',
            'tgl_selesai_kontrak' => 'date',
        ];
    }

    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    public function iurans(): HasMany
    {
        return $this->hasMany(IuranWarga::class);
    }

    public function scopeKontrak(Builder $query): Builder
    {
        return $query->whereIn('status_tempat_tinggal', ['kontrak', 'kost']);
    }

    public function scopeTetap(Builder $query): Builder
    {
        return $query->where('status_tempat_tinggal', 'tetap');
    }
}
