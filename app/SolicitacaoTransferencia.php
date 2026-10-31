<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Pedido de uma pessoa cujo Núcleo foi desativado para passar a
 * fazer parte de outro Núcleo ativo.
 */
class SolicitacaoTransferencia extends Model
{
    public const PENDENTE = 'pendente';
    public const APROVADA = 'aprovada';
    public const RECUSADA = 'recusada';
    public const CANCELADA = 'cancelada';

    protected $table = 'solicitacoes_transferencia';

    protected $fillable = [
        'user_id',
        'perfil',
        'nucleo_origem_id',
        'nucleo_destino_id',
        'mensagem',
        'status',
        'respondido_por',
        'respondido_em',
    ];

    protected $casts = [
        'respondido_em' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nucleoOrigem()
    {
        return $this->belongsTo(Nucleo::class, 'nucleo_origem_id');
    }

    public function nucleoDestino()
    {
        return $this->belongsTo(Nucleo::class, 'nucleo_destino_id');
    }

    public function respondente()
    {
        return $this->belongsTo(User::class, 'respondido_por');
    }

    public function scopePendentes(Builder $query): Builder
    {
        return $query->where('status', self::PENDENTE);
    }

    public function isPendente(): bool
    {
        return $this->status === self::PENDENTE;
    }

    public function getPerfilFormatadoAttribute(): string
    {
        return match ($this->perfil) {
            'aluno' => 'Estudante',
            'professor' => 'Professor(a)',
            'coordenador' => 'Coordenador(a)',
            default => ucfirst($this->perfil),
        };
    }
}
