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

        if (request()->hasFile('banner')) {
            $file = request()->file('banner');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/geral/banner/'), $name);
            $data['banner'] = $name;
            File::delete(public_path('images/geral/banner/' . $geral->banner));
        }

        if($geral) {
            $geral->update($data);
        } else {
            Geral::create($data);
        }

        return $geral;
    }
}