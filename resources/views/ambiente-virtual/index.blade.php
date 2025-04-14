@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>AULAS VIRTUAIS</h1>
        </div>
    </div>
    <div class="container">
        @if($user->role != 'aluno' && $user->role != 'professor')
        <div class="row">
            <div class="col-6 m-auto">
                <form action="" method="POST" role="search">
                    @csrf
                    <div class="input-group d-flex justify-content-center align-center">
                        <input type="text" class="form-control" name="inputQuery"
                            placeholder="Buscar por nome ou sobrenome do aluno" required> <span class="input-group-btn">
                            <button type="submit" class="btn-link text-decoration-none">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
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
    @if($aulas->isEmpty() || $user->role !== 'aluno')
    <div class="col mt-4 text-center">
        <a class="btn btn-success" href="{{route('ambiente-virtual.create')}}">Adicionar nova aula</a>
    </div>
    @endif
    <div class="row">
        <div class="col mt-4">
            @if($aulas->isEmpty())
            <p>Nenhum registro encontrado.</p>
            @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Capa</th>
                        <th scope="col">Professor</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aulas as $aula)
                    <tr>
                        <td>{{ $aula->titulo }}</td>
                        <td><img class="rounded-circle avatar" src="{{ asset('aulas-virtuais/imagens/' . $aula->id . '/' . $aula->imagem_capa) }}" alt="{{ $aula->titulo }}"></td>
                        <td> {{ $aula->professor->NomeProfessor }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('ambiente-virtual.show', $aula->id)}}">Assistir</a>
                            @if($user->role != 'aluno')
                            <a class="btn btn-warning" href="{{route('ambiente-virtual.edit', $aula->id)}}">Editar</a>
                            <form action="{{route('ambiente-virtual.destroy', $aula->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
        {{ $aulas->links() }}
        </div>
    </div>
</div>
@endsection
