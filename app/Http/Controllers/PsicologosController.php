<?php

namespace App\Http\Controllers;

use App\Psicologos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PsicologosController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->role === 'professor' || $user->role === 'aluno'){
            return back();
        }

        if($user->role === 'administrador'){
            $user = Auth::user();
            $psicologos = Psicologos::paginate(25);

            return view('psicologos.psicologos')->with([
                'user' => $user,
                'psicologos' => $psicologos,
            ]);
        }
    }

    public function show()
    {
        return view('psicologos.psicologosCreate');
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:255',
            'crp'      => 'required|string|max:50|unique:psicologos,crp',
            'telefone' => 'required|string|max:20',
            'email'    => 'required|email|unique:psicologos,email',
        ]);

        Psicologos::create($data);
        return redirect()->route('psicologos.psicologos')->with('success', 'Psicólogo criado com sucesso!');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $dados = Psicologos::find($id);

        return view('psicologos.psicologosEdit')->with([
          'dados'     => $dados
        ]);
    }

    public function update(Request $request, Psicologos $psicologos)
    {
        $data = $request->validate([
            'nome'     => 'required|string|max:255',
            'crp'      => "required|string|max:50|unique:psicologos,crp,{$psicologos->id}",
            'telefone' => 'required|string|max:20',
            'email'    => "required|email|unique:psicologos,email,{$psicologos->id}",
        ]);

        $psicologos->update($data);
        return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function search(Request $request)
    {
      $params = self::getParams($request);
      $user = Auth::user();

      switch ($user->role) {
        case 'professor':
          if (!$params['nucleo_id']) {
            $params['nucleo_id'] = $user->professor->id_nucleo;
          }
          break;
      }

      $psicologos = DB::table('psicologos')
        ->when($params['query'], function ($query) use ($params) {
          return $query->where('psicologos.nome', 'LIKE', '%' . $params['query'] . '%');
        })
        ->paginate(25);

      return view('psicologos.psicologos')->with([
        'user' => $user,
        'psicologos' => $psicologos,
      ]);
    }

    public function details($id)
    {
        $user = Auth::user();

        $dados = Psicologos::find($id);

        return view('psicologos.psicologosDetails')->with([
          'dados'     => $dados
        ]);
    }

    private static function getParams($request)
    {
        return [
            'query' => $request->input('inputQuery'),
        ];
    }

}
