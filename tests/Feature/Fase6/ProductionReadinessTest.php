<?php

namespace Tests\Feature\Fase6;

use Illuminate\Support\Facades\Artisan;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

/**
 * Verificações que só dão problema em produção, com os caches ligados.
 */
class ProductionReadinessTest extends TestCase
{
    /**
     * Com "php artisan config:cache", env() passa a devolver null fora de config/.
     * NUCLEO_AMBIENTE_VIRTUAL e MAIL_FROM_ADDRESS eram lidos assim.
     */
    public function test_env_is_only_called_inside_config_files(): void
    {
        $ocorrencias = [];

        foreach (['app', 'routes', 'resources/views'] as $pasta) {
            $arquivos = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path($pasta)));

            foreach ($arquivos as $arquivo) {
                if (! $arquivo->isFile() || $arquivo->getExtension() !== 'php') {
                    continue;
                }

                foreach (file($arquivo->getPathname()) as $numero => $linha) {
                    if (preg_match('/(?<![\w>:$])env\(/', $linha)) {
                        $ocorrencias[] = str_replace(base_path().'/', '', $arquivo->getPathname()).':'.($numero + 1);
                    }
                }
            }
        }

        $this->assertSame([], $ocorrencias, 'Use config(...) em vez de env(...) fora de config/.');
    }

    public function test_routes_can_be_cached(): void
    {
        try {
            $this->assertSame(0, Artisan::call('route:cache'));
        } finally {
            Artisan::call('route:clear');
        }
    }

    public function test_views_can_be_compiled(): void
    {
        try {
            $this->assertSame(0, Artisan::call('view:cache'));
        } finally {
            Artisan::call('view:clear');
        }
    }
}
