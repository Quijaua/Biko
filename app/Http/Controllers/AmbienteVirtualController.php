<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Services\AmbienteVirtualService;

use Auth;

class AmbienteVirtualController extends Controller
{
    public function index()
    {
        return view('ambiente-virtual.index')->with([
            'user' => Auth::user(),
            'aulas' => AmbienteVirtualService::index(),
        ]);
    }

    public function create()
    {
        return view('ambiente-virtual.create')->with([
            'user' => Auth::user(),
            'professores' => AmbienteVirtualService::getProfessores(),
            'disciplinas' => AmbienteVirtualService::getDisciplinas(),
        ]);
    }

    public function store(Request $request)
    {
        AmbienteVirtualService::store($request);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual criada com sucesso!'
        ]);
    }

    public function show($id)
    {
        return view('ambiente-virtual.show')->with([
            'user' => Auth::user(),
            'aula' => AmbienteVirtualService::find($id),
        ]);
    }

    public function edit($id)
    {
        return view('ambiente-virtual.edit')->with([
            'user' => Auth::user(),
            'aula' => AmbienteVirtualService::find($id),
            'professores' => AmbienteVirtualService::getProfessores(Auth::user()->professor->id_nucleo ?? Auth::user()->coordenador->id_nucleo),
            'disciplinas' => AmbienteVirtualService::getDisciplinas(/*Auth::user()->professor->id_nucleo ?? Auth::user()->coordenador->id_nucleo*/),
        ]);
    }

    public function update(Request $request, $id)
    {
        AmbienteVirtualService::update($id);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual atualizada com sucesso!'
        ]);
    }

    public function destroy($id)
    {
        AmbienteVirtualService::destroy($id);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual excluida com sucesso!'
        ]);
    }

    public function comentar(Request $request, $id)
    {
        return AmbienteVirtualService::comentar($id);
    }
}
