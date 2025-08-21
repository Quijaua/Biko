<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
        $app_name = \DB::table('gerals')->pluck('nome_cursinho')->first() ?? null;
    ?>
    <title>@if($app_name != null){{ $app_name }}@else{{ config('app.name') }}@endif</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.maskMoney.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cpf-validate.1.0.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/quill.min.js') }}" defer></script>
    <script src="{{ asset('js/functions.js') }}" defer></script>

    <script src="{{ asset('dist/libs/litepicker/dist/litepicker.js?1738096684') }}" defer></script>


    <script src="{{ asset('dist/libs/litepicker/dist/litepicker.js') }}" defer></script>
    <script src="{{ asset('dist/libs/tom-select/dist/js/tom-select.base.min.js') }}"></script>


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

    <!-- TablerAccessibility -->
    <link href="{{ asset('dist/libs/TablerAccessibility/dist/tabler-a11y.min.css') }}" rel="stylesheet"/>

    <!-- hCaptcha -->
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

<style>
.btn.btn-floating.btn-icon.btn-primary.bottom-right {
	height: 32px;
}
</style>

<?php
    $tag_head = \DB::table('codigo_personalizados')->pluck('tag_head')->first();
    $open_tag_body = \DB::table('codigo_personalizados')->pluck('open_tag_body')->first();
    $close_tag_body = \DB::table('codigo_personalizados')->pluck('close_tag_body')->first();

    if ($tag_head) {
        echo $tag_head;
    }
?>
</head>

