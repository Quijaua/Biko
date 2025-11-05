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
            <form action="{{ route('ead.store') }}" method="POST" role="search" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" placeholder="Título do evento" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="data">Data</label>
                            <input type="date" class="form-control" id="data" name="data" aria-describedby="tituloHelp" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_inicio">Horário de inicio</label>
                            <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" aria-describedby="hora_inicioHelp" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_fim">Horário de término</label>
                            <input type="text" class="form-control" id="hora_fim" name="hora_fim" aria-describedby="hora_fimHelp" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="semestre">Semestre</label>
                            <select class="form-select" aria-label="Default select example" name="semestre" id="semestre">
                                <option value="02/2024">02/2024</option>
                                <option value="01/2025">01/2025</option>
                                <option value="02/2025">02/2025</option>
                                <option value="01/2026">01/2026</option>
                                <option value="02/2026">02/2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" aria-describedby="descricaoHelp" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="link">Link da Aula</label>
                            <input type="text" class="form-control" id="link" name="link" aria-describedby="linkHelp" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="material_apoio">Material de Apoio</label>
                            <input type="file" class="form-control" id="material_apoio" name="material_apoio" aria-describedby="material_apoioHelp" >
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="tipo">Tipo</label>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo">
                                <option value="Palestras">Palestras</option>
                                <option value="Encontros pedagógicos">Encontros pedagógicos</option>
                                <option value="Encontros GARCIA">Encontros GARCIA</option>
                            </select>
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