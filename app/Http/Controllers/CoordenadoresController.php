<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Session;
use App\Exports\CoordenadoresExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Coordenadores;
use App\Nucleo;
use App\User;
use App\PovoIndigena;
use App\TerraIndigena;

class CoordenadoresController extends Controller
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
        return back();
      }

      if($user->role === 'professor'){
        //$coordenadores = Coordenadores::get();
        $coordenadores = Coordenadores::paginate(25);

        return view('coordenadores')->with([
          'coordenadores' => $coordenadores,
          'user' => $user,
        ]);
      }

      if($user->role === 'coordenador'){
        //$coordenadores = Coordenadores::get();
        $coordenadores = Coordenadores::paginate(25);

        return view('coordenadores')->with([
          'coordenadores' => $coordenadores,
          'user' => $user,
        ]);
      }

      if($user->role === 'administrador'){
        $user = Auth::user();
        //$coordenadores = Coordenadores::where('Status', 1)->get();
        $coordenadores = Coordenadores::where('Status', 1)->paginate(25);
        if($coordenadores->isEmpty()){
          //$coordenadores = Coordenadores::where('Status', 0)->get();
          $coordenadores = Coordenadores::where('Status', 0)->paginate(25);
        }

        return view('coordenadores')->with([
          'user' => $user,
          'coordenadores' => $coordenadores,
        ]);
      }
    }

    public function showForm()
    {
      $nucleos = Nucleo::get()->where('Status', 1);

      return view('coordenadoresCreate')->with([
        'nucleos' => $nucleos,
        'povo_indigenas' => PovoIndigena::all(),
        'terra_indigenas' => TerraIndigena::all(),
      ]);
    }

    public function create(Request $request)
    {
      $Foto = $request->file('inputFoto');
      //$Extension = $Foto->getClientOriginalExtension();
      $today = \Carbon\Carbon::now();

      $cgu = $request->input('inputRepresentanteCGU');
      if($cgu){
        $nucleo = $request->input('inputNucleo');
        $representantesNucleo = Coordenadores::where('id_nucleo', $nucleo)->count();
        if($representantesNucleo >= 2){
          return back()->withInput()->with('error', 'NÚCLEO JÁ POSSUI 2 REPRESENTANTES.');
        }elseif($representantesNucleo != ''){
          $dados = Nucleo::find($nucleo);
          $id = $coordenador->id;
          $dados->id_representanteCGU = $id;
          $dados->save();
        }
      }

      $user = User::where('email', $request->input('inputEmail'))->first();
      if (!$user) {
        $user = User::create([
          'name' => $request->input('inputNomeCoordenador'),
          'email' => $request->input('inputEmail'),
          'password' => Hash::make('uneafro@2019'),
          'role' => 'coordenador',
          'email_verified_at' => $today,
        ]);
      }else{
        return back()->with([
          'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
        ]);
      }

      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
        $foto = $Foto->getFilename() . '.' . $Extension;
      }else{
        $foto = null;
      }

      $coordenador = Coordenadores::create([
        'id_user' => $user->id,
        'Status' => $request->input('inputStatus'),
        'NomeCoordenador' => $request->input('inputNomeCoordenador'),
        'NomeSocial' => $request->input('inputNomeSocial'),
        'id_nucleo' => $request->input('inputNucleo'),
        'FuncaoCoordenador' => $request->input('inputFuncaoCoordenador'),
        'AnoIngresso' => $request->input('inputAnoIngresso'),
        'RepresentanteCGU' => $request->input('inputRepresentanteCGU'),
        //'Foto' => $Foto->getFilename() . '.' . $Extension,
        'Foto' => $foto,
        'CPF' => $request->input('inputCPF'),
        'RG' => $request->input('inputRG'),
        'Raca' => $request->input('inputRaca'),
        'Genero' => $request->input('inputGenero'),
        'concordaSexoDesignado' => $request->input('concordaSexoDesignado'),
        'EstadoCivil' => $request->input('inputEstadoCivil'),
        'Nascimento' => $request->input('inputNascimento'),
        'Escolaridade' => $request->input('inputEscolaridade'),
        'FormacaoSuperior' => $request->input('inputFormacaoSuperior'),
        'AnoInicioUneafro' => $request->input('inputAnoInicioUneafro'),
        'aulasForaUneafro' => $request->input('aulasForaUneafro'),
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
        'Email' => $request->input('inputEmail'),
        'Empresa' => $request->input('inputEmpresa'),
        'RamoAtuacao' => $request->input('inputRamoAtuacao'),
        'RamoAtuacaoOutros' => $request->input('inputRamoAtuacaoOutros'),
        'EnderecoEmpresa' => $request->input('inputEnderecoEmpresa'),
        'NumeroEmpresa' => $request->input('inputNumeroEmpresa'),
        'ComplementoEmpresa' => $request->input('inputComplementoEmpresa'),
        'BairroEmpresa' => $request->input('inputBairroEmpresa'),
        'CidadeEmpresa' => $request->input('inputCidadeEmpresa'),
        'EstadoEmpresa' => $request->input('inputEstadoEmpresa'),
        'CEPEmpresa' => $request->input('inputCEPEmpresa'),
        'Cargo' => $request->input('inputCargo'),
        'HorarioFrom' => $request->input('inputHorarioFrom'),
        'HorarioTo' => $request->input('inputHorarioTo'),
        'ProjetosRealizados' => $request->input('inputProjetosRealizados'),
        'ProjetosNome' => $request->input('inputProjetosNome'),
        'ProjetosFuncao' => $request->input('inputProjetosFuncao'),
        'ComoSoube' => $request->input('inputComoSoube'),
        'ComoSoubeOutros' => $request->input('inputComoSoubeOutros'),
        'MotivoPrincipal' => $request->input('inputMotivoPrincipal'),
        'EnsinoSuperior' => $request->input('inputEnsinoSuperior'),
        'InstituicaoSuperior' => $request->input('inputInstituicaoSuperior'),
        'CursoSuperior1' => $request->input('inputCursoSuperior1'),
        'AnoCursoSuperior1' => $request->input('inputAnoCursoSuperior1'),
        'CursoSuperior2' => $request->input('inputCursoSuperior2'),
        'AnoCursoSuperior2' => $request->input('inputAnoCursoSuperior2'),
        'Especializacao' => $request->input('inputEspecializacao'),
        'InstEspecializacao' => $request->input('inputInstEspecializacao'),
        'CursoEspecializacao' => $request->input('inputCursoEspecializacao'),
        'AnoCursoEspecializacao' => $request->input('inputAnoCursoEspecializacao'),
        'Mestrado' => $request->input('inputMestrado'),
        'InstMestrado' => $request->input('inputInstMestrado'),
        'CursoMestrado' => $request->input('inputCursoMestrado'),
        'AnoCursoMestrado' => $request->input('inputAnoCursoMestrado'),
        'FormacaoAcademicaRecente' => $request->input('inputFormacaoAcademicaRecente'),
        'povo_indigenas_id' => $request->input('povo_indigenas_id'),
        'terra_indigenas_id' => $request->input('terra_indigenas_id'),
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
      $dados = Coordenadores::find($id);
      $nucleos = Nucleo::get()->where('Status', 1);

      return view('coordenadoresEdit')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'povo_indigenas' => PovoIndigena::all(),
        'terra_indigenas' => TerraIndigena::all(),
      ]);
    }

    public function update(Request $request, $id)
    {
      $dados = Coordenadores::find($id);

      $Foto = $request->file('inputFoto');
      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
      }

      $dados->NomeCoordenador = $request->input('inputNomeCoordenador');
      $dados->NomeSocial = $request->input('inputNomeSocial');
      $dados->id_nucleo = $request->input('inputNucleo') ? $request->input('inputNucleo') : NULL;
      if($Foto){
        $dados->Foto = $Foto->getFilename() . '.' . $Extension;
      }
      $dados->FuncaoCoordenador = $request->input('inputFuncaoCoordenador');
      $dados->AnoIngresso = $request->input('inputAnoIngresso');
      $dados->RepresentanteCGU = $request->input('inputRepresentanteCGU');
      $dados->CPF = $dados->CPF;
      $dados->RG = $request->input('inputRG');
      $dados->Raca = $request->input('inputRaca') ? $request->input('inputRaca') : NULL;
      $dados->Genero = $request->input('inputGenero') ? $request->input('inputGenero') : NULL;
      $dados->concordaSexoDesignado = $request->input('concordaSexoDesignado');
      $dados->EstadoCivil = $request->input('inputEstadoCivil') ? $request->input('inputEstadoCivil') : NULL;
      $dados->Nascimento = $request->input('inputNascimento');
      $dados->Escolaridade = $request->input('inputEscolaridade') ? $request->input('inputEscolaridade') : NULL;
      $dados->FormacaoSuperior = $request->input('inputFormacaoSuperior');
      $dados->AnoInicioUneafro = $request->input('inputAnoInicioUneafro');
      $dados->aulasForaUneafro = $request->input('aulasForaUneafro') ? $request->input('aulasForaUneafro') : NULL;
      $dados->Endereco = $request->input('inputEndereco');
      $dados->Numero = $request->input('inputNumero');
      $dados->Bairro = $request->input('inputBairro');
      $dados->CEP = $request->input('inputCEP');
      $dados->Cidade = $request->input('inputCidade');
      $dados->Estado = $request->input('inputEstado') ? $request->input('inputEstado') : NULL;
      $dados->Complemento = $request->input('inputComplemento');
      $dados->FoneComercial = $request->input('inputFoneComercial');
      $dados->FoneResidencial = $request->input('inputFoneResidencial');
      $dados->FoneCelular = $request->input('inputFoneCelular');
      $dados->Email = $request->input('inputEmail');
      $dados->Empresa = $request->input('inputEmpresa');
      $dados->RamoAtuacao = $request->input('inputRamoAtuacao');
      $dados->RamoAtuacaoOutros = $request->input('inputRamoAtuacaoOutros');
      $dados->EnderecoEmpresa = $request->input('inputEnderecoEmpresa');
      $dados->NumeroEmpresa = $request->input('inputNumeroEmpresa');
      $dados->ComplementoEmpresa = $request->input('inputComplementoEmpresa');
      $dados->BairroEmpresa = $request->input('inputBairroEmpresa');
      $dados->CidadeEmpresa = $request->input('inputCidadeEmpresa');
      $dados->EstadoEmpresa = $request->input('inputEstadoEmpresa');
      $dados->CEPEmpresa = $request->input('inputCEPEmpresa');
      $dados->Cargo = $request->input('inputCargo');
      $dados->HorarioFrom = $request->input('inputHorarioFrom');
      $dados->HorarioTo = $request->input('inputHorarioTo');
      $ProjetosRealizados = $dados->ProjetosRealizados = $request->input('inputProjetosRealizados');
      if($ProjetosRealizados === 'nao'){
        $dados->ProjetosNome = NULL;
        $dados->ProjetosFuncao = NULL;
      }else{
        $dados->ProjetosNome = $request->input('inputProjetosNome');
        $dados->ProjetosFuncao = $request->input('inputProjetosFuncao');
      }
      $dados->ComoSoube = $request->input('inputComoSoube');
      if($request->input('inputComoSoube') != 'outros'){
        $dados->ComoSoubeOutros = NULL;
      }else{
        $dados->ComoSoubeOutros = $request->input('inputComoSoubeOutros');
      }
      $dados->MotivoPrincipal = $request->input('inputMotivoPrincipal');
      $dados->EnsinoSuperior = $request->input('inputEnsinoSuperior') ? $request->input('inputEnsinoSuperior') : NULL;
      $dados->InstituicaoSuperior = $request->input('inputInstituicaoSuperior');
      $dados->CursoSuperior1 = $request->input('inputCursoSuperior1');
      $dados->AnoCursoSuperior1 = $request->input('inputAnoCursoSuperior1') ? $request->input('inputAnoCursoSuperior1') : NULL;
      $dados->CursoSuperior2 = $request->input('inputCursoSuperior2');
      $dados->AnoCursoSuperior2 = $request->input('inputAnoCursoSuperior2') ? $request->input('inputAnoCursoSuperior2') : NULL;
      $dados->Especializacao = $request->input('inputEspecializacao') ? $request->input('inputEspecializacao') : NULL;
      $dados->InstEspecializacao = $request->input('inputInstEspecializacao');
      $dados->CursoEspecializacao = $request->input('inputCursoEspecializacao');
      $dados->AnoCursoEspecializacao = $request->input('inputAnoCursoEspecializacao') ? $request->input('inputAnoCursoEspecializacao') : NULL;
      $dados->Mestrado = $request->input('inputMestrado') ? $request->input('inputMestrado') : NULL;
      $dados->InstMestrado = $request->input('inputInstMestrado') ? $request->input('inputInstMestrado') : NULL;
      $dados->CursoMestrado = $request->input('inputCursoMestrado');
      $dados->AnoCursoMestrado = $request->input('inputAnoCursoMestrado') ? $request->input('inputAnoCursoMestrado') : NULL;
      $dados->FormacaoAcademicaRecente = $request->input('inputFormacaoAcademicaRecente');
      $dados->povo_indigenas_id = $request->input('povo_indigenas_id') ?? NULL;
      $dados->terra_indigenas_id = $request->input('terra_indigenas_id') ?? NULL;

      $cgu = $dados->RepresentanteCGU;
      if($cgu){
        $nucleo = $dados->id_nucleo;
        $representantesNucleo = Coordenadores::where('id_nucleo', $nucleo)->count();
        $idRepresentantes = Coordenadores::where('id_nucleo', $nucleo)->get('id');

        if($representantesNucleo >= 2 && $idRepresentantes[0]['id'] != $dados->id && $idRepresentantes[1]['id'] != $dados->id){
          return back()->with('error', 'NÚCLEO JÁ POSSUI 2 REPRESENTANTES.');
        }
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

      $currentEmail = Coordenadores::where('id_user', $dados->id_user)->pluck('Email');
      $inputEmail = $request->input('inputEmail');
      if($inputEmail !== $currentEmail[0]){
        try {
          $coordenador = Coordenadores::where('Email',$inputEmail)->get('Email');
          $user = User::where('id', $dados->id_user)->first();
          $user->email = $inputEmail;
          $user->save();
          //dd($professor);
        } catch (ModelNotFoundException $exception) {
            return back()->with([
              'error' => 'ESTE EMAIL JÁ ESTÁ EM USO.',
            ]);
        }
      }

      $dados->save();

      return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function disable(Request $request, $id)
    {
      $coordenador = Coordenadores::find($id);
      $coordenador->Status = 0;

      $coordenador->save();

      return back()->with('success', 'Coordenador inativado com sucesso.');
    }

    public function enable(Request $request, $id)
    {
      $coordenador = Coordenadores::find($id);
      $coordenador->Status = 1;

      $coordenador->save();

      return back()->with('success', 'Coordenador ativado com sucesso.');
    }

    public function search(Request $request)
    {
      $user = Auth::user();
      $cpf = $request->input('cpf');
      $status = $request->input('status');
      $query = $request->input('inputQuery');

      if($query){
        if($user->role === 'coordenador'){
          $me = Coordenadores::where('id_user', $user->id)->first();
          //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->get();
          //$results = Coordenadores::where('NomeCoordenador','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->paginate(25);
          $results = Coordenadores::where('NomeCoordenador','LIKE','%'.$query.'%')->paginate(25);
          //dd($results);
          if($results->isEmpty()){
            return back()->with('error', 'Nenhum resultado encontrado.');
          }else{
            return view('coordenadores')->with([
              'user' => $user,
              'coordenadores' => $results,
            ]);
          }
        }elseif($user->role === 'professor'){
          $me = Professores::where('id_user', $user->id)->first();
          //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->get();
          $results = Coordenadores::where('NomeCoordenador','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->paginate(25);
          if($results->isEmpty()){
            return back()->with('error', 'Nenhum resultado encontrado.');
          }else{
            return view('coordenadores')->with([
              'user' => $user,
              'coordenadores' => $results,
            ]);
          }
        }else{
          $query = $request->input('inputQuery');
          //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->get();
          $results = Coordenadores::where('NomeCoordenador','LIKE','%'.$query.'%')->paginate(25);
          if($results->isEmpty()){
            return back()->with('error', 'Nenhum resultado encontrado.');
          }else{
            return view('coordenadores')->with([
              'user' => $user,
              'coordenadores' => $results,
            ]);
          }
        }
      }

      if($cpf){
        if($cpf != ''){
          $result = Coordenadores::where('CPF', $cpf)->count();
          if($result > 0){
            return \Response::json(true);
          }elseif($result === 0){
            return \Response::json(false);
          }
        }
      }

      if($user->role === 'coordenador'){
        $myNucleo = Nucleo::find($user->coordenador->id_nucleo);
        $nucleo = $myNucleo->id;
      }else if($user->role === 'professor'){
        $myNucleo = Nucleo::find($user->professor->id_nucleo);
        $nucleo = $myNucleo->id;
      }else if($user->role === 'aluno'){
        $myNucleo = Nucleo::find($user->aluno->id_nucleo);
        $nucleo = $myNucleo->id;
      }else{
        $nucleo = $request->input('nucleo');
      }

      if($status === NULL && $nucleo === NULL){
        //$result = Aluno::get();
        $result = Coordenadores::paginate(25);
        return view('coordenadores')->with([
          'nucleo' => $nucleo,
          'user' => $user,
          'coordenadores' => $result,
        ]);
      }else if($status === NULL){
        //$result = Aluno::where('id_nucleo', $nucleo)->get();
        $result = Coordenadores::where('id_nucleo', $nucleo)->paginate(25);
        return view('coordenadores')->with([
          'nucleo' => $nucleo,
          'user' => $user,
          'coordenadores' => $result,
        ]);
      }else if($nucleo === NULL){
        //$result = Aluno::where('Status', $status)->get();
        $result = Coordenadores::where('Status', $status)->paginate(25);
        return view('coordenadores')->with([
          'nucleo' => $nucleo,
          'user' => $user,
          'coordenadores' => $result,
        ]);
      }else{
        //$result = Aluno::where('Status', $status)->where('id_nucleo', $nucleo)->get();
        $result = Coordenadores::where('Status', $status)->where('id_nucleo', $nucleo)->paginate(25);
        if($result->isEmpty()){
          return redirect('coordenadores')->with([
            'nucleo' => $nucleo,
            'coordenadores' => $result,
            'error' => 'Não há coordenadores inativos no momento.',
          ]);
        }else{
          return view('coordenadores')->with([
            'nucleo' => $nucleo,
            'user' => $user,
            'coordenadores' => $result,
          ]);
        };
      }

      if($status === '0'){
        //$user = Auth::user();
        $result = Coordenadores::where('Status', 0)->get();
        if($result->isEmpty()){
          return redirect('coordenadores')->with([
            'error' => 'Não há coordenadores inativos no momento.',
          ]);
        }

        return view('coordenadores')->with([
          'user' => $user,
          'coordenadores' => $result,
        ]);
      }

      if($status === '1'){
        //$user = Auth::user();
        $result = Coordenadores::where('Status', 1)->get();
        if($result->isEmpty()){
          return redirect('coordenadores')->with([
            'error' => 'Não há coordenadores ativos no momento.',
          ]);
        }

        return view('coordenadores')->with([
          'user' => $user,
          'coordenadores' => $result,
        ]);
      }

      $query = $request->input('inputQuery');
      $results = Coordenadores::where('NomeCoordenador','LIKE','%'.$query.'%')->get();

      if($results->isEmpty()){
        return back()->with('error', 'Nenhum resultado encontrado.');
      }else{
        return view('coordenadores')->with([
          'user' => $user,
          'coordenadores' => $results
        ]);
      }
    }

    public function details($id)
    {
      $dados = Coordenadores::find($id);
      $nucleos = Nucleo::get()->where('Status', 1);

      return view('coordenadoresDetails')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'povo_indigenas' => PovoIndigena::all(),
        'terra_indigenas' => TerraIndigena::all(),
      ]);
    }

    public function export(Request $request)
    {
        $nucleo = $request->input('nucleo');

        if ($nucleo === null) {
            return (new CoordenadoresExport())->download('coordenadores.xlsx');
        }

        return (new CoordenadoresExport($nucleo))->download('coordenadores.xlsx');
    }
}
