<?php

namespace Tests\Feature\Smoke;

use Illuminate\Routing\Route;
use Tests\TestCase;
use Throwable;

/**
 * Compara a tabela de rotas atual com tests/fixtures/routes.json.
 *
 * Qualquer rota que sumir, mudar de URI/nome/controller ou perder um
 * middleware durante o upgrade faz este teste falhar.
 *
 * - Primeira execução (arquivo inexistente): o snapshot é gerado e o teste é pulado.
 * - Mudança intencional: rode com UPDATE_SNAPSHOTS=1 e faça commit do novo arquivo.
 */
class RouteSnapshotTest extends TestCase
{
    /** Rotas registradas por pacotes de desenvolvimento ou pelo próprio framework. */
    private const IGNORED_PREFIXES = ['_ignition/', '_debugbar/', 'storage/'];

    private const IGNORED_URIS = ['up'];

    private function snapshotPath(): string
    {
        return base_path('tests/fixtures/routes.json');
    }

    public function test_route_table_matches_snapshot(): void
    {
        $current = json_encode(
            $this->currentRoutes(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        )."\n";

        if (! file_exists($this->snapshotPath()) || env('UPDATE_SNAPSHOTS')) {
            if (! is_dir(dirname($this->snapshotPath()))) {
                mkdir(dirname($this->snapshotPath()), 0775, true);
            }

            file_put_contents($this->snapshotPath(), $current);

            $this->markTestSkipped('Snapshot de rotas gerado em tests/fixtures/routes.json. Revise e faça commit.');
        }

        $this->assertSame(
            file_get_contents($this->snapshotPath()),
            $current,
            'A tabela de rotas mudou. Se a mudança for intencional, rode com UPDATE_SNAPSHOTS=1.'
        );
    }

    private function currentRoutes(): array
    {
        $routes = collect($this->app['router']->getRoutes()->getRoutes())
            ->reject(fn (Route $route) => $this->isIgnored($route->uri()))
            ->map(fn (Route $route) => [
                'methods' => implode('|', array_values(array_diff($route->methods(), ['HEAD']))),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => ltrim($route->getActionName(), '\\'),
                'middleware' => $this->middlewareFor($route),
            ])
            ->sortBy(fn (array $route) => $route['uri'].' '.$route['methods'])
            ->values()
            ->all();

        return $routes;
    }

    private function middlewareFor(Route $route): array
    {
        try {
            $middleware = $route->gatherMiddleware();
        } catch (Throwable) {
            $middleware = $route->middleware();
        }

        $middleware = array_map(
            fn ($item) => is_string($item) ? $item : get_debug_type($item),
            $middleware
        );

        $middleware = array_values(array_unique($middleware));
        sort($middleware);

        return $middleware;
    }

    private function isIgnored(string $uri): bool
    {
        if (in_array($uri, self::IGNORED_URIS, true)) {
            return true;
        }

        foreach (self::IGNORED_PREFIXES as $prefix) {
            if (str_starts_with($uri, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
