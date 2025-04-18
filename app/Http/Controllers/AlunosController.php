<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Aluno;
use App\Nucleo;
use App\Professores;
use App\Coordenadores;
use App\User;
use App\AlunoInfoFamiliares;
use App\PovoIndigena;
use App\TerraIndigena;
use Image;
use Session;
use Carbon\Carbon;
use App\Exports\AlunosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\ActionLogTrait;

class AlunosController extends Controller
{

    use ActionLogTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        Session::put('verified', $user->email_verified_at);

        if ($user->role === 'aluno') {
            $alunos = $user->aluno()->paginate(25);
            if ($alunos[0]['CPF'] === null) {
                return redirect('alunos/edit/' . $alunos[0]['id'])->with([
                    'user' => $user,
                ]);
            } else {
                return view('alunos')->with([
                    'alunos' => $alunos,
                    'user' => $user,
                ]);
            }
        } else {
            //$alunos = Aluno::get();
            $alunos = Aluno::paginate(25);
        }

        if ($user->role === 'professor') {
            $nucleo = Professores::where('id_user', $user->id)->get('id_nucleo');
            //$alunos = Aluno::where('id_nucleo', $nucleo[0]['id_nucleo'])->get();
            $alunos = Aluno::where('id_nucleo', $nucleo[0]['id_nucleo'])->paginate(25);

            return view('alunos')->with([
                'alunos' => $alunos,
                'user' => $user,
            ]);
        }

        if ($user->role === 'coordenador') {
            $me = Coordenadores::where('id_user', $user->id)->first();
            $nucleo = Nucleo::find($me->id_nucleo);
            //$alunos = Aluno::where('id_nucleo', $nucleo->id)->get();
            $alunos = Aluno::where('id_nucleo', $nucleo->id)->paginate(25);

            return view('alunos')->with([
                'nucleo' => $nucleo->id,
                'alunos' => $alunos,
                'user' => $user,
            ]);
        }

        if ($user->role === 'administrador') {
            $alunos = Aluno::paginate(25);

            return view('alunos')->with([
                'alunos' => $alunos,
                'user' => $user,
            ]);
        }

        if ($alunos->isEmpty()) {
            //$alunos = Aluno::where('Status', 0)->get();
            $alunos = Aluno::where('Status', 0)->paginate(25);
            if ($alunos->isEmpty()) {
                return redirect('alunos/add');
            }
        }

