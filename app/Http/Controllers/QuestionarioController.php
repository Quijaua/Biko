<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\AmbienteVirtual;
use App\Models\Quiz;

class QuestionarioController extends Controller
{
    public function questionario(Request $request)
    {
        $ambiente_virtual = AmbienteVirtual::find($request->aula)->load('questionarios');

        return view('ambiente-virtual.questionario.index')->with([
            'ambiente_virtual' => $ambiente_virtual,
        ]);
    }

    public function create($id)
    {
        $aula = AmbienteVirtual::find($id);
        return view('ambiente-virtual.questionario.create')->with([
            'aula' => $aula,
        ]);
    }

    public function store(Request $request)
    {
        $quiz_data = [
            'ambiente_virtual_id' => $request->input('ambiente_virtual_id'),
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'total_marks' => $request->input('total_marks') ?? 0,
            'pass_marks' => $request->input('pass_marks') ?? 0,
            'max_attempts' => $request->input('max_attempts') ?? 0,
            'is_published' => $request->input('is_published') ?? 1,
            'valid_from' => $request->input('valid_from') ?? now(),
            'valid_upto' => $request->input('valid_upto') ?? null,
            'duration' => $request->input('duration') ?? 0,
        ];

        $questions = $request->input('questions', []);

        $quiz = Quiz::create($quiz_data);

        $authorClass = config('laravel-quiz.models.quiz_author', \Harishdurga\LaravelQuiz\Models\QuizAuthor::class);
        $authorClass::create([
            'quiz_id'   => $quiz->id,
            'author_id' => auth()->id(),
            'author_type' => auth()->user()->role,
        ]);

        foreach ($questions as $questionData) {
            $questionClass = config('laravel-quiz.models.question', \Harishdurga\LaravelQuiz\Models\Question::class);
            $question = $questionClass::create([
                'name' => $questionData['name'],
                'question_type_id' => $questionData['type'],
                'is_active' => 1,
                'media_type' => $questionData['media_type'] ?? null,
            ]);

            $quizQuestionClass = config('laravel-quiz.models.quiz_question', \Harishdurga\LaravelQuiz\Models\QuizQuestion::class);
            $quizQuestionClass::create([
                'quiz_id' => $quiz->id,
                'question_id' => $question->id,
                'marks' => $questionData['marks'] ?? 0,
                'order' => 0,
                'negative_marks' => $questionData['negative_marks'] ?? 0,
                'is_optional' => $questionData['is_optional'] ?? false,
            ]);

            if (in_array($questionData['type'], [1, 2])) {
                foreach ($questionData['options'] as $optionData) {
                    $option = $question->options()->create([
                        'question_id' => $question->id,
                        'name' => $optionData,
                        'is_correct' => $optionData ==  $questionData['answer'] ? true : false,
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Questionário criado com sucesso!');
    }

    public function edit($id)
    {
        $aula = AmbienteVirtual::find($id)->load('questionarios');
        return view('ambiente-virtual.questionario.edit')->with([
            'quiz' => $aula->questionarios->first(),
            'aula' => $aula,
        ]);
    }

    public function update(Request $request, $id)
    {
        $quiz_data = [
            'ambiente_virtual_id' => $request->input('ambiente_virtual_id'),
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'total_marks' => $request->input('total_marks') ?? 0,
            'pass_marks' => $request->input('pass_marks') ?? 0,
            'max_attempts' => $request->input('max_attempts') ?? 0,
            'is_published' => $request->input('is_published') ?? 1,
            'valid_from' => $request->input('valid_from') ?? now(),
            'valid_upto' => $request->input('valid_upto') ?? null,
            'duration' => $request->input('duration') ?? 0,
        ];

        $questions = $request->input('questions', []);

        $quiz = Quiz::where('ambiente_virtual_id', $id)->first();

        foreach ($quiz->questions as $existingQuestion) {
            foreach ($existingQuestion->question->options as $option) {
                $option->delete();
            }
            $existingQuestion->question->delete();
            $existingQuestion->delete();
        }

        foreach ($questions as $questionData) {
            $questionClass = config('laravel-quiz.models.question', \Harishdurga\LaravelQuiz\Models\Question::class);
            $question = $questionClass::create([
                'name' => $questionData['name'],
                'question_type_id' => $questionData['type'],
                'is_active' => 1,
                'media_type' => $questionData['media_type'] ?? null,
            ]);

            $quizQuestionClass = config('laravel-quiz.models.quiz_question', \Harishdurga\LaravelQuiz\Models\QuizQuestion::class);
            $quizQuestionClass::create([
                'quiz_id' => $quiz->id,
                'question_id' => $question->id,
                'marks' => $questionData['marks'] ?? 0,
                'order' => 0,
                'negative_marks' => $questionData['negative_marks'] ?? 0,
                'is_optional' => $questionData['is_optional'] ?? false,
            ]);

            if (in_array($questionData['type'], [1, 2])) {
                foreach ($questionData['options'] as $optionData) {
                    $option = $question->options()->create([
                        'question_id' => $question->id,
                        'name' => $optionData,
                        'is_correct' => $optionData ==  $questionData['answer'] ? true : false,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Questionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        foreach ($quiz->questions as $existingQuestion) {
            foreach ($existingQuestion->question->options as $option) {
                $option->delete();
            }
            $existingQuestion->question->delete();
            $existingQuestion->delete();
        }
        $quiz->delete();
        return redirect()->back()->with('success', 'Questionário excluído com sucesso!');
    }
}
