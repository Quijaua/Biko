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
                            <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" placeholder="Título do evento" value="{{ $ead->titulo }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="data">Data</label>
                            <input type="date" class="form-control" id="data" name="data" aria-describedby="tituloHelp" value="{{ $ead->data->format('Y-m-d') }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_inicio">Horário de inicio</label>
                            <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" aria-describedby="hora_inicioHelp" value="{{ $ead->hora_inicio }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="hora_fim">Horário de término</label>
                            <input type="text" class="form-control" id="hora_fim" name="hora_fim" aria-describedby="hora_fimHelp" value="{{ $ead->hora_fim }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="semestre">Semestre</label>
                            <select class="form-select" aria-label="Default select example" name="semestre" id="semestre" disabled>
                                <option value="02/2024" @if($ead->semestre == '02/2024') selected @endif>02/2024</option>
                                <option value="01/2025" @if($ead->semestre == '01/2025') selected @endif>01/2025</option>
                                <option value="02/2025" @if($ead->semestre == '02/2025') selected @endif>02/2025</option>
                                <option value="01/2026" @if($ead->semestre == '01/2026') selected @endif>01/2026</option>
                                <option value="02/2026" @if($ead->semestre == '02/2026') selected @endif>02/2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" aria-describedby="descricaoHelp" value="{{ $ead->descricao }}" disabled>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="link">Link da Aula</label>
                            <div class="mt-3">
                                <a href="{{ $ead->link }}" target="_blank">{{ $ead->link }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="tipo">Tipo</label>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo" disabled>
                                <option value="Palestras" @if($ead->tipo == 'Palestras') selected @endif >Palestras</option>
                                <option value="Encontros pedagógicos" @if($ead->tipo == 'Encontros pedagógicos') selected @endif >Encontros pedagógicos</option>
                                <option value="Encontros GARCIA" @if($ead->tipo == 'Encontros GARCIA') selected @endif >Encontros GARCIA</option>
                            </select>
                        </div>
                    </div>

                    @if($ead->material_apoio)
                    <div class="col-12">
                        <div class="mb-3">
                            <a href="{{ asset('storage/eads/' . $ead->id . '/' . $ead->material_apoio) }}" target="_blank">{{  $ead->material_apoio }}</a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-12 col-md-3">
                        <a class="btn btn-outline-primary ms-3" href="{{ route('ead.index') }}">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection