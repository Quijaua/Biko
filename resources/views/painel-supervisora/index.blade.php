@extends('layouts.app')

@section('content')

<style>
    .cards-wrapper {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        padding-bottom: 12px;
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #007bff #f1f1f1; /* Cor barra no Firefox */
    }

    .cards-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .cards-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .cards-wrapper::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 4px;
    }

    .card-item {
        width: 320px; /* largura mínima do card */
        flex: 0 0 auto; /* impede encolhimento */
    }
    .card-link:hover {
        box-shadow: none !important;
    }
</style>

<div class="container">
    <h2>Painel da Supervisora</h2>

    <div class="card mb-4 col-md-5">
        <div class="card-body">
            <form method="GET" class="d-flex gap-2">
                <select name="ano" class="form-select">
                    <option value="">Todos os anos</option>
                    @for($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ $i == $ano ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>

                <select name="mes" class="form-select">
                    <option value="">Todos os meses</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $mes ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <button class="btn btn-primary">Filtrar</button>

                <div class="col-md-5 d-flex gap-2">
                    <a href="{{ route('painel.supervisora') }}" class="btn btn-light">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                            </svg>
                        </span>
                        Limpar filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="cards-wrapper">
        @foreach($atendimentos as $psicologoId => $lista)
            <div class="card shadow card-item">
                <div class="card-header bg-primary text-white">
                    {{ $lista->first()->criador->name }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($lista as $atendimento)
                            <li class="list-group-item">
                                <a href="/atendimento-psicologico/details/{{ $lista->first()->id }}" class="card-link">
                                    @php
                                        $statusColors = [
                                            'Novo' => 'blue',
                                            'Atendida/o' => 'green',
                                            'Cancelou' => 'yellow',
                                            'Não compareceu' => 'red',
                                            'Psi cancelou' => 'gray'
                                        ];
                                        $status = $atendimento->status ?? 'Novo';
                                        $color = $statusColors[$status] ?? 'default';
                                    @endphp

                                    @if ($status !== 'Novo')
                                    <span class="badge bg-{{ $color }} text-{{ $color }}-fg mb-1 {{ $status === 'Novo' ? 'd-none' : '' }}">
                                        {{ $status }}
                                    </span>
                                    <br>
                                    @endif

                                    <strong>
                                        {{ ucfirst(\Carbon\Carbon::parse($atendimento->data_atendimento ?: $atendimento->created_at)->translatedFormat('l, d \d\e F')) }} • 
                                        {{ \Carbon\Carbon::parse($atendimento->data_atendimento ?: $atendimento->created_at)->format('H:i') }}
                                    </strong><br>
                                    Estudante: {{ $atendimento->estudante->NomeAluno }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection