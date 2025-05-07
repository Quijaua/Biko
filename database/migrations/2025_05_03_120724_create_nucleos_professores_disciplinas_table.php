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
        Schema::create('nucleos_professores_disciplinas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('nucleo_id');
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('disciplina_id');

            $table->foreign('nucleo_id')->references('id')->on('nucleos');
            $table->foreign('professor_id')->references('id')->on('professores');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');

            $table->string('horario_inicial')->nullable();
            $table->string('horario_final')->nullable();
            $table->string('dia_semana')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nucleos_professores_disciplinas');
    }
};
