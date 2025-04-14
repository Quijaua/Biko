@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <!-- PAGE HEADER -->
            <div class="row">
                <div class="col-8">
                    <h1 class="text-[34px]">Material</h1>
                </div>
                <div class="col-4  text-center">
                    @if ($user->role != 'aluno')
                        <a class="btn btn-primary" href="/nucleos/add"><span><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                </svg></span>Adicionar novo material</a>
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

                        {{-- Enviado por --}}
                        <div class="col-md-4">
                            <select class="form-select" id="status" name="status">
                                <option value="" @selected(request('status') == '')>Situação</option>
                                <option value="1" @selected(request('status') == '1')>Ativos</option>
                                <option value="0" @selected(request('status') == '0')>Inativo</option>
                            </select>
                        </div>

                        {{-- Botões --}}
                        <div class="col-md-5 d-flex gap-2">
                            <a class="btn btn-light w-100">
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
                <form action="/coordenadores/search" method="POST" class="p-4 bg-white" role="search">
                    <div class="col-10 d-flex align-items-center gap-2">
                        @csrf
                        <input type="text" name="inputQuery" class="form-control" placeholder="Digite uma palavra-chave"
                            required />

                        <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                            <i class="fas fa-search"></i> Buscar
                        </button>

                        <a href="/coordenadores" class="btn btn-light text-secondary">
                            Limpar
                        </a>
                    </div>
                </form>

                <div>
                    @if ($files->isEmpty())
                        <p>Nenhum registro encontrado.</p>
                    @endif

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
                                        <td class="text-secondary">{{ $file->created_at->format('d/m/Y') }}</td>
                                        <td class="text-secondary">{{ $file->name }}</td>
                                        <td class="text-secondary">{{ $file->user->name }}</td>
                                        <td class="text-secondary">{{ $file->nucleo->NomeNucleo }}</td>
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
                                            <a class="btn btn-outline-primary p-2"
                                                href="{{ asset('uploads') . '/' . $file->name }}"
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
                                                @if (($user->role === 'administrador' && $file->status) || $user->id === $file->user_id)
                                                    <a class="btn  btn-outline-danger p-2"
                                                        href="{{ route('nucleo.material.delete', ['id' => $file->id]) }}">Excluir</a>
                                                @elseif($user->role === 'administrador' && !$file->status)
                                                    <a class="btn  btn-outline-warning p-2"
                                                        href="{{ route('nucleo.material.restore', ['id' => $file->id]) }}">Restaurar</a>
                                                @endif
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
    </div>
@endsection
