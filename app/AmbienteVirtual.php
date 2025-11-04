<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AmbienteVirtual extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
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
        'class_duration',
        'peso',
    ];

    public function professor()
    {
        return $this->belongsTo('App\Professores', 'professor_id');
    }

    public function disciplina()
    {
        return $this->belongsTo('App\Disciplina', 'disciplina_id');
    }

    public function comentario()
    {
        return $this->hasMany('App\Comentario', 'ambiente_virtual_id')->whereNull('comentario_id');
    }

    public function respostas()
    {
        return $this->hasMany('App\Comentario', 'ambiente_virtual_id')->whereNotNull('comentario_id');
    }

    public function nota()
    {
        return $this->hasMany('App\Nota', 'ambiente_virtual_id');
    }

    public function questionarios()
    {
        return $this->hasMany('App\Models\Quiz', 'ambiente_virtual_id');
    }
}
