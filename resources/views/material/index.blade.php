@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
    <div class="col-8">
      <h1 class="text-[34px]">Material</h1>
    </div>
    <div class="col-4  text-center">
      @if($user->role != 'aluno')
      <a class="btn btn-primary" href="/nucleos/add"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
            <path d="M16 19h6" />
            <path d="M19 16v6" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
          </svg></span>Adicionar novo material</a>
      @endif
    </div>
  </div>
  <div class="card mb-4 col-md-5">
    <div class="card-body">
      <form class="row g-2 align-items-end">

        <div class="col-md-12">
          <h3 class="card-title mb-3 d-flex align-items-center">
            <span class="mx-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-horizontal">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M4 6l8 0" />
                <path d="M16 6l4 0" />
                <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M4 12l2 0" />
                <path d="M10 12l10 0" />
                <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M4 18l11 0" />
                <path d="M19 18l1 0" />
              </svg>
            </span>
            Filtros avançados
          </h3>
        </div>

        {{-- Núcleo --}}
        <div class="col-md-3">
          <select class="form-select" id="nucleo" name="nucleo">
            <option value="" @selected(request('nucleo')=='' )>Núcleo</option>
            @foreach(\App\Nucleo::all() as $nuc)
            <option value="{{ $nuc->id }}" @selected(request('nucleo')==$nuc->id)>
              {{ $nuc->NomeNucleo }}
            </option>
            @endforeach
          </select>
        </div>

        {{-- Enviado por --}}
        <div class="col-md-4">
          <select class="form-select" id="status" name="status">
            <option value="" @selected(request('status')=='' )>Situação</option>
            <option value="1" @selected(request('status')=='1' )>Ativos</option>
            <option value="0" @selected(request('status')=='0' )>Inativo</option>
          </select>
        </div>

        {{-- Botões --}}
        <div class="col-md-5 d-flex gap-2">
          <a class="btn btn-light w-100">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
              </svg>
            </span>
            Limpar filtros
          </a>
        </div>

      </form>
    </div>
  </div>

  @if(\Session::has('success'))
  <div class="row mt-2">
    <div class="col-6 m-auto">
      <div class="alert alert-success text-center" role="alert">
        {!! \Session::get('success') !!}
      </div>
    </div>
  </div>
  @endif
  @if(\Session::has('error'))
  <div class="row mt-2">
    <div class="col-6 m-auto">
      <div class="alert alert-danger text-center" role="alert">
        {!! \Session::get('error') !!}
      </div>
    </div>
  </div>
  @endif

  @if( $user->role === 'professor' || $user->role === 'administrador' || $user->role === 'coordenador' )
  <div class="row mt-4">
    <div class="col-12">
      <form action="{{ route('nucleo.material.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-12 col-md-6 mb-2">
            <input class="form-control" type="file" name="file" id="file" required>
          </div>
          @if( $user->role === 'administrador' )
          <div class="col mb-2">
            <select class="form-select" name="nucleo_id">
              @foreach( $nucleos as $nucleo )
              <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}</option>
              @endforeach
            </select>
          </div>
          @else
          <input type="hidden" name="nucleo_id" value="{{ $nucleos->id }}">
          @endif
          <div class="col-12 col-md-6">
            <button class="btn btn-success" type="submit">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endif

  <div class="row">
    <div class="col mt-4">
      {{ $user->role }}
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Título</th>
            <th scope="col">Enviado por</th>
            <th scope="col">Núcleo</th>
            <th scope="col">Data de envio</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $files as $file )
          <tr>
            <th>{{ $file->name }}</th>
            <th>{{ $file->user->name }}</th>
            <td>{{ $file->nucleo->NomeNucleo }}</td>
            <td>{{ $file->created_at->format('d/m/Y') }}</td>
            <td>@if( $file->status ) <span class="badge bg-success text-white p-2">disponível</span> @else <span class="badge bg-danger text-white p-2">indisponível</span> @endif</td>
            <td>
              @if( $user->role === 'professor' || $user->role === 'administrador' || $user->role === 'coordenador' )
              @if( $user->role === 'administrador' && $file->status || $user->id === $file->user_id )
              <a class="btn btn-sm btn-danger p-2" href="{{ route('nucleo.material.delete', ['id' => $file->id]) }}">Excluir</a>
              @elseif( $user->role === 'administrador' && !$file->status )
              <a class="btn btn-sm btn-warning p-2" href="{{ route('nucleo.material.restore', ['id' => $file->id]) }}">Restaurar</a>
              @endif
              @endif
              <a class="btn btn-sm btn-primary p-2" href="{{ asset('uploads') . '/' . $file->name }}" target="_blank">Baixar</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>

</div>
@endsection