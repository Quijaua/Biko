<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitacoes_transferencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('perfil', 20); // aluno, professor ou coordenador
            $table->foreignId('nucleo_origem_id')->nullable()->constrained('nucleos')->nullOnDelete();
            $table->foreignId('nucleo_destino_id')->constrained('nucleos')->cascadeOnDelete();
            $table->text('mensagem')->nullable();
            $table->string('status', 20)->default('pendente'); // pendente, aprovada, recusada, cancelada
            $table->foreignId('respondido_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('respondido_em')->nullable();
            $table->timestamps();

            $table->index(['status', 'nucleo_destino_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_transferencia');
    }
};
