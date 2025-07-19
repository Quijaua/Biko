<?php

namespace App\Services;

use App\AmbienteVirtual;
use App\Nucleo;
use App\Professores;
use App\Disciplina;
use App\Comentario;
use App\Nota;
use DB;
use Carbon\Carbon;
use Auth;

use File;

class AmbienteVirtualService
{
    

    public static function index()
    {
        return AmbienteVirtual::paginate(10);
    }

    public static function store()
    {
        $params = self::getParams();

        $aula = AmbienteVirtual::create($params);

        if (request()->hasFile('imagem_capa')) {
            $file = request()->file('imagem_capa');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('aulas-virtuais/imagens/' . $aula->id), $name);
            $params['imagem_capa'] = $name;
        }

        $aula->update([
            'imagem_capa' => $params['imagem_capa']
        ]);

        return $aula;
    }

    public static function find($id)
    {
        return AmbienteVirtual::find($id);
    }

    public static function update($id)
    {
        $params = self::getParams();
        $aula = AmbienteVirtual::find($id);

        if (request()->hasFile('imagem_capa')) {
            $file = request()->file('imagem_capa');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('aulas-virtuais/imagens/' . $aula->id), $name);
            $params['imagem_capa'] = $name;

            File::delete(public_path('aulas-virtuais/imagens/' . $aula->id . '/' . $aula->imagem_capa));
        }

        $aula->update($params);
        
        return $aula;
    }

    public static function destroy($id)
    {
        $aula = AmbienteVirtual::find($id);

        File::delete(public_path('aulas-virtuais/imagens/' . $aula->id . '/' . $aula->imagem_capa));

        return $aula->delete();
    }

    public static function comentar($id)
    {
        $params = self::getParams();

        Comentario::create($params);

        return redirect()->route('ambiente-virtual.show', $id);
    }

    public static function anotar($id)
    {
        $params = self::getParams();

        Nota::create($params);

        return redirect()->route('ambiente-virtual.show', $id);
    }

    public static function getProfessores()
    {
        $professores = Professores::all()->map(function ($professor) {
            if ($professor->nucleo && $professor->nucleo->permite_ambiente_virtual) {
                return $professor;
            }
        });

        return $professores->filter();
    }

    public static function getDisciplinas()
    {
        /*$disciplinas = Nucleo::where('permite_ambiente_virtual', true)->get()->map(function ($disciplina) {
                return $disciplina->disciplina;
        });

        return $disciplinas;*/
        return Disciplina::all();
    }

    public static function isAssistido($id)
    {
        return DB::table('alunos_ambiente_virtuals_watched')->where('aluno_id', Auth::user()->aluno->id)->where('ambiente_virtual_id', $id)->where('deleted_at', null)->exists();
    }

    public static function marcarAssistido()
    {
        $data = [
            'aluno_id' => request('aluno_id'),
            'ambiente_virtual_id' => request('ambiente_virtual_id'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        return DB::table('alunos_ambiente_virtuals_watched')->insert($data);
    }

    public static function desmarcarAssistido()
    {
        return DB::table('alunos_ambiente_virtuals_watched')->where('aluno_id', request('aluno_id'))->where('ambiente_virtual_id', request('ambiente_virtual_id'))->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }

    private static function getParams()
    {
        return [
            'titulo' => request('titulo'),
            'descricao' => request('descricao'),
            'yt_url' => request('yt_url'),
            //'notas' => request('notas'),
            'professor_id' => request('professor_id'),
            'user_id' => request('user_id'),
            'disciplina_id' => request('disciplina_id'),
            'ambiente_virtual_id' => request('ambiente_virtual_id'),
            'comentario' => request('comentario'),
            'class_duration' => request('class_duration'),
            //'nota' => request('nota')
        ];
    }
}