@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="container">
    <div class="row">
      <div class="col-8">
        <h1 class="text-[34px]">Alunos (as)</h1>
      </div>
      <div class="col-4  text-center">
        <a class="btn btn-primary" href="/alunos/add"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
              <path d="M16 19h6" />
              <path d="M19 16v6" />
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg></span>Adicionar novo aluno</a>
        @if($user->role === 'coordenador')
        <a class="btn btn-outline" href="{{ route('alunos/export/') }}/?nucleo={{ $nucleo ?? '' }}"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M9 15h6" />
              <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
            </svg></span> Exportar</a>
        @else
        <a class="btn btn-outline-primary" href="{{ route('alunos/export/') }}/?nucleo=0">
          <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M9 15h6" />
              <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
            </svg></span>
          Exportar</a>
        @endif
      </div>
    </div>
    @if($user->role != 'aluno' && $user->role != 'professor')
    <div class="card mb-4 col-md-7">
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

          {{-- Situação --}}
          <div class="col-md-3">
            <select class="form-select" id="status" name="status">
              <option value="" @selected(request('status')=='' )>Situação</option>
              <option value="1" @selected(request('status')=='1' )>Ativos</option>
              <option value="0" @selected(request('status')=='0' )>Inativo</option>
            </select>
          </div>

          {{-- Lista de Espera --}}
          <div class="col-md-3">
            <select class="form-select" id="lista_espera" name="lista_espera">
              <option value="">Lista de espera</option>
              <option value="Sim">Sim</option>
              <option value="Não">Não</option>
            </select>
          </div>

          {{-- Botões --}}
          <div class="col-md-3 d-flex gap-2">
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

    <div class="row">
      <div class="col-6 m-auto">
        <form action="/alunos/search" method="POST" role="search">
          @csrf
          <div class="input-group d-flex justify-content-center align-center">
            <input type="text" class="form-control" name="inputQuery"
              placeholder="Buscar por nome ou sobrenome do aluno" required> <span class="input-group-btn">
              <button type="submit" class="btn-link text-decoration-none">
                <i class="fas fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </div>
    </div>
    @endif
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
  @if($alunos->isEmpty())
  @if($user->role != 'aluno' && $user->role != 'professor')
  <div class="col mt-4 text-center">
    <a class="btn btn-success" href="/alunos/add">Adicionar novo aluno</a>
  </div>
  @endif
  @else
  @endif
  <div class="row">
    <div class="col mt-4">
      @if($alunos->isEmpty())
      <p>Nenhum registro encontrado.</p>
      @else
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Foto</th>
            <th scope="col">Nome</th>
            <th scope="col">Núcleo</th>
            <th scope="col">Situação</th>
            <th scope="col">Lista de Espera</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($alunos as $aluno)
          <tr>
            @if($aluno->Foto)
            <td><img class="rounded-circle avatar" src="{{ asset('storage') }}/{{ $aluno->Foto }}" alt="{{ $aluno->NomeAluno }}"></td>
            @else
            <td><img class="rounded-circle avatar" src="{{ asset('images') }}/user.png" alt="{{ $aluno->NomeAluno }}"></td>
            @endif
            @if($aluno->NomeSocial === null)
            <td class="w25p">{{ $aluno->NomeAluno}}</td>
            @else
            <td class="w25p">{{ $aluno->NomeSocial}}</td>
            @endif
            @php $nomeNucleo = \App\Nucleo::where('id', $aluno->id_nucleo)->get('NomeNucleo'); @endphp
            @if($nomeNucleo->isEmpty())
            <td></td>
            @else
            <td>{{ $nomeNucleo[0]['NomeNucleo'] }}</td>
            @endif
            <td>
              @if($aluno->Status === 1)
              <span class="badge bg-success p-2 text-white">ATIVO</span>
              @else
              <span class="badge bg-danger p-2 text-white">INATIVO</span>
              @endif
            </td>
            @if($aluno->ListaEspera === 'Sim')
            <td>Sim</td>
            @else
            <td>Não</td>
            @endif
            <td>
              <a class="btn btn-info text-light" href="/alunos/details/{{ $aluno->id }}">Detalhes</a>
              <a class="btn btn-primary" href="/alunos/edit/{{ $aluno->id }}">Editar</a>
              @if($aluno->Status === 1)
              <a class="btn btn-danger disableBtn" href="/alunos/disable/{{ $aluno->id }}">Inativar</a>
              @else
              <a class="btn btn-success enableBtn" href="/alunos/enable/{{ $aluno->id }}">Ativar</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col">
      {{ $alunos->appends(request()->input())->links() }}
    </div>
  </div>
</div>
@endsection