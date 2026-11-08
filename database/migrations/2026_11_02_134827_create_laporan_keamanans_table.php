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
        Schema::create('laporan_keamanans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kategori'); // ronda_malam, kondusifitas, tamu_menginap, banjir_musibah, gangguan, lainnya
            $table->string('judul');
            $table->string('lokasi')->default('Perumahan Bumi Mutiara Indah II RT 005 / RW 013');
            $table->text('petugas_ronda')->nullable();
            $table->text('keterangan');
            $table->string('status')->default('kondusif'); // kondusif, perlu_tindakan, proses, selesai
            $table->text('tindakan')->nullable();
            $table->string('pelapor')->default('Seksi Keamanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keamanans');
    }
};
