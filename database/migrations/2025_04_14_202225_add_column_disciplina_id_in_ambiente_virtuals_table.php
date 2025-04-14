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
            $table->unsignedBigInteger('disciplina_id')->nullable();
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ambiente_virtuals', function (Blueprint $table) {
            $table->dropForeign(['disciplina_id']);
            $table->dropColumn('disciplina_id');
        });
    }
};
