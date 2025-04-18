<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PovoIndigena extends Model
{
    protected $table = 'povo_indigenas';

    protected $fillable = [
        'label',
    ];

    public function alunos()
    {
        return $this->hasMany('App\Aluno', 'povo_indigenas_id');
    }

    public function professores()
    {
        return $this->hasMany('App\Professores', 'povo_indigenas_id');
    }

    public function coordenadores()
    {
        return $this->hasMany('App\Coordenadores', 'povo_indigenas_id');
    }
}
