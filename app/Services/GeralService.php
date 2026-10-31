<?php

namespace App\Services;

use App\Geral;
use File;

class GeralService
{
    public static function index()
    {
        return Geral::first();
    }

    public static function update()
    {
        $geral = Geral::first();

        $data = request()->except('banner', '_token');

        request()->validate([
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        if (request()->hasFile('banner')) {
            $file = request()->file('banner');
            // Extensão deduzida do conteúdo, não do nome enviado.
            $name = time() . '.' . ($file->guessExtension() ?: 'jpg');
            $file->move(public_path('images/geral/banner/'), $name);
            $data['banner'] = $name;

            if ($geral && $geral->banner) {
                File::delete(public_path('images/geral/banner/' . basename($geral->banner)));
            }
        }

        if($geral) {
            $geral->update($data);
        } else {
            $geral = Geral::create($data);
        }

        return $geral;
    }
}