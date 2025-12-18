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
        Schema::table('eads', function (Blueprint $table) {
            $table->string('descricao')->nullable();
            $table->string('link')->nullable();
            $table->string('material_apoio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eads', function (Blueprint $table) {
            $table->dropColumn('descricao');
            $table->dropColumn('link');
            $table->dropColumn('material_apoio');
        });
    }
};
