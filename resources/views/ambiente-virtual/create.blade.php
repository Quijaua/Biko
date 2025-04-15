@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>CADASTRO DE AULAS VIRTUAIS</h1>
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
            <form action="{{ route('ambiente-virtual.store') }}" method="POST" role="search" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" placeholder="Título da aula virtual" required>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="imagem_capa">Imagem da capa</label>
                            <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" aria-describedby="imagem_capaHelp" placeholder="Imagem da capa da aula virtual" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="yt_url">Link</label>
                            <input type="text" class="form-control" id="yt_url" name="yt_url" aria-describedby="yt_urlHelp" placeholder="Link da aula virtual" required>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="professor_id">Nome do professor</label>
                            <select name="professor_id" class="form-select" required>
                                <option value="" selected>Selecione</option>
                                @foreach($professores as $professor)
                                <option value="{{ $professor->id }}">{{ $professor->NomeProfessor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="disciplina_id">Disciplina</label>
                            <select name="disciplina_id" class="form-select" >
                                <option value="" selected>Selecione</option>
                                @foreach($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="descricao">Descrição</label>
                            <input type="textarea" class="form-control" id="descricao" name="descricao" aria-describedby="descricaoHelp" placeholder="Descrição da aula virtual" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <a class="btn btn-danger" href="{{ route('ambiente-virtual.index') }}">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('dist/libs/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {

        let options = {
            selector: "#descricao",
            language: "pt_BR",
            menubar: false,
            license_key: 'gpl',
        }

        tinyMCE.init(options)
    })
</script>
@endsection