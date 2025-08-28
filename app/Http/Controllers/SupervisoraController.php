<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AtendimentoPsicologico;
use Carbon\Carbon;

class SupervisoraController extends Controller
{
    public function index(Request $request)
    {
        $ano = $request->get('ano');
        $mes = $request->get('mes');

        // Base query
        $query = AtendimentoPsicologico::with(['criador', 'estudante'])
            ->orderByRaw('COALESCE(data_atendimento, created_at) ASC');

        // Aplica os filtros somente se tiverem sido enviados
        if ($ano) {
            $query->whereRaw('YEAR(COALESCE(data_atendimento, created_at)) = ?', [$ano]);
        }

        if ($mes) {
            $query->whereRaw('MONTH(COALESCE(data_atendimento, created_at)) = ?', [$mes]);
        }

        $atendimentos = $query->get()->groupBy('created_by');

        return view('painel-supervisora.index', compact('atendimentos', 'ano', 'mes'));
    }
}