<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // As views não dependem do manifest do Vite, mas isso evita falhas
        // caso alguma passe a usar @vite sem o build ter sido gerado.
        $this->withoutVite();
    }
}
