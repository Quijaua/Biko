@extends('layouts.app')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>QUESTIONÁRIO ({{ $ambiente_virtual->titulo }})</h1>
        </div>
    </div>
    @if(session('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center" role="alert">
                {!! session('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! session('error') !!}
                </div>
            </div>
    </div>
    @endif
    <div class="row">
        @if($ambiente_virtual->questionarios->isEmpty())
        <div class="col-12">
            <a href="{{ route('ambiente-virtual.questionario.create', $ambiente_virtual->id) }}" class="btn btn-success mb-3">Criar questionário</a>
        </div>
        @endif
        <div class="col-12">
            <div class="list-group">
                @if($ambiente_virtual->questionarios->count() > 0)
                @foreach($ambiente_virtual->questionarios as $questionario)
                    <div class="list-group-item list-group-item-action">
                        <a href="{{ route('ambiente-virtual.questionario.edit', ['id' => $ambiente_virtual->id]) }}">
                            <h5 class="mb-1">{{ $questionario->name }}</h5>
                        </a>
                        @if($questionario->attempts->isEmpty())
                        <form action="{{ route('ambiente-virtual.questionario.destroy', $questionario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mt-2">Excluir Questionário</button>
                        </form>
                        @endif
                    </div>
                @endforeach
                @else
                    <div class="alert alert-info text-center" role="alert">
                        Nenhum questionário disponível.
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="list-group">
                <div class="list-group-item list-group-item-action">
                    <strong>Participantes que responderam ao questionário:</strong>
                    <div class="row">
                        <div class="col mt-2">
                            @if(!$ambiente_virtual->questionarios->first()->attempts->isEmpty())
                                @foreach($ambiente_virtual->questionarios as $questionario)
                                    @foreach($questionario->attempts as $attempt)
                                        <p>{{ $attempt->participant->NomeAluno ?? 'N/A' }} - Score: {{ $attempt->calculate_score() }} - Data: {{ $attempt->created_at->format('d/m/Y') }}</p>
                                    @endforeach
                                @endforeach
                            @else
                                <div class="alert alert-info text-center" role="alert">
                                    Nenhum participante respondeu ao questionário.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection