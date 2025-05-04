<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

    <link href="{{ asset('dist/css/tabler.min.css?1738096682') }}" rel="stylesheet">
    <link href="{{ asset('dist/libs/TablerAccessibility/dist/tabler-a11y.min.css') }}" rel="stylesheet"/>
  
    <style>
        .welcome-title {
            font-size: 84px;
            font-weight: 400;
            opacity: 0.5;
        }
    </style>
    </head>
    <body>

<div class="page">
    
    <header class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-xl d-flex justify-content-end">
            <div class="btn-list">
                    <a href="{{ route('login') }}" class="btn btn-5" rel="noreferrer">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-login-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M3 12h13l-3 -3" /><path d="M13 15l3 -3" /></svg>
                        {{ __('Login') }}
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register-slug') }}" class="btn btn-6" rel="noreferrer">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-contract"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21h-2a3 3 0 0 1 -3 -3v-1h5.5" /><path d="M17 8.5v-3.5a2 2 0 1 1 2 2h-2" /><path d="M19 3h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7h4" /><path d="M9 11h4" /><path d="M18.42 12.61a2.1 2.1 0 0 1 2.97 2.97l-6.39 6.42h-3v-3z" /></svg>
                        {{ __('Pré-inscrição') }}
                    </a>
                    @endif
                </div>
            </div>
            </header>
        <div class="container container-tight py-4 d-flex justify-content-center align-center" style="margin-top:200px">
           <h1 class="welcome-title">{{ env('APP_NAME') }}</h1>
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


    </body>
</html>
