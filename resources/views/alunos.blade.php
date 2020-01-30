@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>CADASTRO DE ALUNOS</h1>
      </div>
  </div>
  <div class="container">
    @if($user->role != 'aluno' && $user->role != 'professor')
    <div class="row">
      <div class="col-6 m-auto">
        <form action="/alunos/search" method="POST" role="search">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" name="inputQuery"
                placeholder="Buscar por nome ou sobrenome do aluno" required> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
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
  @foreach($alunos as $aluno)
  @endforeach
  @if($user->role != 'aluno' && $user->role != 'professor')
  <div class="col mt-4 text-center">
    <a class="btn btn-success" href="/alunos/add">Adicionar novo aluno</a>
    @if($aluno->Status === 1)
    <a class="btn btn-danger" href="/alunos/search/?status=0">Ver alunos inativos</a>
    @else
    <a class="btn btn-primary" href="/alunos">Ver alunos ativos</a>
    @endif
    @if(url()->current() != $app['url']->to('/') . '/alunos/search')
      <a class="btn btn-primary" href="{{ route('alunos/export/') }}/?nucleo=0">Exportar</a>
    @else
    <a class="btn btn-primary" href="{{ route('alunos/export/') }}/?nucleo={{ $aluno->id_nucleo }}">Exportar</a>
    @endif
  </div>
  @endif
  @endif
  <div class="row">
    <div class="col mt-4">
      @if($alunos->isEmpty())
      <p>Nenhum registro encontrado.</p>
      @else
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Foto</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF</th>
            <th scope="col">Núcleo</th>
            <th scope="col">Situação</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($alunos as $aluno)
          <tr>
            <td><img class="rounded-circle" src="{{ asset('storage') }}/{{ $aluno->Foto }}" alt="{{ $aluno->Foto }}" width="25%"></td>
            @if($aluno->NomeSocial === null)
            <td>{{ $aluno->NomeAluno}}</td>
            @else
            <td>{{ $aluno->NomeSocial}}</td>
            @endif
            <td>{{ $aluno->CPF }}</td>
            @php $nomeNucleo = \App\Nucleo::where('id', $aluno->id_nucleo)->get('NomeNucleo'); @endphp
            @if($nomeNucleo->isEmpty())
            <td></td>
            @else
            <td>{{ $nomeNucleo[0]['NomeNucleo'] }}</td>
            @endif
            <td>
              @if($aluno->Status === 1)
              <span class="badge badge-success p-2">ATIVO</span>
              @else
              <span class="badge badge-danger p-2">INATIVO</span>
              @endif
            </td>
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
</div>
@endsection
