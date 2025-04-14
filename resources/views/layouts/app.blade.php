<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.maskMoney.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.cpf-validate.1.0.min.js') }}" defer></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/quill.min.js') }}" defer></script>
    <script src="{{ asset('js/functions.js') }}" defer></script>

    <script src="{{ asset('dist/libs/litepicker/dist/litepicker.js?1738096684') }}" defer></script>


    <script src="./dist/libs/litepicker/dist/litepicker.js?1738096684" defer></script>
    <script src="./dist/libs/tom-select/dist/js/tom-select.base.min.js?1738096684" defer></script>


    <!-- Tabler -->
    <script src="{{ asset('dist/js/demo-theme.min.js?1738096682') }}" defer></script>

    <link href="{{ asset('dist/css/tabler.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/tabler-flags.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/tabler-socials.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/tabler-marketing.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/demo.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/custom.css') }}" rel="stylesheet">


    <!-- FontsAwesome -->
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">


    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">



</head>

<body>
    @auth
        @php
            $user = Auth::user();
            $ambiente_virtual = false;

            if ($user->role === 'aluno') {
                $aluno_nucleo = $user->aluno->nucleo;
                $aluno_nucleo->permite_ambiente_virtual ? $ambiente_virtual = true : $ambiente_virtual = false;
            } elseif ($user->role !== 'aluno') {
                $ambiente_virtual = true;
            };
        @endphp
    @endauth
<div class="page">
		<!-- Navbar -->
	<header class="navbar navbar-expand-md d-print-none" >
		<div class="container-xl">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
</button>
<div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
<a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>


</div>
<div class="navbar-nav flex-row order-md-last">
	<div class="nav-item dropdown">
            @guest
            <div class="nav-item d-none d-md-flex me-3">
                <div class="btn-list">
                    <a href="{{ route('login') }}" class="btn btn-5" rel="noreferrer">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-login-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M3 12h13l-3 -3" /><path d="M13 15l3 -3" /></svg>
                        {{ __('Login') }}
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-6" rel="noreferrer">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-contract"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21h-2a3 3 0 0 1 -3 -3v-1h5.5" /><path d="M17 8.5v-3.5a2 2 0 1 1 2 2h-2" /><path d="M19 3h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7h4" /><path d="M9 11h4" /><path d="M18.42 12.61a2.1 2.1 0 0 1 2.97 2.97l-6.39 6.42h-3v-3z" /></svg>
                        {{ __('Cadastro') }}
                    </a>
                    @endif
		        </div>
	        </div>
 
            @else

            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm" style="background-image: url({{ asset('images/user.png') }})"></span>
			<div class="d-none d-xl-block ps-2">
				<div>{{ Auth::user()->name }}</div>
				<div class="mt-1 small text-secondary">{{ Auth::user()->role }}</div>
			</div>
		</a>
		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Sair') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

			<!-- <a href="#" class="dropdown-item">Status</a>
			<a href="./profile.html" class="dropdown-item">Profile</a>
			<a href="#" class="dropdown-item">Feedback</a>
			<div class="dropdown-divider"></div>
			<a href="./settings.html" class="dropdown-item">Settings</a>
			<a href="./sign-in.html" class="dropdown-item">Logout</a> -->
		</div>
	</div>
</div>
                    @endguest



		</div>
	</header>
    @auth
	<header class="navbar-expand-md">
		<div class="collapse navbar-collapse" id="navbar-menu">
			<div class="navbar">
				<div class="container-xl">
					<div class="row flex-fill align-items-center">
						<div class="col">
                        <ul class="navbar-nav">
                        
                        @if(Session::get('role') === 'aluno')
                            @if(Session::get('cpf') === 'OK')
                                <li class="nav-item">
                                    <a class="nav-link" href="/alunos">
                                        {{ __('Meus dados') }}
                                    </a>
                                </li>
                            @endif
                            @if(Session::get('cpf') === 'null')
                                <li class="nav-item">
                                    <a class="nav-link btn-danger text-light" href="/alunos">
                                        {{ __('Informe seus dados') }}
                                    </a>
                                </li>
                            @endif
                        @endif

                        @if(!\Auth()->user()->first_login)
                        @if(Session::get('role') !== 'aluno')
                            @if(Session::get('verified'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/alunos">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" /></svg>
                                        </span>    
                                        {{ __('Alunos') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/professores">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
	                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                        </span>
                                        {{ __('Professores') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/coordenadores">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
	                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                        </span>    
                                        {{ __('Coordenadores') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/nucleos">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
	                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                                        </span>
                                        {{ __('Núcleos') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('nucleo/presences') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
	                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                                        </span>
                                        {{ __('Lista de presença') }}
                                    </a>
                                </li>
                                
                                <!--li class="nav-item">
                                    <a class="nav-link" href="{{ route('ambiente-virtual.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
	                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                                        </span>
                                        {{ __('Ambiente virtual') }}
                                    </a>
                                </li-->
                                
                            @endif
                        @endif

                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('nucleo.material') }}">
                                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-book-2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                                                                <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                                                                <path d="M9 8h6" />
                                                            </svg>
                                                        </span>
                                                        {{ __('Material') }}
                                                    </a>
                                                </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('messages.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-message"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                                </span>
                                {{ __('Mensagens') }}
                            </a>
                        </li>
                        @if($ambiente_virtual)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ambiente-virtual.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                                </span>
                                {{ __('Ambiente virtual') }}
                            </a>
                        </li>
                        @endif
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('disciplinas.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                                </span>
                                {{ __('Configurações') }}
                            </a>
                        </li>
                        </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
    @endauth


            <main class="py-4">
                @yield('content')
            </main>

            @yield('js')
        </div>
    </div>


    <script src="{{ asset('dist/js/tabler.min.js?1738096684') }}"></script>
    </div>
</body>

</html>
