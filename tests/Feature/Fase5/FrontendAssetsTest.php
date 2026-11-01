<?php

namespace Tests\Feature\Fase5;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * O layout passou a carregar o JavaScript pelo Vite (public/build)
 * em vez do bundle antigo do Laravel Mix (public/js/app.js).
 */
class FrontendAssetsTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_layout_uses_vite_bundle_instead_of_mix(): void
    {
        $layout = file_get_contents(resource_path('views/layouts/app.blade.php'));

        $this->assertStringContainsString("@vite('resources/js/app.js')", $layout);
        $this->assertStringNotContainsString("asset('js/app.js')", $layout);
    }

    public function test_vite_build_is_committed_and_contains_app_entry(): void
    {
        $manifestPath = public_path('build/manifest.json');

        $this->assertFileExists($manifestPath, 'Rode "npm run build" e faça commit de public/build.');

        $manifest = json_decode(file_get_contents($manifestPath), true);

        $this->assertArrayHasKey('resources/js/app.js', $manifest);
        $this->assertFileExists(public_path('build/'.$manifest['resources/js/app.js']['file']));
    }

    public function test_pages_render_with_real_vite_manifest(): void
    {
        // Desfaz o withoutVite() do TestCase para usar o manifest de verdade.
        $this->withVite();

        $this->actingAs($this->createAdmin())
            ->get('/home')
            ->assertOk()
            ->assertSee('/build/assets/', false);
    }
}
