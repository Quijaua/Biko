<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Disciplina;

class DisciplinaController extends Controller
{
    public function index()
    {
        return view('disciplinas.index')->with([
            'disciplinas' => Disciplina::all(),
        ]);
    }

    public function create()
    {
        return view('disciplinas.create');
    }

    public function store(Request $request)
    {
        $disciplina = new Disciplina();
        $disciplina->nome = $request->nome;
        $disciplina->areas_conhecimento = $request->areas_conhecimento;
        $disciplina->save();
        return redirect()->route('disciplinas.index')->with([
            'success' => 'Disciplina criada com sucesso!'
        ]);
    }

    public function edit($id)
    {
        return view('disciplinas.edit')->with([
            'disciplina' => Disciplina::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $disciplina = Disciplina::find($id);
        $disciplina->nome = $request->nome;
        $disciplina->areas_conhecimento = $request->areas_conhecimento;
        $disciplina->save();
        return redirect()->route('disciplinas.index')->with([
            'success' => 'Disciplina atualizada com sucesso!'
        ]);
    }

    public function destroy($id)
    {
        Disciplina::destroy($id);
        return redirect()->route('disciplinas.index')->with([
            'success' => 'Disciplina excluida com sucesso!'
        ]);
    }
}
