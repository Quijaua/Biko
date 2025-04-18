<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerraIndigena extends Model
{
    protected $table = 'terra_indigenas';

    protected $fillable = [
        'label',
    ];

    public function alunos()
    {
        return $this->hasMany('App\Aluno', 'terra_indigenas_id');
    }

    public function professores()
    {
        return $this->hasMany('App\Professores', 'terra_indigenas_id');
    }

    public function coordenadores()
    {
        return $this->hasMany('App\Coordenadores', 'terra_indigenas_id');
    }
}
