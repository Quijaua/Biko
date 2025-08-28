<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogAtendimentoPsicologico extends Model
{
    protected $table = 'logs_atendimento_psicologico';
    protected $fillable = [
        'atendimento_psicologico_id',
        'user_id',
        'acao',
        'detalhes',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
