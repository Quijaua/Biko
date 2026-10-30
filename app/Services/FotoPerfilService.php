<?php

namespace App\Services;

use Intervention\Image\ImageManager;

/**
 * Tratamento padrão das fotos de perfil de alunos, professores e coordenadores.
 *
 * Mantém o mesmo resultado da versão com Intervention Image 2.x:
 * largura 150px (proporcional) -> recorte central 110x110 -> JPEG qualidade 80.
 */
class FotoPerfilService
{
    public const LARGURA_REDIMENSIONADA = 150;

    public const TAMANHO_FINAL = 110;

    public const QUALIDADE_JPEG = 80;

    public static function salvar(string $origem, string $destino): void
    {
        ImageManager::gd()
            ->read($origem)
            ->scale(width: self::LARGURA_REDIMENSIONADA)
            ->crop(self::TAMANHO_FINAL, self::TAMANHO_FINAL, position: 'center')
            ->toJpeg(self::QUALIDADE_JPEG)
            ->save($destino);
    }
}
