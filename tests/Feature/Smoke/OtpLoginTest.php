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

    public function test_requesting_otp_sends_link_by_email(): void
    {
        Mail::fake();
        $aluno = $this->createAluno();

        $this->from(route('login'))
            ->post(route('otp-login'), ['email' => $aluno->email])
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertNotNull($aluno->fresh()->otp_hash);

        Mail::assertSent(MessageOtpLogin::class, fn (MessageOtpLogin $mail) => $mail->hasTo($aluno->email)
            && str_contains($mail->url, $aluno->fresh()->otp_hash));
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
        $aluno = $this->createAluno(userAttributes: ['otp_hash' => 'token-valido-123']);

        $this->get(route('otp-verify', ['email' => $aluno->email, 'token' => 'token-valido-123']))
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($aluno);
        $this->assertNull($aluno->fresh()->otp_hash);
    }

    public function test_invalid_otp_token_is_rejected(): void
    {
        $aluno = $this->createAluno(userAttributes: ['otp_hash' => 'token-valido-123']);

        $this->get(route('otp-verify', ['email' => $aluno->email, 'token' => 'token-errado']))
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
        $this->assertSame('token-valido-123', $aluno->fresh()->otp_hash);
    }

    public function test_otp_with_esperanca_garcia_redirect_goes_to_ead_registration(): void
    {
        $aluno = $this->createAluno(userAttributes: ['otp_hash' => 'token-ead']);

        $this->get(route('otp-verify', [
            'email' => $aluno->email,
            'token' => 'token-ead',
            'redirect' => 'aula-programa-esperanca-garcia',
        ]))->assertRedirect(route('ead.register'));
    }
}
