<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Abre as telas principais como administrador para garantir que
 * controllers, queries e views Blade continuam renderizando.
 */
class AdminPagesTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public static function adminPages(): array
    {
        return [
            'núcleos' => ['/nucleos'],
            'novo núcleo' => ['/nucleos/add'],
            'alunos' => ['/alunos'],
            'novo aluno' => ['/alunos/add'],
            'professores' => ['/professores'],
            'novo professor' => ['/professores/add'],
            'coordenadores' => ['/coordenadores'],
            'novo coordenador' => ['/coordenadores/add'],
            'psicólogos' => ['/psicologos'],
            'mensagens' => ['/mensagens'],
            'nova mensagem' => ['/mensagens/create'],
            'material' => ['/nucleo/material'],
            'disciplinas' => ['/disciplinas'],
            'ambiente virtual' => ['/ambiente-virtual'],
            'EAD' => ['/ead'],
            'atendimento psicológico' => ['/atendimento-psicologico'],
            'auditoria' => ['/auditoria'],
            'administradores' => ['/administradores'],
        ];
    }

    #[DataProvider('adminPages')]
    public function test_admin_page_renders(string $uri): void
    {
        $nucleo = $this->createNucleo();
        $this->createAluno($nucleo);
        $this->createProfessor($nucleo);
        $this->createCoordenador($nucleo);

        $this->actingAs($this->createAdmin())
            ->get($uri)
            ->assertOk();
    }

    public function test_admin_can_open_nucleo_details_and_edit(): void
    {
        $nucleo = $this->createNucleo();
        $admin = $this->createAdmin();

        $this->actingAs($admin)->get('/nucleos/details/'.$nucleo->id)->assertOk();
        $this->actingAs($admin)->get('/nucleos/edit/'.$nucleo->id)->assertOk();
    }

    public function test_admin_can_open_people_details(): void
    {
        $nucleo = $this->createNucleo();
        $aluno = $this->createAluno($nucleo);
        $professor = $this->createProfessor($nucleo);
        $coordenador = $this->createCoordenador($nucleo);
        $admin = $this->createAdmin();

        $this->actingAs($admin)->get('/alunos/details/'.$aluno->aluno->id)->assertOk();
        $this->actingAs($admin)->get('/alunos/edit/'.$aluno->aluno->id)->assertOk();
        $this->actingAs($admin)->get('/professores/details/'.$professor->professor->id)->assertOk();
        $this->actingAs($admin)->get('/professores/edit/'.$professor->professor->id)->assertOk();
        $this->actingAs($admin)->get('/coordenadores/details/'.$coordenador->coordenador->id)->assertOk();
        $this->actingAs($admin)->get('/coordenadores/edit/'.$coordenador->coordenador->id)->assertOk();
    }

    public function test_active_nucleos_by_state_json(): void
    {
        $this->createNucleo(['Estado' => 'SP']);
        $this->createNucleo(['Estado' => 'RJ']);
        $this->createNucleo(['Estado' => 'SP', 'Status' => 0]);

        $this->getJson('/nucleo/estados/all')->assertOk()->assertJsonCount(2);
        $this->getJson('/nucleo/estados/SP')->assertOk()->assertJsonCount(1);
    }
}
