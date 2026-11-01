<?php

namespace Tests\Feature\Security;

use App\Aluno;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Revisão OWASP 2025 — A01 Broken Access Control.
 */
class AccessControlHardeningTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public static function rotasSoDeAdministrador(): array
    {
        return [
            'listar administradores' => ['get', '/administradores'],
            'formulário de administrador' => ['get', '/administradores/create'],
            'código personalizado' => ['get', '/codigo-personalizado'],
        ];
    }

    public static function rotasDeGestao(): array
    {
        return [
            'geral' => ['get', '/geral'],
            'auditoria' => ['get', '/auditoria'],
            'disciplinas' => ['get', '/disciplinas'],
        ];
    }

    #[DataProvider('rotasSoDeAdministrador')]
    public function test_aluno_and_coordenador_are_blocked_from_admin_only_pages(string $metodo, string $uri): void
    {
        $this->actingAs($this->createAluno())->{$metodo}($uri)->assertForbidden();
        $this->actingAs($this->createCoordenador())->{$metodo}($uri)->assertForbidden();
    }

    #[DataProvider('rotasDeGestao')]
    public function test_aluno_is_blocked_from_management_pages(string $metodo, string $uri): void
    {
        $this->actingAs($this->createAluno())->{$metodo}($uri)->assertForbidden();
        $this->actingAs($this->createProfessor())->{$metodo}($uri)->assertForbidden();
    }

    public function test_coordenador_keeps_access_to_geral_and_auditoria(): void
    {
        $coordenador = $this->createCoordenador();

        $this->actingAs($coordenador)->get('/geral')->assertOk();
        $this->actingAs($coordenador)->get('/auditoria')->assertOk();
    }

    public function test_aluno_cannot_create_administrator(): void
    {
        $this->actingAs($this->createAluno())
            ->post('/administradores/store', ['name' => 'Invasor', 'email' => 'invasor@biko.test'])
            ->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'invasor@biko.test']);
    }

    public function test_aluno_cannot_inject_custom_code(): void
    {
        $this->actingAs($this->createAluno())
            ->post('/codigo-personalizado/update', ['tag_head' => '<script>alert(1)</script>'])
            ->assertForbidden();

        $this->assertSame(0, DB::table('codigo_personalizados')->count());
    }

    public function test_aluno_cannot_change_general_settings(): void
    {
        $this->actingAs($this->createAluno())
            ->post('/geral/update', ['texto_pre_cadastro' => '<script>alert(1)</script>'])
            ->assertForbidden();
    }

    public function test_aluno_cannot_import_professores(): void
    {
        $this->actingAs($this->createAluno())->post('/professores/import')->assertForbidden();
    }

    public function test_guest_cannot_touch_family_data_or_teacher_assignments(): void
    {
        $this->post('/alunos/familiares/add', ['inputIdUser' => 1])->assertRedirect(route('login'));
        $this->post('/alunos/familiares/delete/1')->assertRedirect(route('login'));
        $this->post('/nucleo/professores-disciplinas/create')->assertRedirect(route('login'));
        $this->post('/nucleo/professores-disciplinas/delete', ['id' => 1])->assertRedirect(route('login'));
    }

    public function test_aluno_cannot_add_family_data_to_another_student(): void
    {
        $aluno = $this->createAluno();
        $outro = $this->createAluno();

        $this->actingAs($aluno)
            ->post('/alunos/familiares/add', ['inputIdUser' => $outro->id, 'inputIdAluno' => $outro->aluno->id])
            ->assertForbidden();

        $this->assertDatabaseMissing('aluno_info_familiares', ['id_user' => $outro->id]);
    }

    public function test_student_json_search_is_not_available_to_alunos(): void
    {
        $this->actingAs($this->createAluno())
            ->getJson('/api/alunos/nucleo/search?aluno=a')
            ->assertForbidden();
    }

    public function test_student_json_search_returns_only_basic_fields_from_own_nucleos(): void
    {
        $meu = $this->createNucleo();
        $outro = $this->createNucleo();
        $this->createAluno($meu, alunoAttributes: ['NomeAluno' => 'Ana do Meu Núcleo', 'CPF' => '111.111.111-11']);
        $this->createAluno($outro, alunoAttributes: ['NomeAluno' => 'Ana de Outro Núcleo']);

        $resposta = $this->actingAs($this->createProfessor($meu))
            ->getJson('/api/alunos/nucleo/search?'.http_build_query(['nucleos' => [$meu->id, $outro->id], 'aluno' => 'Ana']))
            ->assertOk()
            ->json();

        $this->assertCount(1, $resposta);
        $this->assertSame('Ana do Meu Núcleo', $resposta[0]['NomeAluno']);
        $this->assertArrayNotHasKey('CPF', $resposta[0]);
        $this->assertArrayNotHasKey('Endereco', $resposta[0]);
    }

    public function test_aluno_search_only_returns_own_record(): void
    {
        $nucleo = $this->createNucleo();
        $aluno = $this->createAluno($nucleo);
        $this->createAluno($nucleo);
        $this->createAluno($nucleo);

        $alunos = $this->actingAs($aluno)
            ->get('/alunos/search')
            ->assertOk()
            ->viewData('alunos');

        $this->assertSame(1, $alunos->total());
        $this->assertSame($aluno->id, (int) $alunos->first()->id_user);
    }

    public function test_aluno_cannot_list_psychological_care_records(): void
    {
        $this->actingAs($this->createAluno())
            ->from('/home')
            ->get('/atendimento-psicologico/search')
            ->assertRedirect('/home');
    }

    public function test_aluno_cannot_upload_or_manage_material(): void
    {
        $aluno = $this->createAluno();

        $this->actingAs($aluno)->post('/nucleo/material/create')->assertForbidden();
        $this->actingAs($aluno)->get('/nucleo/material/inactive/1')->assertForbidden();
    }

    public function test_admin_created_from_panel_must_change_password(): void
    {
        $this->actingAs($this->createAdmin())
            ->post('/administradores/store', ['name' => 'Nova Admin', 'email' => 'nova.admin@biko.test'])
            ->assertRedirect(route('administradores.index'));

        $this->assertTrue((bool) User::where('email', 'nova.admin@biko.test')->value('first_login'));
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)->delete('/administradores/destroy/'.$admin->id)->assertStatus(422);
        $this->assertModelExists($admin);
    }

    public function test_sensitive_user_fields_are_hidden_from_json(): void
    {
        $user = $this->createAdmin(['api_token' => 'segredo', 'otp_hash' => 'hash']);

        $json = $user->fresh()->toArray();

        $this->assertArrayNotHasKey('api_token', $json);
        $this->assertArrayNotHasKey('otp_hash', $json);
        $this->assertArrayNotHasKey('password', $json);
    }
}
