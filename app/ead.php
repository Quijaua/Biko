<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ead extends Model
{
    protected $table = 'eads';

    protected $fillable = [
        'titulo',
        'data',
        'hora_inicio',
        'hora_fim',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function inscritos()
    {
        return $this->belongsToMany(User::class, 'eads_participantes');
    }
}
