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
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk', 16)->unique();
            $table->string('kepala_keluarga');
            $table->text('alamat');
            $table->string('rt', 5)->default('03');
            $table->string('rw', 5)->default('02');
            $table->string('status_tempat_tinggal')->default('tetap'); // tetap, kontrak, kost
            $table->string('nama_pemilik_kontrakan')->nullable(); // info pemilik rumah jika sewa
            $table->string('kontak_pemilik_kontrakan')->nullable();
            $table->date('tgl_mulai_tinggal')->nullable();
            $table->date('tgl_selesai_kontrak')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluargas');
    }
};
