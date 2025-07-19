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
        Schema::create('alunos_ambiente_virtuals_watched', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('aluno_id');
            $table->unsignedBigInteger('ambiente_virtual_id');

            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->foreign('ambiente_virtual_id')->references('id')->on('ambiente_virtuals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos_ambiente_virtuals_watched');
    }
};
