<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'nota', 'user_id', 'ambiente_virtual_id'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}
