<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias_alunos = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'alunos.NomeAluno as aluno', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('alunos', 'audits.auditable_id', '=', 'alunos.id')
            ->where('auditable_type', 'App\Aluno')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        $auditorias_professores = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'professores.NomeProfessor as professor', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('professores', 'audits.auditable_id', '=', 'professores.id')
            ->where('auditable_type', 'App\Professores')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        $auditorias_coordenadores = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'coordenadores.NomeCoordenador as coordenador', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('coordenadores', 'audits.auditable_id', '=', 'coordenadores.id')
            ->where('auditable_type', 'App\Professores')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        $auditorias_nucleos = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'nucleos.NomeNucleo as nucleo', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('nucleos', 'audits.auditable_id', '=', 'nucleos.id')
            ->where('auditable_type', 'App\Nucleo')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        $auditorias_materiais = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'materials.name as material', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('materials', 'audits.auditable_id', '=', 'materials.id')
            ->where('auditable_type', 'App\Material')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        $auditorias_ambientes = DB::table('audits')
            ->select('audits.created_at', 'users.name as usuario', 'audits.url', 'ambiente_virtuals.titulo as ambiente', 'audits.event', 'audits.old_values', 'audits.new_values')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->join('ambiente_virtuals', 'audits.auditable_id', '=', 'ambiente_virtuals.id')
            ->where('auditable_type', 'App\AmbienteVirtual')
            ->whereNotNull('audits.user_type')
            ->whereNotNull('audits.user_id')
            ->get();

        return view('auditoria.index')->with([
            'alunos' => $auditorias_alunos,
            'professores' => $auditorias_professores,
            'coordenadores' => $auditorias_coordenadores,
            'nucleos' => $auditorias_nucleos,
            'materiais' => $auditorias_materiais,
            'ambientes' => $auditorias_ambientes,
        ]);
    }
}
