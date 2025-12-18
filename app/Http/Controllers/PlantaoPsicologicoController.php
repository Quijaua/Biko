<?php

namespace App\Http\Controllers;

use App\User;
use App\Psicologos;
use App\PlantaoPsicologico;
use App\AtendimentoPsicologico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use DB;

class PlantaoPsicologicoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.otp-login')->with('info', 'Por favor, informe seu e-mail para login.');
        }

        $user = Auth::user();

        if ($user->role === 'psicologo') {
            $plantoes = PlantaoPsicologico::whereNull('estudante_id')
                ->where('psicologo_id', $user->id)
                ->whereRaw("STR_TO_DATE(CONCAT(data, ' ', horario), '%Y-%m-%d %H:%i') >= ?", [now()])
                ->orderBy('data')
                ->orderBy('horario')
                ->paginate(25);

            return view('plantao-psicologico.psicologo', compact('plantoes'));
        } else {
            $psicologos = Psicologos::get();
            $plantoes = PlantaoPsicologico::whereNull('estudante_id')
                ->whereRaw("STR_TO_DATE(CONCAT(data, ' ', horario), '%Y-%m-%d %H:%i') >= ?", [now()])
                ->orderBy('data')
                ->orderBy('horario')
                ->get();

            $psicologos_com_horarios_disponiveis = $psicologos->filter(function ($psicologo) use ($plantoes) {
                return $plantoes->contains('psicologo_id', $psicologo->user_id);
            })->values();

            return view('plantao-psicologico.index', [
                'psicologos' => $psicologos_com_horarios_disponiveis,
                'plantoes' => $plantoes,
            ]);
        }
    }

    public function show()
    {
        return view('plantao-psicologico.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'psicologo') {
            abort(403, 'Acesso não autorizado.');
        }

        $request->validate([
            'data' => [
                'required',
                'date_format:Y-m-d',
            ],
            'horario' => [
                'required',
                'date_format:H:i',
                Rule::unique('plantao_psicologicos')
                    ->where(function ($query) use ($request) {
                        return $query->where('data', $request->data)
                                    ->where('psicologo_id', auth()->id());
                    }),
            ],
        ]);

        // Combinar data + hora e validar se é futuro
        $dataHora = \Carbon\Carbon::createFromFormat('Y-m-d H:i', "{$request->data} {$request->horario}");

        if ($dataHora->isPast()) {
            return back()->withErrors(['horario' => 'A data e hora devem estar no futuro.'])->withInput();
        }

        PlantaoPsicologico::create([
            'psicologo_id' => auth()->id(),
            'data' => $request->data,
            'horario' => $request->horario
        ]);

        return redirect()->route('plantao-psicologico.index')->with('success', 'Plantão de atendimento criado com sucesso!');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $dados = PlantaoPsicologico::find($id);

        return view('plantao-psicologico.edit')->with([
          'dados' => $dados
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'psicologo' && $user->role !== 'psicologa_supervisora') {
            abort(403, 'Acesso não autorizado.');
        }

        $plantao = PlantaoPsicologico::findOrFail($id);

        $request->validate([
            'data' => [
                'required',
                'date_format:Y-m-d',
            ],
            'horario' => [
                'required',
                'date_format:H:i',
                Rule::unique('plantao_psicologicos')
                    ->where(function ($query) use ($request) {
                        return $query->where('data', $request->data)
                                    ->where('psicologo_id', auth()->id());
                    })
                    ->ignore($id),
            ],
        ]);

        $dataHora = \Carbon\Carbon::createFromFormat('Y-m-d H:i', "{$request->data} {$request->horario}");

        if ($dataHora->isPast()) {
            return back()->withErrors(['horario' => 'A data e hora devem estar no futuro.'])->withInput();
        }

        $plantao->update([
            'data' => $request->data,
            'horario' => $request->horario,
        ]);

        return redirect()->route('plantao-psicologico.index')->with('success', 'Plantão de atendimento atualizado com sucesso!');
    }

    public function datasDisponiveis($id)
    {
        $datas = PlantaoPsicologico::where('psicologo_id', $id)
            ->where('data', '>=', now()->toDateString())
            ->whereNull('estudante_id')
            ->groupBy('data')
            ->orderBy('data')
            ->pluck('data')
            ->map(function ($data) {
                return \Carbon\Carbon::parse($data)->format('Y-m-d');
            });

        return response()->json($datas);
    }

    public function horariosDisponiveis(Request $request, $id)
    {
        $data = $request->input('date');

        if (!$data) {
            return response()->json(['error' => 'Data não informada'], 400);
        }

        $horarios = PlantaoPsicologico::where('psicologo_id', $id)
            ->where('data', $data)
            ->whereNull('estudante_id') // Apenas horários não agendados
            ->orderBy('horario')
            ->pluck('horario')
            ->map(function ($horario) {
                return \Carbon\Carbon::parse($horario)->format('H:i');
            });

        return response()->json($horarios);
    }

    public function agendar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'psicologo_id' => 'required|exists:users,id',
            'data' => 'required|date',
            'horario' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos para agendamento.',
                'errors' => $validator->errors()
            ], 422);
        }

        $psicologo = User::findOrFail($request->psicologo_id);
        $estudante = auth()->user();
        $aluno = \App\Aluno::where('id_user', $estudante->id)->firstOrFail();

        $plantao = PlantaoPsicologico::where('psicologo_id', $psicologo->id)
            ->where('data', $request->data)
            ->where('horario', $request->horario)
            ->whereNull('estudante_id')
            ->first();

        if (!$plantao) {
            return response()->json([
                'success' => false,
                'message' => 'Horário já reservado.'
            ]);
        }

        // Marcar horário como reservado
        $plantao->estudante_id = $aluno->id;
        $plantao->save();

        // Criar o atendimento com dados padrão (você pode customizar depois)
        $atendimento = AtendimentoPsicologico::create([
            // 'psicologo_id' => $psicologo->id,
            'estudante_id' => $aluno->id,
            'data_atendimento' => Carbon::parse($request->data . ' ' . $request->horario),
            'demanda_objetivos' => 'Agendamento automático via sistema.',
            'registro_atendimento' => 'Agendamento realizado.',
            'tipo_encaminhamento' => 'Atendimento finalizado',
            'descricao_encaminhamento' => null,
            'created_by' => $psicologo->id, // ou Auth::id(), dependendo da lógica
        ]);

        // Criar log
        \App\LogAtendimentoPsicologico::create([
            'atendimento_psicologico_id' => $atendimento->id,
            'user_id' => Auth::id(),
            'acao' => 'criou',
            'detalhes' => 'Atendimento psicológico criado automaticamente via agendamento.',
        ]);

        // Gerar iCal
        $icalContent = $this->gerarICal($psicologo, $estudante, $request->data, $request->horario);
        $filename = 'agendamento-' . Str::uuid() . '.ics';
        Storage::disk('local')->put($filename, $icalContent);
        $icsPath = storage_path("app/{$filename}");

        $dataHoraFormatada = Carbon::parse("{$request->data} {$request->horario}")->format('d/m/Y H:i');

        // Enviar e-mail para o psicólogo
        Mail::send('emails.agendamentoPsicologo', [
            'estudante' => $estudante,
            'psicologo' => $psicologo,
            'dataHora' => $dataHoraFormatada
        ], function ($mail) use ($psicologo, $icsPath) {
            $mail->to($psicologo->email)
                ->subject('Novo Atendimento Agendado')
                ->attach($icsPath);
        });

        // Enviar e-mail para o estudante
        Mail::send('emails.agendamentoEstudante', [
            'estudante' => $estudante,
            'psicologo' => $psicologo,
            'dataHora' => $dataHoraFormatada
        ], function ($mail) use ($estudante, $icsPath) {
            $mail->to($estudante->email)
                ->subject('Confirmação de Agendamento Psicológico');
                // ->attach($icsPath);
        });

        session()->flash('success', 'Atendimento agendado com sucesso.');
        return response()->json([
            'success' => true,
            'message' => 'Atendimento agendado com sucesso.'
        ]);
    }

    private function gerarICal($psicologo, $estudante, $data, $hora)
    {
        $start = Carbon::parse("{$data} {$hora}");
        $end = $start->copy()->addHour();

        $ical = "BEGIN:VCALENDAR\r\n";
        $ical .= "VERSION:2.0\r\n";
        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "UID:" . uniqid() . "\r\n";
        $ical .= "SUMMARY:Atendimento Psicológico com {$psicologo->name}\r\n";
        $ical .= "DESCRIPTION:Atendimento psicológico agendado.\r\n";
        $ical .= "DTSTART:" . $start->format('Ymd\THis') . "\r\n";
        $ical .= "DTEND:" . $end->format('Ymd\THis') . "\r\n";
        $ical .= "ORGANIZER;CN={$psicologo->name}:MAILTO:{$psicologo->email}\r\n";
        $ical .= "ATTENDEE;CN={$estudante->name};RSVP=TRUE:MAILTO:{$estudante->email}\r\n";
        $ical .= "LOCATION:Online ou Local Definido\r\n";
        $ical .= "END:VEVENT\r\n";
        $ical .= "END:VCALENDAR\r\n";

        return $ical;
    }
}
