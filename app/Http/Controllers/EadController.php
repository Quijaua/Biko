<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\ead;
use App\Aluno;

class EadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $eads = ead::paginate(10);

        return view('ead.index')->with([
            'user' => $user,
            'eads' => $eads
        ]);
    }

    public function create()
    {
        return view('ead.create');
    }

    public function store(Request $request)
    {
        $ead = ead::create($request->except('_token'));
        return redirect()->route('ead.index')->with(['success' => 'Evento criado com sucesso!']);
    }

    public function edit($id)
    {
        $ead = ead::find($id);
        return view('ead.edit')->with(['ead' => $ead]);
    }

    public function update(Request $request, $id)
    {
        $ead = ead::find($id);
        $ead->update($request->except('_token'));
        return redirect()->route('ead.index')->with(['success' => 'Evento editado com sucesso!']);
    }

    public function destroy($id)
    {
        $ead = ead::find($id);
        $ead->delete();
        return redirect()->route('ead.index')->with(['success' => 'Evento excluido com sucesso!']);
    }

    public function register()
    {
        if (!Auth::check()) {
            return view('auth.otp-login')->with([
                'info' => 'Por favor, informe seu e-mail para login.',
                'redirect' => 'aula-programa-esperanca-garcia'
            ]);
        }

        $user = Auth::user();
        $evento = ead::where('data', '=', Carbon::now()->format('Y-m-d'))->first();

        return view('ead.register')->with([
            'user' => $user,
            'evento' => $evento
        ]);
    }

    public function registerStore(Request $request)
    {
        DB::table('eads_participantes')->insert([
            'ead_id' => $request->ead_id,
            'user_id' => $request->user_id,
            'questao_1' => $request->questao_1,
            'questao_2' => $request->questao_2,
            'questao_3' => $request->questao_3,
            'questao_4' => $request->questao_4,
        ]);

        return redirect()->route('ead.register')->with(['success' => 'Presença registrada com sucesso!']);
    }

    public function participantes($id)
    {
        $eads = ead::find($id);
        $participantes = $eads->inscritos()->paginate(10);
        // dd($participantes);
        return view('ead.participantes')->with([
            'eads' => $eads,
            'participantes' => $participantes
        ]);
    }
}
