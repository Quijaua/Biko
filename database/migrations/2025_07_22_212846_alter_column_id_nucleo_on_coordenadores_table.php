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
        if (Schema::hasTable('coordenadores') && Schema::hasColumn('coordenadores', 'id_nucleo')) {
            Schema::table('coordenadores', function (Blueprint $table) {
                $table->unsignedBigInteger('id_nucleo')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('coordenadores') && Schema::hasColumn('coordenadores', 'id_nucleo')) {
            Schema::table('coordenadores', function (Blueprint $table) {
                $table->unsignedBigInteger('id_nucleo')->nullable(false)->change();
            });
        }
    }
};
