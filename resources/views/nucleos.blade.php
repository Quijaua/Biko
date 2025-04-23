@extends('layouts.app')

@section('content')
<div class="container">
  <!-- PAGE HEADER -->
  <div class="container">
  <div class="row">
      <div class="col-6">
        <h1 class="text-[34px]">Núcleos</h1>
      </div>
      <div class="col-6" style="text-align: right;">
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
              <option value="ativo" @selected(request('status')=='ativo' )>Ativo</option>
              <option value="inativo" @selected(request('status')=='inativo' )>Inativo</option>
            </select>
          </div>

          {{-- Botões --}}
          <div class="col-md-5 d-flex gap-2">
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
  @endif

  <div class="container">
    <div class="rounded border border-gray-300">
        <form action="/nucleos/search" method="POST" class="p-4 bg-white" role="search">
            <div class="col-10 d-flex align-items-center gap-2">
                @csrf
                <input type="text" name="inputQuery" class="form-control"
                    placeholder="Digite o nome ou sobrenome para encontrar um professor(a)" required />

                <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-1">
                    <i class="fas fa-search"></i> Buscar
                </button>

                <a href="/nucleos" class="btn btn-light text-secondary">
                    Limpar
                </a>
            </div>
        </form>

        <div>
            @if ($nucleos->isEmpty())
            <div class="row">
              <div class="col text-center m-auto mt-4 mb-4">Nenhum registro encontrado.</div>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-nowrap text-black py-3"></th>
                            <th class="text-nowrap text-black py-3">Nome</th>
                            <th class="text-nowrap text-black py-3">Cidade</th>
                            <th class="text-nowrap text-black py-3">Telefone</th>
                            <th class="text-nowrap text-black py-3">Situação</th>
                            <th class="text-nowrap text-black py-3">Ações</th>
                        </tr>

                    </thead>
                    <tbody class="bg-white rounded">
                        @foreach ($nucleos as $nucleo)
                            <tr>
                                <td><input type="checkbox" class="custom-checkbox" /></td>
                             
                                {{-- Nome --}}
                                
                                <td>{{ $nucleo->NomeNucleo }}</td>

                                {{-- Cidade --}}
                                <td>{{ $nucleo->Cidade }}</td>


                                {{-- Telefone --}}
                                <td>{{ $nucleo->Telefone }}</td>

                                {{-- Situação --}}

                                <td class="text-center">
                                  @if($nucleo->Status === 1)
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

                                {{-- Ações --}}
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="/nucleos/details/{{ $nucleo->id }}"
                                            class="btn btn-outline-secondary">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg></span> Ver Detalhes
                                        </a>
                                        <a href="/nucleos/edit/{{ $nucleo->id }}"
                                            class="btn btn-primary">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                        fill="none" />
                                                    <path
                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg></span> Editar
                                        </a>
                                        <a href="#" id="modal-importar-alunos" class="btn btn-outline-primary open-modal-btn" data-url="{{route('alunos.importar', ['id' => $nucleo->id])}}">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                          </svg>
                                          
                                          Importar
                                         </a>
                                        @if ($nucleo->Status === 1)
                                            <a href="/nucleos/disable/{{ $nucleo->id }}">
                                                <span class="status-btn status-inativo ms-8">
                                                    <span class="status-circle"></span>
                                                    Inativar
                                                </span>
                                            </a>
                                        @else
                                            <a href="/nucleos/enable/{{ $nucleo->id }}">
                                                <span class="status-btn status-ativo ms-8">
                                                    Ativar
                                                    <span class="status-circle"></span>
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
        </div>
    </div>
</div>
  <div class="row">
    <div class="col">
      {{ $nucleos->links() }}
    </div>
  </div>
