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
        Schema::table('alunos_ambiente_virtuals_watched', function (Blueprint $table) {
            $table->dropForeign('alunos_ambiente_virtuals_watched_aluno_id_foreign');

            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos_ambiente_virtuals_watched', function (Blueprint $table) {
            //
        });
    }
};
