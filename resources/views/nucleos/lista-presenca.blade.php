@extends('layouts.app')

@section('content')
    <div class="container">

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
        <div class="container">

            <form name="listaPresencaForm" action="{{ route('nucleo/presences/new') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-10">
                        <h1 class="text-[34px]">Listas de Presença</h1>
                    </div>
                    <div class="col-2">
                        @if (Session::get('role') == 'professor')
                            <div class="row">
                                <div>
                                    <button class="btn btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M16 19h6" />
                                            <path d="M19 16v6" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                        </svg>Adicionar nova Lista</button>
                                </div>
                        @endif
                    </div>
                </div>
                <div class="card col-md-5">
                    <div class="card-body">
                        <h2 class="visually-hidden">Filtros</h2>    

                        <div class="col-md-12">
                            <h3 class="card-title mb-3 d-flex align-items-center">
                                <span class="mx-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M4 6l8 0" />
                                        <path d="M16 6l4 0" />
                                        <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M4 12l2 0" />
                                        <path d="M10 12l10 0" />
                                        <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M4 18l11 0" />
                                        <path d="M19 18l1 0" />
                                    </svg>
                                </span>
                                Filtros avançados
                            </h3>
                        </div>

                        <div class="row">
                            {{-- Núcleo --}}
                            <div class="col-md-4" style="margin-top: 20px;">
                                <label for="nucleo" class="visually-hidden">Núcleo</label>
                                <select class="form-select" id="nucleo" name="nucleo">
                                    <option value="" @selected(request('nucleo') == '')>Núcleo</option>
                                    @foreach (\App\Nucleo::all() as $nuc)
                                        <option value="{{ $nuc->id }}" @selected(request('nucleo') == $nuc->id)>
                                            {{ $nuc->NomeNucleo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Periodo --}}
                            <div class="col-4">
                                <?php $today = \Carbon\Carbon::now()->format('Y-m-d'); ?>
                                <label for="date">Período de</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    aria-describedby="dateHelp" max="{{ $today }}" value="{{ request('date') }}">
                            </div>

                            {{-- Botões --}}
                            <div class="col-md-4" style="margin-top: 20px;">
                                <button type="button" class="btn btn-light w-100" id="limparFiltros">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"
                                            aria-hidden="true" focusable="false">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                        </svg>
                                    </span>
                                    Limpar filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    @if (Session::get('role') === 'administrador')
                    <div class="col-12">
                        <div class="mb-3 d-flex justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $nucleo->NomeNucleo }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach (\App\Nucleo::all() as $nucleo)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('nucleo/presences', ['nid' => $nucleo->id]) }}">{{ $nucleo->NomeNucleo }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <div class="container">
            <div class="rounded border border-gray-300">
                <form action="/nucleo/presences/search" method="POST" class="p-4 bg-white" role="search">
                    <div class="col-10 d-flex align-items-center gap-2">
                        @csrf
                        <label for="inputQuery" class="visually-hidden">Nome do núcleo</label>

                        <input type="text" name="inputQuery" class="form-control"
                            placeholder="Digite o nome do núcleo" required />

                        <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                            <i class="fas fa-search"></i> Buscar
                        </button>

                        <a href="/nucleo/presences" class="btn btn-light text-secondary">
                            Limpar
                        </a>
                    </div>
                </form>

                <div>
                    <h2 class="visually-hidden">Listas de presença cadastradas</h2>    

                    <div class="table-responsive" id="presences_wrapper">
                        <table class="table table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-nowrap text-black py-3"><span class="visually-hidden">Selecionar</span></th>
                                    <th scope="col" scope="text-nowrap text-black py-3">Data</th>
                                    <th scope="col" scope="text-nowrap text-black py-3">Núcleo</th>
                                    <th scope="col" scope="text-nowrap text-black py-3">Ações</th>

                                </tr>

                            </thead>
                            <tbody class="bg-white rounded">
                                @foreach ($nucleo->listas_presenca as $lista)
                                    <tr>
                                        <td><input type="checkbox" class="custom-checkbox" aria-label="Selecionar lista de presença do dia {{ $lista->date->format('d/m/Y') }}" /></td>
                                        <td class="text-secondary">{{ $lista->date->format('d/m/Y') }}</td>
                                        <td class="text-secondary">{{ $nucleo->NomeNucleo }}</td>
                                        <td class="text-secondary">
                                            @if (Session::get('role') === 'administrador')
                                                -
                                            @else
                                                <a class="btn btn-primary mb-2"
                                                    href="{{ route('nucleo/presences/new', ['date' => $lista->date->format('Y-m-d')]) }}"><span><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M11.192 17.966c-3.242 -.28 -5.972 -2.269 -8.192 -5.966c2.4 -4 5.4 -6 9 -6c3.326 0 6.14 1.707 8.442 5.122" />
                                                            <path
                                                                d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                                        </svg></span>Ver/Editar</a>

                                                <div class="modal modal-blur fade" id="modalConfirmarExclusao"
                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h2 class="modal-title text-danger">Excluir Núcleo</h2>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Fechar modal"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p class="mb-0">Deseja excluir este núcleo?
                                                                    Esta ação não podera ser desfeita após a confirmação.
                                                                </p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">cancelar</button>
                                                                <a href="{{ route('nucleo/presences/destroy', ['id' => $lista->id]) }} "
                                                                    class="btn btn-danger"
                                                                    id="btnConfirmarExclusao"><span><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path
                                                                                d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
                                                                            <path d="M9 8l6 8" />
                                                                            <path d="M15 8l-6 8" />
                                                                        </svg></span> excluir</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-outline-danger mb-2"
                                                    data-bs-toggle="modal" data-bs-target="#modalConfirmarExclusao"
                                                    data-file-id="{{ $lista->id }}">
                                                    Excluir
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h2>Estudantes com ausência</h2>
            </div>
        </div>

        <div class="row">
            <div class="col">
                @foreach ($alunos as $aluno)
                    @if (count($aluno->ausencias) > 0)
                        <h3>{{ $aluno->NomeAluno }}</h3>
                        <p><b>Faltas: </b>{{ count($aluno->ausencias) }}</p>
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
@stop
