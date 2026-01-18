@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="row justify-content-center">
        <div class="col-8">
            @if ($user->role !== 'aluno')
            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('novos-voluntarios') }}" class="btn btn-primary">Novos Voluntários</a>
            </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Bem vinda(o), {{ $user->name }}.</p>
                    <?php
                    $user = Auth::user();
                    $my_token = app('auth.password.broker')->createToken($user);
                    $url = $app['url']->to('/');
                    ?>
                    <p><?php echo '<a href="'.$url.'/password/reset/'.$my_token.'?email='.$user->email.'" class="text-link">Clique aqui</a> para cadastrar ou alterar a sua senha no sistema.'; ?></p>
                    <p>Aqui você poderá acompanhar a sua jornada e seu desempenho durante a permanência no projeto.</p>
                    <p>Boa sorte e bons estudos!</p>
                    <p><a href="http://uneafrobrasil.org" class="text-link" target="_blank"><strong>UNEAfro Brasil</strong></a></p>
                </div>
            </div>
            @if ($user->role === 'coordenador' && $nucleos->isNotEmpty())
                <div>
                    <h3>Núcleos que faço parte</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($nucleos as $nucleo)
                            <a href="{{ url('/nucleos/details/' . $nucleo->id) }}" class="btn btn-primary">
                                {{ $nucleo->NomeNucleo }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
