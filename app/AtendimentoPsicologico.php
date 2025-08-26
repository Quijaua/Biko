<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoPsicologico extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudante_id',
        'demanda_objetivos',
        'registro_atendimento',
        'tipo_encaminhamento',
        'status',
        'descricao_encaminhamento',
        'anexo',
        'data_atendimento',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'data_atendimento',
    ];

    public function estudante()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
