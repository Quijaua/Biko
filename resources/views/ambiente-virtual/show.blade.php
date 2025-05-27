@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<link rel="stylesheet" href="{{ asset('public/dist/libs/plyr/dist/plyr.css') }}" />
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-8">
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

    <div>
            <p style="font-size: 24px;"><span><a href="/ambiente-virtual" class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 30px; height: 30px;" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-arrow-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" />
                            <path d="M8 12l4 4" />
                            <path d="M8 12h8" />
                            <path d="M12 8l-4 4" />
                        </svg>
                    </a></span> Todas aulas</p>
        </div>

                    <div class="plyr__video-embed" id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $aula->yt_url }}" >
                        <video>
                            <source src="{{ $aula->yt_url }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mt-4">
                    <h2>Comentarios</h2>
                    @foreach($aula->comentario as $comentario)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <p>Comentario: <?php echo strip_tags($comentario->comentario); ?></p>
                                </div>
                                <div class="col">
                                    <p>Estudante: {{ $comentario->user->aluno->NomeAluno ?? $comentario->user->name }}</p>
                                </div>
                                <div class="col">
                                    <p>Data: {{ $comentario->created_at->format('d/m/Y') }}</p>
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
                                <button type="submit" class="btn btn-primary mt-2">Comentar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4 mt-5">
            <h1 class="mt-6">Aula: {{ $aula->titulo }} (Professor: {{ $aula->professor->NomeProfessor }})</h1>
                <p>@php echo strip_tags($aula->descricao); @endphp</p>
                <div><strong>Disciplina:</strong> {{ $aula->disciplina->nome }}</div>

                <div class="row">
            <div class="col mt-4">
                <?php //dd($aula->nota) ?>
                @foreach($aula->nota as $nota)
                @if(Auth::user()->id === $nota->user_id)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <p>Nota: <?php echo strip_tags($nota->nota); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ambiente-virtual.anotar', $aula) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}" />
                        <div class="form-group">
                            <label class="mb-2" for="comentarios">Anotações</label>
                            <textarea class="form-control" id="nota" name="nota" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Anotar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('public/dist/libs/plyr/dist/plyr.js') }}"></script>
<script src="{{ asset('dist/libs/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var player = new Plyr('#player');

        let options = {
            selector: "#comentarios",
            language: "pt_BR",
            menubar: false,
            height: 200,
            license_key: 'gpl',
        }

        let optionsNotas = {
            selector: "#nota",
            language: "pt_BR",
            height: 150,
            menubar: false,
            license_key: 'gpl',
        }

        tinyMCE.init(options)

        tinyMCE.init(optionsNotas)
    })
</script>
@endsection

@section('scripts')

@endsection
