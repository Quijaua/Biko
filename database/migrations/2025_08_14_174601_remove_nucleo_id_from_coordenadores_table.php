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
        Schema::table('coordenadores', function (Blueprint $table) {
            if (Schema::hasColumn('coordenadores', 'nucleo_id')) {
                $table->dropColumn('nucleo_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coordenadores', function (Blueprint $table) {
            if (!Schema::hasColumn('coordenadores', 'nucleo_id')) {
                $table->unsignedBigInteger('nucleo_id')->nullable();
            }
        });
    }
};
