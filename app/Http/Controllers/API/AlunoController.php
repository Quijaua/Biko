<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;

use App\Aluno;
use App\User;

class AlunoController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }

  public function cadastraAluno(Request $request)
  {
    $data = $request->all();
    $aluno = User::where('email', $data['email'])->get();

    if( !$aluno->isEmpty() ) {
      return response()->json('Já existe cadastro para este email.', 422);
    }

    try {

      $user = User::create([
        'name' => $data['NomeAluno'],
        'email' => $data['email'],
        'password' => Hash::make($data['email']),
        'role' => 'aluno', // nunca vindo da requisição
        'first_login' => true
      ]);

      Aluno::create([
        'id_user' => $user->id,
        'Status' => 1,
        'NomeAluno' => $data['NomeAluno'],
        'id_nucleo' => $data['id_nucleo'],
        'Raca' => $data['Raca'],
        'Genero' => $data['Genero'],
        'IdentificaGenero' => $data['IdentificaGenero'],
        'Nascimento' => $data['Nascimento'],
        'Cidade' => $data['Cidade'],
        'Estado' => $data['Estado'],
        'CEP' => $data['CEP'],
        'Endereco' => $data['Endereco'],
        'Numero' => $data['Numero'],
        'Bairro' => $data['Bairro'],
        'Complemento' => $data['Complemento'],
        'FoneCelular' => $data['FoneCelular'],
        'EnsFundamental' => $data['EnsFundamental'],
        'PorcentagemBolsa' => $data['PorcentagemBolsa'],
        'EnsMedio' => $data['EnsMedio'],
        'PorcentagemBolsaMedio' => $data['PorcentagemBolsaMedio'],
        'Enem' => $data['Enem'],
        'Vestibular' => $data['Vestibular'],
        'OpcoesVestibular1' => $data['OpcoesVestibular1'],
        'OpcoesVestibular2' => $data['OpcoesVestibular2'],
        'VestibularOutraCidade' => $data['VestibularOutraCidade'],
        'ComoSoube' => $data['ComoSoube']
      ]);
      return response()->json('Pré-cadastro realizado com sucesso.', 200);

    } catch (\Exception $e) {

      \Log::info([
        'aluno CREATE ERROR' => $e->getMessage()
      ]);
      return response()->json('Não foi possível realizar esta operação.', 500);

    }
  }
}
