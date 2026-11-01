<?php

namespace Tests\Feature\Smoke;

use App\Mail\MessageOtpLogin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

class OtpLoginTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function otp(string $token, int $minutos = 30): array
    {
        return ['otp_hash' => hash('sha256', $token), 'otp_expires_at' => now()->addMinutes($minutos)];
    }

    public function test_requesting_otp_sends_link_by_email_and_stores_only_the_hash(): void
    {
        Mail::fake();
        $aluno = $this->createAluno();

        $this->from(route('login'))
            ->post(route('otp-login'), ['email' => $aluno->email])
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $salvo = $aluno->fresh();
        $this->assertNotNull($salvo->otp_hash);
        $this->assertTrue($salvo->otp_expires_at->isFuture());

        Mail::assertSent(MessageOtpLogin::class, function (MessageOtpLogin $mail) use ($aluno, $salvo) {
            parse_str((string) parse_url($mail->url, PHP_URL_QUERY), $query);

            return $mail->hasTo($aluno->email)
                && ! str_contains($mail->url, $salvo->otp_hash)          // o hash não sai do banco
                && hash('sha256', $query['token']) === $salvo->otp_hash; // o link leva o token original
        });
    }

    public function test_requesting_otp_for_unknown_email_returns_error(): void
    {
        Mail::fake();

        $this->from(route('login'))
            ->post(route('otp-login'), ['email' => 'ninguem@biko.test'])
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        Mail::assertNothingSent();
    }

    public function test_valid_otp_token_logs_user_in_and_is_consumed(): void
    {
        $aluno = $this->createAluno(userAttributes: $this->otp('token-valido-123'));

        $this->get(route('otp-verify', ['email' => $aluno->email, 'token' => 'token-valido-123']))
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($aluno);
        $this->assertNull($aluno->fresh()->otp_hash);
        $this->assertNull($aluno->fresh()->otp_expires_at);
    }

    public function test_invalid_otp_token_is_rejected(): void
    {
        $aluno = $this->createAluno(userAttributes: $this->otp('token-valido-123'));

        $this->get(route('otp-verify', ['email' => $aluno->email, 'token' => 'token-errado']))
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
        $this->assertNotNull($aluno->fresh()->otp_hash);
    }

    public function test_expired_otp_token_is_rejected(): void
    {
        $aluno = $this->createAluno(userAttributes: $this->otp('token-velho', minutos: -1));

        $this->get(route('otp-verify', ['email' => $aluno->email, 'token' => 'token-velho']))
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_otp_with_esperanca_garcia_redirect_goes_to_ead_registration(): void
    {
        $aluno = $this->createAluno(userAttributes: $this->otp('token-ead'));

        $this->get(route('otp-verify', [
            'email' => $aluno->email,
            'token' => 'token-ead',
            'redirect' => 'aula-programa-esperanca-garcia',
        ]))->assertRedirect(route('ead.register'));
    }
}
