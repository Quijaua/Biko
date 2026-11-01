<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Limpa HTML vindo de editores (TinyMCE) antes de exibir com {!! !!}.
 * Mantém formatação, listas, links, imagens e tabelas; remove scripts,
 * atributos de evento (onclick, onerror...), iframes e estilos perigosos.
 */
class HtmlSanitizer
{
    private static ?HTMLPurifier $purifier = null;

    public static function clean(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        return self::purifier()->purify($html);
    }

    private static function purifier(): HTMLPurifier
    {
        if (self::$purifier) {
            return self::$purifier;
        }

        $config = HTMLPurifier_Config::createDefault();

        $cache = storage_path('framework/cache/htmlpurifier');
        if (! is_dir($cache)) {
            @mkdir($cache, 0775, true);
        }
        $config->set('Cache.SerializerPath', is_writable($cache) ? $cache : null);

        $config->set('HTML.Allowed', implode(',', [
            'p', 'br', 'hr', 'span[style]', 'div[style]',
            'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup', 'blockquote', 'pre', 'code',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'ul', 'ol', 'li',
            'a[href|title|target|rel]',
            'img[src|alt|title|width|height]',
            'table[border|cellpadding|cellspacing]', 'thead', 'tbody', 'tr', 'th[colspan|rowspan]', 'td[colspan|rowspan]',
        ]));
        $config->set('CSS.AllowedProperties', 'color,background-color,text-align,font-weight,font-style,text-decoration');
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetNoopener', true);

        return self::$purifier = new HTMLPurifier($config);
    }
}
