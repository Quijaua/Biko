<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Aluno;
use App\Nucleo;
use App\Professores;
use App\Coordenadores;
use App\User;
use App\AlunoInfoFamiliares;
use Image;
use Session;
use Carbon\Carbon;
use App\Exports\AlunosExport;
use Maatwebsite\Excel\Facades\Excel;

class AlunosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $user = Auth::user();
      Session::put('verified', $user->email_verified_at);

      if($user->role === 'aluno'){
        $alunos = $user->aluno()->get();
        if($alunos[0]['CPF'] === null){
          return redirect('alunos/edit/'.$alunos[0]['id'])->with([
            'user' => $user,
          ]);
        }else{
          return view('alunos')->with([
            'alunos' => $alunos,
            'user' => $user,
          ]);
        }
      }else{
        $alunos = Aluno::where('Status', 1)->get();
      }

      if($user->role === 'professor'){
        $nucleo = Professores::where('id_user', $user->id)->get('id_nucleo');
        $alunos = Aluno::where('id_nucleo', $nucleo[0]['id_nucleo'])->get();

        return view('alunos')->with([
          'alunos' => $alunos,
          'user' => $user,
        ]);
      }

      if($user->role === 'coordenador'){
        $nucleo = Coordenadores::where('id_user', $user->id)->get('id_nucleo');
        $alunos = Aluno::where('id_nucleo', $nucleo[0]['id_nucleo'])->where('Status', 1)->get();

        return view('alunos')->with([
          'alunos' => $alunos,
          'user' => $user,
        ]);
      }

      if($user->role === 'administrador'){
        $alunos = Aluno::where('Status', 1)->get();

        return view('alunos')->with([
          'alunos' => $alunos,
          'user' => $user,
        ]);
      }

      if($alunos->isEmpty()){
        $alunos = Aluno::get()->where('Status', 0);
        if($alunos->isEmpty()){
          return redirect('alunos/add');
        }
      }

      return view('alunos')->with('alunos', $alunos);
    }

    public function showForm()
    {
      $user = Auth::user();
      $nucleos = Nucleo::get()->where('Status', 1);

      return view ('alunosCreate')->with([
        'nucleos' => $nucleos,
        'user' => $user,
      ]);
    }

    public function create(Request $request)
    {
      $Fund = $request->input('inputEnsFundamental');
      $Fundamental = json_encode($Fund);
      $Med = $request->input('inputEnsMedio');
      $Medio = json_encode($Med);
      $Foto = $request->file('inputFoto');
      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
        $foto = $Foto->getFilename() . '.' . $Extension;
      }else{
        $foto = null;
      }
      //$Extension = $Foto->getClientOriginalExtension();
      $today = Carbon::now();

      $user = User::where('email', $request->input('inputEmail'))->first();
      if (!$user) {
        $user = User::create([
          'name' => $request->input('inputNomeAluno'),
          'email' => $request->input('inputEmail'),
          'password' => Hash::make('uneafro@2019'),
          'role' => 'aluno',
          'email_verified_at' => $today,
        ]);
      }else{
        return back()->with([
          'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
        ]);
      }

      /*
      $user = User::create([
        'name' => $request->input('inputNomeAluno'),
        'email' => $request->input('inputEmail'),
        'password' => Hash::make('uneafro@2019'),
        'role' => 'aluno',
        'email_verified_at' => $today,
      ]);
      */

      Aluno::create([
        'id_user' => $user->id,
        'Status' => $request->input('inputStatus'),
        'NomeAluno' => $request->input('inputNomeAluno'),
        'id_nucleo' => $request->input('inputNucleo'),
        //'Foto' => $Foto->getFilename() . '.' . $Extension,
        'Foto' => $foto,
        'CPF' => $request->input('inputCPF'),
        'RG' => $request->input('inputRG'),
        'Email' => $request->input('inputEmail'),
        'Raca' => $request->input('inputRaca'),
        'Genero' => $request->input('inputGenero'),
        'EstadoCivil' => $request->input('inputEstadoCivil'),
        'Nascimento' => $request->input('inputNascimento'),
        'Endereco' => $request->input('inputEndereco'),
        'Numero' => $request->input('inputNumero'),
        'Bairro' => $request->input('inputBairro'),
        'CEP' => $request->input('inputCEP'),
        'Cidade' => $request->input('inputCidade'),
        'Estado' => $request->input('inputEstado'),
        'Complemento' => $request->input('inputComplemento'),
        'FoneComercial' => $request->input('inputFoneComercial'),
        'FoneResidencial' => $request->input('inputFoneResidencial'),
        'FoneCelular' => $request->input('inputFoneCelular'),
        'Empresa' => $request->input('inputEmpresa'),
        'EnderecoEmpresa' => $request->input('inputEnderecoEmpresa'),
        'NumeroEmpresa' => $request->input('inputNumeroEmpresa'),
        'BairroEmpresa' => $request->input('inputBairroEmpresa'),
        'CidadeEmpresa' => $request->input('inputCidadeEmpresa'),
        'EstadoEmpresa' => $request->input('inputEstadoEmpresa'),
        'ComplementoEmpresa' => $request->input('inputComplementoEmpresa'),
        'CEPEmpresa' => $request->input('inputCEPEmpresa'),
        'Cargo' => $request->input('inputCargo'),
        'HorarioFrom' => $request->input('inputHorarioFrom'),
        'HorarioTo' => $request->input('inputHorarioTo'),
        'NomeMae' => $request->input('inputNomeMae'),
        'NomePai' => $request->input('inputNomePai'),
        'CEPFamilia' =>$request->input('inputCEPFamilia'),
        'EnderecoFamilia' => $request->input('inputEnderecoFamilia'),
        'NumeroFamilia' => $request->input('inputNumeroFamilia'),
        'ComplementoFamilia' => $request->input('inputComplementoFamilia'),
        'BairroFamilia' => $request->input('inputBairroFamilia'),
        'CidadeFamilia' => $request->input('inputCidadeFamilia'),
        'EstadoFamilia' => $request->input('inputEstadoFamilia'),
        'TelefoneFamilia' => $request->input('inputTelefoneFamilia'),
        'AuxGoverno' => $request->input('inputAuxGoverno'),
        'AuxTipo' => $request->input('inputAuxTipo'),
        'EnsFundamental' => $Fundamental,
        'PorcentagemBolsa' => $request->input('inputPorcentagemBolsa'),
        'EnsMedio' => $Medio,
        'PorcentagemBolsaMedio' => $request->input('inputPorcentagemBolsaMedio'),
        'Vestibular' => $request->input('inputVestibular'),
        'FaculdadeTipo' => $request->input('inputFaculdadeTipo'),
        'NomeFaculdade' => $request->input('inputNomeFaculdade'),
        'CursoFaculdade' => $request->input('inputCursoFaculdade'),
        'AnoFaculdade' => $request->input('inputAnoFaculdade'),
        'OpcoesVestibular1' => $request->input('inputOpcoesVestibular1'),
        'OpcoesVestibular2' => $request->input('inputOpcoesVestibular2'),
        'VestibularOutraCidade' => $request->input('inputVestibularOutraCidade'),
        'ComoSoube' => $request->input('inputComoSoube'),
        'ComoSoubeOutros' => $request->input('inputComoSoubeOutros'),
      ]);

      if($Foto){
        $filename = $Foto->getFilename().'.'.$Foto->getClientOriginalExtension();
        $path = public_path('storage/'.$filename);
        $image = $request->file('inputFoto');

        Image::make($image->getRealPath())
          ->resize(150, null, function ($constraint) {
              $constraint->aspectRatio();
          })
          ->crop(110,110,null,null)
          ->encode('jpg',80)
          ->save($path);
      }

      return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function edit($id)
    {
      $user = Auth::user();
      $dados = Aluno::find($id);
      $nucleos = Nucleo::get()->where('Status', 1);

      return view('alunosEdit')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'user' => $user,
    ]);
    }

    public function update(Request $request,$id)
    {
      $dados = Aluno::find($id);
      $Fund = $request->input('inputEnsFundamental');
      $Fundamental = json_encode($Fund);
      $Med = $request->input('inputEnsMedio');
      $Medio = json_encode($Med);

      $Foto = $request->file('inputFoto');
      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
      }

      $dados->NomeAluno = $request->input('inputNomeAluno');
      $dados->id_nucleo = $request->input('inputNucleo');
      if($Foto){
        $dados->Foto = $Foto->getFilename() . '.' . $Extension;
      }
      if($dados->CPF === null){
        $dados->CPF = $request->input('inputCPF');
      }else{
        $dados->CPF = $dados->CPF;
      }
      $dados->RG = $request->input('inputRG');
      $dados->Email = $request->input('inputEmail');
      $dados->Raca = $request->input('inputRaca');
      $dados->Genero = $request->input('inputGenero');
      $dados->EstadoCivil = $request->input('inputEstadoCivil');
      $dados->Nascimento = $request->input('inputNascimento');
      $dados->Endereco = $request->input('inputEndereco');
      $dados->Numero = $request->input('inputNumero');
      $dados->Bairro = $request->input('inputBairro');
      $dados->CEP = $request->input('inputCEP');
      $dados->Cidade = $request->input('inputCidade');
      $dados->Estado = $request->input('inputEstado');
      $dados->Complemento = $request->input('inputComplemento');
      $dados->FoneComercial = $request->input('inputFoneComercial');
      $dados->FoneResidencial = $request->input('inputFoneResidencial');
      $dados->FoneCelular = $request->input('inputFoneCelular');
      $dados->Empresa = $request->input('inputEmpresa');
      $dados->EnderecoEmpresa = $request->input('inputEnderecoEmpresa');
      $dados->NumeroEmpresa = $request->input('inputNumeroEmpresa');
      $dados->BairroEmpresa = $request->input('inputBairroEmpresa');
      $dados->CidadeEmpresa = $request->input('inputCidadeEmpresa');
      $dados->EstadoEmpresa = $request->input('inputEstadoEmpresa');
      $dados->ComplementoEmpresa = $request->input('inputComplementoEmpresa');
      $dados->CEPEmpresa = $request->input('inputCEPEmpresa');
      $dados->Cargo = $request->input('inputCargo');
      $dados->HorarioFrom = $request->input('inputHorarioFrom');
      $dados->HorarioTo = $request->input('inputHorarioTo');
      $dados->NomeMae = $request->input('inputNomeMae');
      $dados->NomePai = $request->input('inputNomePai');
      $dados->CEPFamilia = $request->input('inputCEPFamilia');
      $dados->EnderecoFamilia = $request->input('inputEnderecoFamilia');
      $dados->NumeroFamilia = $request->input('inputNumeroFamilia');
      $dados->ComplementoFamilia = $request->input('inputComplementoFamilia');
      $dados->BairroFamilia = $request->input('inputBairroFamilia');
      $dados->CidadeFamilia = $request->input('inputCidadeFamilia');
      $dados->EstadoFamilia = $request->input('inputEstadoFamilia');
      $dados->TelefoneFamilia = $request->input('inputTelefoneFamilia');
      $dados->AuxGoverno = $request->input('inputAuxGoverno');
      $dados->AuxTipo = $request->input('inputAuxTipo');
      $dados->EnsFundamental = $request->input('inputEnsFundamental');
      $dados->PorcentagemBolsa = $request->input('inputPorcentagemBolsa');
      $dados->EnsMedio = $request->input('inputEnsMedio');
      $dados->PorcentagemBolsaMedio = $request->input('inputPorcentagemBolsaMedio');
      $dados->Vestibular = $request->input('inputVestibular');
      $dados->FaculdadeTipo = $request->input('inputFaculdadeTipo');
      $dados->NomeFaculdade = $request->input('inputNomeFaculdade');
      $dados->CursoFaculdade = $request->input('inputCursoFaculdade');
      $dados->AnoFaculdade = $request->input('inputAnoFaculdade');
      $dados->OpcoesVestibular1 = $request->input('inputOpcoesVestibular1');
      $dados->OpcoesVestibular2 = $request->input('inputOpcoesVestibular2');
      $dados->VestibularOutraCidade = $request->input('inputVestibularOutraCidade');
      $dados->ComoSoube = $request->input('inputComoSoube');
      if($request->input('inputComoSoube') != 'outros'){
        $dados->ComoSoubeOutros = NULL;
      }else{
        $dados->ComoSoubeOutros = $request->input('inputComoSoubeOutros');
      }

      if($Foto){
        $filename = $Foto->getFilename().'.'.$Foto->getClientOriginalExtension();
        $path = public_path('storage/'.$filename);
        $image = $request->file('inputFoto');

        Image::make($image->getRealPath())
          ->resize(150, null, function ($constraint) {
              $constraint->aspectRatio();
          })
          ->crop(110,110,null,null)
          ->encode('jpg',80)
          ->save($path);
      }

      Session::put('cpf', 'OK');

      $dados->save();

      return back()->with([
        'success' => 'DADOS SALVOS COM SUCESSO.',
      ]);
    }

    public function disable(Request $request, $id)
    {
      $aluno = Aluno::find($id);
      $aluno->Status = 0;

      $aluno->save();

      return back()->with('success', 'Aluno inativado com sucesso.');
    }

    public function enable(Request $request, $id)
    {
      $aluno = Aluno::find($id);
      $aluno->Status = 1;

      $aluno->save();

      return back()->with('success', 'Aluno ativado com sucesso.');
    }

    public function search(Request $request)
    {
      $user = Auth::user();
      $status = $request->input('status');
      $cpf = $request->input('cpf');
      $nucleo = $request->input('nucleo');
      //dd($nucleo);

      if($cpf != ''){
        $result = Aluno::where('CPF', $cpf)->count();
        if($result > 0){
          return \Response::json(true);
        }elseif($result === 0){
          return \Response::json(false);
        }
      }

      if($status != ''){
        $result = Aluno::where('Status', 0)->get();
        if($result->isEmpty()){
          return redirect('alunos')->with([
            'result' => $result,
            'error' => 'Não há alunos inativos no momento.',
          ]);
        }

        return view('alunos')->with([
          'user' => $user,
          'alunos' => $result,
        ]);
      }

      if($nucleo != ''){
        $result = Aluno::where('id_nucleo', $nucleo)->where('status', 1)->get();
        if($result->isEmpty()){
          return back()->with([
            'result' => $result,
            'error' => 'Não há alunos neste núcleo.',
          ]);
        };

        return view('alunos')->with([
          'user' => $user,
          'alunos' => $result,
        ]);
      }

      $query = $request->input('inputQuery');
      $results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->get();

      if($results->isEmpty()){
        return back()->with('error', 'Nenhum resultado encontrado.');
      }else{
        return view('alunos')->with('alunos', $results);
      }
    }

    public function details($id)
    {
      $dados = Aluno::find($id);
      $nucleos = Nucleo::get()->where('Status', 1);
      $familiares = AlunoInfoFamiliares::where('id_aluno', $dados->id)->get();
      /*
      foreach($familiares as $parente){
        $counter = count($parente->GrauParentesco);
        for($i = 0; $i < $counter; $i++){
          echo $parente->GrauParentesco[$i].'<br>';
          echo $parente->Idade[$i].'<br>';
          echo $parente->EstadoCivil[$i].'<br>';
          echo $parente->Escolaridade[$i].'<br>';
          echo $parente->Profissao[$i].'<br>';
          echo $parente->Renda[$i].'<br>';
        }
      }
      */

      return view('alunosDetails')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'familiares' => $familiares,
      ]);
    }

    public function export(Request $request)
    {
      //dd($request->input('nucleo'));
      $nucleo = $request->input('nucleo');
      //dd($nucleo);
      return (new AlunosExport($nucleo))->download('alunos.xlsx');
    }
}
