<?php

namespace Tests\Feature;

use App\Models\SuratMasuk;
use App\Models\SuratPengantar;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RtApplicationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('RT 005 / RW 013');
        $response->assertSee('Perumahan Bumi Mutiara Indah II');
    }

    public function test_quick_login_works_for_ketua_rt(): void
    {
        $response = $this->get('/quick-login/ketua_rt');

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_dashboard_renders_metrics(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('RT 005 / RW 013');
        $response->assertSee('Perumahan Bumi Mutiara Indah II');
        $response->assertSee('Pelayanan Surat Pengantar');
        $response->assertSee('Buku Induk Kependudukan');
    }

    public function test_warga_index_can_be_filtered(): void
    {
        $user = User::where('role', 'sekretaris')->first();

        $response = $this->actingAs($user)->get('/kependudukan/warga?status_tinggal=kontrak');

        $response->assertStatus(200);
        $response->assertSee('Dedi Iskandar');
    }

    public function test_warga_kontrak_monitoring_page_works(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        $response = $this->actingAs($user)->get('/kependudukan/warga/kontrak');

        $response->assertStatus(200);
        $response->assertSee('Warga Kontrak');
        $response->assertSee('Pemilik Rumah');
    }

    public function test_laporan_desa_page_works_and_contains_statistics(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        $response = $this->actingAs($user)->get('/kependudukan/laporan-desa');

        $response->assertStatus(200);
        $response->assertSee('LAPORAN PERKEMBANGAN PENDUDUK');
        $response->assertSee('Perumahan Bumi Mutiara Indah II');
    }

    public function test_surat_pengantar_can_be_created_and_printed(): void
    {
        $user = User::where('role', 'sekretaris')->first();
        $warga = Warga::aktif()->first();

        $postData = [
            'nomor_surat' => '999/RT.005/RW.013/XI/2026',
            'warga_id' => $warga->id,
            'jenis_surat' => 'kehilangan_dokumen',
            'keperluan' => 'Pengantar pengurusan KTP dan KK hilang akibat banjir bandang di RT 005',
            'dokumen_hilang' => 'KTP dan Kartu Keluarga',
            'tanggal_surat' => '2026-11-02',
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'lokasi_arsip_fisik' => 'Ordner 2026',
        ];

        $response = $this->actingAs($user)->post('/surat-pengantar', $postData);

        $response->assertRedirect();

        $this->assertDatabaseHas('surat_pengantars', [
            'nomor_surat' => '999/RT.005/RW.013/XI/2026',
            'warga_id' => $warga->id,
        ]);

        $surat = SuratPengantar::where('nomor_surat', '999/RT.005/RW.013/XI/2026')->first();

        $printResponse = $this->actingAs($user)->get('/surat-pengantar/'.$surat->id.'/print');
        $printResponse->assertStatus(200);
        $printResponse->assertSee('SURAT PENGANTAR');
        $printResponse->assertSee($warga->nama_lengkap);
    }

    public function test_surat_pengantar_index_renders_in_page_viewer_and_archive_search(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        $response = $this->actingAs($user)->get('/surat-pengantar');

        $response->assertStatus(200);
        $response->assertSee('Pelayanan Surat Pengantar Warga');
        $response->assertSee('Buku Register Surat');
    }

    public function test_surat_masuk_can_be_viewed_and_printed_as_lembar_disposisi(): void
    {
        $user = User::where('role', 'sekretaris')->first();
        $suratMasuk = SuratMasuk::first();

        // Index page with in-page viewer
        $indexResponse = $this->actingAs($user)->get('/surat-masuk');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Buku Agenda Arsip Surat Masuk');
        $indexResponse->assertSee('LIHAT BERKAS');
        $indexResponse->assertSee('Pratinjau Berkas Surat Masuk');

        // Show page
        $showResponse = $this->actingAs($user)->get('/surat-masuk/'.$suratMasuk->id);
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Lembar Disposisi');
        $showResponse->assertSee($suratMasuk->nomor_agenda);

        // Print disposisi
        $printResponse = $this->actingAs($user)->get('/surat-masuk/'.$suratMasuk->id.'/print');
        $printResponse->assertStatus(200);
        $printResponse->assertSee('LEMBAR DISPOSISI SURAT MASUK');
        $printResponse->assertSee($suratMasuk->nomor_agenda);
    }

    public function test_arsip_semua_surat_page_works_and_shows_all_letters(): void
    {
        $user = User::where('role', 'ketua_rt')->first();

        $response = $this->actingAs($user)->get('/arsip-surat');

        $response->assertStatus(200);
        $response->assertSee('Buku Induk Arsip Semua Surat RT');
        $response->assertSee('LIHAT ISI SURAT');
        $response->assertSee('Semua Surat (Gabungan)');
    }

    public function test_surat_pengantar_can_be_created_with_uploaded_signature_photo(): void
    {
        $user = User::where('role', 'sekretaris')->first();
        $warga = Warga::aktif()->first();

        $file = UploadedFile::fake()->image('ttd_pak_rt.png', 200, 100);

        $postData = [
            'nomor_surat' => '888/RT.03/RW.02/XI/2026',
            'warga_id' => $warga->id,
            'jenis_surat' => 'ktp_baru',
            'keperluan' => 'Pengantar rekam e-KTP baru ke kantor desa',
            'tanggal_surat' => '2026-11-02',
            'penandatangan_nama' => 'Hartono',
            'penandatangan_jabatan' => 'Ketua RT 03',
            'tanda_tangan_jenis' => 'foto',
            'tanda_tangan_file' => $file,
        ];

        $response = $this->actingAs($user)->post('/surat-pengantar', $postData);
        $response->assertRedirect();

        $surat = SuratPengantar::where('nomor_surat', '888/RT.03/RW.02/XI/2026')->first();
        $this->assertNotNull($surat);
        $this->assertEquals('foto', $surat->tanda_tangan_jenis);
        $this->assertStringContainsString('signatures/', $surat->tanda_tangan_digital);
    }

    public function test_keuangan_iuran_and_kas_works(): void
    {
        $humas = User::where('role', 'humas')->first();
        $bendahara = User::where('role', 'bendahara')->first();

        // Cek halaman iuran
        $responseIuran = $this->actingAs($humas)->get('/keuangan/iuran');
        $responseIuran->assertStatus(200);
        $responseIuran->assertSee('Penarikan Iuran Warga');

        // Cek halaman kas
        $responseKas = $this->actingAs($bendahara)->get('/keuangan/kas');
        $responseKas->assertStatus(200);
        $responseKas->assertSee('Buku Kas Keuangan RT');

        // Tambah transaksi kas
        $postKas = [
            'tanggal' => '2026-11-02',
            'jenis' => 'pemasukan',
            'kategori' => 'donasi',
            'nominal' => 500000,
            'keterangan' => 'Donasi warga untuk kegiatan RT',
        ];

        $responsePostKas = $this->actingAs($bendahara)->post('/keuangan/kas', $postKas);
        $responsePostKas->assertRedirect();

        $this->assertDatabaseHas('kas_rts', [
            'nominal' => 500000,
            'keterangan' => 'Donasi warga untuk kegiatan RT',
        ]);
    }

    public function test_portal_warga_is_accessible_publicly(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Portal Pelayanan Mandiri Warga');
        $response->assertSee('RT 005 / RW 013');
        $response->assertSee('Perumahan Bumi Mutiara Indah II');
    }

    public function test_portal_warga_can_track_letter_with_code(): void
    {
        $surat = SuratPengantar::where('status', 'selesai')->first();

        $response = $this->get('/?kode='.$surat->qr_token);

        $response->assertStatus(200);
        $response->assertSee($surat->qr_token);
        $response->assertSee('Hasil Pelacakan Surat Warga');
        $response->assertSee('Surat Sah');
    }

    public function test_portal_warga_can_view_digital_letter(): void
    {
        $surat = SuratPengantar::where('status', 'selesai')->first();

        $response = $this->get('/surat-digital/'.$surat->qr_token);

        $response->assertStatus(200);
        $response->assertSee('SURAT PENGANTAR');
        $response->assertSee('Dokumen Terverifikasi');
        $response->assertSee($surat->warga->nama_lengkap);
        $response->assertSee($surat->qr_token);
    }

    public function test_citizen_can_apply_for_surat_pengantar_online(): void
    {
        $warga = Warga::first();

        $postData = [
            'warga_id' => $warga->id,
            'jenis_surat' => 'keterangan_domisili',
            'keperluan' => 'Pengurusan rekening tabungan bank syariah warga',
            'no_whatsapp' => '081234567890',
        ];

        $response = $this->post('/ajukan-surat', $postData);

        $response->assertRedirect();
        $response->assertSessionHas('success_token');

        $this->assertDatabaseHas('surat_pengantars', [
            'warga_id' => $warga->id,
            'status' => 'menunggu_validasi',
            'keperluan' => 'Pengurusan rekening tabungan bank syariah warga',
        ]);
    }

    public function test_citizen_can_apply_with_direct_name_and_nik_without_selecting(): void
    {
        $postData = [
            'nama_lengkap' => 'Warga Baru Mandiri',
            'nik' => '3201998877660001',
            'jenis_surat' => 'ktp_baru',
            'keperluan' => 'Perekaman KTP elektronik mandiri',
            'no_whatsapp' => '089988776655',
        ];

        $response = $this->post('/ajukan-surat', $postData);

        $response->assertRedirect();
        $response->assertSessionHas('success_token');

        $this->assertDatabaseHas('wargas', [
            'nama_lengkap' => 'Warga Baru Mandiri',
            'nik' => '3201998877660001',
        ]);

        $this->assertDatabaseHas('surat_pengantars', [
            'status' => 'menunggu_validasi',
            'keperluan' => 'Perekaman KTP elektronik mandiri',
        ]);
    }

    public function test_pengurus_can_validate_citizen_application(): void
    {
        $ketua = User::where('role', 'ketua_rt')->first();
        $suratPending = SuratPengantar::where('status', 'menunggu_validasi')->first();

        $response = $this->actingAs($ketua)->post('/surat-pengantar/'.$suratPending->id.'/validasi');

        $response->assertRedirect();

        $this->assertDatabaseHas('surat_pengantars', [
            'id' => $suratPending->id,
            'status' => 'selesai',
        ]);
    }
}
