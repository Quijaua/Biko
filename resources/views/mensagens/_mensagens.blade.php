@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>MENSAGENS</h1>
            </div>
        </div>

        @if(\Session::has('success'))
            <div class="row mt-2">
                <div class="col-6 m-auto">
                    <div class="alert alert-success text-center" role="alert">
                        {{ \Session::get('success') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-3 col-lg-3">
                <div class="card">
                    <div class="card-header">Pastas</div>

                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="pb-2 pt-2 border-bottom">
                                <a href="{{ route('messages.index') }}" class="text-black-50">
                                    @if(\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                                        <i class="fas fa-paper-plane"></i>
                                        Enviadas
                                    @else
                                        <i class="fas fa-inbox"></i>
                                        Entrada
                                    @endif
                                </a>
                            </li>
                            @if(!\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                                <li class="pb-2 pt-2 border-bottom">
                                    <a href="{{ route('messages.removed') }}" class="text-black-50">
                                        <i class="fas fa-trash-alt"></i>
                                        Removidas
                                    </a>
                                </li>
                            @endif
                        </ul>

                        @if(\Illuminate\Support\Facades\Auth::user()->allowed_send_email)
                            <a href="{{ route('messages.create') }}" class="btn btn-outline-secondary w-100">
                                <i class="far fa-envelope-open me-2"></i>
                                Nova mensagem
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-lg-9">
                @yield('content_message')
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/mensagens.js') }}" defer></script>
@endsection