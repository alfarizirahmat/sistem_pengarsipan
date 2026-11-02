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
        Schema::create('kas_rts', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->string('kategori'); // iuran_warga, bantuan_desa, donasi, posyandu, santunan_kematian, operasional_rt, keamanan_ronda, perbaikan_lingkungan, lainnya
            $table->decimal('nominal', 12, 2);
            $table->text('keterangan');
            $table->string('nomor_bukti')->nullable();
            $table->string('file_bukti')->nullable();
            $table->string('dicatat_oleh')->default('Bendahara RT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_rts');
    }
};
