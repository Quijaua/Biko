@extends('layouts.app')

@section('content')
<div class="container">

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
        <div class="col-7">
          <h1 class="text-[34px]">Núcleos</h1>
        </div>
        <div class="col-5">
          @if(Session::get('role') == 'professor')
          <div class="row">
            <div class="col-5">
              <?php $today = \Carbon\Carbon::now()->format('Y-m-d'); ?>
              <small>Período</small>
              <input type="date" class="form-control" id="date" name="date" aria-describedby="dateHelp" max="{{ $today }}">
            </div>
            <div class="col-5" style="margin-top: 20px;">
              <button class="btn btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                  <path d="M16 19h6" />
                  <path d="M19 16v6" />
                  <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Adicionar nova Lista</button>
            </div>
            @endif
          </div>
        </div>
        <div class="card mb-4 col-md-5">
          <div class="card-body">
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

            <div class="row">
              {{-- Núcleo --}}
              <div class="col-md-3" style="margin-top: 20px;">
                <select class="form-select" id="nucleo" name="nucleo">
                  <option value="" @selected(request('nucleo')=='' )>Núcleo</option>
                  @foreach(\App\Nucleo::all() as $nuc)
                  <option value="{{ $nuc->id }}" @selected(request('nucleo')==$nuc->id)>
                    {{ $nuc->NomeNucleo }}
                  </option>
                  @endforeach
                </select>
              </div>

              {{-- Periodo --}}
              <div class="col-4">
                <?php $today = \Carbon\Carbon::now()->format('Y-m-d'); ?>
                <small>Período</small>
                <input type="date" class="form-control" id="date" name="date" aria-describedby="dateHelp" max="{{ $today }}">
              </div>

              {{-- Botões --}}
              <div class="col-md-5" style="margin-top: 20px;">
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
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        @if(Session::get('role') === 'administrador')
        <div class="col-12">
          <div class="mb-3 d-flex justify-content-end">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $nucleo->NomeNucleo }}
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($nucleos as $nucleo_id => $nucleo_name)
                <li>
                  <a class="dropdown-item" href="{{ route('nucleo/presences', ['nid' => $nucleo_id]) }}">{{ $nucleo_name }}</a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif

      </div>
    </form>

    <div class="row">
      <div class="col" id="presences_wrapper">
        <table class="table table-hover">
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
                @if(Session::get('role') === 'administrador')
                -
                @else
                <a class="btn btn-primary btn-sm btn-absent mb-2" href="{{ route('nucleo/presences/new', ['date' => $lista->date->format('Y-m-d')]) }}">Ver/Editar</a>
                <a class="btn btn-danger btn-sm btn-absent mb-2" href="{{ route('nucleo/presences/destroy', ['id' => $lista->id]) }}">Excluir</a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-12 text-center">
        <h1>ALUNOS COM AUSÊNCIA</h1>
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