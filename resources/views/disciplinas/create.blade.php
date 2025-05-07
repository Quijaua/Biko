@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>CADASTRO DE DISCIPLINAS</h1>
        </div>
    </div>
    @if(session::has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center" role="alert">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if(session::has('error'))
    <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! session::get('error') !!}
                </div>
            </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{ route('disciplinas.store') }}" method="POST" role="search" >
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="titulo">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" placeholder="Nome da disciplina" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="btn-list">
                        <button type="submit" class="btn btn-primary btn-2">Salvar</button>
                        <a href="{{ route('disciplinas.index') }}" class="btn btn-1"> Voltar </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection