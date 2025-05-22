<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPersonalizado extends Model
{
    protected $table = 'codigo_personalizados';

    protected $fillable = [
        'tag_head',
        'open_tag_body',
        'close_tag_body',
    ];
}
