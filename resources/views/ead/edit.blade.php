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
            <form id="ead-form" action="{{ route('ead.update', $ead->id) }}" method="POST" role="search" enctype="multipart/form-data">
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

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="semestre">Semestre</label>
                            <select class="form-select" aria-label="Default select example" name="semestre" id="semestre">
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
                            <input type="text" class="form-control" id="descricao" name="descricao" aria-describedby="descricaoHelp" value="{{ $ead->descricao }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="link">Link da Aula</label>
                            <input type="text" class="form-control" id="link" name="link" aria-describedby="linkHelp" value="{{ $ead->link }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="material_apoio">Material de Apoio</label>
                            <input type="file" class="form-control" id="material_apoio" name="material_apoio" aria-describedby="material_apoioHelp" >
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="tipo">Tipo</label>
                            <select class="form-select" aria-label="Default select example" name="tipo" id="tipo">
                                <option value="Palestras" @if($ead->tipo == 'Palestras') selected @endif >Palestras</option>
                                <option value="Encontros pedagógicos" @if($ead->tipo == 'Encontros pedagógicos') selected @endif >Encontros pedagógicos</option>
                                <option value="Encontros GARCIA" @if($ead->tipo == 'Encontros GARCIA') selected @endif >Encontros GARCIA</option>
                                <option value="Encontros GARCIA" @if($ead->tipo == 'Aulas síncronas') selected @endif >Aulas síncronas</option>
                            </select>
                        </div>
                    </div>

                    @if($ead->material_apoio)
                    <div class="col-12">
                        <div class="mb-3">
                            <a href="{{ asset('storage/eads/' . $ead->id . '/' . $ead->material_apoio) }}" target="_blank">{{  $ead->material_apoio }}</a>
                            <span id="remove_material" class="text-danger px-2" style="cursor: pointer;" data-id="{{ $ead->id }}">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" /><path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" /><path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" /><path d="M8.56 20.31a9 9 0 0 0 3.44 .69" /><path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" /><path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" /><path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" /><path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" /><path d="M14 14l-4 -4" /><path d="M10 14l4 -4" /></svg>
                            </span>
                        </div>
                    </div>
                    @endif
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
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

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

        $('#remove_material').click(function() {
            let id = $(this).attr('data-id');

            $.ajax({
                url: "{{ route('ead.remove_material') }}",
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    ead_id: id
                },
                success: function(response) {
                    location.reload();
                }
            })
        })

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: 'Arraste o arquivo aqui ou <span class="filepond--label-action">Procurar</span>',
            credits: false,
            acceptedFileTypes: ['application/pdf', 'image/jpeg', 'image/png'],
            labelFileTypeNotAllowed: 'Formato de arquivo inválido',
            allowMultiple: false,
            server: {
                url: "{{ route('ead.upload') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    })
</script>
@endsection