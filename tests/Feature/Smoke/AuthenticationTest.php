<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    /**
     * O LoginController só dispensa o hCaptcha quando config('app.env')
     * é local/develop. Isso não altera app()->environment(), então a
     * proteção CSRF continua desligada como em qualquer teste.
     */
    private function withoutCaptcha(): void
    {
        config(['app.env' => 'local']);
    }

    public function test_guest_is_redirected_from_home_to_login(): void
    {
        $this->get('/home')->assertRedirect(route('login'));
    }

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('login-form', false)
            ->assertSee('otp-form', false);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $this->withoutCaptcha();
        $admin = $this->createAdmin();

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => $this->defaultPassword,
        ])->assertRedirect('/home');

        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->withoutCaptcha();
        $admin = $this->createAdmin();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $admin->email,
                'password' => 'senha-errada',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_requires_captcha_outside_local_environment(): void
    {
        $admin = $this->createAdmin();

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $admin->email,
                'password' => $this->defaultPassword,
            ])
            ->assertSessionHasErrors('hcaptcha');

        $this->assertGuest();
    }

    public function test_aluno_login_records_access(): void
    {
        $this->withoutCaptcha();
        $aluno = $this->createAluno();

        $this->post(route('login'), [
            'email' => $aluno->email,
            'password' => $this->defaultPassword,
        ])->assertRedirect('/home');

        $this->assertDatabaseHas('alunos_acessos', ['aluno_id' => $aluno->aluno->id]);
        $this->assertSame(1, DB::table('alunos_acessos')->count());
    }

    public function test_user_can_logout(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_password_reset_request_page_renders(): void
    {
        $this->get(route('password.request'))->assertOk();
    }
}
