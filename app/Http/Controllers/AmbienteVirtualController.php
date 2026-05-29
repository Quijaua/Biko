<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Services\AmbienteVirtualService;
use App\Exports\AulaAssistidosExport;

use Auth;

class AmbienteVirtualController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'professor') {
            $status = \DB::table('professores')->where('id_user', Auth::id())->value('status');

            if (!$status) {
                abort(403, 'Ops! Seu perfil precisa estar ativo para acessar esta página.');
            }
        }

        $area = request('areas_conhecimento');

        return view('ambiente-virtual.index')->with([
            'user' => Auth::user(),
            'aulas' => AmbienteVirtualService::index(),
            'disciplinas' => AmbienteVirtualService::getDisciplinas($area),
        ]);
    }

    public function create()
    {
        abort_unless(
            AmbienteVirtualService::canManageContent(),
            403,
            'Você não possui permissão para gerenciar o Ambiente Virtual.'
        );

        return view('ambiente-virtual.create')->with([
            'user' => Auth::user(),
            'professores' => AmbienteVirtualService::getProfessores(),
            'disciplinas' => AmbienteVirtualService::getAllDisciplinas(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(
            AmbienteVirtualService::canManageContent(),
            403
        );

        AmbienteVirtualService::store($request);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual criada com sucesso!'
        ]);
    }

    public function show($id)
    {
        return view('ambiente-virtual.show')->with([
            'user' => Auth::user(),
            'aula' => AmbienteVirtualService::find($id),
            'is_assistido' => AmbienteVirtualService::isAssistido($id),
        ]);
    }

    public function edit($id)
    {
        abort_unless(
            AmbienteVirtualService::canManageContent(),
            403,
            'Você não possui permissão para gerenciar o Ambiente Virtual.'
        );

        return view('ambiente-virtual.edit')->with([
            'user' => Auth::user(),
            'aula' => AmbienteVirtualService::find($id),
            'professores' => AmbienteVirtualService::getProfessores(),
            'disciplinas' => AmbienteVirtualService::getAllDisciplinas(),
        ]);
    }

    public function update(Request $request, $id)
    {
        abort_unless(
            AmbienteVirtualService::canManageContent(),
            403
        );

        AmbienteVirtualService::update($id);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual atualizada com sucesso!'
        ]);
    }

    public function destroy($id)
    {
        abort_unless(
            AmbienteVirtualService::canManageContent(),
            403,
            'Você não possui permissão para gerenciar o Ambiente Virtual.'
        );

        AmbienteVirtualService::destroy($id);
        return redirect()->route('ambiente-virtual.index')->with([
            'success' => 'Aula virtual excluida com sucesso!'
        ]);
    }

    public function comentar(Request $request, $id)
    {
        return AmbienteVirtualService::comentar($id);
    }

    public function responder(Request $request)
    {
        return AmbienteVirtualService::responder($request);
    }

    public function anotar(Request $request, $id)
    {
        return AmbienteVirtualService::anotar($id);
    }

    public function marcarAssistido(Request $request)
    {
        AmbienteVirtualService::marcarAssistido();
        return redirect()->back()->with([
            'success' => 'Aula marcada como assistida!'
        ]);
    }

    public function desmarcarAssistido(Request $request)
    {
        AmbienteVirtualService::desmarcarAssistido();
        return redirect()->back()->with([
            'success' => 'Aula desmarcada como assistida!'
        ]);
    }

    public function search(Request $request)
    {
        return AmbienteVirtualService::search($request);
    }

    public function exportWatched($id)
    {
        $user = Auth::user();

        if ($user->role === 'aluno') {
            return back()->with('error', 'Ação não permitida.');
        }

        return (new AulaAssistidosExport(intval($id)))->download('aula_' . intval($id) . '_assistidos_' . date('Y-m-d') . '.xlsx');
    }
}
