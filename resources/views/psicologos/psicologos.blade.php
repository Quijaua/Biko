@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- PAGE HEADER -->
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="fs-1">Psicólogos (as)</h1>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <div class="btn-list flex-nowrap justify-content-end">
                        @if ($user->role != 'aluno' && $user->role != 'psicologo')
                            <a class="btn btn-primary" href="{{ route('painel.supervisora') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-layout-kanban">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 4l6 0" />
                                    <path d="M14 4l6 0" />
                                    <path d="M4 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    <path d="M14 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                </svg>
                                {{ __('Painel da Supervisora') }}
                            </a>

                            <a class="btn btn-primary" href="/psicologos/add">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                </svg>
                                Adicionar novo psicólogo
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if (\Session::has('success'))
            <div class="row mt-2">
                <div class="col-6 m-auto">
                    <div class="alert alert-success text-center" role="alert">
                        {!! \Session::get('success') !!}
                    </div>
                </div>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="row mt-2">
                <div class="col-6 m-auto">
                    <div class="alert alert-danger text-center" role="alert">
                        {!! \Session::get('error') !!}
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col mt-4">
                <div class="container">
                    <div class="rounded border border-gray-300">
                        <form action="/psicologos/search" method="POST" class="p-4 bg-white" role="search">
                            <div class="col-10 d-flex align-items-center gap-2">
                                @csrf
                                <input type="text" name="inputQuery" class="form-control"
                                    placeholder="Digite o nome ou sobrenome para encontrar um psicologo(a)" required />

                                <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                                    <i class="fas fa-search"></i> Buscar
                                </button>

                                <a href="/psicologos" class="btn btn-light text-secondary">
                                    Limpar
                                </a>
                            </div>
                        </form>

                        <div>
                            @if ($psicologos->isEmpty())
                            <div class="row">
                                <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
                            </div>
                            @endif

                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap text-black py-3"></th>
                                                <th class="text-nowrap text-black py-3">Nome</th>
                                                <th class="text-nowrap text-black py-3">CRP</th>
                                                <th class="text-nowrap text-black py-3">Telefone</th>
                                                <th class="text-nowrap text-black py-3">E-mail</th>
                                                <th class="text-nowrap text-black py-3">Ações</th>
                                            </tr>

                                        </thead>
                                        <tbody class="bg-white rounded">
                                            @foreach ($psicologos as $psicologo)
                                                <tr>
                                                    <td><input type="checkbox" class="custom-checkbox" /></td>

                                                    {{-- Nome --}}
                                                    <td class="text-secondary">{{ $psicologo->nome }}</td>

                                                    {{-- CRP --}}
                                                    <td class="text-secondary">{{ $psicologo->crp }}</td>

                                                    {{-- Telefone --}}
                                                    <td class="text-secondary">{{ $psicologo->telefone }}</td>

                                                    {{-- E-mail --}}
                                                    <td class="text-secondary">{{ $psicologo->email }}</td>

                                                    {{-- Ações --}}
                                                    <td>
                                                        <div class="btn-list flex-nowrap">
                                                            <a href="/psicologos/details/{{ $psicologo->id }}"
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
                                                            <a href="/psicologos/edit/{{ $psicologo->id }}"
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
                                        <span id="start-entry">{{ $psicologos->firstItem() ?? 0 }}</span>
                                        até
                                        <span id="end-entry">{{ $psicologos->lastItem() ?? 0 }}</span>
                                        de
                                        <span id="total-entry">{{ $psicologos->total() }}</span>
                                        registros
                                    </p>
                                    <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                        {{-- Botão Anterior --}}
                                        <li class="page-item {{ $psicologos->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                            <a class="page-link"
                                                href="{{ $psicologos->onFirstPage() ? 'javascript:void(0);' : $psicologos->previousPageUrl() }}"
                                                tabindex="-1"
                                                aria-disabled="{{ $psicologos->onFirstPage() ? 'true' : 'false' }}">
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
                                                {{ $psicologos->currentPage() }}
                                            </a>
                                        </li>

                                        {{-- Botão Próximo --}}
                                        <li class="page-item {{ $psicologos->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                            <a class="page-link"
                                                href="{{ $psicologos->hasMorePages() ? $psicologos->nextPageUrl() : 'javascript:void(0);' }}">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection