@extends('mensagens._mensagens')

@section('content_message')
    <div class="card">
        <div class="card-header">{{ $mensagem->titulo }}</div>

        <div class="card-body">

            @if(\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                <p><strong>Enviado para:</strong> {{ $mensagem->mensagensAluno->pluck('aluno.NomeAluno')->join(', ') }}</p>
            @else
                <p><strong>Enviado por:</strong> {{ $mensagem->remetente->name }}</p>
            @endif

            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($mensagem->created_at)->format('d/m/Y h:i') }}</p>
            <hr/>

            <div class="clearfix">
                {!! $mensagem->mensagem !!}
            </div>

            <a class="btn btn-primary float-right" href="{{ url()->previous() }}">Voltar</a>
        </div>
    </div>
@endsection
