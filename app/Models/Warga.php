<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = [
        'keluarga_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'status_hubungan_keluarga',
        'no_hp',
        'status_tinggal',
        'status_kependudukan',
        'tgl_mutasi',
        'keterangan_mutasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tgl_mutasi' => 'date',
        ];
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function suratPengantars(): HasMany
    {
        return $this->hasMany(SuratPengantar::class);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status_kependudukan', 'aktif');
    }

    public function scopePindah(Builder $query): Builder
    {
        return $query->where('status_kependudukan', 'pindah');
    }

    public function scopeMeninggal(Builder $query): Builder
    {
        return $query->where('status_kependudukan', 'meninggal');
    }

    public function scopeKontrak(Builder $query): Builder
    {
        return $query->whereIn('status_tinggal', ['kontrak', 'kost']);
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : 0;
    }
}
