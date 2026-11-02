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
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->string('tanda_tangan_jenis')->default('manual')->after('penandatangan_jabatan'); // manual, digital, qrcode
            $table->longText('tanda_tangan_digital')->nullable()->after('tanda_tangan_jenis');
            $table->string('qr_token')->nullable()->after('tanda_tangan_digital');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_pengantars', function (Blueprint $table) {
            $table->dropColumn(['tanda_tangan_jenis', 'tanda_tangan_digital', 'qr_token']);
        });
    }
};
