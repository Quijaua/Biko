<?php

namespace Tests\Feature;

use App\Support\Raca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * "preta" e "negra" são a mesma categoria: o sistema grava "negra"
 * e exibe "Negra".
 */
class RacaNegraTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_normalizar_converte_preta_em_negra(): void
    {
        $this->assertSame('negra', Raca::normalizar('preta'));
        $this->assertSame('negra', Raca::normalizar(' Preta '));
        $this->assertSame('negra', Raca::normalizar('Negra'));
        $this->assertSame('indigena', Raca::normalizar('Indígena'));
        $this->assertSame('branca', Raca::normalizar('Branca'));
        $this->assertNull(Raca::normalizar(null));
    }

    public function test_pre_cadastro_grava_negra_e_exibe_negra(): void
    {
        $html = $this->get('/pre-cadastro')->assertOk()->getContent();

        $this->assertStringContainsString('<option value="negra">Negra</option>', $html);
        $this->assertStringNotContainsString('value="preta"', $html);
    }

    public function test_migration_unifica_preta_em_negra(): void
    {
        $aluno = $this->createAluno();
        DB::table('alunos')->where('id_user', $aluno->id)->update(['Raca' => 'Preta']);

        $migration = require database_path('migrations/2026_11_25_000001_unifica_raca_preta_em_negra.php');
        $migration->up();

        $this->assertSame('negra', DB::table('alunos')->where('id_user', $aluno->id)->value('Raca'));
    }

    public function test_dashboard_mostra_uma_unica_fatia_negra(): void
    {
        $a = $this->createAluno();
        $b = $this->createAluno();
        DB::table('alunos')->where('id_user', $a->id)->update(['Raca' => 'preta']);
        DB::table('alunos')->where('id_user', $b->id)->update(['Raca' => 'negra']);

        $html = $this->actingAs($this->createAdmin())->get('/dashboard')->assertOk()->getContent();

        $this->assertStringNotContainsString('"preta"', $html);
        $this->assertSame(1, substr_count($html, '"negra"'));
    }
}
