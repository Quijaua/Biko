<?php

namespace Tests\Unit;

use App\Support\HtmlSanitizer;
use Tests\TestCase;

/**
 * Revisão OWASP 2025 — A05 (XSS nas mensagens e no texto do pré-cadastro).
 */
class HtmlSanitizerTest extends TestCase
{
    public function test_removes_scripts_and_event_handlers(): void
    {
        $limpo = HtmlSanitizer::clean('<p onclick="roubar()">Olá</p><script>alert(1)</script><img src="x" onerror="alert(2)">');

        $this->assertStringNotContainsString('<script', $limpo);
        $this->assertStringNotContainsString('onclick', $limpo);
        $this->assertStringNotContainsString('onerror', $limpo);
        $this->assertStringContainsString('Olá', $limpo);
    }

    public function test_removes_javascript_links(): void
    {
        $limpo = HtmlSanitizer::clean('<a href="javascript:alert(1)">clique</a>');

        $this->assertStringNotContainsString('javascript:', $limpo);
    }

    public function test_keeps_basic_formatting(): void
    {
        $html = '<p><strong>Atenção</strong>, <em>aula</em> amanhã:</p><ul><li>item</li></ul><a href="https://biko.test">link</a>';

        $limpo = HtmlSanitizer::clean($html);

        $this->assertStringContainsString('<strong>Atenção</strong>', $limpo);
        $this->assertStringContainsString('<li>item</li>', $limpo);
        $this->assertStringContainsString('href="https://biko.test"', $limpo);
    }
}
