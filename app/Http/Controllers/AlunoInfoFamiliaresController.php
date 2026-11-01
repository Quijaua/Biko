<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlunoInfoFamiliares;
use Illuminate\Support\Facades\Auth;

class AlunoInfoFamiliaresController extends Controller
{
    public function index()
    {
      return 'INFORMAÇÕES FAMILIARES';
    }

    /**
     * Aluno só mexe nos próprios familiares; demais perfis passam pelo
     * mesmo critério de antes (tela de edição do aluno).
     */
    private function autorizar(?AlunoInfoFamiliares $infos = null, $idUser = null): void
    {
      $user = Auth::user();

      if (! in_array($user->role, ['aluno', 'administrador', 'coordenador', 'professor'], true)) {
        abort(403, 'Acesso não autorizado.');
      }

      if ($user->role === 'aluno') {
        $dono = $infos ? $infos->id_user : $idUser;
        abort_unless((int) $dono === (int) $user->id, 403, 'Acesso não autorizado.');
      }
    }

    public function add(Request $request)
    {
      $this->autorizar(null, $request->input('inputIdUser'));

      $infos = AlunoInfoFamiliares::create([
        'id_user' => $request->input('inputIdUser'),
        'GrauParentesco' => $request->input('inputGrauParentesco'),
        'Idade' => $request->input('inputIdade'),
        'EstadoCivil' => $request->input('inputEstadoCivil'),
        'Escolaridade' => $request->input('inputEscolaridade'),
        'Profissao' => $request->input('inputProfissao'),
        'Renda' => $request->input('inputRenda'),
        'id_aluno' => $request->input('inputIdAluno'),
      ]);

      return back()->with([
        'success' => 'DADOS SALVOS COM SUCESSO.',
      ]);
    }

    public function update(Request $request, $id)
    {
      $infos = AlunoInfoFamiliares::findOrFail($id);
      $this->autorizar($infos);

      $infos->GrauParentesco = $request->input('inputGrauParentesco');
      $infos->Idade = $request->input('inputIdade');
      $infos->EstadoCivil = $request->input('inputEstadoCivil');
      $infos->Escolaridade = $request->input('inputEscolaridade');
      $infos->Profissao = $request->input('inputProfissao');
      $infos->Renda = $request->input('inputRenda');

      $infos->save();
    }

    public function delete($id)
    {
      $infos = AlunoInfoFamiliares::findOrFail($id);
      $this->autorizar($infos);

      $infos->delete();
    }
}
