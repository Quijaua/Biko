<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

/**
 * Caracteriza o tratamento de foto usado em AlunosController,
 * ProfessoresController e CoordenadoresController:
 * resize 150px de largura -> crop 110x110 -> JPEG qualidade 80.
 *
 * Na Fase 1 (Intervention Image v2 -> v3) este teste deve continuar
 * passando, apontando para o novo helper/serviço de foto.
 */
class PhotoProcessingTest extends TestCase
{
    public function test_profile_photo_is_resized_cropped_and_saved_as_jpeg(): void
    {
        $upload = UploadedFile::fake()->image('foto.png', 400, 300);
        $destino = tempnam(sys_get_temp_dir(), 'biko-foto-').'.jpg';

        try {
            Image::make($upload->getRealPath())
                ->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->crop(110, 110, null, null)
                ->encode('jpg', 80)
                ->save($destino);

            [$largura, $altura, $tipo] = getimagesize($destino);

            $this->assertSame(110, $largura);
            $this->assertSame(110, $altura);
            $this->assertSame(IMAGETYPE_JPEG, $tipo);
        } finally {
            @unlink($destino);
        }
    }
}
