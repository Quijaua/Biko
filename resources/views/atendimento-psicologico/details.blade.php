@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<!-- Modal -->
<div class="modal fade" id="logsModal" tabindex="-1" aria-labelledby="logsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logsModalLabel">Logs de Atendimento Psicológico</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body p-0">
        @if ($logs->isEmpty())
            <p class="text-muted p-4">Nenhum log registrado para este atendimento.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-nowrap text-black py-3">#</th>
                            <th class="text-nowrap text-black py-3">Usuário</th>
                            <th class="text-nowrap text-black py-3">Ação</th>
                            <th class="text-nowrap text-black py-3">Detalhes</th>
                            <th class="text-nowrap text-black py-3">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name ?? 'N/D' }}</td>
                            <td><span class="badge bg-{{ $log->acao === 'acessou' ? 'success' : 'info' }} text-white">{{ ucfirst(str_replace('_', ' ', $log->acao)) }}</span></td>
                            <td>{{ $log->detalhes ?? '-' }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($log->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    @if(session::has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif

    @if(session::has('error'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-danger text-center">
                {!! session::get('error') !!}
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('atendimento-psicologico.update', $dados->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-9">
                <h1 class="fs-1">Detalhes de Atendimento Psicológico</h1>
            </div>
            <div class="col-3 d-flex gap-3 justify-content-end align-items-center">
                <div>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#logsModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logs"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 12h.01" /><path d="M4 6h.01" /><path d="M4 18h.01" /><path d="M8 18h2" /><path d="M8 12h2" /><path d="M8 6h2" /><path d="M14 6h6" /><path d="M14 12h6" /><path d="M14 18h6" /></svg>
                        Ver Logs de Acesso/Edição
                    </button>
                </div>
                @if($dados->created_by == Auth::id())
                <div>
                    <a class="btn btn-primary" href="/atendimento-psicologico/edit/{{ $dados->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                        </svg>
                        Editar Dados
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="demanda_objetivos" class="form-label">Demanda e Objetivos</label>
                    <input type="text" class="form-control" id="demanda_objetivos" name="demanda_objetivos" aria-describedby="demanda_objetivosHelp" value="{{ $dados->demanda_objetivos }}" disabled>
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="estudante_id" class="form-label">Estudante</label>
                    <select name="estudante_id" id="estudante_id" class="form-select" disabled>
                        <option value="">Selecione</option>
                        @foreach($estudantes as $id => $nome)
                        <option value="{{ $id }}" {{ $dados->estudante_id == $id ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="registro_atendimento" class="form-label">Registro do Atendimento / Procedimentos</label>
                    <input type="text" class="form-control" id="registro_atendimento" name="registro_atendimento" aria-describedby="registro_atendimentoHelp" value="{{ $dados->registro_atendimento }}" disabled>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label for="tipo_encaminhamento" class="form-label">Registro de Encaminhamento ou Encerramento</label>
                    <select name="tipo_encaminhamento" id="tipo_encaminhamento" class="form-select" disabled>
                        <option value="">Selecione</option>
                        @foreach(['SUS', 'CRAS', 'CREAS', 'Atendimento finalizado'] as $opcao)
                        <option value="{{ $opcao }}" {{ $dados->tipo_encaminhamento == $opcao ? 'selected' : '' }}>
                            {{ $opcao }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descricao_encaminhamento" class="form-label">Descrição do Encaminhamento</label>
            <textarea name="descricao_encaminhamento" id="descricao_encaminhamento" class="form-control" rows="2" disabled>{{ $dados->descricao_encaminhamento }}</textarea>
        </div>

        <div class="mb-3">
            <label for="anexo" class="form-label">Anexo (PDF)</label>
            <!-- <input type="file" class="form-control" name="anexo" id="anexo" accept="application/pdf"> -->

            @if ($dados->anexo)
                <div class="mb-3">
                    <a class="btn btn-outline-primary p-2"
                        href="{{ route('atendimento-psicologico.download', $dados->id) }}"
                        target="_blank"><span><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg></span>
                        Baixar Anexo
                    </a>
                </div>
            @endif

            <div class="mb-3">
                @foreach($outros_atendimentos as $outro_atendimento)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="card-title">
                                Outros prontuários do estudante
                            </div>
                            <div class="col-10">
                                <p>Data: {{ date('d/m/Y', strtotime($outro_atendimento->data_atendimento)) }}</p>
                                <a href="/atendimento-psicologico/details/{{ $outro_atendimento->id }}">Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </form>
</div>
@endsection