@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Seu pré-cadastro foi realizado com sucesso!') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                        </div>
                    @endif

                    <p>{{ __('A Coordenação do Núcleo que você escolheu entrará em contato em breve.') }}</p>
                    <p>{{ __('Enquanto isso, enviamos uma mensagem para o seu e-mail. Acesse e clique no link para completar seu cadastro.') }}</p>
                    <?php
                    use Illuminate\Support\Facades\Auth;
                    use App\Aluno;
                    use App\Nucleo;
                    $user = Auth::user();
                    $aluno = Aluno::where('id_user', $user->id)->get('id_nucleo');
                    $nucleo = count($aluno) > 0 ? Nucleo::find($aluno[0]['id_nucleo']) : null;
                    $wa_url = $nucleo ? $nucleo->whatsapp_url : null;
                    $my_token = app('auth.password.broker')->createToken($user);
                    $url = $app['url']->to('/');
                    ?>
                    <p><?php echo '<a href="'.$url.'/password/reset/'.$my_token.'?email='.$user->email.'">Clique aqui</a> para cadastrar ou alterar a sua senha no sistema.'; ?></p>
                    @if($wa_url)
                    <!--<p>
                        <a class="btn btn-success" href="<?php echo $wa_url; ?>" target="_blank">Fale com o seu Núcleo via WhatsApp</a>
                    </p>-->
                    @endif
                    {{ __('Se você não recebeu o email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clique aqui para solicitar outra') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
