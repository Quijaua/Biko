@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 550px;">
    <h1 class="visually-hidden">Acesso ao sistema</h1>

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Entrar sem senha</h5>
        </div>
        <div class="card-body">
            <form id="otp-form" action="{{ route('otp-login') }}" method="POST">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirect ?? 'plantao-psicologico' }}">
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required autofocus>
                    <div id="emailHelp" class="form-text">Digite o e-mail que você usou para se cadastrar.</div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection