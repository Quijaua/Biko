<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\AtendimentoPsicologico;
use App\Psicologos;
use App\Aluno;
use App\LogAtendimentoPsicologico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class AtendimentoPsicologicoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'administrador' || $user->role === 'psicologa_supervisora' || $user->role === 'psicologo') {
            $atendimentos = AtendimentoPsicologico::orderBy('created_at', 'desc')
                            ->paginate(25);
        }
        else {
            abort(403, 'Acesso não autorizado.');
        }

        return view('atendimento-psicologico.index')->with([
            'user' => $user,
            'atendimento_psicologico' => $atendimentos,
        ]);
    }

    public function showByEstudante($id)
    {
        $user = Auth::user();
        $estudante = Aluno::findOrFail($id);

        if ($user->role === 'administrador' || $user->role === 'psicologa_supervisora') {
            $atendimento_psicologico = AtendimentoPsicologico::where('estudante_id', $id)
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(25);
        }
        elseif ($user->role === 'psicologo') {
            $psicologo = \App\Psicologos::where('user_id', $user->id)->first();

            if ($psicologo) {
                $atendimento_psicologico = AtendimentoPsicologico::where('estudante_id', $id)
                                            ->where('created_by', $user->id)
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(25);
            } else {
                $atendimentos = collect();
            }
        }
        else {
            abort(403, 'Acesso não autorizado.');
        }

        return view('atendimento-psicologico.index', compact('estudante', 'atendimento_psicologico'));
    }

    public function create()
    {
        $estudantes = Aluno::whereNotNull('NomeAluno')->orderBy('NomeAluno')->pluck('NomeAluno', 'id');
        return view('atendimento-psicologico.create', compact('estudantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'estudante_id'            => 'required|exists:alunos,id',
            'demanda_objetivos'       => 'required|string',
            'registro_atendimento'    => 'required|string',
            'tipo_encaminhamento'     => 'required|in:SUS,CRAS,CREAS,Atendimento finalizado',
            'descricao_encaminhamento' => 'nullable|string',
            'data'                    => 'nullable|date',
            'horario'                 => 'nullable|date_format:H:i',
            'anexo'                   => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('anexo')) {
            $data['anexo'] = $request->file('anexo')->store('anexos/atendimentos');
        }

        if (!empty($data['data']) && !empty($data['horario'])) {
            $data['data_atendimento'] = Carbon::parse($data['data'] . ' ' . $data['horario']);
        } else {
            $data['data_atendimento'] = null;
        }

        $data['created_by'] = Auth::id();

        unset($data['data'], $data['horario']);

        $atendimento = AtendimentoPsicologico::create($data);

        LogAtendimentoPsicologico::create([
            'atendimento_psicologico_id' => $atendimento->id,
            'user_id' => Auth::id(),
            'acao' => 'criou',
            'detalhes' => 'Criou o Atendimento Psicológico.'
        ]);

        return redirect()->route('atendimento-psicologico.index')
                         ->with('success', 'Atendimento registrado com sucesso!');
    }

    public function edit($id)
    {
        $dados = AtendimentoPsicologico::find($id);
        $userRole = Auth::user()->role;

        if (
            !in_array($userRole, ['administrador', 'psicologa_supervisora']) &&
            ($userRole !== 'psicologo' || $dados->created_by !== Auth::id())
        ) {
            abort(403, 'Acesso negado.');
        }

        $estudantes = Aluno::whereNotNull('NomeAluno')->orderBy('NomeAluno')->pluck('NomeAluno', 'id');
        return view('atendimento-psicologico.edit', compact('dados', 'estudantes'));
    }

    public function update($id, Request $request)
    {
        $atendimento = AtendimentoPsicologico::findOrFail($id);
        $data = $request->validate([
            'estudante_id'            => 'required|exists:alunos,id',
            'demanda_objetivos'       => 'required|string',
            'registro_atendimento'    => 'required|string',
            'tipo_encaminhamento'     => 'required|in:SUS,CRAS,CREAS,Atendimento finalizado',
            'status'                  => 'required|in:Atendida/o,Cancelou,Não compareceu,Psi cancelou',
            'descricao_encaminhamento' => 'nullable|string',
            'anexo'                   => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('anexo')) {
            // Deleta o anexo anterior se existir
            if ($atendimento->anexo && \Storage::exists($atendimento->anexo)) {
                \Storage::delete($atendimento->anexo);
            }

            // Armazena o novo anexo
            $data['anexo'] = $request->file('anexo')->store('anexos/atendimentos');
        }

        $data['updated_by'] = Auth::id();

        $atendimento->update($data);

        LogAtendimentoPsicologico::create([
            'atendimento_psicologico_id' => $id,
            'user_id' => Auth::id(),
            'acao' => 'editou',
            'detalhes' => 'Alterou os campos do Atendimento Psicológico.'
        ]);

        return redirect()->route('atendimento-psicologico.index')
                         ->with('success', 'Atendimento atualizado!');
    }

    private static function getParams($request)
    {
        return [
            'query' => $request->input('inputQuery'),
        ];
    }

    public function search(Request $request)
    {
        $params = self::getParams($request);

        $atendimento_psicologico = \App\AtendimentoPsicologico::with('estudante')
            ->when($params['query'], function ($query) use ($params) {
                $query->whereHas('estudante', function ($q) use ($params) {
                    $q->where('NomeAluno', 'LIKE', '%' . $params['query'] . '%');
                });
            })
            ->paginate(25);

        return view('atendimento-psicologico.index')->with([
            'user' => Auth::user(),
            'atendimento_psicologico' => $atendimento_psicologico,
        ]);
    }

    public function details($id)
    {
        $userId = Auth::id();

        $jaAcessouRecentemente = LogAtendimentoPsicologico::where('atendimento_psicologico_id', $id)
            ->where('user_id', $userId)
            ->where('acao', 'acessou')
            ->where('created_at', '>=', Carbon::now()->subMinutes(10))
            ->exists();

        if (!$jaAcessouRecentemente) {
            LogAtendimentoPsicologico::create([
                'atendimento_psicologico_id' => $id,
                'user_id' => $userId,
                'acao' => 'acessou',
                'detalhes' => 'Visualizou o Atendimento Psicológico.'
            ]);
        }

        $dados = AtendimentoPsicologico::find($id);
        $outros_atendimentos = AtendimentoPsicologico::where('estudante_id', $dados->estudante_id)->whereNotIn('id', [$id])->get();
        $estudantes = Aluno::whereNotNull('NomeAluno')->orderBy('NomeAluno')->pluck('NomeAluno', 'id');
        $logs = LogAtendimentoPsicologico::where('atendimento_psicologico_id', $id)
            ->with('user')
            ->latest()
            ->get();

        return view('atendimento-psicologico.details', compact('dados', 'estudantes', 'logs', 'outros_atendimentos'));
    }

    public function destroy(AtendimentoPsicologico $atendimento)
    {
        $atendimento->delete();
        return back()->with('success', 'Atendimento excluído!');
    }

    public function download($id)
    {
        $userId = Auth::id();

        $jaAbriuAnexo = LogAtendimentoPsicologico::where('atendimento_psicologico_id', $id)
            ->where('user_id', $userId)
            ->where('acao', 'abriu_anexo')
            ->exists();

        if (!$jaAbriuAnexo) {
            LogAtendimentoPsicologico::create([
                'atendimento_psicologico_id' => $id,
                'user_id' => $userId,
                'acao' => 'abriu_anexo',
                'detalhes' => 'Visualizou o anexo do Atendimento Psicológico.'
            ]);
        }

        $atendimento = AtendimentoPsicologico::findOrFail($id);

        if (empty($atendimento->anexo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $filePath = public_path('storage/' . $atendimento->anexo);

        if (!file_exists($filePath)) {
            abort(404, 'Arquivo não encontrado no servidor.');
        }

        return response()->download($filePath);
    }
}
