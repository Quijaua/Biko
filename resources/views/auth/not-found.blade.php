@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container-fluid">
    <h1 class="visually-hidden">Acesso ao sistema</h1>

    <!-- PAGE HEADER -->
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">🚫 Conta não encontrada</div>

                <div class="card-body">
                @if (session::has('error'))
                <div class="row mt-2">
                    <div class="col">
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session::get('error') }}
                        </div>
                    </div>
                </div>
                @endif
		<p>Olá! 😕</o>
		<p>Parece que ainda não há uma conta vinculada ao e-mail fornecido pelo Google.</p>
		<p>Se você é novo por aqui, clique no botão abaixo para realizar seu pré-cadastro e criar sua conta:</p>
		<p><a href="{{ route('register') }}" target="_blank"><strong>🔗 Fazer pré-cadastro</strong></a></p>
		<p>Se você já se cadastrou com outro e-mail, tente fazer login com ele.</>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
