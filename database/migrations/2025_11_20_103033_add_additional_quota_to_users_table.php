<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('sisa_cuti_alasan_penting')->default(30);
            $table->integer('sisa_cuti_besar')->default(90);
            $table->integer('sisa_cuti_melahirkan')->default(90);
            $table->integer('sisa_cuti_cltn')->default(36);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'sisa_cuti_alasan_penting',
                'sisa_cuti_besar',
                'sisa_cuti_melahirkan',
                'sisa_cuti_cltn',
            ]);
        });
    }
};
