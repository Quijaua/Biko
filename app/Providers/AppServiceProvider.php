<?php

namespace App\Providers;

use App\Aluno;
use App\Nucleo;
use App\Policies\AlunoPolicy;
use App\Policies\ProfessorPolicy;
use App\Professores;
use App\Services\DesativacaoNucleoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Antes em AuthServiceProvider. Os nomes não seguem a convenção
        // App\Models\X -> App\Policies\XPolicy, então o registro é explícito.
        Gate::policy(Aluno::class, AlunoPolicy::class);
        Gate::policy(Professores::class, ProfessorPolicy::class);

        // Listeners: descobertos automaticamente em app/Listeners
        // (SendMessageAlunoEmail escuta MessageCreated).

        View::composer('layouts.app', function ($view) {
            $this->compartilharAvisosDeTransferencia($view);
        });
    }

    /**
     * Dados do aviso "Núcleo desativado" (botão no topo + modal) e do
     * contador de pedidos de transferência para coordenação/administração.
     */
    private function compartilharAvisosDeTransferencia($view): void
    {
        $user = Auth::user();
        $dados = [
            'transfPendencias' => collect(),
            'transfNucleosAtivos' => collect(),
            'transfPedidosPendentes' => 0,
            'transfAbrirAviso' => false,
            'transfPerfis' => ['aluno' => 'estudante', 'professor' => 'professor(a)', 'coordenador' => 'coordenador(a)'],
        ];

        if (! $user) {
            $view->with($dados);

            return;
        }

        $service = $this->app->make(DesativacaoNucleoService::class);
        $pendencias = $service->pendencias($user);

        if ($pendencias->isNotEmpty()) {
            $origens = $pendencias->pluck('nucleo.id')->filter()->all();

            $dados['transfPendencias'] = $pendencias;
            $dados['transfNucleosAtivos'] = Nucleo::query()
                ->where('Status', 1)
                ->whereNotIn('id', $origens)
                ->orderBy('NomeNucleo')
                ->get(['id', 'NomeNucleo', 'Cidade', 'Estado']);

            // Abre sozinho uma vez por sessão (se ainda não há pedido), e sempre
            // depois de enviar o pedido ou de um erro no formulário.
            $semPedido = $pendencias->contains(fn ($p) => $p['solicitacao'] === null);
            $errosNoFormulario = session('errors')?->hasAny(['nucleo_destino_id', 'mensagem', 'perfil']) ?? false;

            $dados['transfAbrirAviso'] = session()->has('transferencia_ok')
                || $errosNoFormulario
                || ($semPedido && ! session()->has('aviso_nucleo_desativado_exibido'));

            session()->put('aviso_nucleo_desativado_exibido', true);
        }

        if (in_array($user->getRealRole(), ['administrador', 'coordenador'], true)) {
            $dados['transfPedidosPendentes'] = $service->pendentesPara($user)->count();
        }

        $view->with($dados);
    }
}
