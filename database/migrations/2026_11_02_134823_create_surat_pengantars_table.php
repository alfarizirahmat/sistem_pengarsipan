<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengantars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->foreignId('warga_id')->constrained('wargas')->cascadeOnDelete();
            $table->string('jenis_surat'); // kehilangan_dokumen, ktp_baru, perubahan_kk, pindah_domisili, warga_datang, kematian, keterangan_domisili, sktm, sku, lainnya
            $table->text('keperluan');
            $table->string('dokumen_hilang')->nullable(); // jika kehilangan akibat banjir / musibah
            $table->date('tanggal_surat');
            $table->date('berlaku_sampai')->nullable();
            $table->unsignedSmallInteger('tahun_arsip')->index(); // mendukung pengarsipan 10+ tahun
            $table->string('penandatangan_nama');
            $table->string('penandatangan_jabatan')->default('Ketua RT 005');
            $table->string('status')->default('selesai');
            $table->string('lokasi_arsip_fisik')->nullable(); // sinkron dengan arsip fisik manual
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantars');
    }
};
