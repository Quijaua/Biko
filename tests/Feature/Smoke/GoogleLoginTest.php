<?php

namespace Tests\Feature\Smoke;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Retorno do login com Google (/oauth/google/callback).
 */
class GoogleLoginTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function googleDevolve(?string $email = null, ?\Throwable $erro = null): void
    {
        $driver = Mockery::mock();
        $driver->shouldNotReceive('stateless');

        if ($erro) {
            $driver->shouldReceive('user')->andThrow($erro);
        } else {
            $driver->shouldReceive('user')->andReturn((new SocialiteUser())->map(['email' => $email]));
        }

        Socialite::shouldReceive('driver')->with('google')->andReturn($driver);
    }

    public function test_cancelled_consent_returns_to_login_with_message(): void
    {
        $this->get('/oauth/google/callback?error=access_denied')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error', 'O login com o Google foi cancelado.');

        $this->assertGuest();
    }

    public function test_callback_without_code_does_not_cause_error_500(): void
    {
        $this->get('/oauth/google/callback')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_google_rejecting_the_code_returns_to_login(): void
    {
        $this->googleDevolve(erro: new ClientException(
            'invalid_grant',
            new Psr7Request('POST', 'https://www.googleapis.com/oauth2/v4/token'),
            new Response(400)
        ));

        $this->get('/oauth/google/callback?code=codigo-ja-usado')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_callback_not_started_in_this_browser_is_rejected(): void
    {
        // "state" da URL diferente do guardado na sessão: login forjado por outro site.
        $this->googleDevolve(erro: new InvalidStateException());

        $this->get('/oauth/google/callback?code=codigo-de-outra-pessoa&state=forjado')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_known_email_logs_in(): void
    {
        $admin = $this->createAdmin(['email' => 'admin.google@biko.test']);
        $this->googleDevolve('Admin.Google@biko.test');

        $this->get('/oauth/google/callback?code=codigo-valido')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_unknown_email_shows_not_found_page(): void
    {
        $this->googleDevolve('ninguem@biko.test');

        $this->get('/oauth/google/callback?code=codigo-valido')->assertOk();

        $this->assertGuest();
    }
}
