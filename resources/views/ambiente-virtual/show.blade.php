@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>Aula: {{ $aula->titulo }} (Professor: {{ $aula->professor->NomeProfessor }})</h1>
            <h3 class="text-muted">@php echo strip_tags($aula->descricao); @endphp</h3>
            <h3 class="text-muted">Disciplina: {{ $aula->disciplina->nome }}</h3>
        </div>
    </div>
    @if(Session::has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center" role="alert">
                {!! session::get('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-danger text-center" role="alert">
                {!! session::get('error') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col mt-4 mb-4">
            <div class="plyr__video-embed" id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $aula->yt_url }}" >
                <video>
                    <source src="{{ $aula->yt_url }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col mt-4">
            <h1>Comentarios</h1><?php //dd($aula->comentario) ?>
            @foreach($aula->comentario as $comentario)
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <p>Comentario: <?php echo strip_tags($comentario->comentario); ?></p>
                        </div>
                        <div class="col-2">
                            <p>Aluno: {{ $comentario->user->aluno->NomeAluno ?? $comentario->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ambiente-virtual.comentar', $aula) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}" />
                        <div class="form-group">
                            <label class="mb-2" for="comentarios">Comentar</label>
                            <textarea class="form-control" id="comentarios" name="comentario" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script src="{{ asset('dist/libs/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var player = new Plyr('#player');

        let options = {
            selector: "#comentarios",
            language: "pt_BR",
            menubar: false,
            license_key: 'gpl',
        }

        tinyMCE.init(options)
    })
</script>
@endsection

@section('scripts')

@endsection