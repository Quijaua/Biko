<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NucleosProfessoresDisciplinas extends Model
{
    protected $table = 'nucleos_professores_disciplinas';

    protected $fillable = [
        'nucleo_id',
        'professor_id',
        'disciplina_id',
        'horario_inicial',
        'horario_final',
        'dia_semana',
    ];

    public function nucleo()
    {
        return $this->belongsTo(Nucleo::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professores::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
