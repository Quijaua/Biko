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
        Schema::table('plantao_psicologicos', function (Blueprint $table) {
            $table->dropForeign('plantao_psicologicos_psicologo_id_foreign');
            $table->dropForeign('plantao_psicologicos_estudante_id_foreign');

            $table->foreign('psicologo_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('estudante_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantao_psicologicos', function (Blueprint $table) {
            //
        });
    }
};
