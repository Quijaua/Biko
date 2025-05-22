@extends('layouts.app')

@inject('session', 'Session')

@section('content')
    <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Configurações</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="row g-0">
                        @include('layouts.configuracoes.menu')
                        <div class="col-12 col-md-9 d-flex flex-column">
                            <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-8">
                                        <h1 class="text-[34px]">Disciplinas</h1>
                                    </div>
                                    <div class="col-4">
                                        <a class="btn btn-primary" href="{{route('disciplinas.create')}}">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg>
                                        </span>
                                        Adicionar nova disciplina
                                        </a>
                                    </div>
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

                                <div class="row">
                                    <div class="col mt-4">
                                        @if($disciplinas->isEmpty())
                                        <p>Nenhum registro encontrado.</p>
                                        @else
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($disciplinas as $disciplina)
                                                <tr>
                                                    <td><h3>{{ $disciplina->nome }}</h3></td>
                                                    <td>
                                                        <div class="btn-list">
                                                        <a href="{{ route('disciplinas.edit', $disciplina->id) }}" class="btn btn-primary btn-2"> Editar </a>

                                                        <form action="{{ route('disciplinas.destroy', $disciplina->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-1 ms-6">Excluir</button>
                                                        </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BODY -->
    </div>


@endsection