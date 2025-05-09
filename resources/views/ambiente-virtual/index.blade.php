@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
<div class="container">
  <!-- PAGE HEADER -->

  <div class="row">
      <div class="col-6">
        <h1 class="text-[34px]">Ambiente Virtual</h1>
      </div>
      <div class="col-6" style="text-align: right;">
        @if($aulas->isEmpty() || $user->role !== 'aluno')
        <a class="btn btn-primary" href="{{route('ambiente-virtual.create')}}">
            <span>
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-video"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" /><path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /></svg>      
            </span>
            Adicionar nova aula
        </a>
        @endif
      </div>
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
</div></div>

    <div class="container">
    <div class="row drow-deck drow-cards">
        <div class="col-12">
            @if($aulas->isEmpty())
            <p>Nenhum registro encontrado.</p>
            @else
                @foreach($aulas as $aula)
                <div class="col-md-6 p-2 sh-25" style="float:left">
                <div class="card mb-8">
                    <div class="card-header">
                        <div class="col-6">
                            <h3 class="card-title">{{ $aula->titulo }}</h3>
                            <p class="card-subtitle">{{ $aula->professor->NomeProfessor }} - 12/03/2025</p>
                        </div>
                        <div class="col-6 card-actions ">
                            <p><a href="{{route('ambiente-virtual.show', $aula)}}" class="btn btn-primary btn-2 col-4">Assistir</a></p>
                                @if($user->role != 'aluno')
                            <a class="btn btn2 col-4" href="{{route('ambiente-virtual.edit', $aula)}}">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Editar
                            </a>
                            <form action="{{route('ambiente-virtual.destroy', $aula->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-8 col-4">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>    
                                
                                Excluir</button>
                            </form>
                                @endif
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <img class="drounded-circle davatar" src="{{ asset('aulas-virtuais/imagens/' . $aula->id . '/' . $aula->imagem_capa) }}" alt="{{ $aula->titulo }}">
                    </div>
                </div>
              </div>

                    @endforeach
            @endif
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
        {{ $aulas->links() }}
        </div>
    </div>
</div>
@endsection
