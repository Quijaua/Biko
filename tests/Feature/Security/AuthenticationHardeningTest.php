<?php

namespace Tests\Feature\Security;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Revisão OWASP 2025 — A07 Authentication Failures.
 */
class AuthenticationHardeningTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_login_is_rate_limited(): void
    {
        config(['app.env' => 'local']); // sem hCaptcha
        $admin = $this->createAdmin();

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('login'), ['email' => $admin->email, 'password' => 'errada']);
        }

        $this->post(route('login'), ['email' => $admin->email, 'password' => 'errada'])
            ->assertStatus(429);
    }

    public function test_otp_request_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('otp-login'), ['email' => 'ninguem@biko.test']);
        }

        $this->post(route('otp-login'), ['email' => 'ninguem@biko.test'])->assertStatus(429);
    }

    public function test_command_forces_password_change_when_password_equals_email(): void
    {
        $fraco = $this->createUser('professor', ['email' => 'fraco@biko.test', 'password' => Hash::make('fraco@biko.test')]);
        $forte = $this->createUser('professor', ['email' => 'forte@biko.test']);

        $this->artisan('biko:forcar-troca-senha-padrao')->assertSuccessful();

        $this->assertTrue((bool) $fraco->fresh()->first_login);
        $this->assertFalse((bool) $forte->fresh()->first_login);
    }

    public function test_command_dry_run_changes_nothing(): void
    {
        $fraco = $this->createUser('aluno', ['email' => 'fraco2@biko.test', 'password' => Hash::make('fraco2@biko.test')]);

        $this->artisan('biko:forcar-troca-senha-padrao --dry-run')->assertSuccessful();

        $this->assertFalse((bool) $fraco->fresh()->first_login);
    }

    public function test_api_created_aluno_must_change_password_and_cannot_choose_role(): void
    {
        $nucleo = $this->createNucleo();
        $this->createAdmin(['api_token' => $token = str_repeat('a', 80)]);

        $this->withToken($token)->postJson('/api/cadastro-aluno', [
            'NomeAluno' => 'Via API', 'email' => 'via.api@biko.test', 'role' => 'administrador',
            'id_nucleo' => $nucleo->id, 'Raca' => null, 'Genero' => null, 'IdentificaGenero' => null,
            'Nascimento' => null, 'Cidade' => null, 'Estado' => null, 'CEP' => null, 'Endereco' => null,
            'Numero' => null, 'Bairro' => null, 'Complemento' => null, 'FoneCelular' => null,
            'EnsFundamental' => null, 'PorcentagemBolsa' => null, 'EnsMedio' => null,
            'PorcentagemBolsaMedio' => null, 'Enem' => null, 'Vestibular' => null,
            'OpcoesVestibular1' => null, 'OpcoesVestibular2' => null, 'VestibularOutraCidade' => null,
            'ComoSoube' => null,
        ])->assertOk();

        $user = User::where('email', 'via.api@biko.test')->firstOrFail();
        $this->assertSame('aluno', $user->getRealRole());
        $this->assertTrue((bool) $user->first_login);
    }
}
