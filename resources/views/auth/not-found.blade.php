@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">Conta não encontrada</div>

                <div class="card-body">
                @if (session::has('error'))
                <div class="row mt-2">
                    <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                            {!! session::get('error') !!}
                        </div>
                    </div>
                </div>
                @endif

                    <p>Olá!</p>

                    <p>Parece que ainda não há uma conta vinculada ao e-mail fornecido pelo Google.</p>
                    <p>Se você é novo por aqui, clique no botão abaixo para realizar seu pré-cadastro e criar a sua conta.</p>
                    <p><a href="{{ route('register') }}" target="_blank"><strong>Fazer pré-cadastro</strong></a></p>
                    <p>Caso já tenha se cadastrado com outro e-mail, por favor, tente acessar com o e-mail cadastrado.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
