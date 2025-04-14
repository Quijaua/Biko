<?php

namespace App\Services;

use App\AmbienteVirtual;
use App\Nucleo;

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
        $aula = AmbienteVirtual::find($id)->first();

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

        return $params;
    }

    public static function getProfessores($nucleo_id)
    {
        return Nucleo::find($nucleo_id)->professores()->get();
    }

    public static function getDisciplinas()
    {
        return [];
    }

    private static function getParams()
    {
        return [
            'titulo' => request('titulo'),
            'descricao' => request('descricao'),
            'yt_url' => request('yt_url'),
            'notas' => request('notas'),
            'comentarios' => request('comentarios'),
            'aluno_id' => request('aluno_id'),
            'professor_id' => request('professor_id'),
            'user_id' => request('user_id'),
            //'disciplina_id' => request('disciplina_id'),
        ];
    }
}