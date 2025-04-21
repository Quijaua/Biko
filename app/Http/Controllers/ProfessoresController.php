<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exports\ProfessoresExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

use App\Professores;
use App\Nucleo;
use App\User;
use App\Aluno;
use App\Coordenadores;
use App\HorarioAula;
use App\PovoIndigena;
use App\TerraIndigena;

class ProfessoresController extends Controller
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
        //$professores = Professores::get();
        $professores = Professores::paginate(25);

        return view('professores')->with([
          'professores' => $professores,
            'user' => $user,
        ]);
      }

      if($user->role === 'coordenador'){
        $me = Coordenadores::where('id_user', $user->id)->first();
        //$professores = Professores::where('id_nucleo', $me->id_nucleo)->get();
        $professores = Professores::where('id_nucleo', $me->id_nucleo)->paginate(25);

        return view('professores')->with([
          'professores' => $professores,
          'user' => $user,
        ]);
      }

      if($user->role === 'administrador'){
        $user = Auth::user();
        //$professores = Professores::where('Status', 1)->get();
        //$professores = Professores::where('Status', 1)->paginate(25);
        $professores = Professores::paginate(25);

        return view('professores')->with([
          'user' => $user,
          'professores' => $professores,
        ]);
      }

    }

    public function showForm()
    {
      $user = Auth::user();

      if($user->role === 'coordenador'){
        $me = Coordenadores::where('id_user', $user->id)->first();
        $nucleos = Nucleo::where('id', $me->id_nucleo)->where('Status', 1)->get();

        return view('professoresCreate')->with([
          'nucleos' => $nucleos,
        ]);
      }

      if($user->role === 'administrador'){
        $nucleos = Nucleo::where('Status', 1)->get();

        return view('professoresCreate')->with([
          'nucleos' => $nucleos,
          'povo_indigenas' => PovoIndigena::all(),
          'terra_indigenas' => TerraIndigena::all(),
        ]);
      }

    }

    public function create(Request $request)
    {
      $validated = $request->validate([
          'inputNucleo' => 'required',
      ]);

      if (!$validated) {
          return back()->with([
              'error' => 'O campo Núcleo deve ser preenchido.',
          ]);
      }
      
      $Foto = $request->file('inputFoto');
      //$Extension = $Foto->getClientOriginalExtension();
      $Disc = $request->input('inputDisciplinas');
      $Disciplinas = json_encode($Disc);
      $today = \Carbon\Carbon::now();

      $user = User::where('email', $request->input('inputEmail'))->first();
      if (!$user) {
        $user = User::create([
          'name' => $request->input('inputNomeProfessor'),
          'email' => $request->input('inputEmail'),
          'password' => Hash::make('uneafro@2019'),
          'role' => 'professor',
          'email_verified_at' => $today,
        ]);
      }else{
        return back()->with([
          'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
        ]);
      }

      /*
      $user = User::create([
        'name' => $request->input('inputNomeProfessor'),
        'email' => $request->input('inputEmail'),
        'password' => Hash::make('uneafro@2019'),
        'role' => 'professor',
        'email_verified_at' => $today,
      ]);
      */

      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
        $foto = $Foto->getFilename() . '.' . $Extension;
      }else{
        $foto = null;
      }

      $professor = Professores::create([
        'id_user' => $user->id,
        'Status' => $request->input('inputStatus'),
        'NomeProfessor' => $request->input('inputNomeProfessor'),
        'NomeSocial' => $request->input('inputNomeSocial'),
        'id_nucleo' => $request->input('inputNucleo'),
        //'Foto' => $Foto->getFilename() . '.' . $Extension,
        'Foto' => $foto,
        'CPF' => $request->input('inputCPF'),
        'RG' => $request->input('inputRG'),
        'Raca' => $request->input('inputRaca'),
        'Genero' => $request->input('inputGenero'),
        'concordaSexoDesignado' => $request->input('concordaSexoDesignado'),
        'EstadoCivil' => $request->input('inputEstadoCivil'),
        'Nascimento' => $request->input('inputNascimento'),
        'Disciplinas' => $Disciplinas,
        'OutrosNucleos' => $request->input('inputOutrosNucleos'),
        'Escolaridade' => $request->input('inputEscolaridade'),
        'FormacaoSuperior' => $request->input('inputFormacaoSuperior'),
        'AnoInicioUneafro' => $request->input('inputAnoInicioUneafro'),
        'aulasForaUneafro' => $request->input('aulasForaUneafro'),
        /*'DiasHorarios' => $request->input('inputDiasHorarios'),*/
        'GastoTransporte' => $request->input('inputGastoTransporte'),
        'TempoChegada' => $request->input('inputTempoChegada'),
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
        'CEPEmpresa' => $request->input('inputCEPEmpresa'),
        'EnderecoEmpresa' => $request->input('inputEnderecoEmpresa'),
        'NumeroEmpresa' => $request->input('inputNumeroEmpresa'),
        'ComplementoEmpresa' => $request->input('inputComplementoEmpresa'),
        'BairroEmpresa' => $request->input('inputBairroEmpresa'),
        'CidadeEmpresa' => $request->input('inputCidadeEmpresa'),
        'EstadoEmpresa' => $request->input('inputEstadoEmpresa'),
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

      //ROTINA DE PERSISTÊNCIA DOS HORÁRIOS DE AULA
      foreach( $request->input('inputDiasHorarios', []) as $horarios ){

        if($horarios['Segunda']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Segunda'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Segunda',
                'De'            => $horarios['Segunda']['de'],
                'Ate'           => $horarios['Segunda']['ate']
              ]
          );

        };

        if($horarios['Terca']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Terça'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Terça',
                'De'            => $horarios['Terca']['de'],
                'Ate'           => $horarios['Terca']['ate']
              ]
          );

        };

        if($horarios['Quarta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Quarta'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Quarta',
                'De'            => $horarios['Quarta']['de'],
                'Ate'           => $horarios['Quarta']['ate']
              ]
          );

        };

        if($horarios['Quinta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Quinta'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Quinta',
                'De'            => $horarios['Quinta']['de'],
                'Ate'           => $horarios['Quinta']['ate']
              ]
          );

        };

        if($horarios['Sexta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Sexta'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Sexta',
                'De'            => $horarios['Sexta']['de'],
                'Ate'           => $horarios['Sexta']['ate']
              ]
          );

        };

        if($horarios['Sabado']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $professor->id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Sábado'],
              [
                'professor_id'  => $professor->id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Sábado',
                'De'            => $horarios['Sabado']['de'],
                'Ate'           => $horarios['Sabado']['ate']
              ]
          );

        };

      };

      return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function edit($id)
    {
      $user = Auth::user();

      if($user->role === 'professor'){
        $dados = Professores::find($id);
        $nucleos = Nucleo::where('Status', 1)->get();

        return view('professoresEdit')->with([
          'dados' => $dados,
          'nucleos' => $nucleos,
        ]);
      }

      if($user->role === 'coordenador'){
        $nucleoId = Coordenadores::where('id_user', $user->id)->get('id_nucleo');
        $professor = Professores::find($id);
        if($professor->id_nucleo === $nucleoId[0]['id_nucleo']){
          $dados = Professores::find($id);
          $nucleos = Nucleo::where('Status', 1)->where('id', $nucleoId[0]['id_nucleo'])->get();

          return view('professoresEdit')->with([
            'dados' => $dados,
            'nucleos' => $nucleos,
          ]);
        }else{
          return back()->with('error', 'Ação não permitida.');
        }
      }

      if($user->role === 'administrador'){
        $dados = Professores::find($id);
        $dados->load('horarios');
        $nucleos = Nucleo::where('Status', 1)->get();

        return view('professoresEdit')->with([
          'dados'     => $dados,
          'nucleos'   => $nucleos,
          'povo_indigenas' => PovoIndigena::all(),
          'terra_indigenas' => TerraIndigena::all(),
        ]);
      }

    }

    public function update(Request $request, $id)
    {
      $validated = $request->validate([
          'inputNucleo' => 'required',
      ]);

      if (!$validated) {
          return back()->with([
              'error' => 'O campo Núcleo deve ser preenchido.',
          ]);
      }

      $dados = Professores::find($id);
      $Disc = $request->input('inputDisciplinas');
      $Disciplinas = json_encode($Disc);

      $Foto = $request->file('inputFoto');
      if($Foto){
        $Extension = $Foto->getClientOriginalExtension();
      }

      $dados->NomeProfessor = $request->input('inputNomeProfessor');
      $dados->NomeSocial = $request->input('inputNomeSocial');
      $dados->id_nucleo = $request->input('inputNucleo');
      if($Foto){
        $dados->Foto = $Foto->getFilename() . '.' . $Extension;
      }
      $dados->CPF = $dados->CPF;
      $dados->RG = $request->input('inputRG');
      $dados->Raca = $request->input('inputRaca');
      $dados->Genero = $request->input('inputGenero');
      $dados->concordaSexoDesignado = $request->input('concordaSexoDesignado');
      $dados->EstadoCivil = $request->input('inputEstadoCivil');
      $dados->Nascimento = $request->input('inputNascimento');
      $dados->Disciplinas = $Disciplinas;
      $dados->OutrosNucleos = $request->input('inputOutrosNucleos');
      $dados->Escolaridade = $request->input('inputEscolaridade');
      $dados->FormacaoSuperior = $request->input('inputFormacaoSuperior');
      $dados->AnoInicioUneafro = $request->input('inputAnoInicioUneafro');
      $dados->aulasForaUneafro = $request->input('aulasForaUneafro');
      /*$dados->DiasHorarios = $request->input('inputDiasHorarios');*/
      $dados->GastoTransporte = $request->input('inputGastoTransporte');
      $dados->TempoChegada = $request->input('inputTempoChegada');
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
      $dados->Email = $request->input('inputEmail');
      $dados->Empresa = $request->input('inputEmpresa');
      $dados->RamoAtuacao = $request->input('inputRamoAtuacao');
      $dados->RamoAtuacaoOutros = $request->input('inputRamoAtuacaoOutros');
      $dados->CEPEmpresa = $request->input('inputCEPEmpresa');
      $dados->EnderecoEmpresa = $request->input('inputEnderecoEmpresa');
      $dados->NumeroEmpresa = $request->input('inputNumeroEmpresa');
      $dados->ComplementoEmpresa = $request->input('inputComplementoEmpresa');
      $dados->BairroEmpresa = $request->input('inputBairroEmpresa');
      $dados->CidadeEmpresa = $request->input('inputCidadeEmpresa');
      $dados->EstadoEmpresa = $request->input('inputEstadoEmpresa');
      $dados->povo_indigenas_id = $request->input('povo_indigenas_id') ?? NULL;
      $dados->terra_indigenas_id = $request->input('terra_indigenas_id') ?? NULL;
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
      $dados->EnsinoSuperior = $request->input('inputEnsinoSuperior');
      $dados->InstituicaoSuperior = $request->input('inputInstituicaoSuperior');
      $dados->CursoSuperior1 = $request->input('inputCursoSuperior1');
      $dados->AnoCursoSuperior1 = $request->input('inputAnoCursoSuperior1');
      $dados->CursoSuperior2 = $request->input('inputCursoSuperior2');
      $dados->AnoCursoSuperior2 = $request->input('inputAnoCursoSuperior2');
      $dados->Especializacao = $request->input('inputEspecializacao');
      $dados->InstEspecializacao = $request->input('inputInstEspecializacao');
      $dados->CursoEspecializacao = $request->input('inputCursoEspecializacao');
      $dados->AnoCursoEspecializacao = $request->input('inputAnoCursoEspecializacao');
      $dados->Mestrado = $request->input('inputMestrado');
      $dados->InstMestrado = $request->input('inputInstMestrado');
      $dados->CursoMestrado = $request->input('inputCursoMestrado');
      $dados->AnoCursoMestrado = $request->input('inputAnoCursoMestrado');
      $dados->FormacaoAcademicaRecente = $request->input('inputFormacaoAcademicaRecente');
      $dados->pessoa_com_deficiencia = $request->input('pessoa_com_deficiencia');

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

      $currentEmail = Professores::where('id_user', $dados->id_user)->pluck('Email');
      $inputEmail = $request->input('inputEmail');
      if($inputEmail !== $currentEmail[0]){
        try {
          $professor = Professores::where('Email',$inputEmail)->get('Email');
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

      //ROTINA DE PERSISTÊNCIA DOS HORÁRIOS DE AULA
      foreach( $request->input('inputDiasHorarios', []) as $horarios){

        if($horarios['Segunda']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Segunda'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Segunda',
                'De'            => $horarios['Segunda']['de'],
                'Ate'           => $horarios['Segunda']['ate']
              ]
          );

        };

        if($horarios['Terca']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Terça'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Terça',
                'De'            => $horarios['Terca']['de'],
                'Ate'           => $horarios['Terca']['ate']
              ]
          );

        };

        if($horarios['Quarta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Quarta'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Quarta',
                'De'            => $horarios['Quarta']['de'],
                'Ate'           => $horarios['Quarta']['ate']
              ]
          );

        };

        if($horarios['Quinta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Quinta'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Quinta',
                'De'            => $horarios['Quinta']['de'],
                'Ate'           => $horarios['Quinta']['ate']
              ]
          );

        };

        if($horarios['Sexta']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Sexta'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Sexta',
                'De'            => $horarios['Sexta']['de'],
                'Ate'           => $horarios['Sexta']['ate']
              ]
          );

        };

        if($horarios['Sabado']){

          $horario = HorarioAula::updateOrCreate(
              ['professor_id' => $id, 'nucleo_id' => $request->input('inputNucleo'), 'DiaSemana' => 'Sábado'],
              [
                'professor_id'  => $id,
                'nucleo_id'     => $request->input('inputNucleo'),
                'DiaSemana'     => 'Sábado',
                'De'            => $horarios['Sabado']['de'],
                'Ate'           => $horarios['Sabado']['ate']
              ]
          );

        };

      };

      $dados->save();

      return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function disable(Request $request, $id)
    {
      $user = Auth::user();

      if($user->role === 'coordenador'){
        $nucleoId = Coordenadores::where('id_user', $user->id)->get('id_nucleo');
        $professor = Professores::find($id);
        if($professor->id_nucleo === $nucleoId[0]['id_nucleo']){
          $professor->Status = 0;
          $professor->save();

          return back()->with('success', 'Professor inativado com sucesso.');
        }else{
          return back()->with('error', 'Ação não permitida.');
        }
      }

      if($user->role === 'administrador'){
        $professor = Professores::find($id);
        $professor->Status = 0;
        $professor->save();

        return back()->with([
          'success' => 'Professor inativado com sucesso.',
        ]);
      }

    }

    public function enable(Request $request, $id)
    {
      $user = Auth::user();

      if($user->role === 'coordenador'){
        $nucleoId = Coordenadores::where('id_user', $user->id)->get('id_nucleo');
        $professor = Professores::find($id);
        if($professor->id_nucleo === $nucleoId[0]['id_nucleo']){
          $professor->Status = 1;
          $professor->save();

          return back()->with('success', 'Professor ativado com sucesso.');
        }else{
          return back()->with('error', 'Ação não permitida.');
        }
      }

      if($user->role === 'administrador'){
        $professor = Professores::find($id);
        $professor->Status = 1;
        $professor->save();

        return back()->with([
          'success' => 'Professor ativado com sucesso.',
        ]);
      }

    }

    public function search(Request $request)
    {
      $params = self::getParams($request);
      $user = Auth::user();

      switch ($user->role) {
        case 'coordenador':
          if (!$params['nucleo_id']) {
            $params['nucleo_id'] = $user->coordenador->id_nucleo;
          }
          break;
        
        case 'professor':
          if (!$params['nucleo_id']) {
            $params['nucleo_id'] = $user->professor->id_nucleo;
          }
          break;
      }

      $professores = DB::table('professores')
        ->when($params['nucleo_id'], function ($query) use ($params) {
          return $query->where('professores.id_nucleo', '=', $params['nucleo_id']);
        })
        ->when($params['status'], function ($query) use ($params) {
          return $query->where('professores.Status', '=', $params['status'] === 'ativo' ? 1 : 0);
        })
        ->when($params['query'], function ($query) use ($params) {
          return $query->where('professores.NomeProfessor', 'LIKE', '%' . $params['query'] . '%');
        })
        ->paginate(25);

      return view('professores')->with([
        'user' => $user,
        'professores' => $professores,
      ]);
    }

    private static function getParams($request)
    {
        return [
            'nucleo_id' => $request->input('nucleo'),
            'status' => $request->input('status'),
            'query' => $request->input('inputQuery'),
        ];
    }

    public function details($id)
    {
      $dados = Professores::find($id);
      $dados->load('horarios');
      $nucleos = Nucleo::where('Status', 1)->get();

      return view('professoresDetails')->with([
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
            return (new ProfessoresExport())->download('professores.xlsx');
        }

        return (new ProfessoresExport($nucleo))->download('professores.xlsx');
    }
}
