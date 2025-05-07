<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\NucleoProfessoresDisciplinasService;

class NucleoProfessoresDisciplinasController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $response = NucleoProfessoresDisciplinasService::create($data);
        return $response;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $response = NucleoProfessoresDisciplinasService::update($data);
        return $response;
    }

    public function delete()
    {
        $data = NucleoProfessoresDisciplinasService::delete(request()->id);
        return $data;
    }
}