</div>

 <!-- Modal -->
 <div class="modal-overlay-custom" id="modalOverlay">
    <div class="modal-custom">
      <button class="close-modal" id="closeModal">&times;</button>
      <h2 class="fs-1">Importar alunos</h2>
      <div>
        <div class="row">
          <div class="col">
              <div class="mb-3">
                <div class="mb-4 pb-4 border-bottom">
                  <h3 class="fs-2 text-blue">Planilha Modelo</h3>
                  <p>
                    Clique no botão abaixo para baixar a planilha modelo.
                  </p>
                  <a href="/dist/planilhas/planilha_alunos.xlsx" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  height="800px" width="800px" version="1.1" id="Capa_1" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" viewBox="0 0 490 490" xml:space="preserve" fill="#fff">
                    <g>
                      <path d="M108.862,372.031l10.871-18.109c2.437-4.007,4.606-7.821,6.52-11.439l1.6-2.976h0.224l1.6,2.931l1.54,2.976   c1.51,2.871,3.095,5.712,4.755,8.509l10.826,18.109h16.778l-24.135-38.879l22.64-36.487h-16.898l-10.049,16.838   c-1.764,2.946-3.23,5.563-4.411,7.836l-1.376,2.602c-0.299,0.583-0.763,1.466-1.391,2.647h-0.209l-1.391-2.647l-1.376-2.662   c-1.406-2.572-2.886-5.189-4.471-7.836l-10.049-16.778H93.4l22.969,36.487l-24.733,38.879H108.862z"/>
                      <polygon points="219.459,359.216 184.124,359.216 184.124,296.665 169.813,296.665 169.813,372.031 219.459,372.031  "/>
                      <path d="M255.408,361.204c-8.21,0-13.234-0.583-15.073-1.764c-1.839-1.181-2.766-4.396-2.766-9.66l-0.045-1.6h-13.922l0.06,2.751   c0,8.763,1.944,14.58,5.817,17.451c3.888,2.871,11.754,4.307,23.612,4.307c13.174,0,21.698-1.466,25.571-4.381   c3.858-2.931,5.802-9.406,5.802-19.41c0-8.135-1.66-13.488-4.95-16.075c-3.29-2.572-10.557-4.172-21.787-4.8   c-9.495-0.508-15.088-1.256-16.778-2.213c-1.705-0.957-2.542-3.813-2.542-8.553c0-4.008,1.032-6.639,3.11-7.895   c2.079-1.256,6.505-1.884,13.279-1.884c5.757,0,9.406,0.553,10.946,1.63c1.54,1.092,2.482,3.753,2.811,7.985   c0,0.329,0.045,0.837,0.12,1.54h13.967v-2.871c0-7.806-1.974-13.04-5.907-15.731c-3.948-2.692-11.574-4.038-22.924-4.038   c-11.963,0-19.948,1.466-23.941,4.396c-3.993,2.916-5.981,8.793-5.981,17.585c0,8.613,1.645,14.221,4.965,16.838   c3.305,2.617,10.931,4.277,22.864,4.965l7.896,0.508c4.456,0.254,7.357,0.987,8.703,2.183c1.331,1.196,2.004,3.604,2.004,7.253   c0,4.935-0.882,8.09-2.647,9.451C265.905,360.532,261.808,361.204,255.408,361.204z"/>
                      <path d="M304.665,372.031l10.871-18.109c2.437-4.007,4.606-7.821,6.52-11.439l1.6-2.976h0.224l1.6,2.931l1.54,2.976   c1.51,2.871,3.095,5.712,4.755,8.509l10.826,18.109h16.778l-24.12-38.879l22.64-36.487h-16.898l-10.049,16.838   c-1.78,2.946-3.245,5.563-4.426,7.836l-1.376,2.602c-0.299,0.583-0.763,1.466-1.376,2.647h-0.224l-1.376-2.647l-1.391-2.662   c-1.391-2.572-2.886-5.189-4.471-7.836l-10.049-16.778h-17.062l22.969,36.487l-24.733,38.879H304.665z"/>
                      <path d="M77.788,0v265.111H42.189v139.615h0.001l35.59,35.591L77.788,490h370.023V102.422L345.388,0H77.788z M395.793,389.413   H57.501v-108.99h338.292V389.413z M353.022,36.962l57.816,57.804h-57.816V36.962z"/>
                    </g>
                    </svg> Baixar Planilha Modelo</a>
                </div>
                <div>
                  <h3 class="fs-2 text-blue">Importar Alunos</h3>
                  <p>Anexe abaixo sua planilha em xlsx.</p>
                  <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-label">
                      <input type="file" class="form-control mb-2" name="arquivo" required>
                      <button type="submit" class="btn btn-blue">                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                      </svg> Importar Alunos</button>
                    </div>
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
