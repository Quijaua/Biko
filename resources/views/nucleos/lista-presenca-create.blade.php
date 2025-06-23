@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-12 text-center">
        <h1>LISTA DE PRESENÇA #{{ $lista->id }}</h1>
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
  <div class="row">
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="presenceDate" class="form-label">Data</label>
        <input type="date" class="form-control" name="presenceDate" id="presenceDate" value="{{ $date }}" disabled>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col" id="presences_wrapper">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Presente?</th>
            <th scope="col">Situação</th>
          </tr>
        </thead>
        <tbody>
          @if( $lista->frequencias->isNotEmpty() )
            @foreach($lista->frequencias as $list)
            <tr>
              <td>{{ $list->aluno->NomeAluno }}</td>
              <td>
                <button aria-label="{{ $list->aluno->id }}" class="btn btn-success btn-sm btn-present mb-2" type="button" name="button">Sim</button>
                <button aria-label="{{ $list->aluno->id }}" class="btn btn-danger btn-sm btn-absent mb-2" type="button" name="button">Não</button>
              </td>
              <td id="{{ $list->aluno->id }}">@if( $list->is_present ) <?php echo '<span class="badge bg-success text-white">Presente</span>'; ?> @elseif( !$list->is_present ) <?php echo '<span class="badge bg-danger text-white">Ausente</span>'; ?> @endif</td>
            </tr>
            @endforeach
          @else
            @foreach($alunos as $aluno)
            <tr>
              <td>{{ $aluno->NomeAluno }}</td>
              <td>
                <button aria-label="{{ $aluno->id }}" class="btn btn-success btn-sm btn-present mb-2" type="button" name="button">Sim</button>
                <button aria-label="{{ $aluno->id }}" class="btn btn-danger btn-sm btn-absent mb-2" type="button" name="button">Não</button>
              </td>
              <td id="{{ $aluno->id }}"></td>
            </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop
@section('js')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script>
  let listaId = '<?php echo $lista->id ?>';

  $('.btn-present').click(function() {
    let alunoId = $(this).attr('aria-label');
    let situation = 1;
    $('td[id='+alunoId+']').html('<span class="badge bg-success text-light">Presente</span>');
    /*console.log('listaId', listaId);
    console.log('alunoId', alunoId);
    console.log('situation', situation);*/
    //REGISTRA A FREQUENCIA DO ALUNO
    axios.post('/nucleo/presences/create', {
        'listaId': listaId,
        'alunoId': alunoId,
        'situation': situation
      })
      .then(function (response) {
        /*console.log(response);*/
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  $('.btn-absent').click(function() {
    let alunoId = $(this).attr('aria-label');
    let situation = 0;
    $('td[id='+alunoId+']').html('<span class="badge bg-danger text-light">Ausente</span>');
    /*console.log('listaId', listaId);
    console.log('alunoId', alunoId);
    console.log('situation', situation);*/
    //REGISTRA A FREQUENCIA DO ALUNO
    axios.post('/nucleo/presences/create', {
        'listaId': listaId,
        'alunoId': alunoId,
        'situation': situation
      })
      .then(function (response) {
        /*console.log(response);*/
      })
      .catch(function (error) {
        console.log(error);
      });
  });

</script>
@stop
