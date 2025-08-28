<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class PlantaoPsicologico extends Model
{
    use HasFactory;

    protected $table = 'plantao_psicologicos';

    protected $fillable = [
        'psicologo_id',
        'data',
        'horario',
        'estudante_id',
    ];

    protected $dates = [
        'data',
        'horario',
    ];

    // Relacionamento com o psicólogo
    public function psicologo()
    {
        return $this->belongsTo(User::class, 'psicologo_id');
    }

    // Relacionamento com o estudante
    public function estudante()
    {
        return $this->belongsTo(User::class, 'estudante_id');
    }

    // Acessor para exibir data formatada
    public function getDataFormatadaAttribute()
    {
        return $this->data->format('d/m/Y');
    }

    // Acessor para exibir horário formatado
    public function getHorarioFormatadoAttribute()
    {
        return $this->horario->format('H:i');
    }
}
