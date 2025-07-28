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
        Schema::create('logs_atendimento_psicologico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atendimento_psicologico_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('acao', ['criou', 'acessou', 'editou', 'abriu_anexo']);
            $table->text('detalhes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_atendimento_psicologico');
    }
};
