@extends('layouts.app')

@section('content')
<div class="page">
	<div class="container container-tight py-4">
        <div class="card card-md">


	        <div class="card-body">
		        <h2 class="h2 text-center mb-4">{{ __('Login') }}</h2>
                <form id="login-form" method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                @csrf

	<div class="mb-3">
		<label for="email" class="form-label">{{ __('E-Mail') }}</label>


        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

@error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror


	</div>
	<div class="mb-2">


		<label for="password" class="form-label">
        {{ __('Senha') }}
		</label>
        <div class="input-group input-group-flat">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
	        <span class="input-group-text">
		        <a href="javascript:void(0)" id="toggle-password" class="link-secondary" title="Mostrar senha" data-bs-toggle="tooltip">
	                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                </a>
	        </span>
        </div>
	</div>
	<div class="mb-2">
		<label class="form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <span class="form-check-label" for="remember">
            {{ __('Manter-me conectado') }}
            </span>
		</label>
	</div>

    @if (!in_array(config('app.env'), ['local', 'develop']))
    <div class="row mt-4">
        <div class="col">
            <div class="h-captcha"
                data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
        </div>
    </div>
    @endif

	<div class="form-footer">



		<button type="submit" class="btn btn-primary w-100" id="btn-submit">{{ __('Login') }}</button>
	</div>
</form>
	</div>

</div>

<div class="text-center text-secondary mt-3">
    @if (Route::has('password.request'))
    <div class="d-flex justify-content-center gap-3">
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Esqueceu a senha?') }}
        </a>
        <a class="btn btn-link" href="{{ route('password.request') }}">
            Primeiro acesso
        </a>
    </div>
    @endif
</div>

	</div>
</div>

<div class="container container-tight py-4">
    @inject('session', 'Session')

    @if (session::has('success'))
    <div class="row mt-2">
        <div class="col">
            <div class="alert alert-success text-center" role="alert">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if (session::has('error'))
    <div class="row mt-2">
        <div class="col">
            <div class="alert alert-danger text-center" role="alert">
                {!! session::get('error') !!}
            </div>
        </div>
    </div>
    @endif

    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="otpModalLabel">Qual é o seu e-mail?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="otp-form" action="{{ route('otp-login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">Digite o e-mail que você usou para se cadastrar.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="otp-form">Enviar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="card card-md">
        <div class="card-body">
            <h2 class="text-center">Acesso Rápido</h2>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="text-center">
                        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#otpModal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 7.535v9.465a3 3 0 0 1 -2.824 2.995l-.176 .005h-14a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-9.465l9.445 6.297l.116 .066a1 1 0 0 0 .878 0l.116 -.066l9.445 -6.297z" /><path d="M19 4c1.08 0 2.027 .57 2.555 1.427l-9.555 6.37l-9.555 -6.37a2.999 2.999 0 0 1 2.354 -1.42l.201 -.007h14z" /></svg>
                            {{ __('Entrar sem senha') }}
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="text-center">
                        <a href="{{ route('google.redirect') }}" class="btn btn-primary w-100 mt-3">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-brand-google"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a9.96 9.96 0 0 1 6.29 2.226a1 1 0 0 1 .04 1.52l-1.51 1.362a1 1 0 0 1 -1.265 .06a6 6 0 1 0 2.103 6.836l.001 -.004h-3.66a1 1 0 0 1 -.992 -.883l-.007 -.117v-2a1 1 0 0 1 1 -1h6.945a1 1 0 0 1 .994 .89c.04 .367 .061 .737 .061 1.11c0 5.523 -4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10z" /></svg>
                            {{ __('Google') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(function() {
        const form      = $('#login-form');
        const btnSubmit = $('#btn-submit');
        const hcaptchaElement = document.querySelector('.h-captcha');

        @if (!in_array(config('app.env'), ['local', 'develop']))
        form.on('submit', function(e) {
            const hcaptchaVal = $('[name="h-captcha-response"]').val();

            $(".alert").remove();

            if (!hcaptchaVal) {
                e.preventDefault();

                $(".h-captcha").before(
                    '<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">' +
                        'Por favor complete o desafio hCaptcha' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>'
                );

                btnSubmit.prop("disabled", false).removeClass("d-none");

                if (hcaptchaElement && window.hcaptcha) {
                    const widgetId = hcaptchaElement.getAttribute('data-hcaptcha-widget-id');
                    window.hcaptcha.reset(widgetId);
                }

                return false;
            }
        });
        @endif
    });

    $('document').ready(function() {
        $('#toggle-password').click(function() {
            var input = $('#password');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>

@endsection
