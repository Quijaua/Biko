@extends('layouts.app')

@inject('session', 'Session')

@section('content')
<link rel="stylesheet" href="{{ asset('dist/libs/plyr/dist/plyr.css') }}" />

    <div class="container">
        <!-- PAGE HEADER -->
        <div class="row">
            <div class="col-12">
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
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 col-md-8 mt-4 mb-0 mb-md-4">
                    <p style="font-size: 24px;"><span>
                    <a href="/ambiente-virtual" class="text-primary">
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
                    </a>
                    </span>
                    Todas aulas</p>

                    <div class="plyr__video-embed" id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $aula->yt_url }}" >
                        <video>
                            <source src="{{ $aula->yt_url }}" type="video/mp4">
                        </video>
                    </div>
                </div>


                <div class="col-12 col-md-4 mt-5">
                    <div class="mt-0 mt-md-6 p-2 p-md-0 mb-md-4 mb-2">
                        <h1>Aula: {{ $aula->titulo }} (Professor: {{ $aula->professor->NomeProfessor }})</h1>
                        <p>@php echo strip_tags($aula->descricao); @endphp</p>
                        <strong>Matéria:</strong> {{ $aula->disciplina->nome ?? "Sem matéria" }}
                        @if($aula->class_duration)<p><strong>Duração:</strong> {{ $aula->class_duration }}</p>@endif
                        @if(Auth::user()->role == 'aluno')
                        <form id="formMarcarAssistido" action="{{ route('ambiente-virtual.marcar-assistido') }}" method="POST">
                            @csrf
                            <input type="hidden" name="aluno_id" value="{{ Auth::user()->aluno->id }}">
                            <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}">
                        </form>
                        <form id="formDesmarcarAssistido" action="{{ route('ambiente-virtual.desmarcar-assistido') }}" method="POST">
                            @csrf
                            <input type="hidden" name="aluno_id" value="{{ Auth::user()->aluno->id }}">
                            <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}">
                        </form>
                        @if(!$is_assistido)
                        <button type="submit" form="formMarcarAssistido" class="btn btn-success mt-2" >Marcar como assistido</button>
                        @endif
                        @if($is_assistido)
                        <button type="submit" form="formDesmarcarAssistido" class="btn btn-secondary mt-2" >Desmarcar como assistido</button>
                        @endif
                        @endif
                    </div>

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
                    <div class="card">
                        <div class="card-body">
                        @php
                            $tipo = Auth::user()->role;
                        @endphp

                        @if($tipo === 'aluno')
                            <form id="formAnotar" action="{{ route('ambiente-virtual.anotar', $aula) }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}" />
                                <div class="form-group">
                                    <label class="mb-2" for="comentarios">Anotações</label>
                                    <textarea class="form-control" id="nota" name="nota" rows="3"></textarea>
                                </div>
                                <button form="formAnotar" type="submit" class="btn btn-primary mt-2">Anotar</button>
                            </form>
                        @else
                            <p class="text-muted">Apenas estudantes podem fazer anotações nesta aula.</p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- COMENTARIOS -->
            <div class="row">
                <div class="col-12 col-md-12 mt-4">
                    <h3>Comentários</h3>
                    @foreach($aula->comentario as $comentario)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <p><strong>Comentário:</strong> <?php echo strip_tags($comentario->comentario); ?></p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p>
                                        @if($comentario->user->aluno)
                                            <strong>Estudante:</strong> {{ $comentario->user->aluno->NomeAluno }}
                                        @elseif($comentario->user->professor)
                                            <strong>Professor:</strong> {{ $comentario->user->professor->NomeProfessor }}
                                        @else
                                            <strong>Usuário:</strong> {{ $comentario->user->name }}
                                        @endif
                                    </p>

                                </div>
                                <div class="col-12 col-md-4">
                                    <p><strong>Data:</strong> {{ $comentario->created_at->format('d/m/Y') }}</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <p>
                                        <!-- Button trigger modal resposta -->
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#respostaModal" data-comentario-id="{{ $comentario->id }}" >
                                        Responder
                                        </button>
                                    </p>
                                </div>

                                @if($aula->respostas->where('comentario_id', $comentario->id)->count() > 0)
                                <div class="col-12 ">
                                    <div class="accordion accordion-flush" id="accordion<?php echo $comentario->id; ?>">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $comentario->id; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $comentario->id; ?>">
                                                    {{  $aula->respostas->where('comentario_id', $comentario->id)->count() }} resposta<?php if(count($aula->respostas->where('comentario_id', $comentario->id)) > 1) echo 's'; ?>
                                                </button>
                                            </h2>
                                            <div id="flush-collapse<?php echo $comentario->id; ?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?php echo $comentario->id; ?>">
                                                <div class="accordion-body">
                                                    @foreach($aula->respostas->where('comentario_id', $comentario->id) as $resposta)
                                                    <p><strong>{{  $resposta->user->name }}</strong>: <?php echo strip_tags($resposta->comentario); ?></p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="card">
                        <div class="card-body">
                            <form id="formComentar" action="{{ route('ambiente-virtual.comentar', $aula) }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}" />
                                <div class="form-group">
                                    <label class="mb-2" for="comentarios">Comentar</label>
                                    <textarea class="form-control" id="comentarios" name="comentario" rows="3"></textarea>
                                </div>
                                <button form="formComentar" type="submit" class="btn btn-primary mt-2">Comentar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Resposta -->
            <div class="modal modal-lg fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="respostaModalLabel">Responder comentario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formResponderComentario" action="{{ route('ambiente-virtual.responder-comentario') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}" />
                                <div class="form-group">
                                    <label class="mb-2" for="comentarios">Responder</label>
                                    <textarea class="form-control" id="comentarios" name="comentario" rows="3"></textarea>
                                </div>
                                <button id="btnEnviarResposta" form="formResponderComentario" type="submit" class="btn btn-primary mt-2">Enviar resposta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<script src="{{ asset('dist/libs/plyr/dist/plyr.js') }}"></script>
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

        $('#respostaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var comentario_id = button.data('comentario-id')
            var modal = $(this)
            modal.find('.modal-body form').append('<input type="hidden" name="comentario_id" value="' + comentario_id + '" />')
        })

        $('#respostaModal').on('hide.bs.modal', function (event) {
            $('#formResponderComentario').trigger('reset')
        })

        $('#formResponderComentario').on('submit', function() {
            let comentario = $(this).find('#comentarios').val()
            if(!comentario || comentario == '') {
                $('.modal-body').append('<div class="col-12 m-auto mt-2"><div class="alert alert-danger" role="alert">O campo da resposta precisa ser preenchido</div></div>')
                return false
            }
        })
    })
</script>
@endsection

@section('scripts')

@endsection
