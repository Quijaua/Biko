<?php

namespace App\Http\Controllers;

use App\User;
use App\Psicologos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class PsicologosController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->role === 'professor' || $user->role === 'aluno'){
            return back();
        }

        if($user->role === 'administrador' || $user->role === 'psicologa_supervisora'){
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
        'supervisora'=> 'nullable|boolean',
      ]);

      $isSupervisora = $request->boolean('supervisora');
      $role = $isSupervisora ? 'psicologa_supervisora' : 'psicologo';

      $user = User::where('email', $data['email'])->first();
      $today = \Carbon\Carbon::now();
      if (!$user) {
        $user = new User([
          'name' => $data['nome'],
          'email' => $data['email'],
          'password' => Hash::make('uneafro@2019'),
          'role' => $role,
          'email_verified_at' => $today,
        ]);

        $user->save();

        $data['user_id'] = $user->id;
      }else{
        return back()->with([
          'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
        ]);
      }

      $data['supervisora'] = $isSupervisora;
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

    public function update($id, Request $request)
    {
        $psicologos = Psicologos::findOrFail($id);

        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'crp'        => "required|string|max:50|unique:psicologos,crp,{$id}",
            'telefone'   => 'required|string|max:20',
            'email'      => "required|email|unique:psicologos,email,{$id}",
            'supervisora'=> 'nullable|boolean',
        ]);

        $isSupervisora = $request->boolean('supervisora');
        $role = $isSupervisora ? 'psicologa_supervisora' : 'psicologo';

        // Busca o usuário vinculado ao psicólogo (supondo que o vínculo seja feito pelo e-mail)
        $user = User::where('email', $data['email'])->first();

        // Verifica se o novo e-mail já está em uso por outro usuário
        $emailJaUsado = User::where('email', $data['email'])
            ->where('id', '!=', optional($user)->id)
            ->exists();

        if ($emailJaUsado) {
            return back()->with([
                'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
            ]);
        }

        // Atualiza o usuário, se encontrado
        if ($user) {
            $user->update([
                'name'  => $data['nome'],
                'email' => $data['email'],
                'role'  => $role,
            ]);

            $data['user_id'] = $user->id;
        }

        // Atualiza o psicólogo
        $data['supervisora'] = $isSupervisora;
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
