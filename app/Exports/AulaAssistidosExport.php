<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

class AulaAssistidosExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $aulaId;

    public function __construct(int $aulaId)
    {
        $this->aulaId = $aulaId;
    }

    public function headings(): array
    {
        return [
            'ID Visualização',
            'ID Aluno',
            'Nome do Aluno',
            'E-mail',
            'Data da Visualização',
        ];
    }

    public function collection(): Collection
    {
        return DB::table('alunos_ambiente_virtuals_watched')
            ->join('alunos', 'alunos.id', '=', 'alunos_ambiente_virtuals_watched.aluno_id')
            ->where('alunos_ambiente_virtuals_watched.ambiente_virtual_id', $this->aulaId)
            ->whereNull('alunos_ambiente_virtuals_watched.deleted_at')
            ->select(
                'alunos_ambiente_virtuals_watched.id as watch_id',
                'alunos.id as aluno_id',
                'alunos.NomeAluno',
                'alunos.Email',
                'alunos_ambiente_virtuals_watched.created_at as watched_at'
            )
            ->orderBy('alunos_ambiente_virtuals_watched.created_at', 'asc')
            ->get();
    }
}
