@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="container">
  <div class="row">
      <div class="col-8">
        <h1 class="text-[34px]">Núcleos</h1>
      </div>
      <div class="col-4  text-center">
        @if($user->role != 'aluno' && $user->role != 'professor')
        <a class="btn btn-primary" href="/nucleos/add"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
              <path d="M16 19h6" />
              <path d="M19 16v6" />
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
            </svg></span>Adicionar novo núcleos</a>
        @endif
        @if($user->role === 'coordenador')
        <a class="btn btn-outline"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-arrow-right">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M9 15h6" />
              <path d="M12.5 17.5l2.5 -2.5l-2.5 -2.5" />
            </svg></span> Exportar</a>
        @else
        <a class="btn btn-outline-primary">
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
            <select class="form-select" id="cidade" name="cidade">
              <option value="" @selected(request('cidade')=='')>Cidade</option>
              @foreach(\App\Nucleo::all() as $nuc)
              <option value="{{ $nuc->Cidade }}" @selected(request('cidade')==$nuc->Cidade)>
                {{ $nuc->Cidade }}
              </option>
              @endforeach
            </select>
          </div>

          {{-- Situação --}}
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
    <div class="row">
      <div class="col-6 m-auto">
        <form action="/nucleos/search" method="POST" role="search">
        @csrf
        @if($user->role != 'aluno' && $user->role != 'professor')
        <div class="input-group">
            <input type="text" class="form-control" name="inputQuery"
                placeholder="Buscar por nome do núcleo" required> <span class="input-group-btn">
                <button type="submit" class="btn-link text-decorate-none">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </div>
        @endif
        </form>
      </div>
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
  @if($nucleos->isEmpty())
  @if($user->role != 'aluno' && $user->role != 'professor' && $user->role != 'coordenador')
  <div class="col mt-4 text-center">
    <a class="btn btn-success" href="/nucleos/add">Adicionar novo núcleo</a>
  </div>
  @endif
  @else
  @foreach($nucleos as $nucleo)
  @endforeach
  @if($user->role != 'aluno' && $user->role != 'professor' && $user->role != 'coordenador')
  <div class="col mt-4 text-center">
    <a class="btn btn-success" href="/nucleos/add">Adicionar novo núcleo</a>
    @if($nucleo->Status === 1)
    <a class="btn btn-danger" href="/nucleos/search/?status=0">Ver núcleos inativos</a>
    @else
    <a class="btn btn-primary" href="/nucleos">Ver núcleos ativos</a>
    @endif
  </div>
  @endif
  @endif
  <div class="row">
    <div class="col mt-4">
      @if($nucleos->isEmpty())
      <p>Nenhum registro encontrado.</p>
      @else
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Cidade</th>
            <th scope="col">Telefone</th>
            <th scope="col">Situação</th>
            <th scope="col">Alunos Ativos</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($nucleos as $nucleo)
          <tr>
            <td>{{ $nucleo->NomeNucleo }}</td>
            <td>{{ $nucleo->Cidade }}</td>
            <td>{{ $nucleo->Telefone }}</td>
            <td class="text-center">
              @if($nucleo->Status === 1)
              <span class="badge text-white bg-success p-2">ATIVO</span>
              @else
              <span class="badge text-white bg-danger p-2">INATIVO</span>
              @endif
            </td>
            <!--<td class="text-center"><span class="text-light badge badge-info p-2">{{ $nucleo->alunos->count() }}</span></td>-->
            @if($user->role === 'coordenador')
            @if($nucleo->id === $user->coordenador->id_nucleo)
            <td class="text-center"><span class="badge bg-info p-2"><a class="text-light" href="{{ route('alunos/nucleo/search') }}?nucleo={{ $myNucleo ?? '' }}&status=1">{{ $nucleo->alunos->where('Status', 1)->count() }}</a></span></td>
            @else
            <td class="text-center"><span class="badge badge-secondary p-2 text-light">{{ $nucleo->alunos->where('Status', 1)->count() }}</span></td>
            @endif
            @endif
            @if($user->role !== 'coordenador')
            <td class="text-center"><span class="badge bg-info p-2"><a class="text-light" href="{{ route('alunos/nucleo/search') }}?nucleo={{ $nucleo->id }}&status=1">{{ $nucleo->alunos->where('Status', 1)->count() }}</a></span></td>
            @endif
            <td>
              <a class="btn btn-info text-light" href="/nucleos/details/{{ $nucleo->id }}">Detalhes</a>
              <a class="btn btn-primary" href="/nucleos/edit/{{ $nucleo->id }}">Editar</a>
              @if($nucleo->Status === 1)
              <a class="btn btn-danger disableBtn" href="/nucleos/disable/{{ $nucleo->id }}">Inativar</a>
              @else
              <a class="btn btn-success enableBtn" href="/nucleos/enable/{{ $nucleo->id }}">Ativar</a>
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
      {{ $nucleos->links() }}
    </div>
  </div>
</div>
@endsection
