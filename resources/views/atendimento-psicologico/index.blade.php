@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                        @if(session('import_errors'))
                            <ul style="margin-top: 0.5rem;">
                                @foreach(session('import_errors') as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 col-md-6">
                        <h1 class="fs-1">Atendimentos Psicológicos</h1>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        <div class="btn-list flex-nowrap justify-content-end">
                                <a class="btn btn-primary" href="/atendimento-psicologico/create"><span><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg></span>Cadastrar Atendimento Psicológico</a>
                        </div>
                    </div>
                </div>
                <div class="rounded border border-gray-300 mt-4">
                    <form action="/atendimento-psicologico/search" method="POST" class="p-4 bg-white" role="search">
                        <div class="col-10 d-flex align-items-center gap-2">
                            @csrf
                            <input type="text" name="inputQuery" class="form-control"
                                placeholder="Digite o nome ou sobrenome para encontrar estudante" required />

                            <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                                <i class="fas fa-search"></i> Buscar
                            </button>

                            <a href="/atendimento-psicologico" class="btn btn-light text-secondary">
                                Limpar
                            </a>
                        </div>
                    </form>

                    <div>
                        @if ($atendimento_psicologico->isEmpty())
                        <div class="row">
                            <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
                        </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-novos" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Meus Novos Prontuários</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-todos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab">Todos Prontuários</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    {{-- Aba Novos --}}
                                    <div class="tab-pane active show" id="tabs-novos" role="tabpanel">
                                        @if($atendimento_psicologico->where('status', '')->isEmpty())
                                            <div class="text-center text-secondary">Nenhum registro novo encontrado.</div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-hover table-vcenter">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Estudante</th>
                                                            <th>Data do Atendimento</th>
                                                            <th>Responsável</th>
                                                            <th>Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($atendimento_psicologico->where('status', '') as $psicologo)
                                                            <tr>
                                                                <td><input type="checkbox" class="custom-checkbox" /></td>

                                                                <td class="text-secondary">
                                                                    @if($psicologo->estudante)
                                                                        <a href="{{ route('atendimento-psicologico.estudante', $psicologo->estudante->id) }}">
                                                                            {{ $psicologo->estudante->NomeAluno }}
                                                                        </a>
                                                                    @else
                                                                        Estudante não vinculado
                                                                    @endif
                                                                </td>

                                                                <td class="text-secondary">
                                                                    {{ \Carbon\Carbon::parse($psicologo->data_atendimento ?: $psicologo->created_at)->format('d/m/Y H:i') }}
                                                                </td>

                                                                <td class="text-secondary">{{ $psicologo->criador->name ?? 'N/A' }}</td>

                                                                {{-- Ações --}}
                                                                <td>
                                                                    <div class="btn-list flex-nowrap">
                                                                        <a href="/atendimento-psicologico/details/{{ $psicologo->id }}"
                                                                            class="btn btn-outline-secondary">
                                                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                                        fill="none" />
                                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                                    <path
                                                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                                </svg></span> Ver Detalhes
                                                                        </a>
                                                                        <a href="/atendimento-psicologico/edit/{{ $psicologo->id }}"
                                                                            class="btn btn-primary">
                                                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                                        fill="none" />
                                                                                    <path
                                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                                    <path
                                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                                    <path d="M16 5l3 3" />
                                                                                </svg></span> Editar
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer d-flex align-items-center">
                                                <p class="m-0 text-secondary">
                                                    Exibindo
                                                    <span id="start-entry">{{ $atendimento_psicologico->firstItem() ?? 0 }}</span>
                                                    até
                                                    <span id="end-entry">{{ $atendimento_psicologico->lastItem() ?? 0 }}</span>
                                                    de
                                                    <span id="total-entry">{{ $atendimento_psicologico->total() }}</span>
                                                    registros
                                                </p>
                                                <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                                    {{-- Botão Anterior --}}
                                                    <li class="page-item {{ $atendimento_psicologico->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                                        <a class="page-link"
                                                            href="{{ $atendimento_psicologico->onFirstPage() ? 'javascript:void(0);' : $atendimento_psicologico->previousPageUrl() }}"
                                                            tabindex="-1"
                                                            aria-disabled="{{ $atendimento_psicologico->onFirstPage() ? 'true' : 'false' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon">
                                                                <path d="M15 6l-6 6l6 6"></path>
                                                            </svg>
                                                            anterior
                                                        </a>
                                                    </li>

                                                    {{-- Página Atual (somente número) --}}
                                                    <li class="page-item active" id="current-page">
                                                        <a class="page-link" href="javascript:void(0);">
                                                            {{ $atendimento_psicologico->currentPage() }}
                                                        </a>
                                                    </li>

                                                    {{-- Botão Próximo --}}
                                                    <li class="page-item {{ $atendimento_psicologico->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                                        <a class="page-link"
                                                            href="{{ $atendimento_psicologico->hasMorePages() ? $atendimento_psicologico->nextPageUrl() : 'javascript:void(0);' }}">
                                                            próximo
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon">
                                                                <path d="M9 6l6 6l-6 6"></path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Aba Todos --}}
                                    <div class="tab-pane" id="tabs-todos" role="tabpanel">
                                        @if ($atendimento_psicologico->isEmpty())
                                            <div class="text-center text-secondary">Nenhum registro encontrado.</div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-hover table-vcenter">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Estudante</th>
                                                            <th>Criado em</th>
                                                            <th>Responsável</th>
                                                            <th>Status</th>
                                                            <th>Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($atendimento_psicologico as $psicologo)
                                                            <tr>
                                                                <td><input type="checkbox" class="custom-checkbox" /></td>

                                                                <td class="text-secondary">
                                                                    @if($psicologo->estudante)
                                                                        <a href="{{ route('atendimento-psicologico.estudante', $psicologo->estudante->id) }}">
                                                                            {{ $psicologo->estudante->NomeAluno }}
                                                                        </a>
                                                                    @else
                                                                        Estudante não vinculado
                                                                    @endif
                                                                </td>

                                                                <td class="text-secondary">
                                                                    {{ $psicologo->data_atendimento ? \Carbon\Carbon::parse($psicologo->data_atendimento)->format('d/m/Y H:i') : 'Data não definida' }}
                                                                </td>

                                                                <td class="text-secondary">{{ $psicologo->criador->name ?? 'N/A' }}</td>

                                                                <td>
                                                                    @php
                                                                        $statusColors = [
                                                                            'Novo' => 'blue',
                                                                            'Atendida/o' => 'green',
                                                                            'Cancelou' => 'yellow',
                                                                            'Não compareceu' => 'red',
                                                                            'Psi cancelou' => 'gray'
                                                                        ];
                                                                        $status = $psicologo->status ?? 'Novo';
                                                                        $color = $statusColors[$status] ?? 'default';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $color }} text-{{ $color }}-fg">{{ $status }}</span>
                                                                </td>

                                                                {{-- Ações --}}
                                                                <td>
                                                                    <div class="btn-list flex-nowrap">
                                                                        <a href="/atendimento-psicologico/details/{{ $psicologo->id }}"
                                                                            class="btn btn-outline-secondary">
                                                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                                        fill="none" />
                                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                                    <path
                                                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                                </svg></span> Ver Detalhes
                                                                        </a>
                                                                        <a href="/atendimento-psicologico/edit/{{ $psicologo->id }}"
                                                                            class="btn btn-primary">
                                                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                                        fill="none" />
                                                                                    <path
                                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                                    <path
                                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                                    <path d="M16 5l3 3" />
                                                                                </svg></span> Editar
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer d-flex align-items-center">
                                                <p class="m-0 text-secondary">
                                                    Exibindo
                                                    <span id="start-entry">{{ $atendimento_psicologico->firstItem() ?? 0 }}</span>
                                                    até
                                                    <span id="end-entry">{{ $atendimento_psicologico->lastItem() ?? 0 }}</span>
                                                    de
                                                    <span id="total-entry">{{ $atendimento_psicologico->total() }}</span>
                                                    registros
                                                </p>
                                                <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                                    {{-- Botão Anterior --}}
                                                    <li class="page-item {{ $atendimento_psicologico->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                                        <a class="page-link"
                                                            href="{{ $atendimento_psicologico->onFirstPage() ? 'javascript:void(0);' : $atendimento_psicologico->previousPageUrl() }}"
                                                            tabindex="-1"
                                                            aria-disabled="{{ $atendimento_psicologico->onFirstPage() ? 'true' : 'false' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon">
                                                                <path d="M15 6l-6 6l6 6"></path>
                                                            </svg>
                                                            anterior
                                                        </a>
                                                    </li>

                                                    {{-- Página Atual (somente número) --}}
                                                    <li class="page-item active" id="current-page">
                                                        <a class="page-link" href="javascript:void(0);">
                                                            {{ $atendimento_psicologico->currentPage() }}
                                                        </a>
                                                    </li>

                                                    {{-- Botão Próximo --}}
                                                    <li class="page-item {{ $atendimento_psicologico->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                                        <a class="page-link"
                                                            href="{{ $atendimento_psicologico->hasMorePages() ? $atendimento_psicologico->nextPageUrl() : 'javascript:void(0);' }}">
                                                            próximo
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon">
                                                                <path d="M9 6l6 6l-6 6"></path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection