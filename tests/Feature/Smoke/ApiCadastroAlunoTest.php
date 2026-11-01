<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * POST /api/cadastro-aluno, protegido pelo guard "api" (driver token / api_token).
 */
class ApiCadastroAlunoTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function payload(int $nucleoId, array $overrides = []): array
    {
        return array_merge([
            'NomeAluno' => 'Estudante Via API',
            'email' => 'estudante.api@biko.test',
            'role' => 'aluno',
            'id_nucleo' => $nucleoId,
            'Raca' => 'preta',
            'Genero' => 'mulher',
            'IdentificaGenero' => 1, // coluna integer
            'Nascimento' => '2005-03-10',
            'Cidade' => 'São Paulo',
            'Estado' => 'SP',
            'CEP' => '01001-000',
            'Endereco' => 'Praça da Sé',
            'Numero' => '1',
            'Bairro' => 'Sé',
            'Complemento' => '',
            'FoneCelular' => '11999999999',
            'EnsFundamental' => 'publica',
            'PorcentagemBolsa' => '',
            'EnsMedio' => 'publica',
            'PorcentagemBolsaMedio' => '',
            'Enem' => 1, // coluna integer
            'Vestibular' => 'sim',
            'OpcoesVestibular1' => 'Medicina',
            'OpcoesVestibular2' => 'Direito',
            'VestibularOutraCidade' => 'nao',
            'ComoSoube' => 'amigos',
        ], $overrides);
    }

    public function test_request_without_token_is_unauthorized(): void
    {
        $nucleo = $this->createNucleo();

        $this->postJson('/api/cadastro-aluno', $this->payload($nucleo->id))->assertUnauthorized();
    }

    public function test_valid_token_creates_user_and_aluno(): void
    {
        $nucleo = $this->createNucleo();
        $token = Str::random(80);
        $this->createAdmin(['api_token' => $token]);

        $this->withToken($token)
            ->postJson('/api/cadastro-aluno', $this->payload($nucleo->id))
            ->assertOk();

        $this->assertDatabaseHas('users', ['email' => 'estudante.api@biko.test', 'role' => 'aluno']);
        $this->assertDatabaseHas('alunos', ['NomeAluno' => 'Estudante Via API', 'id_nucleo' => $nucleo->id]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        $nucleo = $this->createNucleo();
        $token = Str::random(80);
        $this->createAdmin(['api_token' => $token]);
        $existente = $this->createAluno($nucleo);

        $this->withToken($token)
            ->postJson('/api/cadastro-aluno', $this->payload($nucleo->id, ['email' => $existente->email]))
            ->assertStatus(422);
    }
}
