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

    /**
     * Cari warga yang sudah ada berdasarkan NIK / Nama, atau buat data baru secara otomatis.
     */
    public static function resolveFromInput(array $data): self
    {
        $wargaId = $data['warga_id'] ?? null;
        $nik = ! empty($data['nik']) ? trim((string) $data['nik']) : null;
        $namaLengkap = ! empty($data['nama_lengkap']) ? trim((string) $data['nama_lengkap']) : null;

        // 1. Berdasarkan warga_id jika ada
        if ($wargaId) {
            $w = self::find($wargaId);
            if ($w) {
                return $w;
            }
        }

        // 2. Berdasarkan NIK jika diinput
        if ($nik) {
            $w = self::where('nik', $nik)->first();
            if ($w) {
                if ($namaLengkap && $w->nama_lengkap !== $namaLengkap) {
                    $w->update(['nama_lengkap' => $namaLengkap]);
                }

                return $w;
            }
        }

        // 3. Berdasarkan Nama Lengkap jika diinput
        if ($namaLengkap) {
            $w = self::where('nama_lengkap', $namaLengkap)->first();
            if ($w) {
                if ($nik && empty($w->nik)) {
                    $w->update(['nik' => $nik]);
                }

                return $w;
            }
        }

        // 4. Buat data warga baru jika belum ada
        if (empty($nik)) {
            do {
                $nik = '320105'.str_pad((string) mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
            } while (self::where('nik', $nik)->exists());
        }

        if (empty($namaLengkap)) {
            $namaLengkap = 'Warga RT 005';
        }

        $warga = self::create([
            'nik' => $nik,
            'nama_lengkap' => $namaLengkap,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? 'L',
            'tempat_lahir' => $data['tempat_lahir'] ?? 'Bogor',
            'tanggal_lahir' => $data['tanggal_lahir'] ?? '1990-01-01',
            'agama' => $data['agama'] ?? 'Islam',
            'pekerjaan' => $data['pekerjaan'] ?? 'Wiraswasta',
            'status_perkawinan' => $data['status_perkawinan'] ?? 'Kawin',
            'status_hubungan_keluarga' => $data['status_hubungan_keluarga'] ?? 'Kepala Keluarga',
            'no_hp' => $data['no_hp'] ?? ($data['no_whatsapp'] ?? null),
            'status_tinggal' => $data['status_tinggal'] ?? 'tetap',
            'status_kependudukan' => 'aktif',
        ]);

        if (! empty($data['alamat'])) {
            $keluarga = Keluarga::create([
                'nomor_kk' => '320105'.str_pad((string) mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT),
                'kepala_keluarga' => $namaLengkap,
                'alamat' => $data['alamat'],
                'rt' => '005',
                'rw' => '013',
                'status_tempat_tinggal' => $data['status_tinggal'] ?? 'tetap',
            ]);
            $warga->update(['keluarga_id' => $keluarga->id]);
        }

        return $warga;
    }
}
