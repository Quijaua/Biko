<?php

namespace App\Models;

use Harishdurga\LaravelQuiz\Models\Quiz as BaseQuiz;
use App\AmbienteVirtual;

class Quiz extends BaseQuiz
{
    protected $fillable = [
        'ambiente_virtual_id',
        'name',
        'slug',
        'description',
        'total_marks',
        'pass_marks',
        'max_attempts',
        'is_published',
        'valid_from',
        'valid_upto',
        'duration',
        'media_url',
        'media_type'
    ];

    public function ambienteVirtual()
    {
        return $this->belongsTo(AmbienteVirtual::class);
    }
}