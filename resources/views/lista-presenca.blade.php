@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-12 text-center">
        <h1>LISTAS DE PRESENÇA</h1>
      </div>
      <div class="col-12 text-center">
        <h2>({{ $nucleo->NomeNucleo }})</h2>
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
<div class="container">

  <form name="listaPresencaForm" action="{{ route('nucleo/presences/new') }}" method="get">
    @csrf
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <div class="mb-3">
            <?php $today = \Carbon\Carbon::now()->format('Y-m-d'); ?>
            <input type="date" class="form-control" id="date" name="date" aria-describedby="dateHelp" max="{{ $today }}">
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <div class="mb-3">
            <button class="btn btn-success" type="submit">Nova Lista</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="row">
    <div class="col" id="presences_wrapper">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Data</th>
            <th scope="col">Núcleo</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($nucleo->listas_presenca as $lista)
          <tr>
            <td>{{ $lista->date->format('d/m/Y') }}</td>
            <td>{{ $nucleo->NomeNucleo }}</td>
            <td>
              <a class="btn btn-primary btn-sm btn-absent mb-2" href="{{ route('nucleo/presences/new', ['date' => $lista->date->format('Y-m-d')]) }}">Ver/Editar</a>
              <a class="btn btn-danger btn-sm btn-absent mb-2" href="{{ route('nucleo/presences/destroy', ['id' => $lista->id]) }}">Excluir</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col">
      @foreach( $alunos as $aluno )
        @if( count($aluno->ausencias) > 0 )
          <p><b>Aluno: </b>{{ $aluno->NomeAluno }}</p>
          <p><b>Faltas: </b>{{ count($aluno->ausencias) }}</p>
          <hr>
        @endif
      @endforeach
    </div>
  </div>

</div>
@stop
