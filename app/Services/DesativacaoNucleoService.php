<?php

namespace App\Services;

use App\Aluno;
use App\Coordenadores;
use App\Mail\TransferenciaNucleoMail;
use App\Nucleo;
use App\Professores;
use App\SolicitacaoTransferencia;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Regra de negócio: desativar um Núcleo desativa quem faz parte dele
 * e abre para essas pessoas a opção de pedir transferência para outro
 * Núcleo ativo.
 *
 * - Estudantes e professores: inativados se o Núcleo principal (id_nucleo) for este.
 * - Coordenadores: inativados só se não coordenarem nenhum outro Núcleo ativo.
 * - Quem já estava inativo não é marcado, para não ser reativado por engano depois.
 */
class DesativacaoNucleoService
{
    /**
     * @return array{alunos:int, professores:int, coordenadores:int}
     */
    public function desativar(Nucleo $nucleo): array
    {
        return DB::transaction(function () use ($nucleo) {
            $nucleo->Status = 0;
            $nucleo->save();

            $alunos = $this->inativar(
                Aluno::query()->where('id_nucleo', $nucleo->id),
                $nucleo
            );

            $professores = $this->inativar(
                Professores::query()->where('id_nucleo', $nucleo->id),
                $nucleo
            );

            $coordenadores = $this->inativar(
                Coordenadores::query()
                    ->whereHas('nucleos', fn (Builder $q) => $q->where('nucleos.id', $nucleo->id))
                    ->whereDoesntHave('nucleos', fn (Builder $q) => $q
                        ->where('nucleos.id', '!=', $nucleo->id)
                        ->where('nucleos.Status', 1)),
                $nucleo
            );

            return compact('alunos', 'professores', 'coordenadores');
        });
    }

    /**
     * Reativa o Núcleo e só as pessoas que foram inativadas por causa dele
     * e que ainda não foram transferidas.
     *
     * @return array{alunos:int, professores:int, coordenadores:int}
     */
    public function reativar(Nucleo $nucleo): array
    {
        return DB::transaction(function () use ($nucleo) {
            $nucleo->Status = 1;
            $nucleo->save();

            $contagem = [];
            foreach (['alunos' => Aluno::class, 'professores' => Professores::class, 'coordenadores' => Coordenadores::class] as $chave => $classe) {
                $registros = $classe::query()->where('inativado_por_nucleo_id', $nucleo->id)->get();

                $registros->each(fn (Model $registro) => $registro->forceFill([
                    'Status' => 1,
                    'inativado_por_nucleo_id' => null,
                ])->save());

                $contagem[$chave] = $registros->count();
            }

            // Pedidos de transferência que deixaram de fazer sentido.
            SolicitacaoTransferencia::query()
                ->pendentes()
                ->where('nucleo_origem_id', $nucleo->id)
                ->update(['status' => SolicitacaoTransferencia::CANCELADA]);

            return $contagem;
        });
    }

    /**
     * Perfis do usuário que estão inativos porque o Núcleo foi desativado.
     *
     * @return Collection<int, array{perfil:string, nucleo:?Nucleo, solicitacao:?SolicitacaoTransferencia}>
     */
    public function pendencias(User $user): Collection
    {
        $perfis = collect([
            'aluno' => $user->aluno,
            'professor' => $user->professor,
            'coordenador' => $user->coordenador,
        ])->filter(fn ($registro) => $registro
            && $registro->inativado_por_nucleo_id
            && (int) $registro->Status === 0);

        if ($perfis->isEmpty()) {
            return collect();
        }

        $solicitacoes = SolicitacaoTransferencia::query()
            ->pendentes()
            ->where('user_id', $user->id)
            ->with('nucleoDestino')
            ->get()
            ->keyBy('perfil');

        return $perfis->map(fn (Model $registro, string $perfil) => [
            'perfil' => $perfil,
            'nucleo' => Nucleo::find($registro->inativado_por_nucleo_id),
            'solicitacao' => $solicitacoes->get($perfil),
        ])->values();
    }

    public function solicitar(User $user, string $perfil, Nucleo $destino, ?string $mensagem): SolicitacaoTransferencia
    {
        $pendencia = $this->pendencias($user)->firstWhere('perfil', $perfil);

        $solicitacao = DB::transaction(function () use ($user, $perfil, $destino, $mensagem, $pendencia) {
            // Um pedido pendente por perfil: o novo substitui o anterior.
            SolicitacaoTransferencia::query()
                ->pendentes()
                ->where('user_id', $user->id)
                ->where('perfil', $perfil)
                ->update(['status' => SolicitacaoTransferencia::CANCELADA]);

            return SolicitacaoTransferencia::create([
                'user_id' => $user->id,
                'perfil' => $perfil,
                'nucleo_origem_id' => $pendencia['nucleo']?->id,
                'nucleo_destino_id' => $destino->id,
                'mensagem' => $mensagem,
                'status' => SolicitacaoTransferencia::PENDENTE,
            ]);
        });

        $this->avisarCoordenadores($solicitacao);

        return $solicitacao;
    }

