@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Adicionar nova data de atendimento</h1>
        </div>
    </div>

    @if(session::has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif

    @if(session::has('error'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-danger text-center">
                {!! session::get('error') !!}
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-danger text-center">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('plantao-psicologico.update', $dados->id) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="data" class="form-label required">Data disponível</label>
                    <input type="date" class="form-control" id="data" name="data" value="{{ $dados->data }}" required min="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="horario" class="form-label required">Horário disponível</label>
                    <input type="time" class="form-control" id="horario" name="horario" value="{{ $dados->horario }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a class="btn btn-outline-primary ms-3" href="{{ route('plantao-psicologico.index') }}">Voltar</a>
            </div>
        </div>
    </form>
</div>
@endsection