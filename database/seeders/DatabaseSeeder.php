<?php

namespace Database\Seeders;

use App\Models\IuranWarga;
use App\Models\KasRt;
use App\Models\Keluarga;
use App\Models\LaporanKeamanan;
use App\Models\SuratMasuk;
use App\Models\SuratPengantar;
use App\Models\User;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengurus RT (RT 005 / RW 013 Perumahan Bumi Mutiara Indah II)
        $users = [
            [
                'name' => 'Bapak Hartono (Ketua RT)',
                'email' => 'rt@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'ketua_rt',
                'jabatan' => 'Ketua RT 005',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Bapak Ahmad Faisal (Sekretaris)',
                'email' => 'sekretaris@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'sekretaris',
                'jabatan' => 'Sekretaris RT 005',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Ibu Hj. Siti Nurjanah (Bendahara)',
                'email' => 'bendahara@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
                'jabatan' => 'Bendahara RT 005',
                'phone' => '081234567892',
            ],
            [
                'name' => 'Bapak Rudi Kurniawan (Humas)',
                'email' => 'humas@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'humas',
                'jabatan' => 'Seksi Humas RT 005',
                'phone' => '081234567893',
            ],
            [
                'name' => 'Bapak Agus Santoso (Keamanan)',
                'email' => 'keamanan@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'keamanan',
                'jabatan' => 'Seksi Keamanan & Ronda RT 005',
                'phone' => '081234567894',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

        // 2. Data Keluarga (Tetap & Kontrak) - RT 005 / RW 013 Perumahan Bumi Mutiara Indah II
        $kk1 = Keluarga::create([
            'nomor_kk' => '3201011203850001',
            'kepala_keluarga' => 'Bambang Sudibyo',
            'alamat' => 'Perumahan Bumi Mutiara Indah II Blok B3 No. 12, RT 005 / RW 013',
            'rt' => '005',
            'rw' => '013',
            'status_tempat_tinggal' => 'tetap',
            'keterangan' => 'Rumah milik sendiri, tinggal sejak tahun 2018',
        ]);

        $kk2 = Keluarga::create([
            'nomor_kk' => '3201011508900002',
            'kepala_keluarga' => 'Dedi Iskandar',
            'alamat' => 'Perumahan Bumi Mutiara Indah II Blok B2 No. 5B (Kontrakan Ibu Hj. Siti)',
            'rt' => '005',
            'rw' => '013',
            'status_tempat_tinggal' => 'kontrak',
            'nama_pemilik_kontrakan' => 'Ibu Hj. Siti Nurjanah',
            'kontak_pemilik_kontrakan' => '081234567892',
            'tgl_mulai_tinggal' => Carbon::now()->subMonths(6),
            'tgl_selesai_kontrak' => Carbon::now()->addMonths(6),
            'keterangan' => 'Warga ngontrak tahunan, karyawan swasta',
        ]);

        $kk3 = Keluarga::create([
            'nomor_kk' => '3201012004920003',
            'kepala_keluarga' => 'Eko Prasetyo',
            'alamat' => 'Perumahan Bumi Mutiara Indah II Blok A1 No. 8, RT 005 / RW 013',
            'rt' => '005',
            'rw' => '013',
            'status_tempat_tinggal' => 'tetap',
            'keterangan' => 'Warga tetap, baru dikaruniai putri bulan lalu',
        ]);

        $kk4 = Keluarga::create([
            'nomor_kk' => '3201010101800004',
            'kepala_keluarga' => 'Wahyu Hidayat',
            'alamat' => 'Perumahan Bumi Mutiara Indah II Blok C4 No. 15, RT 005 / RW 013',
            'rt' => '005',
            'rw' => '013',
            'status_tempat_tinggal' => 'kontrak',
            'nama_pemilik_kontrakan' => 'Bapak Hartono',
            'kontak_pemilik_kontrakan' => '081234567890',
            'tgl_mulai_tinggal' => Carbon::now()->subMonths(14),
            'tgl_selesai_kontrak' => Carbon::now()->subMonths(1),
            'keterangan' => 'Pindah domisili ke luar kota minggu lalu (tercatat mutasi keluar)',
        ]);

        // 3. Data Warga (Anggota Keluarga, Status Mutasi, Jenis Tinggal)
        $warga1 = Warga::create([
            'keluarga_id' => $kk1->id,
            'nik' => '3201011203850001',
            'nama_lengkap' => 'Bambang Sudibyo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1985-03-12',
            'agama' => 'Islam',
            'pekerjaan' => 'PNS / Guru',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'no_hp' => '085711223344',
            'status_tinggal' => 'tetap',
            'status_kependudukan' => 'aktif',
        ]);

        $warga2 = Warga::create([
            'keluarga_id' => $kk1->id,
            'nik' => '3201015509880002',
            'nama_lengkap' => 'Endang Sulastri',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Solo',
            'tanggal_lahir' => '1988-09-15',
            'agama' => 'Islam',
            'pekerjaan' => 'Ibu Rumah Tangga',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Istri',
            'no_hp' => '085711223345',
            'status_tinggal' => 'tetap',
            'status_kependudukan' => 'aktif',
        ]);

        $warga3 = Warga::create([
            'keluarga_id' => $kk1->id,
            'nik' => '3201011002100003',
            'nama_lengkap' => 'Dimas Aditya Sudibyo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2010-02-10',
            'agama' => 'Islam',
            'pekerjaan' => 'Pelajar',
            'status_perkawinan' => 'Belum Kawin',
            'status_hubungan_keluarga' => 'Anak',
            'status_tinggal' => 'tetap',
            'status_kependudukan' => 'aktif',
        ]);

        // Warga Kontrak (Pak Dedi)
        $warga4 = Warga::create([
            'keluarga_id' => $kk2->id,
            'nik' => '3201012506910004',
            'nama_lengkap' => 'Dedi Iskandar',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Cianjur',
            'tanggal_lahir' => '1991-06-25',
            'agama' => 'Islam',
            'pekerjaan' => 'Karyawan Swasta',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'no_hp' => '081987654321',
            'status_tinggal' => 'kontrak',
            'status_kependudukan' => 'aktif',
            'tgl_mutasi' => Carbon::now()->subMonths(6),
            'keterangan_mutasi' => 'Pindah datang mengontrak di rumah Ibu Hj. Siti',
        ]);

        // Warga Eko (Punya Anak Baru - Menjawab No 10 perubahan KK)
        $warga5 = Warga::create([
            'keluarga_id' => $kk3->id,
            'nik' => '3201011401920005',
            'nama_lengkap' => 'Eko Prasetyo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '1992-01-14',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'no_hp' => '082133445566',
            'status_tinggal' => 'tetap',
            'status_kependudukan' => 'aktif',
        ]);

        $warga6 = Warga::create([
            'keluarga_id' => $kk3->id,
            'nik' => '3201015010260006',
            'nama_lengkap' => 'Alisha Putri Prasetyo',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => Carbon::now()->subDays(25),
            'agama' => 'Islam',
            'pekerjaan' => 'Belum Bekerja',
            'status_perkawinan' => 'Belum Kawin',
            'status_hubungan_keluarga' => 'Anak',
            'status_tinggal' => 'tetap',
            'status_kependudukan' => 'aktif',
            'tgl_mutasi' => Carbon::now()->subDays(25),
            'keterangan_mutasi' => 'Kelahiran baru, butuh pengantar perubahan data KK ke desa',
        ]);

        // Warga Pindah (Menjawab No 7 & 10)
        $warga7 = Warga::create([
            'keluarga_id' => $kk4->id,
            'nik' => '3201010101800007',
            'nama_lengkap' => 'Wahyu Hidayat',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1980-01-01',
            'agama' => 'Islam',
            'pekerjaan' => 'Buruh Lepas',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'status_tinggal' => 'kontrak',
            'status_kependudukan' => 'pindah',
            'tgl_mutasi' => Carbon::now()->subDays(10),
            'keterangan_mutasi' => 'Pindah domisili ke Kabupaten Karawang',
        ]);

        // 4. Data Surat Pengantar (Pelayanan Surat & Validasi Warga)
        $sampleSignature = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAACgCAYAAAAisjrVAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFhElEQVR4nO3dUW7bOBQFUKfoArKrLCvIsrKr7CDzM5m6HsmWKYl87/EcoB8BipiiFF5dSm0uFwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACANi+jB9DL6+fH9/XXX2/v0xw7wBl+jR4AADlNESC37QOA/aYIkCVCBWCfaQMEgH0ECABNygeIrSqAc5QPkHuEC0C7qQMEgHalA8Q/HgQ4T+kAAeA8AgSAJtMFyO02lgfpAG3KBojnHwDnKhsgAJxLgADQpOS2zpbtK1tcAPtoIAA0ESAANBEgADT5PXoAR/NsYyzzD/OYtoH4B4XHM4cwl2kDhD6ECtRVKkBsn4wjKGA+pQKEMR4Ft3CBmqYOEAsdQLupA4T9bBvCvMoEiIWsv3tzrt1BfWUCpAoLLZCFAAno9fPjO3qQbGl8WgjUViJA9mxfRVnklkIj6oJruxC4XIoESGUZ2ggwJwESwJaAiBIiz7aPKA0POJ4ACejr7f1l7ZdgjVyAbV3FI5AZKX2AHLGoRb1LXjuWKOPbKur8Zjb6ZgIulwIBkt2jAIzSRrSPOLK8bEF9AiSJkW1EeMRw76ZBiDBC6gCZbWGL0kZa2Mbax3wRUeoAya41AHu2kdlCOpq1m4OlmwkhQ28C5F/Zfhh7tJGjwyPbHI+2Nj9CnCgESHJV3tTij2dah1BmpLQBkn1r5cjxn9FGss9vVloHmaQNEP7vqDZyZni4Y172TOtY+ju33+vo8cESAXKlwg9i5je1ZqV1kFXKC/TMO+QeWze9todaFqZRY5txsTw6OMwpvWkghT3bRixA/WgdVCBAJuBNrTj2POt4pMIWLLkIkM5G3eU/aiO9xzXjYqd1UE26ADl7oau+sG2ZLwvasc5sHUvf8/azj/z+cC1dgLDfGQtX6ziuv6642GkdVCZAOor2kHrp80ePqYqerWPpM27HcubnMa9UARJtAa7gekEzn8fQOphFqgDpZcY7uFGLW6W5Htk6lj7z+uvM80pcv0cPYBbaU133Fmfnmco0EIbLeLe89vrzjwgvKmScV3JJ00DcwRPBlkXYtcks0gRIZsIvt6137hHP69fb+8v1+F8/P74jjpOcbGGtUP/7ijbfj7aorkXYroIRUjQQd/D0krltrKnSQq6PIeP4K0oRIJkJv+1GLXTPtB3nr6+1cyNMYhAgTGm20MjWQp45P8JkHAFyR7YfOh6ruEVVxRHPvYRJX+EnePQW0J7PHz32rI6et9naxj3RrsnWc/Ns2Iw+zqo0EEoSGrHtbYLPholmco7wEzn6jkkDGaN17mxRPTbquuwR6ppJX6EbSOYFOPPYs9E24up9bjSTvkJPWJRFuGUcUcae1aP5Exr7nH19RmuCmsk5QjcQ5rX2Bly0hYk/Ioe6ZnKO0BMT5S7+2XFEGXd2La91muvtjrhOI4fGFprJPmEbiEWYrY3DtdFflSaomewTdgKiBcgz44k29sz8ethz7bmu78l+fjSTbaY86BZbf9CExzl+5tV8HsvLCo8Jk3XTHOheAoSqlq7ZKltURxMmfwv7DAQYw3OndZ6Z/K3cAZ1lS7PQPshKaOwzazMpcRC9PLtfXOUioT4vKxxnpjCxhQX8t4h5WWG/mba5Ug12tHsNQ/sA7qnYTDQQgA5am0nkIPk1egCZ7HlHHuDH19v7y8+f0WPZQwM5gO0roNWe37Q4mgABCCJbmAgQgIAy7GSEH+BWGdIaqC/Dwn8UD9EBaCJAAGgiQABoMs1e3ZH8v0EAGkgTQQEgQA4jVIDZCBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtvsHi3ErT/W5y6IAAAAASUVORK5CYII=';

        // Surat 1: Surat Selesai (Bisa di-track warga dengan token BMI2-SURAT-8849)
        SuratPengantar::create([
            'nomor_surat' => '470/014/RT.005-RW.013/X/2026',
            'warga_id' => $warga1->id,
            'jenis_surat' => 'kehilangan_dokumen',
            'keperluan' => 'Surat Pengantar untuk pengurusan kembali KTP Elektronik dan Kartu Keluarga (KK) ke Kantor Kelurahan / Disdukcapil dikarenakan dokumen asli hilang/rusak.',
            'dokumen_hilang' => 'KTP Elektronik & Kartu Keluarga (Asli)',
            'tanggal_surat' => Carbon::now()->subDays(15),
            'berlaku_sampai' => Carbon::now()->addDays(15),
            'tahun_arsip' => 2026,
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'tanda_tangan_jenis' => 'digital',
            'tanda_tangan_digital' => $sampleSignature,
            'qr_token' => 'BMI2-SURAT-8849',
            'status' => 'selesai',
            'lokasi_arsip_fisik' => 'Ordner Pelayanan Warga 2026 / Lemari A-1',
            'catatan' => 'Pengurusan dokumen warga Perumahan Bumi Mutiara Indah II',
        ]);

        // Surat 2: Surat Selesai QR Code (Bisa di-track warga dengan token BMI2-QR-9201)
        SuratPengantar::create([
            'nomor_surat' => '470/015/RT.005-RW.013/XI/2026',
            'warga_id' => $warga5->id,
            'jenis_surat' => 'perubahan_kk',
            'keperluan' => 'Pengantar permohonan pembaruan susunan anggota keluarga pada Kartu Keluarga (KK) dan penerbitan Akta Kelahiran atas kelahiran anak bernama Alisha Putri Prasetyo.',
            'dokumen_hilang' => null,
            'tanggal_surat' => Carbon::now()->subDays(5),
            'berlaku_sampai' => Carbon::now()->addDays(25),
            'tahun_arsip' => 2026,
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'tanda_tangan_jenis' => 'qrcode',
            'qr_token' => 'BMI2-QR-9201',
            'status' => 'selesai',
            'lokasi_arsip_fisik' => 'Ordner Pelayanan Warga 2026 / Lemari A-1',
            'catatan' => 'Lampiran: Surat Keterangan Lahir dari Bidan',
        ]);

        // Surat 3: Permohonan Baru Masuk dari Warga via Portal (Menunggu Validasi Pengurus - Token BMI2-K89X12)
        SuratPengantar::create([
            'nomor_surat' => '470/016/RT.005-RW.013/XI/2026',
            'warga_id' => $warga4->id,
            'jenis_surat' => 'keterangan_domisili',
            'keperluan' => 'Permohonan surat pengantar domisili sementara untuk perpanjangan kontrak kerja dan pembukaan rekening bank perumahan.',
            'dokumen_hilang' => null,
            'tanggal_surat' => Carbon::now(),
            'berlaku_sampai' => Carbon::now()->addDays(30),
            'tahun_arsip' => 2026,
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'tanda_tangan_jenis' => 'digital',
            'qr_token' => 'BMI2-K89X12',
            'status' => 'menunggu_validasi',
            'lokasi_arsip_fisik' => 'Meja Pelayanan Online',
            'catatan' => 'Diajukan mandiri oleh warga melalui Web Portal BMI II',
        ]);

        // Surat 4: Arsip Masa Lalu (Tahun 2024)
        SuratPengantar::create([
            'nomor_surat' => '470/008/RT.005-RW.013/VI/2024',
            'warga_id' => $warga1->id,
            'jenis_surat' => 'keterangan_domisili',
            'keperluan' => 'Surat Keterangan Domisili Tempat Tinggal untuk keperluan pendaftaran sekolah putra pertama.',
            'tanggal_surat' => Carbon::create(2024, 6, 15),
            'berlaku_sampai' => Carbon::create(2024, 7, 15),
            'tahun_arsip' => 2024,
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'tanda_tangan_jenis' => 'manual',
            'qr_token' => 'BMI2-ARSIP-2024',
            'status' => 'selesai',
            'lokasi_arsip_fisik' => 'Bantex Arsip 2024 / Kotak Arsip B',
        ]);

        // 5. Data Surat Masuk (Menjawab No 6 & 8)
        SuratMasuk::create([
            'nomor_agenda' => 'SM-2026-001',
            'nomor_surat_pengirim' => '140/045/Pem-Kel/2026',
            'pengirim' => 'Pemerintah Kelurahan / Desa',
            'perihal' => 'Instruksi Pemutakhiran Data Perkembangan Penduduk dan Warga Kontrak Triwulan IV',
            'ringkasan_isi' => 'Pemerintah Kelurahan meminta seluruh RT melaporkan perkembangan jumlah warga, mutasi lahir/meninggal/pindah, dan mendata warga penyewa/kontrakan.',
            'tanggal_surat' => Carbon::now()->subDays(20),
            'tanggal_terima' => Carbon::now()->subDays(18),
            'tahun_arsip' => 2026,
            'lokasi_arsip_fisik' => 'Ordner Surat Masuk 2026 / Sekat 1',
            'disposisi' => 'Diteruskan ke Sekretaris untuk rekapitulasi data penduduk',
            'file_lampiran' => 'surat_masuk/surat_edaran_desa.png',
        ]);

        SuratMasuk::create([
            'nomor_agenda' => 'SM-2026-002',
            'nomor_surat_pengirim' => '012/RW.013/X/2026',
            'pengirim' => 'Pengurus RW 013',
            'perihal' => 'Peningkatan Jadwal Ronda Siskamling dan Kesiapsiagaan Musim Hujan',
            'ringkasan_isi' => 'Himbauan kepada Ketua RT 005 dan Seksi Keamanan untuk mengaktifkan ronda malam dan membersihkan saluran drainase pencegah banjir di lingkungan Bumi Mutiara Indah II.',
            'tanggal_surat' => Carbon::now()->subDays(14),
            'tanggal_terima' => Carbon::now()->subDays(12),
            'tahun_arsip' => 2026,
            'lokasi_arsip_fisik' => 'Ordner Surat Masuk RW 2026 / Sekat 2',
            'disposisi' => 'Diteruskan ke Seksi Keamanan & Seksi Humas untuk warga',
        ]);

        // 6. Data Iuran Warga (Menjawab No 2 - Seksi Humas: Posyandu, RW, Kematian, Kebersihan)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        IuranWarga::create([
            'keluarga_id' => $kk1->id,
            'bulan' => $currentMonth,
            'tahun' => $currentYear,
            'nominal_posyandu' => 5000,
            'nominal_rw' => 10000,
            'nominal_kematian' => 10000,
            'nominal_sampah' => 15000,
            'total_iuran' => 40000,
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::now()->subDays(3),
            'metode_pembayaran' => 'tunai',
            'petugas_penarik' => 'Rudi Kurniawan (Humas)',
            'catatan' => 'Lunas tepat waktu',
        ]);

        IuranWarga::create([
            'keluarga_id' => $kk2->id,
            'bulan' => $currentMonth,
            'tahun' => $currentYear,
            'nominal_posyandu' => 5000,
            'nominal_rw' => 10000,
            'nominal_kematian' => 10000,
            'nominal_sampah' => 15000,
            'total_iuran' => 40000,
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::now()->subDays(2),
            'metode_pembayaran' => 'transfer',
            'petugas_penarik' => 'Rudi Kurniawan (Humas)',
            'catatan' => 'Transfer via BCA',
        ]);

        IuranWarga::create([
            'keluarga_id' => $kk3->id,
            'bulan' => $currentMonth,
            'tahun' => $currentYear,
            'nominal_posyandu' => 5000,
            'nominal_rw' => 10000,
            'nominal_kematian' => 10000,
            'nominal_sampah' => 15000,
            'total_iuran' => 40000,
            'status' => 'belum_lunas',
            'catatan' => 'Akan ditarik saat kunjungan pos ronda berikutnya',
        ]);

        // 7. Data Kas RT (Menjawab No 2 - Seksi Bendahara: Kas RT, kas dll)
        KasRt::create([
            'tanggal' => Carbon::now()->subDays(25),
            'jenis' => 'pemasukan',
            'kategori' => 'saldo_awal',
            'nominal' => 2500000,
            'keterangan' => 'Saldo awal kas kas RT bulan ini',
            'nomor_bukti' => 'BKM-001',
            'dicatat_oleh' => 'Ibu Hj. Siti Nurjanah',
        ]);

        KasRt::create([
            'tanggal' => Carbon::now()->subDays(15),
            'jenis' => 'pemasukan',
            'kategori' => 'iuran_warga',
            'nominal' => 800000,
            'keterangan' => 'Penyetoran rekapitulasi iuran warga dari Seksi Humas (20 KK)',
            'nomor_bukti' => 'BKM-002',
            'dicatat_oleh' => 'Ibu Hj. Siti Nurjanah',
        ]);

        KasRt::create([
            'tanggal' => Carbon::now()->subDays(10),
            'jenis' => 'pengeluaran',
            'kategori' => 'keamanan_ronda',
            'nominal' => 200000,
            'keterangan' => 'Pembelian perlengkapan pos ronda (lampu emergency, kopi ronda, senter)',
            'nomor_bukti' => 'BKK-001',
            'dicatat_oleh' => 'Ibu Hj. Siti Nurjanah',
        ]);

        KasRt::create([
            'tanggal' => Carbon::now()->subDays(5),
            'jenis' => 'pengeluaran',
            'kategori' => 'posyandu',
            'nominal' => 150000,
            'keterangan' => 'Bantuan konsumsi dan vitamin PMT Balita Posyandu Melati',
            'nomor_bukti' => 'BKK-002',
            'dicatat_oleh' => 'Ibu Hj. Siti Nurjanah',
        ]);

        // 8. Laporan Keamanan & Ronda (Menjawab No 2 - Seksi Keamanan)
        LaporanKeamanan::create([
            'tanggal' => Carbon::now()->subDays(1),
            'kategori' => 'ronda_malam',
            'judul' => 'Kegiatan Siskamling Regu A Malam Minggu',
            'lokasi' => 'Pos Keamanan Gerbang Utama Perumahan Bumi Mutiara Indah II',
            'petugas_ronda' => 'Agus Santoso, Bambang Sudibyo, Dedi Iskandar',
            'keterangan' => 'Patroli lingkungan Blok A sampai Blok C pukul 23:00, 01:30, dan 04:00. Pintu portal ditutup pukul 23:00. Kondisi aman dan terkendali.',
            'status' => 'kondusif',
            'tindakan' => 'Pemeriksaan rutin keliling perumahan setiap 2 jam',
            'pelapor' => 'Agus Santoso',
        ]);

        LaporanKeamanan::create([
            'tanggal' => Carbon::now()->subDays(8),
            'kategori' => 'banjir_musibah',
            'judul' => 'Pembersihan Saluran Drainase Blok B Mencegah Genangan',
            'lokasi' => 'Perumahan Bumi Mutiara Indah II Blok B2 RT 005',
            'petugas_ronda' => 'Regu Keamanan & Warga Gotong Royong',
            'keterangan' => 'Kerja bakti pembersihan daun dan endapan pasir di saluran drainase utama menjelang musim hujan.',
            'status' => 'selesai',
            'tindakan' => 'Saluran drainase air berfungsi normal dan lancar',
            'pelapor' => 'Agus Santoso',
        ]);
    }
}
