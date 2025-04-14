@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>DISCIPLINAS</h1>
        </div>
    </div>
    <div class="container">
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

        <div class="col mt-4 text-center">
            <a class="btn btn-success" href="{{route('disciplinas.create')}}">Adicionar nova disciplina</a>
        </div>

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
                            <td>{{ $disciplina->nome }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('disciplinas.edit', $disciplina->id) }}">Editar</a>
                                <form action="{{ route('disciplinas.destroy', $disciplina->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
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
@endsection