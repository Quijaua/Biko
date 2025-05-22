<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeralService;

class GeralController extends Controller
{
    public function index()
    {
        return view('geral.index')->with(['data' => GeralService::index()]);
    }

    public function update(Request $request)
    {
        $data = GeralService::update($request->all());
        return redirect()->route('geral.index')->with(['data' => $data]);
    }
}