<body>
    <?php
        if ($open_tag_body) {
            echo $open_tag_body;
        }
    ?>
    @auth
        @php
            $user = Auth::user();
            $ambiente_virtual = false;

            if ($user->role === 'professor') {
                $status = \DB::table('professores')->where('id_user', Auth::id())->value('status');
            }

            if ($user->role === 'aluno') {
                $aluno_nucleo = $user->aluno->nucleo;
                $aluno_nucleo->permite_ambiente_virtual ? ($ambiente_virtual = true) : ($ambiente_virtual = false);
            } elseif ($user->role !== 'aluno') {
                $ambiente_virtual = true;
            }
        @endphp
    @endauth
    <div>
        <!-- Navbar -->
        @guest
            <header class="navbar navbar-expand-md d-print-none">
                <div class="container-xl">
                    <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                        <a class="navbar-brand" href="{{ url('/home') }}">
                            @if($app_name != null){{ $app_name }}@else{{ config('app.name') }}@endif
                        </a>
                    </div>
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <div class="nav-item dd-none d-md-flex me-3">
                                <div class="btn-list">
                                    <a href="{{ route('login') }}" class="btn btn-5" rel="noreferrer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-login-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                            <path d="M3 12h13l-3 -3" />
                                            <path d="M13 15l3 -3" />
                                        </svg>
                                        {{ __('Login') }}
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register-slug') }}" class="btn btn-6" rel="noreferrer">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-contract">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 21h-2a3 3 0 0 1 -3 -3v-1h5.5" />
                                                <path d="M17 8.5v-3.5a2 2 0 1 1 2 2h-2" />
                                                <path d="M19 3h-11a3 3 0 0 0 -3 3v11" />
                                                <path d="M9 7h4" />
                                                <path d="M9 11h4" />
                                                <path d="M18.42 12.61a2.1 2.1 0 0 1 2.97 2.97l-6.39 6.42h-3v-3z" />
                                            </svg>
                                            {{ __('Pré-Inscrição') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        @endguest

        @auth
            <!-- Botão Hamburguer (visível só em telas pequenas) -->
            <div class="d-lg-none p-2 bg-dark text-white">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-offcanvas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="4" y1="6" x2="20" y2="6" />
                                <line x1="4" y1="12" x2="20" y2="12" />
                                <line x1="4" y1="18" x2="20" y2="18" />
                            </svg>
                        </button>
                    </div>
                    <div class="col">
                        <h1>@if($app_name != null){{ $app_name }}@else{{ config('app.name') }}@endif</h1>
                    </div>
                </div>
            </div>

            <!-- Sidebar OFFCANVAS para telas pequenas -->
            <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar-offcanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">
                        @if($app_name != null){{ $app_name }}@else{{ config('app.name') }}@endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav">
                        @if (!\Auth()->user()->first_login)
                            <li class="nav-item {{ request()->is('home') ? 'bg-primary text-white rounded' : '' }}">
                                <a class="nav-link" href="/home">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    {{ __('Home') }}
                                </a>
                            </li>
                            @if (Session::get('role') === 'aluno')
                                <li class="nav-item {{ request()->is('alunos/*') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="/alunos">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            </svg>
                                        </span>
                                        {{ __('Meus dados') }}
                                    </a>
                                </li>
                            @endif
                            @if (Session::get('role') !== 'aluno')
                                @if (Session::get('verified'))
                                    <li
                                        class="nav-item {{ request()->is('alunos/*') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/alunos">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                </svg>
                                            </span>
                                            {{ __('Estudantes') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('professores') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/professores">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24"
                                                    height="24" id="screenshot-bcbff864-1b56-80c9-8005-f15f51a4ad04"
                                                    viewBox="0 0 24 24" fill="none" version="1.1">
                                                    <g id="shape-bcbff864-1b56-80c9-8005-f15f51a4ad04" width="24"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"
                                                        height="24" rx="0" ry="0"
                                                        style="fill: rgb(0, 0, 0);">
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                            style="display: none;">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a5e9e7">
                                                                <rect width="24" height="24" x="0"
                                                                    stroke-linejoin="round"
                                                                    transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                    style="fill: none;" ry="0" fill="none"
                                                                    rx="0" y="0" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <rect rx="0" ry="0" x="0" y="0"
                                                                        transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                        width="24" height="24"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                                <path
                                                                    d="M0.000,0.000L24.000,0.000L24.000,24.000L0.000,24.000ZZ"
                                                                    stroke="none" fill="none" stroke-linejoin="round"
                                                                    stroke-width="2" style="fill: none;" />
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                                <path
                                                                    d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a640ba"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                                <path
                                                                    d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a640bb"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                                <path
                                                                    d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a690c1"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                                <path
                                                                    d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a6cd95"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                                <path
                                                                    d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a5"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                            <g class="fills"
                                                                id="fills-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                                <path
                                                                    d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                    fill="none" stroke-linejoin="round"
                                                                    style="fill: none;" />
                                                            </g>
                                                            <g fill="none" stroke-linejoin="round"
                                                                id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a6"
                                                                class="strokes">
                                                                <g class="stroke-shape">
                                                                    <path
                                                                        d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                        style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                            {{ __('Professores') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('coordenadores') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/coordenadores">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                                </svg>
                                            </span>
                                            {{ __('Coordenadores') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('psicologos') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/psicologos">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brain">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M15.5 13a3.5 3.5 0 0 0 -3.5 3.5v1a3.5 3.5 0 0 0 7 0v-1.8" />
                                                    <path d="M8.5 13a3.5 3.5 0 0 1 3.5 3.5v1a3.5 3.5 0 0 1 -7 0v-1.8" />
                                                    <path d="M17.5 16a3.5 3.5 0 0 0 0 -7h-.5" />
                                                    <path d="M19 9.3v-2.8a3.5 3.5 0 0 0 -7 0" />
                                                    <path d="M6.5 16a3.5 3.5 0 0 1 0 -7h.5" />
                                                    <path d="M5 9.3v-2.8a3.5 3.5 0 0 1 7 0v10" />
                                                </svg>
                                            </span>
                                            {{ __('Psicólogos') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('atendimento-psicologico') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/atendimento-psicologico">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                    <path d="M16 3v4" />
                                                    <path d="M8 3v4" />
                                                    <path d="M4 11h16" />
                                                    <path d="M7 14h.013" />
                                                    <path d="M10.01 14h.005" />
                                                    <path d="M13.01 14h.005" />
                                                    <path d="M16.015 14h.005" />
                                                    <path d="M13.015 17h.005" />
                                                    <path d="M7.01 17h.005" />
                                                    <path d="M10.01 17h.005" />
                                                </svg>
                                            </span>
                                            {{ __('Atendimento Psicológico') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('plantao-psicologico') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/plantao-psicologico">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                    <path d="M16 3v4" />
                                                    <path d="M8 3v4" />
                                                    <path d="M4 11h16" />
                                                    <path d="M7 14h.013" />
                                                    <path d="M10.01 14h.005" />
                                                    <path d="M13.01 14h.005" />
                                                    <path d="M16.015 14h.005" />
                                                    <path d="M13.015 17h.005" />
                                                    <path d="M7.01 17h.005" />
                                                    <path d="M10.01 17h.005" />
                                                </svg>
                                            </span>
                                            {{ __('Plantão Psicológico') }}
                                        </a>
                                    </li>
                                    @if (Auth::user()->role === 'psicologa_supervisora' || Auth::user()->role === 'administrador')
                                    <li
                                        class="nav-item {{ request()->routeIs('painel.supervisora') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="{{ route('painel.supervisora') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-layout-kanban">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 4l6 0" />
                                                    <path d="M14 4l6 0" />
                                                    <path d="M4 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                    <path d="M14 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                </svg>
                                            </span>
                                            {{ __('Painel da Supervisora') }}
                                        </a>
                                    </li>
                                    @endif
                                    <li
                                        class="nav-item {{ request()->is('nucleos') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="/nucleos">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                                    <path d="M9 4v13" />
                                                    <path d="M15 7v5.5" />
                                                    <path
                                                        d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                    <path d="M19 18v.01" />
                                                </svg>
                                            </span>
                                            {{ __('Núcleos') }}
                                        </a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->routeIs('nucleo/presences') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="{{ route('nucleo/presences') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                                    <path d="M14 19l2 2l4 -4" />
                                                    <path d="M9 8h4" />
                                                    <path d="M9 12h2" />
                                                </svg>
                                            </span>
                                            {{ __('Lista de presença') }}
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                            <li
                                class="nav-item {{ request()->routeIs('nucleo.material') ? 'bg-primary text-white rounded' : '' }}">
                                <a class="nav-link" href="{{ route('nucleo.material') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-book-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                                            <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                                            <path d="M9 8h6" />
                                        </svg>
                                    </span>
                                    {{ __('Material') }}
                                </a>
                            </li>
                            @endif
                            @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                            @if ($ambiente_virtual)
                            
                                <li
                                    class="nav-item {{ request()->routeIs('ambiente-virtual.index') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="{{ route('ambiente-virtual.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                                <path d="M14 19l2 2l4 -4" />
                                                <path d="M9 8h4" />
                                                <path d="M9 12h2" />
                                            </svg>
                                        </span>
                                        {{ __('Núcleo Virtual') }}
                                    </a>
                                </li>
                            @endif
                            @endif

                            @if (Session::get('role') === 'administrador')
                                <li
                                    class="nav-item {{ request()->routeIs('geral.index') ? 'bg-primary text-white rounded' : '' }} ">
                                    <a class="nav-link" href="{{ route('geral.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            </svg>
                                        </span>
                                        {{ __('Configurações') }}
                                    </a>
                                </li>
                            @endif

                            @if (Session::get('role') === 'coordenador')
                                <li
                                    class="nav-item {{ request()->routeIs('geral.index') ? 'bg-primary text-white rounded' : '' }} ">
                                    <a class="nav-link" href="{{ route('geral.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            </svg>
                                        </span>
                                        {{ __('Configurações') }}
                                    </a>
                                </li>
                            @endif
                            <li
                                class="nav-item  {{ request()->routeIs('messages.index') ? 'bg-primary text-white rounded' : '' }}">
                                <a class="nav-link" href="{{ route('messages.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                            <path d="M3 7l9 6l9 -6" />
                                        </svg>
                                    </span>
                                    {{ __('Mensagens') }}
                                </a>
                            </li>
                        @endif
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1 icon-tabler text-danger icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg>
                                </span>
                                <span class="nav-link-title text-danger">
                                {{ __('Sair') }}
                                </span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                        <li>
                            <div class="row mt-4">
                                <div class="col-auto">
                                    <span class="avatar avatar-sm" style="background-image: url({{ asset('images/user.png') }})"></span>
                                </div>
                                <div class="col">
                                    <div class="sd-none d-xl-block ps-2">
                                        @auth
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="mt-1 small text-secondary">{{ Auth::user()->role }}</div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar Telas Grandes -->
            <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-dark d-none d-lg-flex"
                style="width: 250px;">
                <div class="container-fluid p-2">
                    <h1 class="navbar-brand text-white my-3">
                        @if($app_name != null){{ $app_name }}@else{{ config('app.name') }}@endif
                    </h1>
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav">
                            @if (!\Auth()->user()->first_login)
                            <li class="nav-item {{ request()->is('home') ? 'bg-primary text-white rounded' : '' }}">
                                <a class="nav-link" href="/home">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    {{ __('Home') }}
                                </a>
                            </li>
                            @if (Session::get('role') === 'aluno')
                                <li class="nav-item {{ request()->is('alunos/*') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="/alunos">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            </svg>
                                        </span>
                                        {{ __('Meus dados') }}
                                    </a>
                                </li>
                                @endif
                                @if (Session::get('role') !== 'aluno')
                                    @if (Session::get('verified'))
                                    <li class="nav-item {{ request()->is('dashboard') ? 'bg-primary text-white rounded' : '' }}">
                                <a class="nav-link" href="/dashboard">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chart-infographic"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M7 3v4h4" /><path d="M9 17l0 4" /><path d="M17 14l0 7" /><path d="M13 13l0 8" /><path d="M21 12l0 9" /></svg>
                                    </span>
                                    {{ __('Painel') }}
                                </a>
                            </li>

                                        <li
                                            class="nav-item {{ request()->is('alunos/*') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/alunos">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    </svg>
                                                </span>
                                                {{ __('Estudantes') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('professores') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/professores">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24"
                                                        height="24"
                                                        id="screenshot-bcbff864-1b56-80c9-8005-f15f51a4ad04"
                                                        viewBox="0 0 24 24" fill="none" version="1.1">
                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a4ad04" width="24"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"
                                                            height="24" rx="0" ry="0"
                                                            style="fill: rgb(0, 0, 0);">
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                                style="display: none;">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a5e9e7">
                                                                    <rect width="24" height="24" x="0"
                                                                        stroke-linejoin="round"
                                                                        transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                        style="fill: none;" ry="0" fill="none"
                                                                        rx="0" y="0" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <rect rx="0" ry="0" x="0" y="0"
                                                                            transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                            width="24" height="24"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                                    <path
                                                                        d="M0.000,0.000L24.000,0.000L24.000,24.000L0.000,24.000ZZ"
                                                                        stroke="none" fill="none"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        style="fill: none;" />
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                                    <path
                                                                        d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a640ba"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                                    <path
                                                                        d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a640bb"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                                    <path
                                                                        d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a690c1"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                                    <path
                                                                        d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a6cd95"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                                    <path
                                                                        d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a5"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                                <g class="fills"
                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                                    <path
                                                                        d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                        fill="none" stroke-linejoin="round"
                                                                        style="fill: none;" />
                                                                </g>
                                                                <g fill="none" stroke-linejoin="round"
                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a6"
                                                                    class="strokes">
                                                                    <g class="stroke-shape">
                                                                        <path
                                                                            d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                {{ __('Professores') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('coordenadores') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/coordenadores">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                                    </svg>
                                                </span>
                                                {{ __('Coordenadores') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('psicologos') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/psicologos">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brain">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M15.5 13a3.5 3.5 0 0 0 -3.5 3.5v1a3.5 3.5 0 0 0 7 0v-1.8" />
                                                        <path d="M8.5 13a3.5 3.5 0 0 1 3.5 3.5v1a3.5 3.5 0 0 1 -7 0v-1.8" />
                                                        <path d="M17.5 16a3.5 3.5 0 0 0 0 -7h-.5" />
                                                        <path d="M19 9.3v-2.8a3.5 3.5 0 0 0 -7 0" />
                                                        <path d="M6.5 16a3.5 3.5 0 0 1 0 -7h.5" />
                                                        <path d="M5 9.3v-2.8a3.5 3.5 0 0 1 7 0v10" />
                                                    </svg>
                                                </span>
                                                {{ __('Psicólogos') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('atendimento-psicologico') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/atendimento-psicologico">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                                        <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                                        <path d="M11 3v2" /><path d="M6 3v2" />
                                                        <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    </svg>
                                                </span>
                                                {{ __('Atendimento Psicológico') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->is('plantao-psicologico') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/plantao-psicologico">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                        <path d="M7 14h.013" />
                                                        <path d="M10.01 14h.005" />
                                                        <path d="M13.01 14h.005" />
                                                        <path d="M16.015 14h.005" />
                                                        <path d="M13.015 17h.005" />
                                                        <path d="M7.01 17h.005" />
                                                        <path d="M10.01 17h.005" />
                                                    </svg>
                                                </span>
                                                {{ __('Plantão Psicológico') }}
                                            </a>
                                        </li>
                                        @if (Auth::user()->role === 'administrador')
                                        <li
                                            class="nav-item {{ request()->routeIs('painel.supervisora') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="{{ route('painel.supervisora') }}">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-layout-kanban">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M4 4l6 0" />
                                                        <path d="M14 4l6 0" />
                                                        <path d="M4 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                        <path d="M14 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                </span>
                                                {{ __('Painel da Supervisora') }}
                                            </a>
                                        </li>
                                        @endif
                                        <li
                                            class="nav-item {{ request()->is('nucleos') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="/nucleos">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                                        <path d="M9 4v13" />
                                                        <path d="M15 7v5.5" />
                                                        <path
                                                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                        <path d="M19 18v.01" />
                                                    </svg>
                                                </span>
                                                {{ __('Núcleos') }}
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->routeIs('nucleo/presences') ? 'bg-primary text-white rounded' : '' }}">
                                            <a class="nav-link" href="{{ route('nucleo/presences') }}">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                                        <path d="M14 19l2 2l4 -4" />
                                                        <path d="M9 8h4" />
                                                        <path d="M9 12h2" />
                                                    </svg>
                                                </span>
                                                {{ __('Lista de presença') }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                                @if ($ambiente_virtual)
                                    <li
                                        class="nav-item {{ request()->routeIs('ambiente-virtual.index') ? 'bg-primary text-white rounded' : '' }}">
                                        <a class="nav-link" href="{{ route('ambiente-virtual.index') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                                    <path d="M14 19l2 2l4 -4" />
                                                    <path d="M9 8h4" />
                                                    <path d="M9 12h2" />
                                                </svg>
                                            </span>
                                            {{ __('Núcleo Virtual') }}
                                        </a>
                                    </li>
                                @endif
                                @endif

                                @if (Session::get('role') === 'administrador')
                                    <li
                                        class="nav-item {{ request()->routeIs('geral.index') ? 'bg-primary text-white rounded' : '' }} ">
                                        <a class="nav-link" href="{{ route('geral.index') }}">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                </svg>
                                            </span>
                                            {{ __('Configurações') }}
                                        </a>
                                    </li>

                                @endif
                                @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                                <li
                                    class="nav-item {{ request()->routeIs('nucleo.material') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="{{ route('nucleo.material') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-book-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                                                <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                                                <path d="M9 8h6" />
                                            </svg>
                                        </span>
                                        {{ __('Material') }}
                                    </a>
                                </li>
                                @endif

                                @if (Auth::user()->role === 'psicologa_supervisora')
                                <li
                                    class="nav-item {{ request()->routeIs('painel.supervisora') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="{{ route('painel.supervisora') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-layout-kanban">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 4l6 0" />
                                                <path d="M14 4l6 0" />
                                                <path d="M4 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                                <path d="M14 8m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            </svg>
                                        </span>
                                        {{ __('Painel da Supervisora') }}
                                    </a>
                                </li>
                                @endif

                                @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                                <li
                                    class="nav-item  {{ request()->routeIs('messages.index') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="{{ route('messages.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                <path d="M3 7l9 6l9 -6" />
                                            </svg>
                                        </span>
                                        {{ __('Mensagens') }}
                                    </a>
                                </li>
                                <li
                                    class="nav-item  {{ request()->routeIs('ead.index') ? 'bg-primary text-white rounded' : '' }}">
                                    <a class="nav-link" href="{{ route('ead.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-school"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" /><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" /></svg>
                                        </span>
                                        {{ __('EAD') }}
                                    </a>
                                </li>
                                @endif
                            @endif
                            <li class="nav-item mt-3">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1 icon-tabler text-danger icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg>
                                    </span>
                                    <span class="nav-link-title text-danger">
                                    {{ __('Sair') }}
                                    </span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            <div class="page">
                <header class="navbar-expand-md">
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <div class="navbar">
                            <div class="container-xl">
                                <div class="row flex-fill align-items-center">
                                    <div class="col">
                                        <ul class="navbar-nav">
                                            @if (!\Auth()->user()->first_login)

                                            <li class="nav-item">
                                                <a class="nav-link" href="/home">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                        </svg>
                                                    </span>
                                                    {{ __('Home') }}
                                                </a>
                                            </li>
                                            @if (Session::get('role') === 'aluno')
                                                <li class="nav-item">
                                                    <a class="nav-link" href="/alunos">
                                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                            </svg>
                                                        </span>
                                                            {{ __('Meus dados') }}
                                                        </a>
                                                </li>
                                            @endif

                                                @if (Session::get('role') !== 'aluno')
                                                    @if (Session::get('verified'))
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="/alunos">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                        <path
                                                                            d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Estudantes') }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="/professores">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        width="24" height="24"
                                                                        id="screenshot-bcbff864-1b56-80c9-8005-f15f51a4ad04"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        version="1.1">
                                                                        <g id="shape-bcbff864-1b56-80c9-8005-f15f51a4ad04"
                                                                            width="24"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"
                                                                            height="24" rx="0" ry="0"
                                                                            style="fill: rgb(0, 0, 0);">
                                                                            <g id="shape-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                                                style="display: none;">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a5e9e7">
                                                                                    <rect width="24" height="24"
                                                                                        x="0" stroke-linejoin="round"
                                                                                        transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                                        style="fill: none;" ry="0"
                                                                                        fill="none" rx="0"
                                                                                        y="0" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a5e9e7"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <rect rx="0"
                                                                                            ry="0" x="0" y="0"
                                                                                            transform="matrix(1.000000, 0.000000, 0.000000, 1.000000, 0.000000, 0.000000)"
                                                                                            width="24" height="24"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a636c1">
                                                                                    <path
                                                                                        d="M0.000,0.000L24.000,0.000L24.000,24.000L0.000,24.000ZZ"
                                                                                        stroke="none" fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a640ba">
                                                                                    <path
                                                                                        d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a640ba"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M10.000,13.000C10.000,14.105,10.895,15.000,12.000,15.000C13.105,15.000,14.000,14.105,14.000,13.000C14.000,11.895,13.105,11.000,12.000,11.000C10.895,11.000,10.000,11.895,10.000,13.000Z"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a640bb">
                                                                                    <path
                                                                                        d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a640bb"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M8.000,21.000L8.000,20.000C8.000,18.895,8.895,18.000,10.000,18.000L14.000,18.000C15.105,18.000,16.000,18.895,16.000,20.000L16.000,21.000"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a690c1">
                                                                                    <path
                                                                                        d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a690c1"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M15.000,5.000C15.000,6.105,15.895,7.000,17.000,7.000C18.105,7.000,19.000,6.105,19.000,5.000C19.000,3.895,18.105,3.000,17.000,3.000C15.895,3.000,15.000,3.895,15.000,5.000Z"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a6cd95">
                                                                                    <path
                                                                                        d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a6cd95"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M17.000,10.000L19.000,10.000C20.105,10.000,21.000,10.895,21.000,12.000L21.000,13.000"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a738a5">
                                                                                    <path
                                                                                        d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a5"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M5.000,5.000C5.000,6.105,5.895,7.000,7.000,7.000C8.105,7.000,9.000,6.105,9.000,5.000C9.000,3.895,8.105,3.000,7.000,3.000C5.895,3.000,5.000,3.895,5.000,5.000Z"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g
                                                                                id="shape-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                                                <g class="fills"
                                                                                    id="fills-bcbff864-1b56-80c9-8005-f15f51a738a6">
                                                                                    <path
                                                                                        d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                                        fill="none"
                                                                                        stroke-linejoin="round"
                                                                                        style="fill: none;" />
                                                                                </g>
                                                                                <g fill="none" stroke-linejoin="round"
                                                                                    id="strokes-bcbff864-1b56-80c9-8005-f15f51a738a6"
                                                                                    class="strokes">
                                                                                    <g class="stroke-shape">
                                                                                        <path
                                                                                            d="M3.000,13.000L3.000,12.000C3.000,10.895,3.895,10.000,5.000,10.000L7.000,10.000"
                                                                                            style="fill: none; stroke-width: 2; stroke: rgb(114, 124, 146); stroke-opacity: 1;" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                {{ __('Professores') }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="/coordenadores">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                                        <path
                                                                            d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Coordenadores') }}
                                                            </a>
                                                        </li>
                                                        <li
                                                            class="nav-item">
                                                            <a class="nav-link" href="/psicologos">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-brain">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                        <path d="M15.5 13a3.5 3.5 0 0 0 -3.5 3.5v1a3.5 3.5 0 0 0 7 0v-1.8" />
                                                                        <path d="M8.5 13a3.5 3.5 0 0 1 3.5 3.5v1a3.5 3.5 0 0 1 -7 0v-1.8" />
                                                                        <path d="M17.5 16a3.5 3.5 0 0 0 0 -7h-.5" />
                                                                        <path d="M19 9.3v-2.8a3.5 3.5 0 0 0 -7 0" />
                                                                        <path d="M6.5 16a3.5 3.5 0 0 1 0 -7h.5" />
                                                                        <path d="M5 9.3v-2.8a3.5 3.5 0 0 1 7 0v10" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Psicólogos') }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="/nucleos">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                                                        <path d="M9 4v13" />
                                                                        <path d="M15 7v5.5" />
                                                                        <path
                                                                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                                        <path d="M19 18v.01" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Núcleos') }}
                                                            </a>
                                                        </li>
                                                        {{-- <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('nucleo/presences') }}">
                                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                                                                        <path d="M14 19l2 2l4 -4" />
                                                                        <path d="M9 8h4" />
                                                                        <path d="M9 12h2" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Lista de presença') }}
                                                            </a>
                                                        </li> --}}
                                                    @endif
                                                @endif

                                                @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
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
                                                @endif

                                                @if (($user->role === 'professor' && $status != 0) || ($user->role !== 'professor'))
                                                <li class="nav-item ">
                                                    <a class="nav-link" href="{{ route('messages.index') }}">
                                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                                <path d="M3 7l9 6l9 -6" />
                                                            </svg>
                                                        </span>
                                                        {{ __('Mensagens') }}
                                                    </a>
                                                </li>
                                                @endif
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div>
                                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0"
                                        data-bs-toggle="dropdown" aria-label="Open user menu">
                                        <span class="avatar avatar-sm"
                                            style="background-image: url({{ asset('images/user.png') }})"></span>
                                        <div class="d-none d-xl-block ps-2">
                                            <div>{{ Auth::user()->name }}</div>
                                            <div class="mt-1 small text-secondary">{{ Auth::user()->formatted_role }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </header>
            @endauth

            <main class="py-4">
                @yield('content')
            </main>
        </div>


        @yield('js')
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalInfo" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title">Título do Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
  
        <div class="modal-body">
          <p>Conteúdo do modal aqui.</p>
        </div>
  
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="modalConfirm">Confirmar</button>
        </div>
      </div>
    </div>
  </div>

</div>

    <script src="{{ asset('dist/js/tabler.min.js?1738096684') }}"></script>
    <script src="{{ asset('dist/libs/TablerAccessibility/dist/tabler-a11y.min.js') }}" defer></script>

    <script>
    window.addEventListener('DOMContentLoaded', () => {
        new TablerA11y({
            position: 'bottom-right' // Opções: bottom-right, bottom-left, top-right, top-left
        });
    });
    </script>

<?php
 if ($close_tag_body) {
    echo $close_tag_body;
}
?>
</body>

</html>
