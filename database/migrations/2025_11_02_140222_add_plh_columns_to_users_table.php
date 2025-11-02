<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_plh_panitera')->default(0)->after('is_ketua_pengganti');
            $table->tinyInteger('is_plh_sekretaris')->default(0)->after('is_plh_panitera');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_plh_panitera', 'is_plh_sekretaris']);
        });
    }
};

