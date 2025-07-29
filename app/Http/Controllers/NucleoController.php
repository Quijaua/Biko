<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use \Carbon\Carbon;
use DB;

use App\Aluno;
use App\Professores;
use App\Coordenadores;
use App\Nucleo;
use App\ListaPresenca;
use App\Frequencia;
use App\Disciplina;

class NucleoController extends Controller
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
        //$nucleos = Nucleo::get();
        $nucleos = Nucleo::paginate(25);

        return view('nucleos.nucleos')->with([
          'nucleos' => $nucleos,
          'user' => $user,
        ]);
      }

      if($user->role === 'coordenador'){
        $myNucleosIds = $user->coordenador->nucleos()->pluck('nucleos.id')->toArray();
        $nucleos = Nucleo::paginate(25);

        return view('nucleos.nucleos')->with([
          'myNucleo' => $myNucleosIds,
          'user' => $user,
          'nucleos' => $nucleos,
        ]);
      }

      if($user->role === 'administrador'){
        $user = Auth::user();
        //$nucleos = Nucleo::where('Status', 1)->get();
        //$nucleos = Nucleo::where('Status', 1)->paginate(25);
        $nucleos = Nucleo::paginate(25);

        return view('nucleos.nucleos')->with([
          'user' => $user,
          'nucleos' => $nucleos,
        ]);
      }
    }

    public function showForm()
    {
      $user = Auth::user();
      if ($user->role !== 'administrador') {
        abort(403, 'Acesso não autorizado.');
      }

      return view('nucleos.nucleosCreate')->with([
        'disciplinas' => Disciplina::all(),
      ]);
    }

    public function edit($id)
    {
      $dados = Nucleo::find($id);
      $dados->disciplinas = json_decode($dados->disciplinas);

      $user = Auth::user();
      if ($user->role === 'coordenador') {
        $myNucleosIds = $user->coordenador->nucleos()->pluck('nucleos.id')->toArray();
        if (!in_array($dados->id, $myNucleosIds)) {
          abort(403, 'Você não tem permissão para excluir este núcleo.');
        }
      }

      $representantes = $dados->coordenadores()
        ->wherePivot('nucleo_id', $id)
        ->where('RepresentanteCGU', 'sim')
        ->get(['NomeCoordenador']);

      $disciplinas = Disciplina::all();

      return view('nucleos.nucleosEdit')->with([
        'dados' => $dados,
        'representantes' => $representantes,
        'disciplinas' => $disciplinas,
        'professoresDisciplinas' => $dados->professoresDisciplinas,
      ]);
    }

    public function create(Request $request)
    {

      $nucleo = Nucleo::create([
        'Status' => $request->input('inputStatus'),
        'NomeNucleo' => $request->input('inputNomeNucleo'),
        'AreaAtuacao' =>$request->input('inputAreaAtuacao'),
        'InfoInscricao' => $request->input('inputInfoInscricao'),
        'EspacoInserido' => $request->input('inputEspacoInserido'),
        'Endereco' => $request->input('inputEndereco'),
        'Numero' => $request->input('inputNumero'),
        'Bairro' => $request->input('inputBairro'),
        'Complemento' => $request->input('inputComplemento'),
        'Cidade' => $request->input('inputCidade'),
        'Estado' => $request->input('inputEstado'),
        'CEP' => $request->input('inputCEP'),
        'Telefone' => $request->input('inputTelefone'),
        'Email' => $request->input('inputEmail'),
        'Fundacao' => $request->input('inputFundacao'),
        'Facebook' => $request->input('inputFacebook'),
        'LinkSite' => $request->input('inputLinkSite'),
        'RedeSocial' => $request->input('inputRedeSocial'),
        'TaxaInscricao' => $request->input('inputTaxaInscricao'),
        'TaxaInscricaoValor' => $request->input('inputTaxaInscricaoValor'),
        'Vagas' => $request->input('inputVagas'),
        'InscricaoFrom' => $request->input('inputInscricaoFrom'),
        'InscricaoTo' => $request->input('inputInscricaoTo'),
        'InicioAtividades' => $request->input('inputInicioAtividades'),
        'Status' => $request->input('inputStatus'),
        'whatsapp_url' => $request->input('inputWhatsapp'),
        'Regiao' => $request->input('inputRegiao'),
        'permite_ambiente_virtual' => $request->input('permiteAmbienteVirtual'),
        'disciplinas' => $request->input('disciplinas'),
      ]);

      return redirect('/nucleos/edit/' . $nucleo->id)
        ->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function update(Request $request, $id)
    {
      $nucleo = Nucleo::find($id);
      $nucleo->NomeNucleo = $request->input('inputNomeNucleo');
      $nucleo->AreaAtuacao = $request->input('inputAreaAtuacao');
      $nucleo->InfoInscricao = $request->input('inputInfoInscricao');
      $nucleo->EspacoInserido = $request->input('inputEspacoInserido');
      $nucleo->Endereco = $request->input('inputEndereco');
      $nucleo->Numero = $request->input('inputNumero');
      $nucleo->Bairro = $request->input('inputBairro');
      $nucleo->Complemento = $request->input('inputComplemento');
      $nucleo->Cidade = $request->input('inputCidade');
      $nucleo->Estado = $request->input('inputEstado');
      $nucleo->CEP = $request->input('inputCEP');
      $nucleo->Telefone = $request->input('inputTelefone');
      $nucleo->Email = $request->input('inputEmail');
      $nucleo->Fundacao = $request->input('inputFundacao');
      $nucleo->Facebook = $request->input('inputFacebook');
      $nucleo->LinkSite = $request->input('inputLinkSite');
      $nucleo->RedeSocial = $request->input('inputRedeSocial');
      $nucleo->TaxaInscricao = $request->input('inputTaxaInscricao');
      $nucleo->TaxaInscricaoValor = $request->input('inputTaxaInscricaoValor');
      $nucleo->Vagas = $request->input('inputVagas');
      $nucleo->InscricaoFrom = $request->input('inputInscricaoFrom');
      $nucleo->InscricaoTo = $request->input('inputInscricaoTo');
      $nucleo->InicioAtividades = $request->input('inputInicioAtividades');
      $nucleo->whatsapp_url = $request->input('inputWhatsapp');
      $nucleo->Regiao = $request->input('inputRegiao');
      $nucleo->permite_ambiente_virtual = $request->input('permiteAmbienteVirtual');
      $nucleo->disciplinas = $request->input('disciplinas');

      $nucleo->save();

      return redirect('/nucleos/edit/' . $nucleo->id)
        ->with('success', 'DADOS SALVOS COM SUCESSO.');
    }

    public function disable(Request $request, $id)
    {
      $nucleo = Nucleo::find($id);
      $nucleo->Status = 0;

      $nucleo->save();

      return back()->with('success', 'Núcleo inativado com sucesso.');
    }

    public function enable(Request $request, $id)
    {
      $nucleo = Nucleo::find($id);
      $nucleo->Status = 1;

      $nucleo->save();

      return back()->with('success', 'Núcleo ativado com sucesso.');
    }

    public function search(Request $request)
    {
      $user = Auth::user();
      $params = self::getParams($request);

      $nucleos = DB::table('nucleos')
        ->when($params['inputQuery'], function ($query) use ($params) {
            return $query->where('nucleos.NomeNucleo', 'LIKE', '%' . $params['inputQuery'] . '%');
        })
        ->when($params['status'], function ($query) use ($params) {
            return $query->where('nucleos.Status', '=', $params['status'] === 'ativo' ? 1 : 0);
        })
        ->when($params['cidade'], function ($query) use ($params) {
            return $query->where('nucleos.Cidade', '=', $params['cidade']);
        })
        ->paginate(25);

      return view('nucleos.nucleos')->with([
        'user' => $user,
        'nucleos' => $nucleos,
      ]);
    }

    public function destroy($id)
    {
      $nucleo = Nucleo::findOrFail($id);

      if ($nucleo->alunos()->exists()) {
        return back()->with('error', 'Não é possível excluir este núcleo pois existem alunos cadastrados.');
      }

      $nucleo->delete();
      return redirect('/nucleos')->with('success', 'Núcleo excluído com sucesso.');
    }

    public function details($id)
    {
      $dados = Nucleo::find($id);
      $dados->disciplinas = json_decode($dados->disciplinas);

      $representantes = $dados->coordenadores()
        ->wherePivot('nucleo_id', $id)
        ->where('RepresentanteCGU', 'sim')
        ->get(['NomeCoordenador']);

      return view('nucleos.nucleosDetails')->with([
        'dados' => $dados,
        'representantes' => $representantes,
        'disciplinas' => Disciplina::all(),
        'professoresDisciplinas' => $dados->professoresDisciplinas,
      ]);
    }

    public function presences_index()
    {
      $user = Auth::user();

      if ( $user->role === 'professor' ) {
        $professor = Professores::where('id_user', Auth::user()->id)->first();
      } else if ( $user->role === 'coordenador' ) {
        $professor = Coordenadores::where('id_user', Auth::user()->id)->first();
      } else if ( $user->role === 'aluno' ) {
        $professor = Aluno::where('id_user', Auth::user()->id)->first();
      }

      $nucleos = [];
      if($user->role === 'administrador'){
          $nucleos = Nucleo::where('Status', 1)->pluck('NomeNucleo', 'id')->all();
          $nucleo = Nucleo::find(request('nid', head(array_keys($nucleos))));
      } else if ($user->role === 'coordenador') {
          $coordenadorNucleos = $user->coordenador->nucleos()->pluck('nucleos.id')->toArray();
          $nucleos = Nucleo::where('Status', 1)->whereIn('id', $coordenadorNucleos)->pluck('NomeNucleo', 'id')->all();
          $nucleo = Nucleo::find(request('nid', head(array_keys($nucleos))));
      } else {
          $nucleo = Nucleo::find($professor->id_nucleo);
      }

      return view('nucleos.lista-presenca')->with([
          'nucleos' => $nucleos,
          'nucleo' => $nucleo,
          'alunos' => $nucleo->alunos,
      ]);
    }

    public function presences_new(Request $request)
    {
      $user = Auth::user();

      if ( $user->role === 'professor' ) {
        $professor = Professores::where('id_user', Auth::user()->id)->first();
      } else if ( $user->role === 'coordenador' ) {
        $professor = Coordenadores::where('id_user', Auth::user()->id)->first();
      };

      $alunos = Nucleo::find($professor->id_nucleo)->alunos;

      if ( $request->date ) {
        $date = $request->date;
      } else {
        $date = Carbon::now()->format('Y-m-d');
      }

      $lista = ListaPresenca::updateOrCreate(
        ['nucleo_id' => $professor->id_nucleo, 'date' => $date],
        [
          'nucleo_id' => $professor->id_nucleo,
          'professor_id' => $professor->id,
          'date' => $date
        ]
      );

      return view('nucleos.lista-presenca-create')->with([
        'lista' => $lista,
        'date' => $date,
        'alunos' => $alunos
      ]);
    }

    public function presences_create(Request $request)
    {
      $data = $request->all();

      $frequencia = Frequencia::updateOrCreate(
          ['lista_presenca_id' => $data['listaId'], 'aluno_id' => $data['alunoId']],
          [
            'lista_presenca_id' => $data['listaId'],
            'aluno_id' => $data['alunoId'],
            'is_present' => $data['situation']
          ]
      );

      return response()->json($frequencia, 200);
    }

    public function presences_destroy(Request $request)
    {
      $frequencias = Frequencia::where('lista_presenca_id', $request->id)->get();

      if( $frequencias ) {
        foreach( $frequencias as $frequencia ) {
          Frequencia::destroy($frequencia->id);
        }
      }

      ListaPresenca::destroy($request->id);
      return redirect()->route('nucleo/presences');
    }

    public function search_presences(Request $request)
    {
      $user = Auth::user();
      $params = self::getParams($request);
      $params['weekAgo'] = Carbon::now()->subWeek()->format('Y-m-d');

      switch ($user->role) {
        case 'professor':
          $professor = Professores::where('id_user', Auth::user()->id)->first();
          break;
        case 'coordenador':
          $professor = Coordenadores::where('id_user', Auth::user()->id)->first();
          break;
        default:
          $professor = Professores::where('Status', 1)->first();
      };

      $nucleos = DB::table('nucleos')
        ->when($params['inputQuery'], function ($query) use ($params) {
            return $query->where('nucleos.NomeNucleo', 'LIKE', '%' . $params['inputQuery'] . '%');
        })
        ->when($params['nucleo'], function ($query) use ($params) {
            return $query->where('nucleos.id', '=', $params['nucleo']);
        })
        ->when($params['date'], function ($query) use ($params) {
            return $query->whereBetween('nucleos.created_at', [$params['weekAgo'], $params['date']]);
        })
        ->paginate(25);

      $nucleo = $professor->nucleo;

      return view('nucleos.lista-presenca')->with([
        'nucleos' => $nucleos,
        'nucleo' => $nucleo,
        'alunos' => $nucleo->alunos,
      ]);
    }

    private static function getParams($request)
    {
        return [
            'inputQuery' => $request->input('inputQuery'),
            'status' => $request->input('status'),
            'cidade' => $request->input('cidade'),
            'nucleo' => $request->input('nucleo'),
            'date' => $request->input('date'),
        ];
    }
}
