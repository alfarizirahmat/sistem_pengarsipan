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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat_pengirim');
            $table->string('pengirim'); // Kantor Desa, RW 02, Polsek, Puskesmas, dll
            $table->string('perihal');
            $table->text('ringkasan_isi')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('file_lampiran')->nullable();
            $table->unsignedSmallInteger('tahun_arsip')->index();
            $table->string('lokasi_arsip_fisik')->nullable(); // Ordner / map fisik 10 tahun
            $table->string('disposisi')->nullable(); // Tindak lanjut ke Seksi Humas / Keamanan / Warga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
