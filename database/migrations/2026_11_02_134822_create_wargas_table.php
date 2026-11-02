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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->nullable()->constrained('keluargas')->nullOnDelete();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama')->default('Islam');
            $table->string('pekerjaan')->default('Wiraswasta');
            $table->string('status_perkawinan')->default('Kawin');
            $table->string('status_hubungan_keluarga')->default('Kepala Keluarga');
            $table->string('no_hp')->nullable();
            $table->string('status_tinggal')->default('tetap'); // tetap, kontrak, kost
            $table->string('status_kependudukan')->default('aktif'); // aktif, pindah, meninggal
            $table->date('tgl_mutasi')->nullable();
            $table->text('keterangan_mutasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
