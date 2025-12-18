<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = [
        'user_id',
        'ambiente_virtual_id',
        'comentario',
        'comentario_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aula()
    {
        return $this->belongsTo('App\AmbienteVirtual');
    }
}