        return view('alunos')->with('alunos', $alunos);
    }

    public function showForm()
    {
        $user = Auth::user();

        if ($user->role === 'coordenador') {
            $me = Coordenadores::where('id_user', $user->id)->first();
            $nucleos = Nucleo::where('id', $me->id_nucleo)->get();
        } else {
            $nucleos = Nucleo::get()->where('Status', 1);
        }

        return view('alunosCreate')->with([
            'nucleos' => $nucleos,
            'user' => $user,
            'povo_indigenas' => PovoIndigena::all(),
            'terra_indigenas' => TerraIndigena::all(),
        ]);
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

        $nome_nucleo = Nucleo::find($request->input('inputNucleo'));
        $Fund = $request->input('inputEnsFundamental');
        $Fundamental = json_encode($Fund);
        $Med = $request->input('inputEnsMedio');
        $Medio = json_encode($Med);
        $Foto = $request->file('inputFoto');
        if ($Foto) {
            $Extension = $Foto->getClientOriginalExtension();
            $foto = $Foto->getFilename() . '.' . $Extension;
        } else {
            $foto = null;
        }

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
        } else {
            return back()->with([
                'error' => 'ESTE EMAIL JÁ ESTÁ EM USO',
            ]);
        }

        Aluno::create([
            'id_user' => $user->id,
            'Status' => $request->input('inputStatus'),
            'NomeAluno' => $request->input('inputNomeAluno'),
            'NomeSocial' => $request->input('inputNomeSocial'),
            'id_nucleo' => $request->input('inputNucleo'),
            'NomeNucleo' => $nome_nucleo->NomeNucleo,
            'Foto' => $foto,
            'ListaEspera' => $request->input('inputListaEspera'),
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

            'RamoAtuacao' => $request->input('inputRamoAtuacao'),
            'RamoAtuacaoOutros' => $request->input('inputRamoAtuacaoOutros'),

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
            'CEPFamilia' => $request->input('inputCEPFamilia'),
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
            'localizacao_curso' => $request->input('localizacao_curso'),
            'povo_indigenas_id' => $request->input('povo_indigenas_id'),
            'terra_indigenas_id' => $request->input('terra_indigenas_id'),
        ]);

        if ($Foto) {
            $filename = $Foto->getFilename() . '.' . $Foto->getClientOriginalExtension();
            $path = public_path('storage/' . $filename);
            $image = $request->file('inputFoto');

            Image::make($image->getRealPath())
                ->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->crop(110, 110, null, null)
                ->encode('jpg', 80)
                ->save($path);
        }

        return back()->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dados = Aluno::find($id);
        $nucleos = Nucleo::get()->where('Status', 1);
        $familiares = AlunoInfoFamiliares::where('id_aluno', $dados->id)->get();

        return view('alunosEdit')->with([
            'dados' => $dados,
            'nucleos' => $nucleos,
            'user' => $user,
            'familiares' => $familiares,
            'povo_indigenas' => PovoIndigena::all(),
            'terra_indigenas' => TerraIndigena::all(),

        ]);
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
        
        $dados = Aluno::find($id);

        $Fund = $request->input('inputEnsFundamental');
        $Fundamental = json_encode($Fund);
        $Med = $request->input('inputEnsMedio');
        $Medio = json_encode($Med);
        $nome_nucleo = Nucleo::find($request->input('inputNucleo'));

        $Foto = $request->file('inputFoto');
        if ($Foto) {
            $Extension = $Foto->getClientOriginalExtension();
        }

        $dados->NomeAluno = $request->input('inputNomeAluno');
        $dados->NomeSocial = $request->input('inputNomeSocial');
        $dados->id_nucleo = $request->input('inputNucleo');
        $dados->NomeNucleo = $nome_nucleo->NomeNucleo;
        if ($Foto) {
            $dados->Foto = $Foto->getFilename() . '.' . $Extension;
        }
        if ($dados->CPF === null) {
            $dados->CPF = $request->input('inputCPF');
        } else {
            $dados->CPF = $dados->CPF;
        }
        $dados->ListaEspera = $request->input('inputListaEspera');
        $dados->RG = $request->input('inputRG');
        $dados->temFilhos = $request->input('temFilhos');
        $dados->filhosQt = $request->input('filhosQt');
        $dados->Email = $request->input('inputEmail');
        $dados->Raca = $request->input('inputRaca');
        $dados->Genero = $request->input('inputGenero');
        $dados->concordaSexoDesignado = $request->input('concordaSexoDesignado');
        $dados->responsavelCuidadoOutraPessoa = $request->input('responsavelCuidadoOutraPessoa');
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
        $dados->Escolaridade = $request->input('inputEscolaridade');

        $dados->RamoAtuacao = $request->input('inputRamoAtuacao');
        $dados->RamoAtuacaoOutros = $request->input('inputRamoAtuacaoOutros');

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
        $dados->Enem = $request->input('inputEnem');
        $dados->Vestibular = $request->input('inputVestibular');
        $dados->FaculdadeTipo = $request->input('inputFaculdadeTipo');
        $dados->NomeFaculdade = $request->input('inputNomeFaculdade');
        $dados->CursoFaculdade = $request->input('inputCursoFaculdade');
        $dados->AnoFaculdade = $request->input('inputAnoFaculdade');
        $dados->OpcoesVestibular1 = $request->input('inputOpcoesVestibular1');
        $dados->OpcoesVestibular2 = $request->input('inputOpcoesVestibular2');
        $dados->VestibularOutraCidade = $request->input('inputVestibularOutraCidade');
        $dados->ComoSoube = $request->input('inputComoSoube');
        $dados->povo_indigenas_id = $request->input('povo_indigenas_id') ?? NULL;
        $dados->terra_indigenas_id = $request->input('terra_indigenas_id') ?? NULL;
        if ($request->input('inputComoSoube') != 'outros') {
            $dados->ComoSoubeOutros = NULL;
        } else {
            $dados->ComoSoubeOutros = $request->input('inputComoSoubeOutros');
        }

        if ($Foto) {
            $filename = $Foto->getFilename() . '.' . $Foto->getClientOriginalExtension();
            $path = public_path('storage/' . $filename);
            $image = $request->file('inputFoto');

            Image::make($image->getRealPath())
                ->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->crop(110, 110, null, null)
                ->encode('jpg', 80)
                ->save($path);
        }

        Session::put('cpf', 'OK');
        //dd($dados);
        $dados->save();

        $url = $request->path();
        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->name;
        $alunoId = $dados->id;
        $alunoNome = $dados->NomeAluno;
        $this->logAction($url, $userId, $userName, $alunoId, $alunoNome);

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
        $cpf = $request->input('cpf');
        $status = $request->input('status');
        $query = $request->input('inputQuery');

        if ($query) {
            if ($user->role === 'coordenador') {
                $me = Coordenadores::where('id_user', $user->id)->first();
                //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->get();
                $results = Aluno::where('NomeAluno', 'LIKE', '%' . $query . '%')->where('id_nucleo', $me->id_nucleo)->paginate(25);
                if ($results->isEmpty()) {
                    return back()->with('error', 'Nenhum resultado encontrado.');
                } else {
                    return view('alunos')->with([
                        'user' => $user,
                        'alunos' => $results,
                    ]);
                }
            } elseif ($user->role === 'professor') {
                $me = Professores::where('id_user', $user->id)->first();
                //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->where('id_nucleo', $me->id_nucleo)->get();
                $results = Aluno::where('NomeAluno', 'LIKE', '%' . $query . '%')->where('id_nucleo', $me->id_nucleo)->paginate(25);
                if ($results->isEmpty()) {
                    return back()->with('error', 'Nenhum resultado encontrado.');
                } else {
                    return view('alunos')->with([
                        'user' => $user,
                        'alunos' => $results,
                    ]);
                }
            } else {
                $query = $request->input('inputQuery');
                //$results = Aluno::where('NomeAluno','LIKE','%'.$query.'%')->get();
                $results = Aluno::where('NomeAluno', 'LIKE', '%' . $query . '%')->paginate(25);
                if ($results->isEmpty()) {
                    return back()->with('error', 'Nenhum resultado encontrado.');
                } else {
                    return view('alunos')->with([
                        'user' => $user,
                        'alunos' => $results,
                    ]);
                }
            }
        }

        if ($cpf) {
            if ($cpf != '') {
                $result = Aluno::where('CPF', $cpf)->count();
                if ($result > 0) {
                    return \Response::json(true);
                } elseif ($result === 0) {
                    return \Response::json(false);
                }
            }
        }

        if ($user->role === 'coordenador') {
            $myNucleo = Nucleo::find($user->coordenador->id_nucleo);
            $nucleo = $myNucleo->id;
        } else if ($user->role === 'professor') {
            $myNucleo = Nucleo::find($user->professor->id_nucleo);
            $nucleo = $myNucleo->id;
        } else if ($user->role === 'aluno') {
            $myNucleo = Nucleo::find($user->aluno->id_nucleo);
            $nucleo = $myNucleo->id;
        } else {
            $nucleo = $request->input('nucleo');
        }

        if ($status === NULL && $nucleo === NULL) {
            //$result = Aluno::get();
            $result = Aluno::paginate(25);
            return view('alunos')->with([
                'nucleo' => $nucleo,
                'user' => $user,
                'alunos' => $result,
            ]);
        } else if ($status === NULL) {
            $result = Aluno::where('id_nucleo', $nucleo)->paginate(25);
            return view('alunos')->with([
                'nucleo' => $nucleo,
                'user' => $user,
                'alunos' => $result,
            ]);
        } else if ($nucleo === NULL) {
            $result = Aluno::where('Status', $status)->paginate(25);
            return view('alunos')->with([
                'nucleo' => $nucleo,
                'user' => $user,
                'alunos' => $result,
            ]);
        } else {
            $result = Aluno::where('Status', $status)->where('id_nucleo', $nucleo)->paginate(25);
            if ($result->isEmpty()) {
                return redirect('alunos')->with([
                    'nucleo' => $nucleo,
                    'alunos' => $result,
                    'error' => 'Não há alunos inativos no momento.',
                ]);
            } else {
                return view('alunos')->with([
                    'nucleo' => $nucleo,
                    'user' => $user,
                    'alunos' => $result,
                ]);
            };
        }

    }

    public function searchByNucleo(Request $request)
    {
        $user = Auth::user();
        $nucleo = $request->input('nucleo');
        $status = $request->input('status');
        $alunos = Aluno::where('id_nucleo', $nucleo)->where('Status', $status)->get();

        if ($alunos->isEmpty()) {
            return back()->with('error', "Nenhum resultado encontrado.");
        }

        return view('alunosByNucleo')->with([
            'alunos' => $alunos,
            'user' => $user,
        ]);
    }

    public function searchByNucleoAPI(Request $request)
    {
        $nucleos = $request->input('nucleos');
        $aluno = $request->input('aluno');

        $alunos = Aluno::whereStatus()
            ->whereIn('id_nucleo', $nucleos)
            ->where('NomeAluno', 'LIKE', "%$aluno%")
            ->orWhere('NomeSocial', 'LIKE', "%$aluno%")
            ->get();

        return response()->json($alunos);
    }

    public function details($id)
    {
        $user = Auth::user();
        $dados = Aluno::find($id);
        $nucleos = Nucleo::get()->where('Status', 1);
        $familiares = AlunoInfoFamiliares::where('id_aluno', $dados->id)->get();

        return view('alunosDetails')->with([
            'user' => $user,
            'dados' => $dados,
            'nucleos' => $nucleos,
            'familiares' => $familiares,
            'povo_indigenas' => PovoIndigena::all(),
            'terra_indigenas' => TerraIndigena::all(),
        ]);
    }

    public function export(Request $request)
    {
        $nucleo = $request->input('nucleo');

        if ($nucleo === null) {
            return (new AlunosExport())->download('alunos.xlsx');
        }

        return (new AlunosExport($nucleo))->download('alunos.xlsx');
    }

    public function logActionView($id)
    {
      $dados = DB::table('action_log')->where('aluno_id', $id)->paginate(25);

      return view('alunosActions')->with([
        'dados' => $dados,
      ]);
    }

}
