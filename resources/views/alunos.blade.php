@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="container">
    <div class="row">
      <div class="col-8">
        <h1 class="text-[34px]">Estudantes</h1>
      </div>
      <div class="col-4  text-center">
        <a class="btn btn-primary" href="/alunos/add"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
              <path d="M16 19h6" />
              <path d="M19 16v6" />
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg></span>Adicionar novo estudante</a>
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
    @if($user->role != 'aluno')
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
              <!--option value="{{ $nuc->id }}" @selected(request('nucleo')==$nuc->id)-->
              <option value="{{ $nuc->id }}" <?php if (request('nucleo') == $nuc->id) echo 'selected'; ?>>
                {{ $nuc->NomeNucleo }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- Situação --}}
          <div class="col-md-3">
            <select class="form-select" id="status" name="status">
              <option value="" @selected(request('status')=='' )>Situação</option>
              <!--option value="ativo" @selected(request('status')=='ativo' )>Ativos</option-->
              <option value="ativo" <?php if (request('status') == 'ativo') echo 'selected'; ?>>Ativo</option>
              <!--option value="inativo" @selected(request('status')=='inativo' )>Inativo</option -->
              <option value="inativo" <?php if (request('status') == 'inativo') echo 'selected'; ?>>Inativo</option>
            </select>
          </div>

          {{-- Lista de Espera --}}
          <div class="col-md-3">
            <select class="form-select" id="lista_espera" name="lista_espera">
              <option value="">Lista de espera</option>
              <option value="Sim" @selected(request('lista_espera')=='Sim' )>Sim</option>
              <option value="Não" @selected(request('lista_espera')=='Não' )>Não</option>
            </select>
          </div>

          {{-- Botões --}}
          <div class="col-md-3 d-flex gap-2">
            <a class="btn btn-light w-100" id="limparFiltros">
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
  <div class="container">
    <div class="rounded border border-gray-300">
      <form action="/alunos/search" method="POST" class="p-4 bg-white" role="search">
        <div class="col-10 d-flex align-items-center gap-2">
          @csrf
          <input type="text" name="inputQuery" class="form-control"
            placeholder="Digite o nome ou sobrenome para encontrar um(a) estudante" required />

          <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
            <i class="fas fa-search"></i> Buscar
          </button>

          <a href="/alunos" class="btn btn-light text-secondary">
            Limpar
          </a>
        </div>
      </form>

      <div>
        @if($alunos->isEmpty())
        <div class="row">
          <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
        </div>
        @else
        <div class="table-responsive">
          <table class="table table-hover table-vcenter">
            <thead>
              <tr>
              <th class="text-nowrap text-black py-3"></th>
                <th class="text-nowrap text-black py-3">Foto</th>
                <th class="text-nowrap text-black py-3">Nome</th>
                <th class="text-nowrap text-black py-3">Núcleo</th>
                <th class="text-nowrap text-black py-3">Situação</th>
                <th class="text-nowrap text-black py-3">Lista de Espera</th>
                <th class="text-nowrap text-black py-3">Ações</th>
              </tr>

            </thead>
            <tbody class="bg-white rounded">
              @foreach($alunos as $aluno)
              <tr>
                <td><input type="checkbox" class="custom-checkbox" /></td>

                {{-- Foto --}}
                <td>
                  <span class="avatar avatar-md rounded" style="background-image: url('{{ $aluno->Foto ? asset('storage/' . $aluno->Foto) : asset('images/user.png') }}')"></span>
                </td>

                {{-- Nome --}}
                <td class="text-secondary">
                  {{ $aluno->NomeSocial ?? $aluno->NomeAluno }}
                </td>

                {{-- Núcleo --}}
                @php
                $nomeNucleo = \App\Nucleo::find($aluno->id_nucleo);
                @endphp
                <td class="text-secondary">{{ $nomeNucleo->NomeNucleo ?? '' }}</td>

                {{-- Situação --}}
                <td>
                  @if($aluno->Status === 1)
                  <span class="status-badge status-ativo">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                    Ativo
                  </span>
                  @else
                  <span class="status-badge status-inativo">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-off me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.042 16.045a9 9 0 0 0 -12.087 -12.087m-2.318 1.677a9 9 0 1 0 12.725 12.73" /><path d="M3 3l18 18" /></svg>
                    Inativo
                  </span>
                  @endif
                </td>

                {{-- Lista de Espera --}}
                <td class="text-center">
                  @if($aluno->ListaEspera === 'Não')
                  <span class="custom-status-yellow text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M18 6l-12 12" />
                      <path d="M6 6l12 12" />
                    </svg></span>
                  @else
                  <span class="custom-status-purple text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M5 12l5 5l10 -10" />
                    </svg></span>
                  @endif
                </td>

                {{-- Ações --}}
                <td>
                  <div class="btn-list flex-nowrap">
                    <a href="/alunos/details/{{ $aluno->id }}" class="btn btn-outline-secondary">
                      <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                          <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                        </svg></span> Ver Detalhes
                    </a>
                    <a href="/alunos/edit/{{ $aluno->id }}" class="btn btn-primary">
                      <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                          <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                          <path d="M16 5l3 3" />
                        </svg></span> Editar
                    </a>
                    @if($aluno->Status === 0)
                    <a href="/alunos/enable/{{ $aluno->id }}">
                      <span class="status-btn status-ativo ms-8">
                        Ativar
                        <span class="status-circle"></span>
                      </span>
                    </a>
                    @else
                    <a onclick="e => e.preventDefault(); modalShow('Inativar aluno', 'Tem certeza que deseja inativar esse aluno?', 'danger', e => window.location.href = '/alunos/disable/{{ $aluno->id }}');">
                      <span class="status-btn status-inativo ms-8">
                        <span class="status-circle"></span>
                        Inativar
                      </span>
                    </a>
                    @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      {{ $alunos->appends(request()->input())->links() }}
    </div>
  </div>
</div>
@endsection
