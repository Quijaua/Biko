<?php

namespace Tests\Feature\Fase3;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Pontos de atenção do upgrade para o Laravel 13.
 */
class Laravel13Test extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_running_on_laravel_13(): void
    {
        $this->assertSame(13, (int) Application::VERSION);
    }

    public function test_web_group_uses_prevent_request_forgery(): void
    {
        $groups = $this->app->make(Kernel::class)->getMiddlewareGroups();

        $this->assertContains(PreventRequestForgery::class, $groups['web']);
    }

    public function test_password_reset_email_subject_is_translated(): void
    {
        // O Laravel 13 mudou o assunto padrão para "Reset your password".
        $user = $this->createAluno();

        $mail = (new ResetPassword('token-de-teste'))->toMail($user);

        $this->assertSame('Redefinição de senha', $mail->subject);
    }

    public function test_cache_does_not_unserialize_objects(): void
    {
        $this->assertFalse(config('cache.serializable_classes'));
    }

    public function test_sessions_keep_php_serialization(): void
    {
        // Trocar para "json" derrubaria todas as sessões abertas no deploy.
        $this->assertSame('php', config('session.serialization'));
    }
}
