<?php

namespace Tests\Feature\Smoke;

use App\Mail\EmailFormularioCoordenador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

class SejaUmProfessorTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

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
        ])->assertOk();

        $this->assertDatabaseHas('users', ['email' => 'voluntaria@biko.test', 'role' => 'professor']);
        $this->assertDatabaseHas('professores', [
            'Email' => 'voluntaria@biko.test',
            'Status' => 0,
            'id_nucleo' => $nucleo->id,
        ]);

        Mail::assertSent(EmailFormularioCoordenador::class, fn ($mail) => $mail->hasTo($coordenador->email));
    }
}
