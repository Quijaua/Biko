<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmbienteVirtual extends Model
{
    protected $table = 'ambiente_virtuals';

    protected $fillable = [
        'titulo',
        'descricao',
        'imagem_capa',
        'yt_url',
        'notas',
        'comentarios',
        'aluno_id',
        'professor_id',
        'disciplina_id',
    ];

    public function professor()
    {
        return $this->belongsTo('App\Professores', 'professor_id');
    }
}
