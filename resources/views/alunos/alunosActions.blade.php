@extends('layouts.app')
@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="row">
      <div class="col-12 text-center">
        <h1>REGISTRO DE AÇÕES</h1>
      </div>
  </div>
  <div class="row mt-4 mb-4">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Usuário</th>
          <th scope="col">URL</th>
          <th scope="col">Estudante</th>
          <th scope="col">Data</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dados as $dado)
        <tr>
          <th scope="row">{{ $dado->username }}</th>
          <td>{{ $dado->url }}</td>
          <td>{{ $dado->alunoNome }}</td>
          <td>{{ $dado->created_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col">
      {{ $dados->appends(request()->input())->links() }}
    </div>
  </div>
</div>
@endsection
