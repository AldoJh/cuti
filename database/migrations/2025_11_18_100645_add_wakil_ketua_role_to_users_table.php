<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah role baru wakil_ketua ke enum
        DB::statement("ALTER TABLE users MODIFY role ENUM(
            'admin',
            'ketua',
            'wakil_ketua',
            'hakim',
            'panitera',
            'panmud',
            'panitera_pengganti',
            'sekretaris',
            'kasubbag',
            'ppnpn',
            'bakti'
        ) DEFAULT 'ppnpn'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback enum tanpa wakil_ketua
        DB::statement("ALTER TABLE users MODIFY role ENUM(
            'admin',
            'ketua',
            'hakim',
            'panitera',
            'panmud',
            'panitera_pengganti',
            'sekretaris',
            'kasubbag',
            'ppnpn',
            'bakti'
        ) DEFAULT 'ppnpn'");
    }
};
