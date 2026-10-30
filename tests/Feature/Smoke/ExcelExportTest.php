<?php

namespace Tests\Feature\Smoke;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Gera as planilhas de verdade (maatwebsite/excel + PhpSpreadsheet),
 * que mudam de versão durante o upgrade.
 */
class ExcelExportTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    private function assertXlsxDownload(TestResponse $response, string $filenamePrefix): void
    {
        $response->assertOk()->assertDownload();

        $disposition = $response->headers->get('content-disposition');
        $this->assertStringContainsString($filenamePrefix, $disposition);
        $this->assertStringContainsString('.xlsx', $disposition);

        // Arquivos .xlsx são zips: começam com "PK"
        $base = $response->baseResponse;
        $content = $base instanceof BinaryFileResponse
            ? file_get_contents($base->getFile()->getPathname())
            : $response->streamedContent();

        $this->assertStringStartsWith('PK', $content);
    }

    private function seedPeople(): void
    {
        $nucleo = $this->createNucleo();
        $this->createAluno($nucleo);
        $this->createProfessor($nucleo);
        $this->createCoordenador($nucleo);
    }

    public function test_admin_exports_alunos(): void
    {
        $this->seedPeople();

        $this->assertXlsxDownload(
            $this->actingAs($this->createAdmin())->get('/alunos/export'),
            'alunos-'
        );
    }

    public function test_admin_exports_professores(): void
    {
        $this->seedPeople();

        $this->assertXlsxDownload(
            $this->actingAs($this->createAdmin())->get('/professores/export'),
            'professores_'
        );
    }

    public function test_admin_exports_coordenadores(): void
    {
        $this->seedPeople();
        $admin = $this->createAdmin();

        // Com o parâmetro que o botão do administrador envia...
        $this->assertXlsxDownload($this->actingAs($admin)->get('/coordenadores/export?nucleo=0'), 'coordenadores');

        // ...e sem parâmetro nenhum (antes da Fase 1 dava erro 500).
        $this->assertXlsxDownload($this->actingAs($admin)->get('/coordenadores/export'), 'coordenadores');
    }

    public function test_coordenador_exports_coordenadores_of_own_nucleos(): void
    {
        $this->seedPeople();

        // O botão do coordenador envia ?nucleo= vazio (antes da Fase 1 dava erro 500).
        $this->assertXlsxDownload(
            $this->actingAs($this->createCoordenador())->get('/coordenadores/export?nucleo='),
            'coordenadores'
        );
    }

    public function test_aluno_cannot_export_coordenadores(): void
    {
        $this->actingAs($this->createAluno())->get('/coordenadores/export?nucleo=0')->assertForbidden();
    }

    public function test_coordenador_exports_only_with_linked_nucleo(): void
    {
        $this->seedPeople();

        $this->assertXlsxDownload(
            $this->actingAs($this->createCoordenador())->get('/alunos/export'),
            'alunos-'
        );
    }

    public function test_aluno_cannot_export_alunos(): void
    {
        $this->actingAs($this->createAluno())->get('/alunos/export')->assertForbidden();
    }
}
