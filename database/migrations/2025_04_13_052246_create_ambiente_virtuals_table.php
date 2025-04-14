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
        Schema::create('ambiente_virtuals', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->longText('descricao');
            $table->string('imagem_capa')->nullable();
            $table->string('yt_url');
            $table->longText('notas')->nullable();
            $table->longText('comentarios')->nullable();
            // $table->unsignedBigInteger('aluno_id');
            $table->unsignedBigInteger('professor_id');
            // $table->unsignedBigInteger('disciplina_id');

            // $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade');
            // $table->foreign('disciplina_id')->references('id')->on('disciplinas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambiente_virtuals');
    }
};
