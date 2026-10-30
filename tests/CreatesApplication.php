<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->guardAgainstNonTestingDatabase($app);

        return $app;
    }

    /**
     * Os testes usam RefreshDatabase, que APAGA todas as tabelas.
     * Impede que isso aconteça por engano no banco de desenvolvimento/produção.
     */
    protected function guardAgainstNonTestingDatabase($app): void
    {
        $connection = $app['config']->get('database.default');
        $database = (string) $app['config']->get("database.connections.{$connection}.database");

        $isSqliteMemory = $database === ':memory:';
        $isTestingDatabase = str_ends_with($database, '_testing') || str_ends_with($database, '-testing');

        if (! $isSqliteMemory && ! $isTestingDatabase) {
            throw new RuntimeException(
                "Testes abortados: o banco configurado é [{$database}]. ".
                'Use um banco cujo nome termine em "_testing" (veja phpunit.xml e tests/README.md).'
            );
        }
    }
}
