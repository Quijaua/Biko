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
        Schema::table('ambiente_virtuals', function (Blueprint $table) {
            $table->longText('descricao')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ambiente_virtuals', function (Blueprint $table) {
            $table->longText('descricao')->nullable(false)->change();
        });
    }
};
