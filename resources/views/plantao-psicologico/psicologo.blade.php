@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- PAGE HEADER -->
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1 class="fs-1">Seus Plantões Psicológicos</h1>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <div class="btn-list flex-nowrap justify-content-end">
                        <a class="btn btn-primary" href="/plantao-psicologico/add"><span><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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

                                </svg></span>Adicionar nova data</a>
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
                        <div>
                            @if ($plantoes->isEmpty())
                            <div class="row">
                                <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
                            </div>
                            @endif

                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap text-black py-3">Data</th>
                                                <th class="text-nowrap text-black py-3">Hora</th>
                                                <th class="text-nowrap text-black py-3">Ações</th>
                                            </tr>

                                        </thead>
                                        <tbody class="bg-white rounded">
                                            @foreach ($plantoes as $psicologo)
                                                <tr>
                                                    <td class="text-secondary">{{ \Carbon\Carbon::parse($psicologo->data)->format('d/m/Y') }}</td>

                                                    <td class="text-secondary">{{ \Carbon\Carbon::parse($psicologo->horario)->format('H:i') }}</td>

                                                    {{-- Ações --}}
                                                    <td>
                                                        <div class="btn-list flex-nowrap">
                                                            <a href="/plantao-psicologico/edit/{{ $psicologo->id }}"
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
                                        <span id="start-entry">{{ $plantoes->firstItem() ?? 0 }}</span>
                                        até
                                        <span id="end-entry">{{ $plantoes->lastItem() ?? 0 }}</span>
                                        de
                                        <span id="total-entry">{{ $plantoes->total() }}</span>
                                        registros
                                    </p>
                                    <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                        {{-- Botão Anterior --}}
                                        <li class="page-item {{ $plantoes->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                            <a class="page-link"
                                                href="{{ $plantoes->onFirstPage() ? 'javascript:void(0);' : $plantoes->previousPageUrl() }}"
                                                tabindex="-1"
                                                aria-disabled="{{ $plantoes->onFirstPage() ? 'true' : 'false' }}">
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
                                                {{ $plantoes->currentPage() }}
                                            </a>
                                        </li>

                                        {{-- Botão Próximo --}}
                                        <li class="page-item {{ $plantoes->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                            <a class="page-link"
                                                href="{{ $plantoes->hasMorePages() ? $plantoes->nextPageUrl() : 'javascript:void(0);' }}">
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