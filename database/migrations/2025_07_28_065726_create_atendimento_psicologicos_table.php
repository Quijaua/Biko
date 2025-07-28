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
        Schema::create('atendimento_psicologicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudante_id');
            $table->text('demanda_objetivos');
            $table->text('registro_atendimento');
            $table->enum('tipo_encaminhamento', ['SUS', 'CRAS', 'CREAS', 'Atendimento finalizado']);
            $table->text('descricao_encaminhamento')->nullable();
            $table->string('anexo')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimento_psicologicos');
    }
};
