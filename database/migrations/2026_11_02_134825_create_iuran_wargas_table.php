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
        Schema::create('iuran_wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluargas')->cascadeOnDelete();
            $table->unsignedTinyInteger('bulan'); // 1 - 12
            $table->unsignedSmallInteger('tahun');
            $table->decimal('nominal_posyandu', 12, 2)->default(5000);
            $table->decimal('nominal_rw', 12, 2)->default(10000);
            $table->decimal('nominal_kematian', 12, 2)->default(10000);
            $table->decimal('nominal_sampah', 12, 2)->default(15000);
            $table->decimal('total_iuran', 12, 2)->default(40000);
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->string('metode_pembayaran')->default('tunai'); // tunai, transfer
            $table->string('petugas_penarik')->nullable(); // Seksi Humas / Bendahara
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['keluarga_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_wargas');
    }
};
