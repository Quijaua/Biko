@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 p-3">
            <h1 class="page-title mb-3">Pedidos de transferência de Núcleo</h1>

            <p class="text-secondary">
                Pessoas cujo Núcleo foi desativado e que pediram para entrar em um Núcleo que você coordena.
                Ao aprovar, o cadastro passa para o novo Núcleo e volta a ficar ativo.
            </p>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></a>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></a>
                </div>
            @endif

            <div class="card">
                @if ($solicitacoes->isEmpty())
                    <div class="card-body">
                        <p class="mb-0">Nenhum pedido aguardando resposta.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Pessoa</th>
                                    <th>Perfil</th>
                                    <th>Núcleo desativado</th>
                                    <th>Quer ir para</th>
                                    <th>Mensagem</th>
                                    <th>Pedido em</th>
                                    <th class="w-1"><span class="visually-hidden">Ações</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitacoes as $solicitacao)
                                    <tr>
                                        <td>
                                            {{ $solicitacao->user->name }}
                                            <div class="small text-secondary">{{ $solicitacao->user->email }}</div>
                                        </td>
                                        <td>{{ $solicitacao->perfil_formatado }}</td>
                                        <td>{{ $solicitacao->nucleoOrigem?->NomeNucleo ?? '—' }}</td>
                                        <td>{{ $solicitacao->nucleoDestino->NomeNucleo }}</td>
                                        <td style="white-space: pre-line; max-width: 24rem;">{{ $solicitacao->mensagem ?: '—' }}</td>
                                        <td>{{ $solicitacao->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <form method="POST" action="{{ route('transferencias.aprovar', $solicitacao) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Aprovar</button>
                                                </form>
                                                <form method="POST" action="{{ route('transferencias.recusar', $solicitacao) }}"
                                                      data-confirmacao="Recusar o pedido de {{ $solicitacao->user->name }}?"
                                                      onsubmit="return confirm(this.dataset.confirmacao)">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Recusar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
