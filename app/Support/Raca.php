<?php

namespace App\Support;

/**
 * Valores de raça/cor gravados no banco: negra, branca, parda, amarela, indigena.
 * Os formulários exibem "negra" como "Negra".
 */
class Raca
{
    public const VALORES = ['negra', 'branca', 'parda', 'amarela', 'indigena'];

    /**
     * Padroniza o valor vindo de importação, API ou formulário.
     * "preta" vira "negra"; valores fora da lista são devolvidos como vieram.
     */
    public static function normalizar(?string $valor): ?string
    {
        if ($valor === null) {
            return null;
        }

        $limpo = mb_strtolower(trim($valor), 'UTF-8');
        $limpo = strtr($limpo, ['í' => 'i']);

        if ($limpo === 'preta') {
            return 'negra';
        }

        return in_array($limpo, self::VALORES, true) ? $limpo : $valor;
    }
}
