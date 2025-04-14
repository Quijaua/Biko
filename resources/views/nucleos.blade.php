@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>CADASTRO DE NÚCLEOS</h1>
      </div>
  </div>
  <div class="container">
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
            <th scope="col">Ambiente Virtual</th>
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
            <td class="text-center">
              @if($nucleo->permite_ambiente_virtual === 1)
              <span class="badge text-white bg-success p-2">SIM</span>
              @else
              <span class="badge text-white bg-danger p-2">NÃO</span>
              @endif
            </td>
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
