<?php

namespace App\Http\Controllers;

use App\CodigoPersonalizado;
use Illuminate\Http\Request;

class CodigoPersonalizadoController extends Controller
{
    public function index()
    {
        return view('codigo-personalizado.index')->with(['data' => CodigoPersonalizado::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $codigo = CodigoPersonalizado::first();

        if($codigo) {
            $codigo->update($data);
        } else {
            $codigo = CodigoPersonalizado::create($data);
        }

        return redirect()->route('codigo-personalizado.index')->with(['data' => $codigo]);
    }
}
