<?php

namespace Tests\Feature\Nucleo;

use App\Mail\TransferenciaNucleoMail;
use App\Nucleo;
use App\SolicitacaoTransferencia;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Regra: desativar um Núcleo desativa quem faz parte dele e oferece a
 * opção de pedir transferência para outro Núcleo ativo.
 */
class DesativacaoNucleoTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function desativar(Nucleo $nucleo): void
    {
        $this->actingAs($this->createAdmin())
            ->from('/nucleos')
            ->get('/nucleos/disable/'.$nucleo->id)
            ->assertRedirect('/nucleos');
    }

    public function test_disabling_a_nucleo_disables_its_people(): void
    {
        $nucleo = $this->createNucleo();
        $outro = $this->createNucleo();

        $aluno = $this->createAluno($nucleo);
        $professor = $this->createProfessor($nucleo);
        $coordenador = $this->createCoordenador($nucleo);
        $alunoDeOutroNucleo = $this->createAluno($outro);

        $this->desativar($nucleo);

        $this->assertSame(0, (int) $nucleo->fresh()->Status);
        $this->assertSame(0, (int) $aluno->aluno->fresh()->Status);
        $this->assertSame(0, (int) $professor->professor->fresh()->Status);
        $this->assertSame(0, (int) $coordenador->coordenador->fresh()->Status);
        $this->assertSame($nucleo->id, $aluno->aluno->fresh()->inativado_por_nucleo_id);

        $this->assertSame(1, (int) $alunoDeOutroNucleo->aluno->fresh()->Status);
    }

    public function test_coordinator_with_another_active_nucleo_stays_active(): void
    {
        $nucleo = $this->createNucleo();
        $outro = $this->createNucleo();
        $coordenador = $this->createCoordenador($nucleo);
        $coordenador->coordenador->nucleos()->attach($outro->id);

        $this->desativar($nucleo);

        $this->assertSame(1, (int) $coordenador->coordenador->fresh()->Status);
        $this->assertNull($coordenador->coordenador->fresh()->inativado_por_nucleo_id);
    }

    public function test_people_already_inactive_are_not_flagged(): void
    {
        $nucleo = $this->createNucleo();
        $professorInativo = $this->createProfessor($nucleo, status: 0);

        $this->desativar($nucleo);

        $this->assertNull($professorInativo->professor->fresh()->inativado_por_nucleo_id);
    }

    public function test_enabling_the_nucleo_again_reactivates_only_who_was_disabled_with_it(): void
    {
        $nucleo = $this->createNucleo();
        $aluno = $this->createAluno($nucleo);
        $professorJaInativo = $this->createProfessor($nucleo, status: 0);

        $this->desativar($nucleo);

        $this->actingAs($this->createAdmin())->from('/nucleos')->get('/nucleos/enable/'.$nucleo->id);

        $this->assertSame(1, (int) $nucleo->fresh()->Status);
        $this->assertSame(1, (int) $aluno->aluno->fresh()->Status);
        $this->assertNull($aluno->aluno->fresh()->inativado_por_nucleo_id);
        $this->assertSame(0, (int) $professorJaInativo->professor->fresh()->Status);
    }

    public function test_only_admin_can_disable_a_nucleo(): void
    {
        $nucleo = $this->createNucleo();
        $coordenador = $this->createCoordenador($nucleo);
        $aluno = $this->createAluno($nucleo);

        $this->actingAs($coordenador)->get('/nucleos/disable/'.$nucleo->id);
        $this->actingAs($aluno)->get('/nucleos/disable/'.$nucleo->id);

        $this->assertSame(1, (int) $nucleo->fresh()->Status);
        $this->assertSame(1, (int) $aluno->aluno->fresh()->Status);
    }

    public function test_affected_user_sees_the_warning_and_only_active_nucleos(): void
    {
        $nucleo = $this->createNucleo(['NomeNucleo' => 'Núcleo Fechado']);
        $ativo = $this->createNucleo(['NomeNucleo' => 'Núcleo Aberto']);
        $this->createNucleo(['NomeNucleo' => 'Núcleo Também Inativo', 'Status' => 0]);
        $aluno = $this->createAluno($nucleo);

        $this->desativar($nucleo);

        $this->actingAs($aluno->fresh())
            ->get('/home')
            ->assertOk()
            ->assertSee('Núcleo desativado')
            ->assertSee('id="modalNucleoDesativado"', false)
            ->assertSee('abrirModalNucleoDesativado', false) // abre sozinho no primeiro acesso
            ->assertSee('Núcleo Aberto')
            ->assertDontSee('Núcleo Também Inativo');
    }

    public function test_warning_does_not_appear_for_unaffected_users(): void
    {
        $aluno = $this->createAluno();

        $this->actingAs($aluno)
            ->get('/home')
            ->assertOk()
            ->assertDontSee('modalNucleoDesativado', false);
    }

    public function test_affected_student_requests_transfer_and_destination_coordinators_are_emailed(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $destino = $this->createNucleo();
        $coordenadorDestino = $this->createCoordenador($destino);
        $aluno = $this->createAluno($nucleo);

        $this->desativar($nucleo);

        $this->actingAs($aluno->fresh())
            ->from('/home')
            ->post('/transferencia-nucleo', [
                'perfil' => 'aluno',
                'nucleo_destino_id' => $destino->id,
                'mensagem' => 'Moro perto deste Núcleo.',
            ])
            ->assertRedirect('/home')
            ->assertSessionHas('transferencia_ok');

        $this->assertDatabaseHas('solicitacoes_transferencia', [
            'user_id' => $aluno->id,
            'perfil' => 'aluno',
            'nucleo_origem_id' => $nucleo->id,
            'nucleo_destino_id' => $destino->id,
            'status' => SolicitacaoTransferencia::PENDENTE,
        ]);

        Mail::assertSent(TransferenciaNucleoMail::class, fn ($mail) => $mail->hasTo($coordenadorDestino->coordenador->Email)
            && str_contains($mail->mensagem, 'Moro perto'));
    }

    public function test_inactive_professor_can_request_transfer(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $destino = $this->createNucleo();
        $professor = $this->createProfessor($nucleo);

        $this->desativar($nucleo);

        $this->actingAs($professor->fresh())
            ->post('/transferencia-nucleo', ['perfil' => 'professor', 'nucleo_destino_id' => $destino->id])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('solicitacoes_transferencia', ['user_id' => $professor->id, 'perfil' => 'professor']);
    }

    public function test_new_request_replaces_the_pending_one(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $primeiro = $this->createNucleo();
        $segundo = $this->createNucleo();
        $aluno = $this->createAluno($nucleo);
        $this->desativar($nucleo);

        $this->actingAs($aluno->fresh())->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $primeiro->id]);
        $this->actingAs($aluno->fresh())->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $segundo->id]);

        $this->assertSame(1, SolicitacaoTransferencia::pendentes()->where('user_id', $aluno->id)->count());
        $this->assertSame($segundo->id, SolicitacaoTransferencia::pendentes()->where('user_id', $aluno->id)->value('nucleo_destino_id'));
    }

    public function test_request_must_target_an_active_nucleo_other_than_the_disabled_one(): void
    {
        $nucleo = $this->createNucleo();
        $inativo = $this->createNucleo(['Status' => 0]);
        $aluno = $this->createAluno($nucleo);
        $this->desativar($nucleo);

        $this->actingAs($aluno->fresh())
            ->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $inativo->id])
            ->assertSessionHasErrors('nucleo_destino_id');

        $this->actingAs($aluno->fresh())
            ->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $nucleo->id])
            ->assertSessionHasErrors('nucleo_destino_id');

        $this->assertSame(0, SolicitacaoTransferencia::count());
    }

    public function test_user_without_disabled_nucleo_cannot_request_transfer(): void
    {
        $aluno = $this->createAluno();

        $this->actingAs($aluno)
            ->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $this->createNucleo()->id])
            ->assertForbidden();
    }

    public function test_destination_coordinator_approves_and_student_moves_to_new_nucleo(): void
    {
        Mail::fake();

        [$aluno, $destino, $coordenadorDestino, $solicitacao] = $this->pedidoPendente();

        $this->actingAs($coordenadorDestino)
            ->get('/transferencias')
            ->assertOk()
            ->assertSee($aluno->name);

        $this->actingAs($coordenadorDestino)
            ->from('/transferencias')
            ->post("/transferencias/{$solicitacao->id}/aprovar")
            ->assertRedirect('/transferencias');

        $registro = $aluno->aluno->fresh();
        $this->assertSame($destino->id, (int) $registro->id_nucleo);
        $this->assertSame($destino->NomeNucleo, $registro->NomeNucleo);
        $this->assertSame(1, (int) $registro->Status);
        $this->assertNull($registro->inativado_por_nucleo_id);
        $this->assertSame(SolicitacaoTransferencia::APROVADA, $solicitacao->fresh()->status);

        Mail::assertSent(TransferenciaNucleoMail::class, fn ($mail) => $mail->hasTo($aluno->email));

        // Aviso some depois da aprovação.
        $this->actingAs($aluno->fresh())->get('/home')->assertDontSee('modalNucleoDesativado', false);
    }

    public function test_approved_coordinator_is_linked_to_the_new_nucleo(): void
    {
        Mail::fake();

        $nucleo = $this->createNucleo();
        $destino = $this->createNucleo();
        $coordenadorDestino = $this->createCoordenador($destino);
        $coordenador = $this->createCoordenador($nucleo);
        $this->desativar($nucleo);

        $this->actingAs($coordenador->fresh())
            ->post('/transferencia-nucleo', ['perfil' => 'coordenador', 'nucleo_destino_id' => $destino->id]);

        $solicitacao = SolicitacaoTransferencia::firstOrFail();
        $this->actingAs($coordenadorDestino)->post("/transferencias/{$solicitacao->id}/aprovar");

        $registro = $coordenador->coordenador->fresh();
        $this->assertSame(1, (int) $registro->Status);
        $this->assertTrue($registro->nucleos()->where('nucleos.id', $destino->id)->exists());
    }

    public function test_coordinator_refuses_and_student_stays_inactive(): void
    {
        Mail::fake();

        [$aluno, , $coordenadorDestino, $solicitacao] = $this->pedidoPendente();

        $this->actingAs($coordenadorDestino)->post("/transferencias/{$solicitacao->id}/recusar");

        $this->assertSame(SolicitacaoTransferencia::RECUSADA, $solicitacao->fresh()->status);
        $this->assertSame(0, (int) $aluno->aluno->fresh()->Status);
    }

    public function test_coordinator_of_another_nucleo_cannot_answer(): void
    {
        Mail::fake();

        [$aluno, , , $solicitacao] = $this->pedidoPendente();
        $intruso = $this->createCoordenador($this->createNucleo());

        $this->actingAs($intruso)->post("/transferencias/{$solicitacao->id}/aprovar")->assertForbidden();
        $this->actingAs($intruso)->get('/transferencias')->assertOk()->assertDontSee($aluno->name);

        $this->assertSame(SolicitacaoTransferencia::PENDENTE, $solicitacao->fresh()->status);
    }

    public function test_students_cannot_open_the_requests_page(): void
    {
        $this->actingAs($this->createAluno())->get('/transferencias')->assertForbidden();
    }

    public function test_coordinator_header_shows_pending_requests_counter(): void
    {
        Mail::fake();

        [, , $coordenadorDestino] = $this->pedidoPendente();

        $this->actingAs($coordenadorDestino)
            ->get('/home')
            ->assertOk()
            ->assertSee('Pedidos de transferência');
    }

    /**
     * @return array{0: User, 1: Nucleo, 2: User, 3: SolicitacaoTransferencia}
     */
    private function pedidoPendente(): array
    {
        $nucleo = $this->createNucleo();
        $destino = $this->createNucleo();
        $coordenadorDestino = $this->createCoordenador($destino);
        $aluno = $this->createAluno($nucleo);

        $this->desativar($nucleo);

        $this->actingAs($aluno->fresh())
            ->post('/transferencia-nucleo', ['perfil' => 'aluno', 'nucleo_destino_id' => $destino->id]);

        return [$aluno->fresh(), $destino, $coordenadorDestino, SolicitacaoTransferencia::firstOrFail()];
    }
}
