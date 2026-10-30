<?php

namespace Tests\Feature\Fase1;

use App\Mail\MessageOtpLogin;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Garante que as trocas de infraestrutura da Fase 1 continuam funcionando:
 * factories em classe, config de e-mail no formato "mailers" e
 * providers padrão do framework.
 */
class FrameworkCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_based_user_factory_works(): void
    {
        $user = User::factory()->role('coordenador')->create();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'coordenador']);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull(User::factory()->unverified()->create()->email_verified_at);
    }

    public function test_mail_uses_mailers_config_and_sends_through_array_transport(): void
    {
        $this->assertSame('array', config('mail.default'));
        $this->assertSame('smtp', config('mail.mailers.smtp.transport'));

        $user = User::factory()->create();

        Mail::to($user->email)->send(new MessageOtpLogin($user->email, 'https://biko.test/otp', $user));

        $mensagens = app('mailer')->getSymfonyTransport()->messages();
        $this->assertCount(1, $mensagens);
        $this->assertSame('Solicitação de acesso', $mensagens->first()->getOriginalMessage()->getSubject());
    }

    public function test_legacy_mail_driver_env_is_still_honoured(): void
    {
        // config/mail.php: env('MAIL_MAILER', env('MAIL_DRIVER', 'smtp'))
        $config = require config_path('mail.php');

        $this->assertArrayHasKey('mailers', $config);
        $this->assertArrayHasKey($config['default'], $config['mailers']);
    }

    public function test_default_framework_providers_are_registered(): void
    {
        foreach ([
            \Illuminate\Auth\AuthServiceProvider::class,
            \Illuminate\Mail\MailServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \App\Providers\AuthServiceProvider::class,
            \App\Providers\RouteServiceProvider::class,
            \OwenIt\Auditing\AuditingServiceProvider::class,
            \Harishdurga\LaravelQuiz\LaravelQuizServiceProvider::class,
        ] as $provider) {
            $this->assertNotNull($this->app->getProvider($provider), "{$provider} não foi registrado");
        }
    }
}