    public function aprovar(SolicitacaoTransferencia $solicitacao, User $responsavel): void
    {
        DB::transaction(function () use ($solicitacao, $responsavel) {
            $destino = $solicitacao->nucleoDestino;
            $user = $solicitacao->user;

            match ($solicitacao->perfil) {
                'aluno' => $user->aluno?->forceFill([
                    'id_nucleo' => $destino->id,
                    'NomeNucleo' => $destino->NomeNucleo,
                    'Status' => 1,
                    'inativado_por_nucleo_id' => null,
                ])->save(),
                'professor' => $user->professor?->forceFill([
                    'id_nucleo' => $destino->id,
                    'Status' => 1,
                    'inativado_por_nucleo_id' => null,
                ])->save(),
                'coordenador' => $this->transferirCoordenador($user->coordenador, $destino),
            };

            $this->responder($solicitacao, SolicitacaoTransferencia::APROVADA, $responsavel);
        });

        $this->avisarSolicitante($solicitacao->fresh(), true);
    }

    public function recusar(SolicitacaoTransferencia $solicitacao, User $responsavel): void
    {
        $this->responder($solicitacao, SolicitacaoTransferencia::RECUSADA, $responsavel);

        $this->avisarSolicitante($solicitacao->fresh(), false);
    }

    /**
     * Administradores veem todos os pedidos; coordenadores, os dos Núcleos que coordenam.
     */
    public function podeResponder(User $user, SolicitacaoTransferencia $solicitacao): bool
    {
        if ($this->isAdministrador($user)) {
            return true;
        }

        return $this->nucleosCoordenados($user)->contains($solicitacao->nucleo_destino_id);
    }

    public function pendentesPara(User $user): Builder
    {
        $query = SolicitacaoTransferencia::query()
            ->pendentes()
            ->with(['user', 'nucleoOrigem', 'nucleoDestino'])
            ->latest();

        if ($this->isAdministrador($user)) {
            return $query;
        }

        return $query->whereIn('nucleo_destino_id', $this->nucleosCoordenados($user));
    }

    private function isAdministrador(User $user): bool
    {
        return $user->getRealRole() === 'administrador';
    }

    private function nucleosCoordenados(User $user): Collection
    {
        return $user->coordenador?->nucleos()->where('nucleos.Status', 1)->pluck('nucleos.id') ?? collect();
    }

    private function inativar(Builder $query, Nucleo $nucleo): int
    {
        // Um a um (e não com update em massa) para ficar registrado na auditoria.
        $registros = $query
            ->where(fn (Builder $q) => $q->where('Status', '!=', 0)->orWhereNull('Status'))
            ->get();

        $registros->each(fn (Model $registro) => $registro->forceFill([
            'Status' => 0,
            'inativado_por_nucleo_id' => $nucleo->id,
        ])->save());

        return $registros->count();
    }

    private function transferirCoordenador(?Coordenadores $coordenador, Nucleo $destino): void
    {
        if (! $coordenador) {
            return;
        }

        $coordenador->nucleos()->syncWithoutDetaching([$destino->id]);
        $coordenador->forceFill(['Status' => 1, 'inativado_por_nucleo_id' => null])->save();
    }

    private function responder(SolicitacaoTransferencia $solicitacao, string $status, User $responsavel): void
    {
        $solicitacao->update([
            'status' => $status,
            'respondido_por' => $responsavel->id,
            'respondido_em' => now(),
        ]);
    }

    private function avisarCoordenadores(SolicitacaoTransferencia $solicitacao): void
    {
        $emails = $solicitacao->nucleoDestino->coordenadores()
            ->where('coordenadores.Status', 1)
            ->pluck('Email')
            ->filter();

        // Núcleo sem coordenação ativa: o pedido vai para os administradores.
        if ($emails->isEmpty()) {
            $emails = User::query()->where('role', 'administrador')->pluck('email')->filter();
        }

        $nome = $solicitacao->user->name;
        $origem = $solicitacao->nucleoOrigem?->NomeNucleo ?? 'um Núcleo desativado';

        foreach ($emails->unique() as $email) {
            $this->enviar($email, new TransferenciaNucleoMail(
                assunto: 'Pedido de transferência para o '.$solicitacao->nucleoDestino->NomeNucleo,
                linhas: [
                    "{$nome} ({$solicitacao->perfil_formatado}) fazia parte de {$origem}, que foi desativado, e pediu para entrar no {$solicitacao->nucleoDestino->NomeNucleo}.",
                ],
                mensagem: $solicitacao->mensagem,
                link: route('transferencias.index'),
                textoLink: 'Ver e responder o pedido',
            ));
        }
    }

    private function avisarSolicitante(SolicitacaoTransferencia $solicitacao, bool $aprovada): void
    {
        $destino = $solicitacao->nucleoDestino->NomeNucleo;

        $this->enviar($solicitacao->user->email, new TransferenciaNucleoMail(
            assunto: $aprovada ? "Transferência aprovada: {$destino}" : "Pedido de transferência recusado: {$destino}",
            linhas: [
                $aprovada
                    ? "Seu pedido foi aprovado. Agora você faz parte do {$destino} e seu cadastro está ativo de novo."
                    : "A coordenação do {$destino} não aprovou seu pedido. Você pode escolher outro Núcleo ao entrar no sistema.",
            ],
            mensagem: null,
            link: url('/home'),
            textoLink: 'Entrar no sistema',
        ));
    }

    private function enviar(string $email, TransferenciaNucleoMail $mail): void
    {
        // O pedido já está salvo e aparece no painel: uma falha de e-mail não pode desfazê-lo.
        try {
            Mail::to($email)->send($mail);
        } catch (Throwable $e) {
            report($e);
        }
    }
}
