@extends('mensagens._mensagens')

@section('content_message')
    <div class="card">
        <div class="card-header">Nova mensagem</div>

        <div class="card-body">
            <form action="{{ route('messages.store') }}" id="mensagem-form" method="POST">
                @csrf

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="nucleos">Para os núcleos:</label>
                            <select name="nucleos[]" id="inputParaNucleo" class="form-select" multiple>
                                <option value="null" selected>Todos os núcleos</option>
                                @foreach($nucleos as $nucleo)
                                    <option value="{{ $nucleo->id }}">{{ $nucleo->NomeNucleo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row d-none" id="divAluno">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="alunos">Para o estudante:</label>
                            <select name="alunos[]" id="inputParaAluno" class="form-select" multiple>
                            </select>
                            <small class="form-text text-muted">Mantenha o campo vazio caso queira enviar para todos os estudantes dos núcleos selecionados.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3 @if ($errors->has('titulo')) has-error @endif">
                            <label class="form-label mb-2" for="titulo">Titulo:</label>
                            <input type="text" id="titulo" name="titulo" class="form-select" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3 @if ($errors->has('mensagem')) has-error @endif">
                            <label class="form-label mb-2" for="editor">Mensagem:</label>
                            <div id="editor"></div>
                            <input type="hidden" id="mensagem" name="mensagem" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 soffset-md-8 text-right">
                        <button type="submit" class="btn btn-primary btn-1">Enviar mensagem</button>
                        <a class="btn btn-2" href="{{ url()->previous() }}">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
