@extends('layouts.app')

@inject('session', 'Session')

@section('content')

<div class="page-wrapper">

    <!-- PAGE HEADER -->
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <h1 class="text-[34px]">EAD</h1>
            </div>
            @if(\Auth::user()->role != 'aluno')
            <div class="col-6" style="text-align: right;">
                
                <a class="btn btn-primary" href="{{ route('ead.create') }}">
                    <span>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" /><path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /></svg>      
                    </span>
                    Adicionar novo evento
                </a>
                
            </div>
            @endif
        </div>
        @if(session::has('success'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-success text-center" role="alert">
                    {!! \Session::get('success') !!}
                </div>
            </div>
        </div>
        @endif
        @if(session::has('error'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! \Session::get('error') !!}
                </div>
            </div>
        </div>
        @endif
    </div>


    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards">
                @if($eads->isEmpty())
                <p>Nenhum registro encontrado.</p>
                @else
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                            <th class="text-nowrap text-black py-3">Título</th>
                            <th class="text-nowrap text-black py-3">Data</th>
                            <th class="text-nowrap text-black py-3">Horário Inicial</th>
                            <th class="text-nowrap text-black py-3">Horário Final</th>
                            <th class="text-nowrap text-black py-3">Inscritos</th>
                            <th class="text-nowrap text-black py-3">Ações</th>
                            </tr>

                        </thead>
                        <tbody class="bg-white rounded">
                            @foreach($eads as $ead)
                            <tr>
                                {{-- Titulo --}}
                                <td>
                                    {{ $ead->titulo }}
                                </td>

                                {{-- Data --}}
                                <td>{{ $ead->data->format('d/m/Y') }}</td>

                                {{-- Horario inicio --}}
                                <td>
                                    {{ $ead->hora_inicio }}
                                </td>

                                {{-- Horario fim --}}
                                <td>
                                    {{ $ead->hora_fim }}
                                </td>

                                {{-- Inscritos --}}
                                <td>
                                    {{ $ead->inscritos->count() }}
                                </td>

                                {{-- Ações --}}
                                <td>
                                    <div class="btn-list flex-nowrap">
                                    <a href="#" class="btn btn-outline-secondary">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg></span> Ver Detalhes
                                    </a>
                                    @if($user->role === 'administrador' || $user->role === 'coordenador')
                                    <a href="{{ route('ead.edit', $ead->id) }}" class="btn btn-primary">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg></span> Editar
                                    </a>
                                    <form action="{{ route('ead.destroy', $ead->id) }}" method="POST" id="delete-form-{{ $ead->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> Excluir</button>
                                    </form>
                                    <!-- <a href="{{ route('ead.destroy', $ead->id) }}" class="btn btn-primary">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg></span> Excluir
                                    </a> -->

                                    @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="row mt-4 text-center">
                <div class="col-12">
                    {{ $eads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
