@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Cadastro de Atendimento Psicológico</h1>
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

    <form action="{{ route('atendimento-psicologico.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="demanda_objetivos" class="form-label">Demanda e Objetivos</label>
                    <input type="text" class="form-control" id="demanda_objetivos" name="demanda_objetivos" aria-describedby="demanda_objetivosHelp" value="{{ old('demanda_objetivos') }}" required>
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="estudante_id" class="form-label">Estudante</label>
                    <select name="estudante_id" id="estudante_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($estudantes as $id => $nome)
                        <option value="{{ $id }}" {{ old('estudante_id') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="registro_atendimento" class="form-label">Registro do Atendimento / Procedimentos</label>
                    <input type="text" class="form-control" id="registro_atendimento" name="registro_atendimento" aria-describedby="registro_atendimentoHelp" value="{{ old('registro_atendimento') }}" required>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <label for="tipo_encaminhamento" class="form-label">Registro de Encaminhamento ou Encerramento</label>
                    <select name="tipo_encaminhamento" id="tipo_encaminhamento" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach(['SUS', 'CRAS', 'CREAS', 'Atendimento finalizado'] as $opcao)
                        <option value="{{ $opcao }}" {{ old('tipo_encaminhamento') == $opcao ? 'selected' : '' }}>
                            {{ $opcao }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descricao_encaminhamento" class="form-label">Descrição do Encaminhamento</label>
            <textarea name="descricao_encaminhamento" id="descricao_encaminhamento" class="form-control" rows="2">{{ old('descricao_encaminhamento') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="anexo" class="form-label">Anexo (PDF)</label>
            <input type="file" class="form-control" name="anexo" id="anexo" accept="application/pdf">
        </div>

        <div class="row">
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a class="btn btn-outline-primary ms-3" href="{{ route('atendimento-psicologico.index') }}">Voltar</a>
            </div>
        </div>
    </form>
</div>
@endsection