<?php

namespace App\Http\Controllers;

use App\Nucleo;
use App\Services\DesativacaoNucleoService;
use App\SolicitacaoTransferencia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransferenciaNucleoController extends Controller
{
    public function __construct(private DesativacaoNucleoService $service)
    {
    }

    /**
     * Pedido feito por quem teve o Núcleo desativado (formulário do aviso no topo da página).
     */
    public function solicitar(Request $request)
    {
        $user = $request->user();
        $pendencias = $this->service->pendencias($user);

        abort_if($pendencias->isEmpty(), 403);

        $origens = $pendencias->pluck('nucleo.id')->filter()->all();

        $dados = $request->validate([
            'perfil' => ['required', Rule::in($pendencias->pluck('perfil')->all())],
            'nucleo_destino_id' => [
                'required',
                'integer',
                Rule::exists('nucleos', 'id')->where('Status', 1),
                Rule::notIn($origens),
            ],
            'mensagem' => ['nullable', 'string', 'max:2000'],
        ], [
            'nucleo_destino_id.required' => 'Escolha o Núcleo para onde quer ir.',
            'nucleo_destino_id.exists' => 'Escolha um Núcleo ativo.',
            'nucleo_destino_id.not_in' => 'Escolha um Núcleo diferente do que foi desativado.',
        ]);

        $destino = Nucleo::findOrFail($dados['nucleo_destino_id']);

        $this->service->solicitar($user, $dados['perfil'], $destino, $dados['mensagem'] ?? null);

        // Mostrado dentro do próprio aviso, que reabre após o envio.
        return back()->with('transferencia_ok', "Pedido enviado para a coordenação do {$destino->NomeNucleo}. Você receberá a resposta por e-mail.");
    }

    /**
     * Pedidos aguardando resposta (coordenação do Núcleo de destino ou administradores).
     */
    public function index(Request $request)
    {
        return view('transferencias.index', [
            'solicitacoes' => $this->service->pendentesPara($request->user())->get(),
        ]);
    }

    public function aprovar(Request $request, SolicitacaoTransferencia $solicitacao)
    {
        $this->autorizar($request, $solicitacao);

        if (! $solicitacao->isPendente()) {
            return back()->with('error', 'Este pedido já foi respondido.');
        }

        $this->service->aprovar($solicitacao, $request->user());

        return back()->with('success', "Transferência de {$solicitacao->user->name} aprovada.");
    }

    public function recusar(Request $request, SolicitacaoTransferencia $solicitacao)
    {
        $this->autorizar($request, $solicitacao);

        if (! $solicitacao->isPendente()) {
            return back()->with('error', 'Este pedido já foi respondido.');
        }

        $this->service->recusar($solicitacao, $request->user());

        return back()->with('success', "Pedido de {$solicitacao->user->name} recusado.");
    }

    private function autorizar(Request $request, SolicitacaoTransferencia $solicitacao): void
    {
        abort_unless($this->service->podeResponder($request->user(), $solicitacao), 403);
    }
}
