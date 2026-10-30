<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_guest_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_pre_cadastro_renders(): void
    {
        $this->get(route('pre-cadastro'))->assertOk();
    }

    public function test_legacy_signup_slug_redirects_to_pre_cadastro(): void
    {
        $this->get(route('register-slug'))->assertRedirect(route('pre-cadastro'));
    }

    public function test_seja_um_professor_form_renders(): void
    {
        $this->get('/seja-um-professor')->assertOk();
    }

    public function test_esperanca_garcia_asks_guest_for_email(): void
    {
        $this->get(route('ead.register'))
            ->assertOk()
            ->assertViewIs('auth.otp-login');
    }
}
