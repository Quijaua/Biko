<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Revisão OWASP 2025 — A08 (uploads sem validação podiam virar execução de código).
 */
class UploadHardeningTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private array $criados = [];

    protected function tearDown(): void
    {
        foreach ($this->criados as $arquivo) {
            File::delete($arquivo);
        }

        parent::tearDown();
    }

    private function arquivosEm(string $pasta): array
    {
        return File::isDirectory($pasta) ? File::files($pasta) : [];
    }

    public function test_material_upload_rejects_php_files(): void
    {
        $nucleo = $this->createNucleo();
        $professor = $this->createProfessor($nucleo);
        $antes = count($this->arquivosEm(public_path('uploads')));

        $this->actingAs($professor)
            ->from('/nucleo/material')
            ->post('/nucleo/material/create', [
                'title' => 'Shell',
                'nucleo_id' => $nucleo->id,
                'file' => UploadedFile::fake()->createWithContent('shell.php', '<?php echo "x";'),
            ])
            ->assertSessionHasErrors('file');

        $this->assertCount($antes, $this->arquivosEm(public_path('uploads')));
        $this->assertDatabaseMissing('materials', ['name' => 'Shell']);
    }

    public function test_material_upload_accepts_pdf_with_sanitized_name(): void
    {
        $nucleo = $this->createNucleo();
        $professor = $this->createProfessor($nucleo);

        $this->actingAs($professor)
            ->from('/nucleo/material')
            ->post('/nucleo/material/create', [
                'title' => 'Apostila',
                'nucleo_id' => $nucleo->id,
                'file' => UploadedFile::fake()->create('Apostila de História (v2).pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHasNoErrors();

        $nome = \App\Material::where('name', 'Apostila')->value('file');
        $this->criados[] = public_path('uploads/'.$nome);

        $this->assertMatchesRegularExpression('/^\d+_apostila-de-historia-v2\.pdf$/', $nome);
        $this->assertFileExists(public_path('uploads/'.$nome));
    }

    public function test_banner_upload_rejects_non_images(): void
    {
        $this->actingAs($this->createAdmin())
            ->from('/geral')
            ->post('/geral/update', [
                'banner' => UploadedFile::fake()->createWithContent('banner.php', '<?php echo "x";'),
            ])
            ->assertSessionHasErrors('banner');
    }

    public function test_ead_upload_rejects_php_files(): void
    {
        $this->actingAs($this->createAdmin())
            ->postJson('/ead/upload', [
                'material_apoio' => UploadedFile::fake()->createWithContent('shell.phtml', '<?php echo "x";'),
            ])
            ->assertUnprocessable();
    }
}
