<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'crp',
        'telefone',
        'email',
    ];
}
