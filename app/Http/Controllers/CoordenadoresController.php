<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Session;
use App\Exports\CoordenadoresExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

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

        return view('coordenadores.coordenadores')->with([
          'coordenadores' => $coordenadores,
          'user' => $user,
        ]);
      }

      if($user->role === 'coordenador'){
        //$coordenadores = Coordenadores::get();
        $coordenadores = Coordenadores::paginate(25);

        return view('coordenadores.coordenadores')->with([
          'coordenadores' => $coordenadores,
          'user' => $user,
        ]);
      }

      if($user->role === 'administrador'){
        $user = Auth::user();
        //$coordenadores = Coordenadores::where('Status', 1)->get();
        /*$coordenadores = Coordenadores::where('Status', 1)->paginate(25);
        if($coordenadores->isEmpty()){
          //$coordenadores = Coordenadores::where('Status', 0)->get();
          $coordenadores = Coordenadores::where('Status', 0)->paginate(25);
        }*/
        $coordenadores = Coordenadores::paginate(25);

        return view('coordenadores.coordenadores')->with([
          'user' => $user,
          'coordenadores' => $coordenadores,
        ]);
      }
    }

    public function showForm()
    {
      $user = Auth::user();
      if ($user->role === 'professor') {
        abort(403, 'Acesso não autorizado.');
      }

      // dd(Auth::user()->coordenador->nucleo()->get());
      $nucleos = collect();

      if (Auth::user()->role === 'coordenador') {
        $nucleos = \App\Nucleo::where('Status', 1)->where('id', Auth::user()->coordenador->id_nucleo)->get();
      } else {
        $nucleos = \App\Nucleo::where('Status', 1)->get();
      }

      // dd($nucleos);
      // $nucleos = Nucleo::get()->where('Status', 1);
      $povosIndigenas = PovoIndigena::orderByRaw('label = "Sem Informação" DESC')
                      ->orderByRaw('LOWER(label) ASC')
                      ->get();

      return view('coordenadores.coordenadoresCreate')->with([
        'nucleos' => $nucleos,
        'povo_indigenas' => $povosIndigenas,
        'terra_indigenas' => TerraIndigena::all(),
      ]);
    }

    public function create(Request $request)
    {
      $validated = $request->validate([
        'inputNucleo' => 'required|array|min:1',
      ], [
        'inputNucleo.required' => 'O campo Núcleo deve ser preenchido.',
        'inputNucleo.array'    => 'Selecione ao menos um núcleo.',
        'inputNucleo.min'      => 'Selecione ao menos um núcleo.'
      ]);

      if (!$validated) {
          return back()->with([
              'error' => 'O campo Núcleo deve ser preenchido.',
          ]);
      }
      
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
        'pessoa_com_deficiencia' => $request->input('pessoa_com_deficiencia'),
      ]);

      $coordenador->nucleos()->sync($request->input('inputNucleo'));

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

      $selectedNucleos = $dados->nucleos()->pluck('nucleo_id')->toArray();

      $povosIndigenas = PovoIndigena::orderByRaw('label = "Sem Informação" DESC')
                      ->orderByRaw('LOWER(label) ASC')
                      ->get();

      return view('coordenadores.coordenadoresEdit')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'selectedNucleos' => $selectedNucleos,
        'povo_indigenas' => $povosIndigenas,
        'terra_indigenas' => TerraIndigena::all(),
      ]);
    }

    public function update(Request $request, $id)
    {
      $validated = $request->validate([
        'inputNucleo' => 'required|array|min:1',
      ], [
        'inputNucleo.required' => 'O campo Núcleo deve ser preenchido.',
        'inputNucleo.array'    => 'Selecione ao menos um núcleo.',
        'inputNucleo.min'      => 'Selecione ao menos um núcleo.'
      ]);

      if (!$validated) {
          return back()->with([
              'error' => 'O campo Núcleo deve ser preenchido.',
          ]);
      }

      $dados = Coordenadores::find($id);

      $Foto = $request->file('inputFoto');
      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
      }

      $dados->NomeCoordenador = $request->input('inputNomeCoordenador');
      $dados->NomeSocial = $request->input('inputNomeSocial');
      // $dados->id_nucleo = $request->input('inputNucleo') ? $request->input('inputNucleo') : NULL;
      if($Foto){
        $dados->Foto = $Foto->getFilename() . '.' . $Extension;
      }
      $dados->FuncaoCoordenador = $request->input('inputFuncaoCoordenador');
      $dados->AnoIngresso = $request->input('inputAnoIngresso');
      $dados->RepresentanteCGU = $request->input('inputRepresentanteCGU');
      $dados->CPF = $request->input('inputCPF');
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
      $dados->pessoa_com_deficiencia = $request->input('pessoa_com_deficiencia');

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

      $dados->nucleos()->sync($request->input('inputNucleo'));

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

    private static function getParams($request)
    {
      return [
        'inputQuery' => $request->input('inputQuery'),
        'nucleo' => $request->input('nucleo'),
        'status' => $request->input('status'),
      ];
    }

    public function search(Request $request)
    {
      $user = Auth::user();
      $params = self::getParams($request);

      $coordenadores = DB::table('coordenadores')
        ->when($params['inputQuery'], function ($query) use ($params) {
            return $query->where('coordenadores.NomeCoordenador', 'LIKE', '%' . $params['inputQuery'] . '%');
        })
        ->when($params['nucleo'], function ($query) use ($params) {
            return $query->where('coordenadores.id_nucleo', '=', $params['nucleo']);
        })
        ->when($params['status'], function ($query) use ($params) {
            return $query->where('coordenadores.Status', '=', $params['status'] === 'ativo' ? 1 : 0);
        })
        ->paginate(25);

      return view('coordenadores.coordenadores')->with([
        'user' => $user,
        'coordenadores' => $coordenadores,
      ]);
    }

    public function details($id)
    {
      $dados = Coordenadores::find($id);
      $nucleos = Nucleo::get()->where('Status', 1);

      $selectedNucleos = $dados->nucleos()->pluck('nucleo_id')->toArray();

      return view('coordenadores.coordenadoresDetails')->with([
        'dados' => $dados,
        'nucleos' => $nucleos,
        'selectedNucleos' => $selectedNucleos,
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
