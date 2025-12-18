@extends('layouts.app')

@section('content')
<div class="container">
    <!-- PAGE HEADER -->
    <div class="row">
        <div class="col-12 text-center">
            <h1>QUESTIONÁRIO ({{ $aula->titulo }})</h1>
        </div>
    </div>
    @if(session('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center" role="alert">
                {!! session('success') !!}
            </div>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! session('error') !!}
                </div>
            </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <form action="{{ route('ambiente-virtual.questionario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- ambiente_virtual_id -->
                    <input type="hidden" class="form-control" id="ambiente_virtual_id" name="ambiente_virtual_id" value="{{ $aula->id }}" aria-describedby="ambiente_virtual_idHelp" required>
                    <!-- title -->
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="title">Título do Questionário</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="titleHelp" placeholder="Título do questionário" required>
                        </div>
                    </div>
                    <!-- description -->
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="description">Descrição do Questionário</label>
                            <input type="text" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" placeholder="Descrição do questionário" required>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Questions Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h4>Perguntas</h4>
                        <div id="questions-container">
                            <!-- Template for questions -->
                            <div class="question-block card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Pergunta</label>
                                        <input type="text" class="form-control" name="questions[0][name]" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Pergunta</label>
                                        <select class="form-control question-type" name="questions[0][type]" required>
                                            <option value="">Escolher</option>
                                            @foreach(\Harishdurga\LaravelQuiz\Models\QuestionType::all() as $type)
                                                @php
                                                    $label = match($type->id) {
                                                        1 => 'Múltipla Escolha (Uma Resposta)',
                                                        2 => 'Múltipla Escolha (Várias Respostas)',
                                                        3 => 'Resposta Aberta',
                                                        default => 'Indefinido'
                                                    };
                                                @endphp
                                                <option value="{{ $type->id }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="options-container mb-3" style="display: none;">
                                        <label class="form-label">Opções (para múltipla escolha)</label>
                                        <div class="options-list">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="questions[0][options][]" placeholder="Opção">
                                                <button type="button" class="btn btn-outline-secondary remove-option">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm add-option">
                                            + Adicionar Opção
                                        </button>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Resposta Correta</label>
                                        <input type="text" class="form-control" name="questions[0][answer]" style="display: none;">
                                    </div>

                                    <button type="button" class="btn btn-danger btn-sm remove-question">
                                        Remover Pergunta
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success" id="add-question">
                            + Adicionar Nova Pergunta
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Salvar Questionário</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let questionCount = 1;

        // Add new question
        document.getElementById('add-question').addEventListener('click', function() {
            const template = document.querySelector('.question-block').cloneNode(true);
            
            // Update names and IDs
            template.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('[0]', `[${questionCount}]`);
                input.value = '';
            });

            // Add to container
            document.getElementById('questions-container').appendChild(template);
            questionCount++;
        });

        // Remove question
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                if (document.querySelectorAll('.question-block').length > 1) {
                    e.target.closest('.question-block').remove();
                } else {
                    alert('Você precisa ter pelo menos uma pergunta!');
                }
            }
        });

        // Add option
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-option')) {
                const optionsList = e.target.previousElementSibling;
                const newOption = optionsList.children[0].cloneNode(true);
                newOption.querySelector('input').value = '';
                optionsList.appendChild(newOption);
            }
        });

        // Remove option
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option')) {
                const optionsContainer = e.target.closest('.options-list');
                if (optionsContainer.children.length > 1) {
                    e.target.closest('.input-group').remove();
                }
            }
        });

        // Toggle options based on question type
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('question-type')) {
                const questionBlock = e.target.closest('.question-block');
                const optionsContainer = questionBlock.querySelector('.options-container');
                const answerField = questionBlock.querySelector('[name$="[answer]"]');
                
                // Reset displays
                optionsContainer.style.display = 'none';
                answerField.style.display = 'block'; // Changed from hiding the parent div
                
                // Show relevant section based on type
                switch(e.target.value) {
                    case '1': // Múltipla Escolha (Uma Resposta)
                    case '2': // Múltipla Escolha (Várias Respostas)
                        optionsContainer.style.display = 'block';
                        break;
                    case '3': // Resposta Curta
                        // answerField.style.display = 'block';
                        answerField.style.display = 'none';
                        break;
                    default:
                        answerField.style.display = 'none';
                }
            }
        });
    });
</script>

@endsection