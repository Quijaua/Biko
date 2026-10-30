<?php

namespace Tests\Unit;

use App\Services\FotoPerfilService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/**
 * Tratamento de foto usado em AlunosController, ProfessoresController e
 * CoordenadoresController: largura 150px -> recorte 110x110 -> JPEG 80.
 */
class PhotoProcessingTest extends TestCase
{
    public function test_profile_photo_is_resized_cropped_and_saved_as_jpeg(): void
    {
        $upload = UploadedFile::fake()->image('foto.png', 400, 300);
        $destino = tempnam(sys_get_temp_dir(), 'biko-foto-').'.jpg';

        try {
            FotoPerfilService::salvar($upload->getRealPath(), $destino);

            [$largura, $altura, $tipo] = getimagesize($destino);

            $this->assertSame(110, $largura);
            $this->assertSame(110, $altura);
            $this->assertSame(IMAGETYPE_JPEG, $tipo);
        } finally {
            @unlink($destino);
        }
    }

    public function test_portrait_photo_also_ends_square(): void
    {
        $upload = UploadedFile::fake()->image('retrato.jpg', 300, 600);
        $destino = tempnam(sys_get_temp_dir(), 'biko-foto-').'.jpg';

        try {
            FotoPerfilService::salvar($upload->getRealPath(), $destino);

            [$largura, $altura] = getimagesize($destino);

            $this->assertSame([110, 110], [$largura, $altura]);
        } finally {
            @unlink($destino);
        }
    }
}
