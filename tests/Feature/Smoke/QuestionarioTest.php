<?php

namespace Tests\Feature\Smoke;

use App\AmbienteVirtual;
use App\Models\Quiz;
use Harishdurga\LaravelQuiz\Database\Seeders\QuestionTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Cobre a integração com harishdurga/laravel-quiz, o pacote que
 * hoje bloqueia o upgrade (será substituído/forkado na Fase 1).
 */
class QuestionarioTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function createAula(): AmbienteVirtual
    {
        $professor = $this->createProfessor();

        return AmbienteVirtual::create([
            'titulo' => 'Aula de teste',
            'descricao' => 'Descrição',
            'yt_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'professor_id' => $professor->professor->id,
        ]);
    }

    public function test_admin_creates_quiz_with_multiple_choice_question(): void
    {
        $this->seed(QuestionTypeSeeder::class);
        $aula = $this->createAula();

        $this->actingAs($this->createAdmin())
            ->post(route('ambiente-virtual.questionario.store'), [
                'ambiente_virtual_id' => $aula->id,
                'name' => 'Questionário de História',
                'description' => 'Revisão',
                'questions' => [
                    [
                        'name' => 'Em que ano foi a Revolta dos Malês?',
                        'type' => 1,
                        'options' => ['1798', '1835', '1888'],
                        'answer' => '1835',
                    ],
                ],
            ])
            ->assertRedirect(route('ambiente-virtual.questionario', ['aula' => $aula->id]));

        $quiz = Quiz::where('ambiente_virtual_id', $aula->id)->firstOrFail();
        $this->assertSame('Questionário de História', $quiz->name);

        $this->assertDatabaseHas('questions', ['name' => 'Em que ano foi a Revolta dos Malês?']);
        $this->assertSame(3, DB::table('question_options')->count());
        $this->assertDatabaseHas('question_options', ['name' => '1835', 'is_correct' => 1]);
        $this->assertDatabaseHas('quiz_questions', ['quiz_id' => $quiz->id]);
    }

    public function test_quiz_list_for_aula_renders(): void
    {
        $aula = $this->createAula();

        $this->actingAs($this->createAdmin())
            ->get(route('ambiente-virtual.questionario', ['aula' => $aula->id]))
            ->assertOk();
    }
}
