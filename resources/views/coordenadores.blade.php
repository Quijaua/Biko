@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- PAGE HEADER -->
        <div class="row">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h1 class="text-[34px]">Coordenadores (as)</h1>
                </div>
                <div class="col-4  text-center">
                    @if ($user->role != 'aluno' && $user->role != 'professor')
                        <a class="btn btn-primary" href="/coordenadores/add"><span><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                </svg></span>Adicionar novo coordenador</a>
                    @endif
                    @if ($user->role === 'coordenador')
                        <a class="btn btn-outline"
                            href="{{ route('coordenadores/export/') }}/?nucleo={{ $nucleo ?? '' }}"><span><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 15h6" />
                                    <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
                                </svg></span> Exportar</a>
                    @else
                        <a class="btn btn-outline-primary" href="{{ route('coordenadores/export/') }}/?nucleo=0">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 15h6" />
                                    <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
                                </svg></span>
                            Exportar</a>
                    @endif
                </div>
            </div>
        


            <div class="card mb-4 col-md-5">
                <div class="card-body">
                    <form class="row g-2 align-items-end">

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

                        {{-- Núcleo --}}
                        <div class="col-md-3">
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
                            <select class="form-select" id="status" name="status">
                                <option value="" @selected(request('status') == '')>Situação</option>
                                <option value="1" @selected(request('status') == '1')>Ativos</option>
                                <option value="0" @selected(request('status') == '0')>Inativo</option>
                            </select>
                        </div>

                        {{-- Botões --}}
                        <div class="col-md-5 d-flex gap-2">
                            <a class="btn btn-light w-100" id="limparFiltros">
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
        </div>
            <div class="container">
                <div class="rounded border border-gray-300">
                    <form action="/coordenadores/search" method="POST" class="p-4 bg-white" role="search">
                        <div class="col-10 d-flex align-items-center gap-2">
                            @csrf
                            <input type="text" name="inputQuery" class="form-control"
                                placeholder="Digite o nome ou sobrenome para encontrar um professor(a)" required />

                            <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                                <i class="fas fa-search"></i> Buscar
                            </button>

                            <a href="/coordenadores" class="btn btn-light text-secondary">
                                Limpar
                            </a>
                        </div>
                    </form>

                    <div>
                        @if ($coordenadores->isEmpty())
                            <p>Nenhum registro encontrado.</p>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap text-black py-3"></th>
                                        <th class="text-nowrap text-black py-3">Foto</th>
                                        <th class="text-nowrap text-black py-3">Nome</th>
                                        <th class="text-nowrap text-black py-3">Núcleo</th>
                                        <th class="text-nowrap text-black py-3">Situação</th>
                                        <th class="text-nowrap text-black py-3">Ações</th>
                                    </tr>

                                </thead>
                                <tbody class="bg-white rounded">
                                    @foreach ($coordenadores as $coordenador)
                                        <tr>
                                            <td><input type="checkbox" class="custom-checkbox" /></td>

                                            {{-- Foto --}}
                                            <td>
                                                <span class="avatar avatar-md rounded"
                                                    style="background-image: url('{{ $coordenador->Foto ? asset('storage/' . $coordenador->Foto) : asset('images/user.png') }}')"></span>
                                            </td>

                                            {{-- Nome --}}

                                            @if ($coordenador->NomeSocial === null)
                                                <td class="text-secondary">{{ $coordenador->NomeCoordenador }}</td>
                                            @else
                                                <td class="text-secondary">{{ $coordenador->NomeSocial }}</td>
                                            @endif
                                            {{-- NUCLEO --}}
                                            @php $nomeNucleo = \App\Nucleo::where('id', $coordenador->id_nucleo)->get('NomeNucleo'); @endphp
                                            @if($nomeNucleo->isEmpty())
                                            <td></td>
                                            @else
                                            <td class="text-secondary">{{ $nomeNucleo[0]['NomeNucleo'] }}</td>
                                            @endif


                                            {{-- Situação --}}
                                            <td>
                                                @if ($coordenador->Status === 1)
                                                    <span class="status-badge status-ativo">
                                                        Ativar
                                                    </span>
                                                @else
                                                    <span class="status-badge status-inativo">
                                                        Inativar
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Ações --}}
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="/coordenadores/details/{{ $coordenador->id }}"
                                                        class="btn btn-outline-secondary">
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path
                                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            </svg></span> Ver Detalhes
                                                    </a>
                                                    <a href="/coordenadores/edit/{{ $coordenador->id }}"
                                                        class="btn btn-primary">
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg></span> Editar
                                                    </a>
                                                    @if ($coordenador->Status === 1)
                                                        <a href="/coordenadores/disable/{{ $coordenador->id }}">
                                                            <span class="status-btn status-ativo">
                                                                Ativar
                                                                <span class="status-circle"></span>
                                                            </span>
                                                        </a>
                                                    @else
                                                        <a href="/coordenadores/enable/{{ $coordenador->id }}">
                                                            <span class="status-btn status-inativo">
                                                                <span class="status-circle"></span>
                                                                Inativar
                                                            </span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
        <div class="row" id="coordenadores-links">
            <div class="col">
                {{ $coordenadores->links() }}
            </div>
        </div>
    </div>

@endsection
