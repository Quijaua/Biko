@extends('layouts.app')

@inject('session', 'Session')

@section('content')

<!-- styles -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #ffffff;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .header {
        background: #ffffff;
        color: #2d3748;
        padding: 40px 30px;
        text-align: center;
        border-bottom: 3px solid #e9ecef;
    }

    .header h1 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .header p {
        font-size: 16px;
        opacity: 0.95;
        line-height: 1.6;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        border: 2px solid #e9ecef;
    }

    .info-box p {
        font-size: 14px;
        line-height: 1.6;
        color: #4a5568;
    }

    .content {
        padding: 40px 30px;
    }

    .session-info {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
    }

    .session-info::before {
        content: "📅";
        font-size: 32px;
    }

    .session-info div h3 {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .session-info div p {
        font-size: 20px;
        font-weight: 600;
    }

    .question-card {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .question-card:hover {
        border-color: #667eea;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .question-label {
        font-size: 18px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        display: block;
    }

    .required {
        color: #e53e3e;
        margin-left: 4px;
    }

    .options-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .option-wrapper {
        position: relative;
    }

    .option-wrapper input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .option-label {
        display: inline-block;
        padding: 12px 24px;
        background: white;
        border: 2px solid #cbd5e0;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #4a5568;
        font-size: 15px;
    }

    .option-wrapper input[type="radio"]:checked + .option-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .option-label:hover {
        border-color: #667eea;
        transform: translateY(-1px);
    }

    .text-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #cbd5e0;
        border-radius: 12px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s ease;
        resize: vertical;
        min-height: 100px;
    }

    .text-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .submit-container {
        margin-top: 35px;
        text-align: center;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 16px 50px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .icon {
        display: inline-block;
        margin-right: 8px;
    }

    @media (max-width: 768px) {
        .container {
            border-radius: 0;
        }

        .header {
            padding: 30px 20px;
        }

        .header h1 {
            font-size: 24px;
        }

        .content {
            padding: 30px 20px;
        }

        .question-card {
            padding: 20px;
        }

        .options-container {
            flex-direction: column;
        }

        .option-label {
            width: 100%;
            text-align: center;
        }
    }
</style>
<!-- /styles -->

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

                <div class="header">
                    <h1>📚 Avaliação da Atividade Pedagógica</h1>
                    <p>Programa Esperança Garcia - Módulo 2 | Pedagógico</p>
                    
                    <div class="info-box">
                        <p><strong>Instruções:</strong> Este é o formulário de avaliação das atividades síncronas do módulo 2 da área pedagógica. O preenchimento é obrigatório para cômputo da presença na atividade em conformidade com o Termo de Compromisso.</p>
                    </div>
                </div>

                <div class="content">
                    <div class="session-info">
                        <div>
                            <h3>Aula em avaliação</h3>
                            <p>{{  $evento->titulo ?? "Sem título" }} - {{ $evento->data->format('d/m/Y') }}</p>
                        </div>
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

                <!-- <h2>AVALIAÇÃO DA ATIVIDADE PEDAGÓGICA - NEW</h2> -->

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
                            <!-- Questão 1 -->
                            <div class="question-card">
                                <label class="question-label">
                                    <span class="icon">⭐</span>
                                    De forma geral, como você avalia essa atividade?
                                    <span class="required">*</span>
                                </label>
                                <div class="options-container">
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_1" id="questao_1_1" value="excelente" required>
                                        <label for="questao_1_1" class="option-label">😄 Excelente</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_1" id="questao_1_2" value="bom">
                                        <label for="questao_1_2" class="option-label">🙂 Bom</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_1" id="questao_1_3" value="regular">
                                        <label for="questao_1_3" class="option-label">😐 Regular</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_1" id="questao_1_4" value="ruim">
                                        <label for="questao_1_4" class="option-label">😞 Ruim</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questão 2 -->
                            <div class="question-card">
                                <label class="question-label">
                                    <span class="icon">📊</span>
                                    O conteúdo da atividade pedagógica foi relevante para você?
                                    <span class="required">*</span>
                                </label>
                                <div class="options-container">
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_2" id="questao_2_1" value="muito_relevante" required>
                                        <label for="questao_2_1" class="option-label">Muito relevante</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_2" id="questao_2_2" value="relevante">
                                        <label for="questao_2_2" class="option-label">Relevante</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_2" id="questao_2_3" value="neutro">
                                        <label for="questao_2_3" class="option-label">Neutro</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_2" id="questao_2_4" value="pouco_relevante">
                                        <label for="questao_2_4" class="option-label">Pouco relevante</label>
                                    </div>
                                    <div class="option-wrapper">
                                        <input type="radio" name="questao_2" id="questao_2_5" value="irrelevante">
                                        <label for="questao_2_5" class="option-label">Irrelevante</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questão 3 -->
                            <div class="question-card">
                                <label class="question-label">
                                    <span class="icon">✨</span>
                                    Quais pontos você considera que foram importantes nesta atividade?
                                </label>
                                <textarea 
                                    class="text-input" 
                                    id="questao_3"
                                    name="questao_3"
                                    placeholder="Descreva os aspectos que você considerou mais importantes e valiosos durante a atividade..."
                                ></textarea>
                            </div>

                            <!-- Questão 4 -->
                            <div class="question-card">
                                <label class="question-label">
                                    <span class="icon">💡</span>
                                    Qual aspecto da atividade não atendeu às suas expectativas ou poderia ser melhorado?
                                </label>
                                <textarea 
                                    class="text-input" 
                                    id="questao_4"
                                    name="questao_4"
                                    placeholder="Compartilhe suas sugestões de melhoria ou aspectos que poderiam ser aprimorados..."
                                ></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-5">
                            <div class="submit-container">
                                <button type="submit" class="submit-btn">
                                    ✓ Enviar Avaliação
                                </button>
                            </div>
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