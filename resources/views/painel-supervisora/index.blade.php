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
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="fs-1">Apoio Emocional</h1>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <div class="btn-list flex-nowrap justify-content-end">
                        <a class="btn btn-primary" href="/psicologos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brain">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M15.5 13a3.5 3.5 0 0 0 -3.5 3.5v1a3.5 3.5 0 0 0 7 0v-1.8" />
                                <path d="M8.5 13a3.5 3.5 0 0 1 3.5 3.5v1a3.5 3.5 0 0 1 -7 0v-1.8" />
                                <path d="M17.5 16a3.5 3.5 0 0 0 0 -7h-.5" />
                                <path d="M19 9.3v-2.8a3.5 3.5 0 0 0 -7 0" />
                                <path d="M6.5 16a3.5 3.5 0 0 1 0 -7h.5" />
                                <path d="M5 9.3v-2.8a3.5 3.5 0 0 1 7 0v10" />
                            </svg>
                            {{ __('Psicólogas (os)') }}
                        </a>

                        <a class="btn btn-primary" href="/atendimento-psicologico">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                <path d="M11 3v2" /><path d="M6 3v2" />
                                <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            </svg>
                            Prontuários
                        </a>

                        <a class="btn btn-primary" href="/plantao-psicologico">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M7 14h.013" />
                                <path d="M10.01 14h.005" />
                                <path d="M13.01 14h.005" />
                                <path d="M16.015 14h.005" />
                                <path d="M13.015 17h.005" />
                                <path d="M7.01 17h.005" />
                                <path d="M10.01 17h.005" />
                            </svg>
                            Agenda
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 col-md-8">
            <div class="row card-body">
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
                                <a href="/atendimento-psicologico/details/{{ $atendimento->id }}" class="card-link">
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
                                    Estudante: {{ optional($atendimento->estudante)->NomeAluno ?? 'Sem estudante' }}
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