<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * O pré-cadastro público gravava "preta" enquanto os demais formulários
 * gravam "negra", o que dividia a mesma categoria em duas no dashboard.
 * Esta migration unifica os registros existentes em "negra".
 */
return new class extends Migration
{
    private array $tabelas = ['alunos', 'professores', 'coordenadores'];

    public function up(): void
    {
        foreach ($this->tabelas as $tabela) {
            DB::table($tabela)
                ->whereRaw("lower(trim(Raca)) = 'preta'")
                ->update(['Raca' => 'negra']);
        }
    }

    public function down(): void
    {
        // Sem volta: depois da unificação não há como saber quais
        // registros eram "preta". Use o dump feito antes do deploy.
    }
};
