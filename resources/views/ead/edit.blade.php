@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>CADASTRO DE EVENTOS</h1>
        </div>
    </div>
    @if(session::has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center" role="alert">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if(session::has('error'))
    <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! session::get('error') !!}
                </div>
            </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{ route('ead.update', $ead->id) }}" method="POST" role="search" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" placeholder="Título do evento" value="{{ $ead->titulo }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="data">Data</label>
                            <input type="date" class="form-control" id="data" name="data" aria-describedby="tituloHelp" value="{{ $ead->data->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_inicio">Horário de inicio</label>
                            <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" aria-describedby="hora_inicioHelp" value="{{ $ead->hora_inicio }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_fim">Horário de término</label>
                            <input type="text" class="form-control" id="hora_fim" name="hora_fim" aria-describedby="hora_fimHelp" value="{{ $ead->hora_fim }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" aria-describedby="descricaoHelp" value="{{ $ead->descricao }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="link">Link da Aula</label>
                            <input type="text" class="form-control" id="link" name="link" aria-describedby="linkHelp" value="{{ $ead->link }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="material_apoio">Material de Apoio</label>
                            <input type="file" class="form-control" id="material_apoio" name="material_apoio" aria-describedby="material_apoioHelp" >
                        </div>
                        <div class="mb-3">
                            <a href="{{ asset('eads/' . $ead->id . '/' . $ead->material_apoio) }}" target="_blank">{{  $ead->material_apoio }}</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-outline-primary ms-3" href="{{ route('ead.index') }}">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('#hora_inicio').mask('00:00', {reverse: true});
        $('#hora_fim').mask('00:00', {reverse: true});

        $('#hora_inicio').change(function() {
            if ($(this).val().length < 4) {
                let newValue = $(this).val()+':00';
                $(this).val(newValue);
            }
        })

        $('#hora_fim').change(function() {
            if ($(this).val().length < 4) {
                let newValue = $(this).val()+':00';
                $(this).val(newValue);
            }
        })
    })
</script>
@endsection