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
        'descricao_encaminhamento',
        'anexo',
        'created_by',
        'updated_by',
    ];

    public function estudante()
    {
        return $this->belongsTo(Psicologos::class);
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
