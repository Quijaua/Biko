<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Marca alunos, professores e coordenadores que foram inativados
 * automaticamente porque o Núcleo deles foi desativado.
 *
 * Serve para três coisas:
 * - mostrar o aviso e a opção de transferência só para essas pessoas;
 * - reativar só elas se o Núcleo voltar a ficar ativo;
 * - não confundir com quem foi inativado manualmente por outro motivo.
 */
return new class extends Migration
{
    private const TABELAS = ['alunos', 'professores', 'coordenadores'];

    public function up(): void
    {
        foreach (self::TABELAS as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->foreignId('inativado_por_nucleo_id')
                    ->nullable()
                    ->constrained('nucleos')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (self::TABELAS as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->dropConstrainedForeignId('inativado_por_nucleo_id');
            });
        }
    }
};
