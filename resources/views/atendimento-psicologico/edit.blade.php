@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Edição de Atendimento Psicológico</h1>
        </div>
    </div>

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

    @if ($errors->any())
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('atendimento-psicologico.update', $dados->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="demanda_objetivos" class="form-label">Demanda e Objetivos</label>
                    <input type="text" class="form-control" id="demanda_objetivos" name="demanda_objetivos" aria-describedby="demanda_objetivosHelp" value="{{ $dados->demanda_objetivos }}" required>
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="estudante_id" class="form-label">Estudante</label>
                    <select name="estudante_id" id="estudante_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($estudantes as $id => $nome)
                        <option value="{{ $id }}" {{ $dados->estudante_id == $id ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <label for="registro_atendimento" class="form-label">Registro do Atendimento / Procedimentos</label>
                    <input type="text" class="form-control" id="registro_atendimento" name="registro_atendimento" aria-describedby="registro_atendimentoHelp" value="{{ $dados->registro_atendimento }}" required>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label for="tipo_encaminhamento" class="form-label">Registro de Encaminhamento ou Encerramento</label>
                    <select name="tipo_encaminhamento" id="tipo_encaminhamento" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach(['SUS', 'CRAS', 'CREAS', 'Atendimento finalizado'] as $opcao)
                        <option value="{{ $opcao }}" {{ $dados->tipo_encaminhamento == $opcao ? 'selected' : '' }}>
                            {{ $opcao }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach(['Atendida/o', 'Cancelou', 'Não compareceu', 'Psi cancelou'] as $opcao)
                            <option value="{{ $opcao }}" {{ $dados->status == $opcao ? 'selected' : '' }}>
                                {{ $opcao }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descricao_encaminhamento" class="form-label">Descrição do Encaminhamento</label>
            <textarea name="descricao_encaminhamento" id="descricao_encaminhamento" class="form-control" rows="2">{{ $dados->descricao_encaminhamento }}</textarea>
        </div>

        <div class="mb-3">
            <label for="anexo" class="form-label">Anexo (PDF)</label>
            <input type="file" class="form-control" name="anexo" id="anexo" accept="application/pdf">
        </div>

        @if ($dados->anexo)
            <div class="mt-2 mb-3">
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

        <div class="row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a class="btn btn-outline-primary ms-3" href="{{ route('atendimento-psicologico.index') }}">Voltar</a>
            </div>
        </div>
    </form>
</div>
@endsection