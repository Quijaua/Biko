@extends('layouts.app')

@section('content')
@php
    $user = Auth::user();
@endphp

    <div class="container">
        <div class="container">
            <!-- PAGE HEADER -->
            <div class="row">
                <div class="col-8">
                    <h1 class="text-[34px]">Material</h1>
                </div>
                <div class="col-4 text-center">
                    @if ($user->role != 'aluno')
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalAdicionarMaterial">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-user-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                </svg>
                            </span>
                            Adicionar novo material
                        </a>
                    @endif
                </div>
            </div>
            <div class="card mb-4 col-md-5">
                <div class="card-body">
                    <h2 class="visually-hidden">Filtros</h2>

                    <form class="row g-2 align-items-end" role="search">
                        <fieldset class="w-100 g-2 row">
                            <legend class="visually-hidden">Filtros avançados</legend>

                            <div class="col-md-12">
                                <h3 class="card-title mb-3 d-flex align-items-center">
                                    <span class="mx-2">
                                        <!-- ícone (ok) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal"
                                            aria-hidden="true" focusable="false">
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

                            {{-- Núcleo --}}
                            <div class="col-md-3">
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

                            {{-- Situação --}}
                            <div class="col-md-4">
                                <label for="status" class="visually-hidden">Situação</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" @selected(request('status') == '')>Situação</option>
                                    <option value="ativo" @selected(request('status') == 'ativo')>Ativos</option>
                                    <option value="inativo" @selected(request('status') == 'inativo')>Inativo</option>
                                </select>
                            </div>

                            {{-- Botões --}}
                            <div class="col-md-5 d-flex gap-2">
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
                        </fieldset>
                    </form>
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
        </div>

        <div class="container">
            <div class="rounded border border-gray-300">
                <h2 class="visually-hidden">Buscar materiais</h2>

                <form action="/files/search" method="POST" class="p-4 bg-white" role="search">
                    @csrf

                    <fieldset class="border rounded p-3">
                        <legend class="visually-hidden">Filtros de materiais</legend>

                        <div class="row g-2 align-items-center">
                        <div class="col-10">
                            <label for="inputQuery" class="visually-hidden">Buscar materiais</label>
                            <input
                            id="inputQuery"
                            type="text"
                            name="inputQuery"
                            class="form-control"
                            placeholder="Digite uma palavra-chave"
                            required
                            />
                        </div>

                        <div class="col-auto d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                            <i class="fas fa-search"></i> Buscar
                            </button>

                            <a href="/files" class="btn btn-light text-secondary">
                            Limpar
                            </a>
                        </div>
                        </div>
                    </fieldset>
                </form>

                <div>
                    @if ($files->isEmpty())
                        <div class="row">
                            <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
                        </div>
                    @endif

                    <div class="card">
                        <h2 class="visually-hidden">Lista de materiais</h2>

                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap text-black py-3">Data</th>
                                        <th class="text-nowrap text-black py-3">Título</th>
                                        <th class="text-nowrap text-black py-3">Enviado por</th>
                                        <th class="text-nowrap text-black py-3">Núcleo</th>
                                        <th class="text-nowrap text-black py-3">Status</th>
                                        <th class="text-nowrap text-black py-3">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white rounded">
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="text-secondary">{{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y') }}</td>
                                            <td class="text-secondary">{{ $file->name }}</td>
                                            <td class="text-secondary">{{ $file->user->name ?? 'Desconhecido' }}</td>
                                            <td class="text-secondary">{{ $file->nucleo->NomeNucleo ?? 'Desconhecido' }}</td>
                                            <td class="text-secondary">
                                                @if ($file->status)
                                                    <span class="d-flex align-center gap-2"> <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill=" #4263ec"
                                                            class="icon icon-tabler icons-tabler-filled icon-tabler-square-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M18.333 2c1.96 0 3.56 1.537 3.662 3.472l.005 .195v12.666c0 1.96 -1.537 3.56 -3.472 3.662l-.195 .005h-12.666a3.667 3.667 0 0 1 -3.662 -3.472l-.005 -.195v-12.666c0 -1.96 1.537 -3.56 3.472 -3.662l.195 -.005h12.666zm-2.626 7.293a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                                                        </svg>
                                                        Disponível</span>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-square">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                    Disponível</span>
                                                @endif
                                            </td>
                                            <td class="text-secondary">
                                                @if ($file->user_id === $user->id)
                                                <a href="#" class="btn btn-outline-primary p-2 open-modal-editar"
                                                data-url="{{ route('material.edit', ['id' => $file->id]) }}"
                                                data-file-id="{{ $file->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px;" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                </svg>
                                                
                                                Editar
                                                </a>
                                                @endif

                                                <a class="btn btn-outline-primary p-2"
                                                    href="{{ route('material.download', $file->id) }}"
                                                    target="_blank"><span><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M7 11l5 5l5 -5" />
                                                            <path d="M12 4l0 12" />
                                                        </svg></span>Baixar</a>
                                                @if ($user->role === 'professor' || $user->role === 'administrador' || $user->role === 'coordenador')
                                                    @if (($user->role === 'administrador' && $file->status == 1))
                                                        <div class="modal modal-blur fade" id="modalConfirmarInativar{{ $file->id }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title text-danger">Inativar Material
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Fechar modal"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <p class="mb-0">Deseja inativar este material?</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <a href="{{ route('nucleo.material.inactive', ['id' => $file->id]) }}"
                                                                            class="btn btn-danger"
                                                                            id="btnConfirmarInativar">
                                                                            Inativar
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-danger p-2"
                                                            data-bs-toggle="modal" data-bs-target="#modalConfirmarInativar{{ $file->id }}"
                                                            data-file-id="{{ $file->id }}">
                                                            Inativar
                                                        </a>
                                                    @elseif($user->role === 'administrador' && $file->status == 0)
                                                        <a class="btn btn-outline-warning p-2"
                                                            href="{{ route('nucleo.material.restore', ['id' => $file->id]) }}">Restaurar</a>
                                                    @endif
                                                    
                                                    @if (($user->role == 'professor' && $file->user_id == $user->id) || $user->role !== 'professor')
                                                    <div class="modal modal-blur fade" id="modalConfirmarExclusao{{ $file->id }}"
                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-danger">Excluir Material
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Fechar modal"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <p class="mb-0">Deseja excluir este material?
                                                                        Esta ação não podera ser desfeita após a
                                                                        confirmação.</p>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <form action="{{ route('nucleo.material.delete', ['id' => $file->id]) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <span>
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                    <path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z"/>
                                                                                    <path d="M9 8l6 8"/>
                                                                                    <path d="M15 8l-6 8"/>
                                                                                </svg>
                                                                            </span>
                                                                            Excluir
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-danger p-2"
                                                        data-bs-toggle="modal" data-bs-target="#modalConfirmarExclusao{{ $file->id }}">
                                                        Excluir
                                                    </a>
                                                    @endif
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-secondary">
                                Exibindo
                                <span id="start-entry">{{ $files->firstItem() ?? 0 }}</span>
                                até
                                <span id="end-entry">{{ $files->lastItem() ?? 0 }}</span>
                                de
                                <span id="total-entry">{{ $files->total() }}</span>
                                registros
                            </p>
                            <ul class="pagination m-0 ms-auto" id="pagination-custom">
                                {{-- Botão Anterior --}}
                                <li class="page-item {{ $files->onFirstPage() ? 'disabled' : '' }}" id="prev-page">
                                    <a class="page-link"
                                        href="{{ $files->onFirstPage() ? 'javascript:void(0);' : $files->previousPageUrl() }}"
                                        tabindex="-1"
                                        aria-disabled="{{ $files->onFirstPage() ? 'true' : 'false' }}">
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
                                        {{ $files->currentPage() }}
                                    </a>
                                </li>

                                {{-- Botão Próximo --}}
                                <li class="page-item {{ $files->hasMorePages() ? '' : 'disabled' }}" id="next-page">
                                    <a class="page-link"
                                        href="{{ $files->hasMorePages() ? $files->nextPageUrl() : 'javascript:void(0);' }}">
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
        @if ($user->role === 'professor' || $user->role === 'administrador' || $user->role === 'coordenador')
            <div class="modal modal-blur fade" id="modalAdicionarMaterial" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title text-primary">Adicionar novo material</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('nucleo.material.create') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-6">
                                        <label for="file" class="form-label">Escolher arquivo</label>
                                        <input class="form-control" type="file" name="file" id="file"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Título do material</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>

                                    @if ($user->role === 'administrador' || $user->role === 'coordenador')
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Núcleo</label>
                                            <select class="form-select" name="nucleo_id" required>
                                                @foreach ($nucleos as $nucleo)
                                                    <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" name="nucleo_id" value="{{ $nucleos->id }}">
                                    @endif
                                    <div class="col-12  text-end">
                                        <button class="btn btn-primary" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-upload">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                <path d="M12 11v6" />
                                                <path d="M9.5 13.5l2.5 -2.5l2.5 2.5" />
                                            </svg>
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

      <div class="modal modal-blur fade" id="modaleditar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-primary">Editar material</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar modal"></button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-center">
                <label class="form-label" style="text-align: left;">Editar título do material:</label>
                    <input type="text" name="title" class="form-control">
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">cancelar</button>
                    <button id="modaleditar_url" class="btn btn-primary"><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6" style="width: 16px;">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                      </svg>
                      </span> salvar</button>
                </div>
            </form>
          </div>
        </div>
      </div>

      <script>
        const btnsEditar = document.querySelectorAll('.open-modal-editar')
        btnsEditar.forEach(btnEditar => {
            btnEditar.addEventListener('click', e => {
                const modal = new bootstrap.Modal(modaleditar);
                modal.show();
                const urlModal = btnEditar.dataset.url
                const formModal = modaleditar.querySelector('form')
                formModal.action = urlModal
            })
        })
      </script>
      
    </div>
@endsection
