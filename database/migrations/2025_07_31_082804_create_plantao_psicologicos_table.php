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
        Schema::create('plantao_psicologicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('psicologo_id')->constrained('users');
            $table->date('data');
            $table->time('horario');
            $table->foreignId('estudante_id')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['psicologo_id', 'data', 'horario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantao_psicologicos');
    }
};
