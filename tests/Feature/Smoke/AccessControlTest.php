<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Regras dos middlewares restrict.aluno, restrict.professor e permissions.
 */
class AccessControlTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    // ---- restrict.aluno / restrict.professor (dashboard) ----

    public function test_admin_can_open_dashboard(): void
    {
        $this->actingAs($this->createAdmin())->get('/dashboard')->assertOk();
    }

    public function test_aluno_cannot_open_dashboard(): void
    {
        $this->actingAs($this->createAluno())->get('/dashboard')->assertForbidden();
    }

    public function test_inactive_professor_is_sent_back_to_home(): void
    {
        $this->actingAs($this->createProfessor(status: 0))
            ->get('/dashboard')
            ->assertRedirect(route('home'));
    }

    public function test_active_professor_can_open_dashboard(): void
    {
        $this->actingAs($this->createProfessor(status: 1))->get('/dashboard')->assertOk();
    }

    public function test_dashboard_signup_chart_returns_daily_counts(): void
    {
        $admin = $this->createAdmin();
        $this->createAluno();

        $this->actingAs($admin)
            ->getJson('/dashboard/cadastros-json/30')
            ->assertOk()
            ->assertJsonStructure([['count', 'date']])
            ->assertJsonFragment(['date' => now()->format('Y-m-d')]);

        $this->actingAs($admin)
            ->getJson('/dashboard/cadastros-json/all')
            ->assertOk()
            ->assertJsonStructure([['count', 'date']]);
    }

    // ---- permissions: aluno ----

    public function test_aluno_can_open_own_details(): void
    {
        $aluno = $this->createAluno();

        $this->actingAs($aluno)
            ->get('/alunos/details/'.$aluno->aluno->id)
            ->assertOk();
    }

    public function test_aluno_cannot_open_other_aluno_details(): void
    {
        $nucleo = $this->createNucleo();
        $aluno = $this->createAluno($nucleo);
        $outro = $this->createAluno($nucleo);

        $this->actingAs($aluno)
            ->from('/home')
            ->get('/alunos/details/'.$outro->aluno->id)
            ->assertRedirect('/home');
    }

    public function test_aluno_cannot_manage_nucleos(): void
    {
        $this->actingAs($this->createAluno())
            ->from('/home')
            ->get('/nucleos')
            ->assertRedirect('/home');
    }

    // ---- permissions: professor ----

    public function test_active_professor_can_list_coordenadores(): void
    {
        $this->actingAs($this->createProfessor())->get('/coordenadores')->assertOk();
    }

    public function test_professor_cannot_edit_nucleo(): void
    {
        $nucleo = $this->createNucleo();

        $this->actingAs($this->createProfessor($nucleo))
            ->from('/home')
            ->get('/nucleos/edit/'.$nucleo->id)
            ->assertRedirect('/home');
    }

    // ---- permissions: coordenador ----

    public function test_coordenador_can_list_professores(): void
    {
        $this->actingAs($this->createCoordenador())->get('/professores')->assertOk();
    }

    public function test_coordenador_cannot_open_psicologos(): void
    {
        $coordenador = $this->createCoordenador();

        // psicologos/* só é liberado para administrador e psicóloga supervisora
        $this->actingAs($coordenador)
            ->from('/home')
            ->get('/psicologos')
            ->assertRedirect('/home');
    }
}
