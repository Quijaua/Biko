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
            ->orderBy('data_atendimento', 'asc');

        // Aplica os filtros somente se tiverem sido enviados
        if ($ano) {
            $query->whereYear('data_atendimento', $ano);
        }

        if ($mes) {
            $query->whereMonth('data_atendimento', $mes);
        }

        $atendimentos = $query->get()->groupBy('created_by');

        return view('painel-supervisora.index', compact('atendimentos', 'ano', 'mes'));
    }
}