<?php

namespace App\Services;

use App\NucleosProfessoresDisciplinas;

class NucleoProfessoresDisciplinasService
{
    public static function create()
    {
        $nucleosProfessoresDisciplinas = NucleosProfessoresDisciplinas::create(request()->all());
        return [
            'id' => $nucleosProfessoresDisciplinas->id,
            'horario_inicial' => $nucleosProfessoresDisciplinas->horario_inicial,
            'horario_final' => $nucleosProfessoresDisciplinas->horario_final,
            'dia_semana' => $nucleosProfessoresDisciplinas->dia_semana,
            'professor_name' => $nucleosProfessoresDisciplinas->professor->NomeProfessor,
            'disciplina_name' => $nucleosProfessoresDisciplinas->disciplina->nome,
        ];
    }

    public static function update()
    {
        $data = NucleosProfessoresDisciplinas::find(request()->id);
        $data->update(request()->all());
        $data->refresh();
        return [
            'id' => $data->id,
            'horario_inicial' => $data->horario_inicial,
            'horario_final' => $data->horario_final,
            'dia_semana' => $data->dia_semana,
            'professor_name' => $data->professor->NomeProfessor,
            'disciplina_name' => $data->disciplina->nome,
        ];
    }

    public static function delete()
    {
        $data = NucleosProfessoresDisciplinas::find(request()->id);
        $data->delete();
        return $data;
    }
}