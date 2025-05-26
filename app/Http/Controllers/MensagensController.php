<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Mensagens;
use App\MensagensAluno;
use App\Nucleo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MensagensController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->allowed_send_email) {
            $mensagens = Mensagens::query()
                ->where('remetente_id', Auth::user()->id)
                ->paginate(10);
        } else {
            $mensagens = MensagensAluno::query()
                ->where('aluno_id', Auth::user()->aluno->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('mensagens.index', compact('mensagens'));
    }

    public function removed()
    {
        $mensagensAluno = MensagensAluno::onlyTrashed()
            ->where('aluno_id', Auth::user()->id)
            ->paginate(10);

        return view('mensagens.removed', compact('mensagensAluno'));
    }

    public function create()
    {
        $nucleos = Nucleo::whereUserAtuacao()->get();

        return view('mensagens.create', compact('nucleos'));
    }

    public function store(StoreMessageRequest $request)
    {
        DB::transaction(static function () use ($request) {
            $mensagem = Mensagens::create($request->all());
            $alunos = collect($request->alunos);
            $nucleos = collect($request->nucleos);

            if (collect($request->alunos)->isNotEmpty()) {
                return MensagensAluno::enviarParaAlunos($alunos, $mensagem);
            }

            return MensagensAluno::enviarParaNucleos($nucleos, $mensagem);
        });

        return redirect()->route('messages.index')->with('success', 'Mensagem enviada com sucesso!');
    }

    public function show(Mensagens $mensagem)
    {
        $mensagem->marcarComoLida();
        return view('mensagens.show', compact('mensagem'));
    }

    public function destroy(Mensagens $mensagem)
    {
        try {
            $mensagem->mensagensAluno->where('aluno_id', Auth::user()->id)->first()->delete();
            return redirect()->route('messages.index')->with('success', 'Mensagem removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('messages.index')->with('error', 'Ocorreu um erro para remover a mensagem!');
        }
    }

}
