@extends('layouts.app')

@inject('session', 'Session')

@section('content')

<div class="page-wrapper">
    <div class="container-xl">
        <!-- <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">Informe seu email para receber o link de acesso</h2>
            </div>
        </div> -->

        @if(session::has('success'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-success text-center" role="alert">
                    {!! \Session::get('success') !!}
                </div>
            </div>
        </div>
        @endif
        @if(session::has('error'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! \Session::get('error') !!}
                </div>
            </div>
        </div>
        @endif
        @php
        $ids = $evento ? $evento->inscritos->pluck('id')->toArray() : [];
        @endphp
        @if(!in_array(\Auth::user()->id, $ids))
        <div class="row row-cards">
            @if($evento)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Aula: {{  $evento->titulo ?? "Sem título" }} - {{ $evento->data->format('d/m/Y') }}</strong></p>
                        <p>Programa Esperança Garcia: Lista de Presença do Módulo 2 | Pedagógico</p>
                        <p>Esse é o link fixo das atividades síncronas do módulo 2 da área pedagógica do Programa Esperança Garcia.</p>
                        <p>O preenchimento do formulário é obrigatório para cômputo da presença na atividade em conformidade com o Termo de Compromisso.</p>
                    </div>
                </div>
            </div>
            @endif
            @php
            $evento_data_hora = $evento ? $evento->data->format('Y-m-d') . ' ' . $evento->hora_fim : null;
            $evento_data_hora_final = $evento ? \Carbon\Carbon::parse($evento_data_hora) : null;
            $now = \Carbon\Carbon::now();
            $form_available = false;
            
            if ($evento_data_hora_final && ($now->diffInMinutes($evento_data_hora_final) >= 20 && $now->diffInMinutes($evento_data_hora_final) >= -10)) {
                $form_available = true;
            }
            @endphp
            <div class="col-12">
                <h2>AVALIAÇÃO DA ATIVIDADE PEDAGÓGICA</h2>

                @if(!$evento)
                    <div class="alert alert-warning text-center" role="alert">
                        Nenhum evento encontrado para hoje.
                    </div>
                @endif

                @if($form_available)
                <form action="{{ route('ead.register-store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                    <input type="hidden" name="ead_id" value="{{ $evento->id }}" />
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <label class="form-label mb-2" for="questao_1">De forma geral, como você avalia essa atividade?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_1" id="questao_1_1"
                                        value="Excelente" checked>
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_1_1">
                                        Excelente
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_1" id="questao_1_2"
                                        value="Bom">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_1_2">
                                        Bom
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_1" id="questao_1_3"
                                        value="Regular">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_1_3">
                                        Regular
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_1" id="questao_1_4"
                                        value="Ruim">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_1_4">
                                        Ruim
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="form-label mb-2" for="questao_2">O conteúdo da atividade pedagógica foi relevante para você?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_2" id="questao_2_1"
                                        value="Muito relevante" checked>
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_2_1">
                                        Muito relevante
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_2" id="questao_2_2"
                                        value="Relevante">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_2_2">
                                        Relevante
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_2" id="questao_2_3"
                                        value="Neutro">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_2_3">
                                        Neutro
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_2" id="questao_2_4"
                                        value="Pouco relevante">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_2_4">
                                        Pouco relevante
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"
                                        name="questao_2" id="questao_2_5"
                                        value="Irrelevante">
                                    <label class="form-label mb-2" class="form-check-label"
                                        for="questao_2_5">
                                        Irrelevante
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="mb-3">
                                    <label for="questao_3" class="form-label mb-2">Quais pontos você considera que foram importantes nesta atividade?</label>
                                    <input type="textarea" class="form-control" id="questao_3" name="questao_3" aria-describedby="descricaoHelp" placeholder="Pontos importantes" required>
                                </div>
                            </div>

                            <div>
                                <div class="mb-3">
                                    <label for="questao_4" class="form-label mb-2">Qual aspecto da atividade não atendeu às suas expectativas ou poderia ser melhorado?</label>
                                    <input type="textarea" class="form-control" id="questao_4" name="questao_4" aria-describedby="descricaoHelp" placeholder="Aspectos que poderiam ser melhorados" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-6 m-auto">
                <div class="alert alert-warning text-center" role="alert">
                    A avaliação dessa atividade já foi preenchida!
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection