<?php

namespace Tests\Feature\Smoke;

use App\Http\Repository\HcaptchaRepository;
use App\Mail\EmailFormularioCoordenador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

class SejaUmProfessorTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Sem chamada real ao hCaptcha: só "token-valido" passa.
        $this->app->instance(HcaptchaRepository::class, new class extends HcaptchaRepository {
            public function validate($challenge, ?string $ip = null): bool
            {
                return $challenge === 'token-valido';
            }
        });
    }

    public function test_email_check_endpoint(): void
    {
        $professor = $this->createProfessor();

        $this->postJson('/verifica-email-professor', ['email' => $professor->email])
            ->assertOk()
            ->assertJson(['existe' => true]);

        $this->postJson('/verifica-email-professor', ['email' => 'novo@biko.test'])
            ->assertOk()
            ->assertJson(['existe' => false]);
    }

    public function test_volunteer_signup_creates_inactive_professor_and_notifies_coordenadores(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $coordenador = $this->createCoordenador($nucleo);

        $this->post('/seja-um-professor', [
            'nome_social' => 'Professora Voluntária',
            'email' => 'voluntaria@biko.test',
            'data_nascimento' => '1990-01-01',
            'telefone' => '11988887777',
            'profissao' => 'Historiadora',
            'cidade_professor' => 'Campinas',
            'estado' => 'SP',
            'raca_cor' => 'preta',
            'genero' => 'mulher',
            'nucleo_id' => $nucleo->id,
            'h-captcha-response' => 'token-valido',
        ])->assertOk();

        $this->assertDatabaseHas('users', ['email' => 'voluntaria@biko.test', 'role' => 'professor']);
        $this->assertDatabaseHas('professores', [
            'Email' => 'voluntaria@biko.test',
            'Status' => 0,
            'id_nucleo' => $nucleo->id,
        ]);

        // A senha inicial (o e-mail) precisa ser gravada com hash.
        $user = User::where('email', 'voluntaria@biko.test')->firstOrFail();
        $this->assertNotSame('voluntaria@biko.test', $user->password);
        $this->assertTrue(Hash::check('voluntaria@biko.test', $user->password));

        Mail::assertSent(EmailFormularioCoordenador::class, fn ($mail) => $mail->hasTo($coordenador->email));
    }

    private function dadosDoFormulario(array $sobrescrever = []): array
    {
        return array_merge([
            'nome_social' => 'Professora Voluntária',
            'email' => 'voluntaria@biko.test',
            'telefone' => '11988887777',
            'profissao' => 'Historiadora',
            'cidade_professor' => 'Campinas',
            'estado' => 'SP',
            'raca_cor' => 'preta',
            'genero' => 'mulher',
            'h-captcha-response' => 'token-valido',
        ], $sobrescrever);
    }

    public function test_duplicate_email_shows_friendly_notice_instead_of_error_500(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $existente = $this->createAluno(null, ['email' => 'ja.existe@biko.test']);

        $this->from('/seja-um-professor')
            ->post('/seja-um-professor', $this->dadosDoFormulario([
                'email' => '  JA.Existe@biko.test ',
                'nucleo_id' => $nucleo->id,
            ]))
            ->assertRedirect('/seja-um-professor')
            ->assertSessionHas('email_ja_cadastrado', 'ja.existe@biko.test')
            ->assertSessionHasInput('nome_social', 'Professora Voluntária');

        $this->assertSame(1, User::where('email', 'ja.existe@biko.test')->count());
        $this->assertDatabaseMissing('professores', ['Email' => 'ja.existe@biko.test']);
        Mail::assertNothingSent();

        $this->get('/seja-um-professor')
            ->assertOk()
            ->assertSee('Este e-mail já tem cadastro')
            ->assertSee(route('password.request'), false)
            ->assertSee('value="Professora Voluntária"', false);

        $this->assertSame('aluno', $existente->fresh()->role);
    }

    public function test_inactive_or_missing_nucleo_is_rejected_with_validation_message(): void
    {
        $inativo = $this->createNucleo(['Status' => 0]);

        $this->from('/seja-um-professor')
            ->post('/seja-um-professor', $this->dadosDoFormulario(['nucleo_id' => $inativo->id]))
            ->assertRedirect('/seja-um-professor')
            ->assertSessionHasErrors('nucleo_id');

        $this->from('/seja-um-professor')
            ->post('/seja-um-professor', $this->dadosDoFormulario())
            ->assertSessionHasErrors('nucleo_id');

        $this->assertDatabaseMissing('users', ['email' => 'voluntaria@biko.test']);
    }

    public function test_signup_still_succeeds_when_coordinator_email_fails(): void
    {
        $nucleo = $this->createNucleo();
        $this->createCoordenador($nucleo);

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP fora do ar'));

        $this->post('/seja-um-professor', $this->dadosDoFormulario(['nucleo_id' => $nucleo->id]))
            ->assertOk()
            ->assertSee('Agradecemos o interesse');

        $this->assertDatabaseHas('professores', ['Email' => 'voluntaria@biko.test']);
    }

    public function test_signup_without_solving_hcaptcha_is_rejected(): void
    {
        Mail::fake();
        $nucleo = $this->createNucleo();

        foreach ([null, '', 'token-forjado'] as $token) {
            $this->from('/seja-um-professor')
                ->post('/seja-um-professor', $this->dadosDoFormulario([
                    'nucleo_id' => $nucleo->id,
                    'h-captcha-response' => $token,
                ]))
                ->assertRedirect('/seja-um-professor')
                ->assertSessionHasErrors('hcaptcha');
        }

        $this->assertDatabaseMissing('users', ['email' => 'voluntaria@biko.test']);
        Mail::assertNothingSent();
    }
}
