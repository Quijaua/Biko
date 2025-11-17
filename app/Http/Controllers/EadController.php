<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function details($id)
    {
        $ead = ead::find($id);
        return view('ead.details')->with(['ead' => $ead]);
    }

    public function store(Request $request)
    {
        $ead = ead::create($request->except(['_token', 'material_apoio']));

        // Verifica se existe upload de arquivos e salva
        // if ($request->hasFile('material_apoio')) {
        if ($request->material_apoio) {
            // $file = $request->file('material_apoio');
            // $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            // $file->move(public_path('eads' . '/' . $ead->id . '/'), $fileName);
            // $ead->material_apoio = $fileName;
            // $ead->save();
            $tmpFile = Storage::disk('public')->get('eads/tmp/' . $request->material_apoio);
            $file = Storage::disk('public')->get('eads/tmp/' . $request->material_apoio);
            Storage::move('eads/tmp/' . $request->material_apoio, 'eads/' . $ead->id . '/' . $request->material_apoio);
            $ead->material_apoio = $request->material_apoio;
            $ead->save();
        }

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
        // Verifica se existe upload de arquivos e salva
        if ($request->material_apoio) {
            // Verifica se existe material de apoio e deleta
            if ($ead->material_apoio) {
                unlink(public_path('eads' . '/' . $ead->id . '/' . $ead->material_apoio));
            }
            $tmpFile = Storage::disk('public')->get('eads/tmp/' . $request->material_apoio);
            $file = Storage::disk('public')->get('eads/tmp/' . $request->material_apoio);
            Storage::move('eads/tmp/' . $request->material_apoio, 'eads/' . $ead->id . '/' . $request->material_apoio);
            $ead->material_apoio = $request->material_apoio;
            $ead->save();
            Storage::disk('public')->delete('eads/tmp/' . $request->material_apoio);
        }

        $ead->update($request->except([ '_token', 'material_apoio' ]));

        return redirect()->route('ead.index')->with(['success' => 'Evento editado com sucesso!']);
    }

    public function destroy($id)
    {
        $ead = ead::find($id);
        $ead->delete();
        return redirect()->route('ead.index')->with(['success' => 'Evento excluido com sucesso!']);
    }

    public function remove_material(Request $request)
    {
        $ead = ead::find($request->ead_id);
        $file = $ead->material_apoio;
        Storage::disk('public')->delete('eads/' . $ead->id . '/' . $file);
        $ead->material_apoio = null;
        $ead->save();
        return response()->json(['success' => 'Material de apoio removido com sucesso!']);
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
        return view('ead.participantes')->with([
            'eads' => $eads,
            'participantes' => $participantes
        ]);
    }

    public function participacao()
    {
        $eads = Ead::query()
            ->select('semestre', DB::raw('MIN(tipo) as tipo'), DB::raw('MIN(id) as id'))
            ->groupBy(['semestre'])
            ->get();

        $counters_tipo = [];
        $counters_participantes = [];
        $nucleo_ambiente_virtual = config('global.nucleo_ambiente_virtual');

        foreach ($eads as $ead) {
            if (!isset($counters_tipo[$ead->tipo])) {
                $counters_tipo[$ead->tipo] = 0;
            }
            $counters_tipo[$ead->tipo]++;

            // Filtra somente os alunos inscritos no núcleo virtual especificado
            $ead->inscritos = $ead->inscritos->filter(function ($inscrito) use ($nucleo_ambiente_virtual) {
                return $inscrito->aluno->id_nucleo == $nucleo_ambiente_virtual;
            });

            foreach ($ead->inscritos as $inscrito) {
                if (!isset($counters_participantes[$inscrito->id])) {
                    $counters_participantes[$inscrito->id] = [
                        'participation' => []
                    ];
                }
                if (!isset($counters_participantes[$inscrito->id]['participation'][$ead->tipo])) {
                    $counters_participantes[$inscrito->id]['participation'][$ead->tipo] = 0;
                }
                $counters_participantes[$inscrito->id]['participation'][$ead->tipo]++;
            }
        }

        return view('ead.participacao')->with([
            'counters_tipo' => $counters_tipo,
            'counters_participantes' => $counters_participantes,
            'eads' => $eads
        ]);
    }

    public function upload(Request $request)
    {
        $tmpFile = $request->file('material_apoio');
        $path = Storage::disk('public')->path('eads/tmp');
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $tmpFile->getClientOriginalName());
        $tmpFile->move($path, $fileName);
        return $fileName;
    }
}
