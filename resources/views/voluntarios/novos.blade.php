@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- PAGE HEADER -->
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
                    <h1 class="fs-1">Novos Voluntários</h1>
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
                            @if ($professores->isEmpty())
                            <div class="row">
                                <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
                            </div>
                            @endif

                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap text-black py-3">Nome</th>
                                                <th class="text-nowrap text-black py-3">Projeto (Núcleo)</th>
                                                <th class="text-nowrap text-black py-3">Data do Cadastro</th>
                                            </tr>

                                        </thead>
                                        <tbody class="bg-white rounded">
                                            @foreach ($professores as $professor)
                                                <tr>
                                                    {{-- Nome --}}
                                                    <td>
                                                        <a href="/professores/details/{{ $professor->id }}">
                                                            {{ $professor->NomeProfessor }}
                                                        </a>
                                                    </td>

                                                    {{-- Nucleo --}}
                                                    <td class="text-secondary">{{ $professor->nucleo->NomeNucleo ?? 'N/A' }}</td>

                                                    {{-- Data --}}
                                                    <td class="text-secondary">{{ $professor->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">
                                        Exibindo
                                        <span id="start-entry">{{ $professores->firstItem() ?? 0 }}</span>
                                        até
                                        <span id="end-entry">{{ $professores->lastItem() ?? 0 }}</span>
                                        de
                                        <span id="total-entry">{{ $professores->total() }}</span>
                                        registros
                                    </p>
                                    <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                        {{-- Botão Anterior --}}
                                        <li class="page-item {{ $professores->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                            <a class="page-link"
                                                href="{{ $professores->onFirstPage() ? 'javascript:void(0);' : $professores->previousPageUrl() }}"
                                                tabindex="-1"
                                                aria-disabled="{{ $professores->onFirstPage() ? 'true' : 'false' }}">
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
                                                {{ $professores->currentPage() }}
                                            </a>
                                        </li>

                                        {{-- Botão Próximo --}}
                                        <li class="page-item {{ $professores->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                            <a class="page-link"
                                                href="{{ $professores->hasMorePages() ? $professores->nextPageUrl() : 'javascript:void(0);' }}">
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