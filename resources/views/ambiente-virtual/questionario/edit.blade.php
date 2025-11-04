@extends('layouts.app')

@section('content')
<div class="container">
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
            <form action="{{ route('ambiente-virtual.questionario.update', ['id' => $aula->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="ambiente_virtual_id" value="{{ $aula->id }}">
                <div class="row">
                    <!-- title -->
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="title">Título do Questionário</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="titleHelp" placeholder="Título do questionário" value="{{ $quiz->name }}" required>
                        </div>
                    </div>
                    <!-- description -->
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label mb-2" for="description">Descrição do Questionário</label>
                            <input type="text" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" placeholder="Descrição do questionário" value="{{ $quiz->description }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h4>Perguntas</h4>
                        <div id="questions-container">
                            @if(!$quiz || !$quiz->questions)
                                <div class="alert alert-warning">
                                    Nenhuma pergunta encontrada para este questionário.
                                </div>
                            @else
                                @foreach($quiz->questions as $index => $question)
                                <div class="question-block card mb-3">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pergunta</label>
                                            <input type="text" class="form-control" name="questions[{{$index}}][name]" value="{{ $question->question->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Pergunta</label>
                                            <select class="form-control question-type" name="questions[{{$index}}][type]" required>
                                                <option value="">Escolher</option>
                                                @foreach(\Harishdurga\LaravelQuiz\Models\QuestionType::all() as $type)
                                                    @php
                                                        $label = match($type->id) {
                                                            1 => 'Múltipla Escolha (Uma Resposta)',
                                                            2 => 'Múltipla Escolha (Várias Respostas)',
                                                            3 => 'Resposta Aberta',
                                                            default => $type->name
                                                        };
                                                    @endphp
                                                    <option value="{{ $type->id }}" {{ $question->question->question_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        @if ($question->question->question_type_id == 1 || $question->question->question_type_id == 2)
                                        <label class="form-label options-label">Opções (para múltipla escolha)</label>
                                        <div class="options-container mb-3">
                                            <div class="options-list">
                                                @foreach ($question->question->options as $key => $option)
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option->name }}" placeholder="Opção">
                                                    <button type="button" class="btn btn-outline-secondary remove-option">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <button type="button" class="btn btn-outline-primary btn-sm add-option">
                                            + Adicionar Opção
                                        </button>
                                        @endif

                                        @foreach ($question->question->options as $index => $option)
                                        @if ($option->is_correct)
                                        <div class="mt-4 mb-3 short-answer">
                                            <label class="form-label">Resposta Correta</label>
                                            <input type="text" class="form-control" name="questions[{{ $index }}][answer]" required value="{{ $option->name }}">
                                        </div>
                                        @endif
                                        @endforeach

                                        <!-- <div class="mt-3 mb-3 short-answer" style="/*display: {{ $question->question_type_id == 3 ? 'block' : 'none' }}*/">
                                            <label class="form-label">Resposta Correta</label>
                                            <input type="text" class="form-control" 
                                                   name="questions[{{$index}}][answer]"
                                                   value="{{ $question->answer }}"
                                                   required>
                                        </div> -->

                                        <button type="button" class="btn btn-danger btn-sm remove-question">
                                            Remover Pergunta
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" class="btn btn-success" id="add-question">
                            + Adicionar Nova Pergunta
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Atualizar Questionário</button>
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
                const newOption = optionsList.children[0].children[0].cloneNode(true);
                newOption.querySelector('input').value = '';
                optionsList.children[0].appendChild(newOption);
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
                const optionsLabel = questionBlock.querySelector('.options-label');
                const optionsAddBtn = questionBlock.querySelector('.add-option');
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
                        answerField.style.display = 'block';
                        answerField.style.display = 'none';
                        optionsContainer.style.display = 'none';
                        optionsLabel.style.display = 'none';
                        optionsAddBtn.style.display = 'none';
                        break;
                    default:
                        answerField.style.display = 'none';
                }
            }
        });
    });
</script>

@endsection