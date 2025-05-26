<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class Mensagens extends Model
{

    protected $fillable = [
        'remetente_id',
        'titulo',
        'nucleos',
        'mensagem',
    ];

    protected $appends = [
        'nucleos_formatted',
        'alunos_formatted',
    ];

    protected $casts = [
        'nucleos' => 'array'
    ];

    public function mensagensAluno()
    {
        return $this->hasMany(MensagensAluno::class, 'mensagens_id');
    }

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function getNucleosFormattedAttribute()
    {
        if ($this->nucleos === null) {
            return 'Todos os núcleos';
        }

        return Nucleo::query()
            ->whereIn('id', $this->nucleos)
            ->get()
            ->pluck('NomeNucleo')
            ->join(', ');
    }

    public function getAlunosFormattedAttribute()
    {
        return $this->mensagensAluno->pluck('aluno.NomeAluno')->join(', ');
    }

    public static function create(array $attributes = [])
    {
        $attributes['remetente_id'] = Auth::user()->id;
        return parent::query()->create($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function marcarComoLida()
    {
        try {
            $mensagemAluno = $this->mensagensAluno()->where('aluno_id', Auth::user()->aluno->id)->firstOrFail();
            if ($mensagemAluno->is_visualizado === false) {
                $mensagemAluno->update([
                    'visualizado_at' => Date::now(),
                ]);
            }
        } catch (\Exception $e) {}
    }

}
