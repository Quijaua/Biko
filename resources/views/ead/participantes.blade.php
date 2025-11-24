@extends('layouts.app')

@inject('session', 'Session')

@section('content')

<div class="page-wrapper">

    <!-- PAGE HEADER -->
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <h1 class="text-[34px]">EAD - Participantes</h1>
                <p><strong>Evento</strong>: {{ $eads->titulo }}</p>
                <p><strong>Data</strong>: {{ $eads->data->format('d/m/Y') }}</p>
                <p><strong>Hora Início</strong>: {{ $eads->hora_inicio }}</p>
                <p><strong>Hora Fim</strong>: {{ $eads->hora_fim }}</p>
            </div>
            @if(\Auth::user()->role != 'aluno')
            <div class="col-6" style="text-align: right;">
                
                <a class="btn btn-primary" href="{{ route('ead.create') }}">
                    <span>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" /><path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /></svg>      
                    </span>
                    Adicionar novo evento
                </a>
                
            </div>
            @endif
        </div>
        @if(session::has('success'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-success text-center" role="alert">
                    {!! \Session::get('success') !!}
                </div>
            </div>
        </div>
        @endif
        @if(session::has('error'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! \Session::get('error') !!}
                </div>
            </div>
        </div>
        @endif
    </div>


    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards">
                @if($participantes->isEmpty())
                <p>Nenhum registro encontrado.</p>
                @else
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-black py-3">Nome</th>
                            </tr>

                        </thead>
                        <tbody class="bg-white rounded">
                            @foreach($participantes as $participante)
                            <tr>
                                {{-- Nome --}}
                                <td>
                                    {{  $participante->name }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="row mt-4 text-center">
                <div class="col-12">
                    {{  $participantes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
