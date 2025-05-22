<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geral extends Model
{
    protected $table = 'gerals';

    protected $fillable = [
        'nome_cursinho',
        'banner',
        'texto_pre_cadastro',
    ];
}
