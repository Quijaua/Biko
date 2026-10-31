<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

class HomeByRoleTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_administrador_sees_home(): void
    {
        $this->actingAs($this->createAdmin())
            ->get('/home')
            ->assertOk()
            ->assertViewIs('home');
    }

    public function test_first_login_shows_change_password_screen(): void
    {
        $this->actingAs($this->createAdmin(['first_login' => true]))
            ->get('/home')
            ->assertOk()
            ->assertViewIs('first_login.change_password');
    }

    public function test_aluno_sees_home(): void
    {
        $this->actingAs($this->createAluno())
            ->get('/home')
            ->assertOk()
            ->assertViewIs('home')
            ->assertSessionHas('role', 'aluno');
    }

    public function test_unverified_user_is_sent_to_email_verification(): void
    {
        $this->actingAs($this->createAluno(userAttributes: ['email_verified_at' => null]))
            ->get('/home')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_professor_sees_home(): void
    {
        $this->actingAs($this->createProfessor())
            ->get('/home')
            ->assertOk()
            ->assertViewIs('home');
    }

    public function test_coordenador_sees_home_with_own_nucleos(): void
    {
        $nucleo = $this->createNucleo(['NomeNucleo' => 'Núcleo do Coordenador']);
        $this->createNucleo(['NomeNucleo' => 'Outro Núcleo']);

        $response = $this->actingAs($this->createCoordenador($nucleo))
            ->get('/home')
            ->assertOk()
            ->assertViewIs('home');

        $this->assertSame(
            ['Núcleo do Coordenador'],
            collect($response->viewData('nucleos'))->pluck('NomeNucleo')->all()
        );
    }
}
