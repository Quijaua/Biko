<?php

namespace App\Imports;

use App\Aluno;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlunosImport implements ToModel, WithHeadingRow
{

  public function __construct(public $id)
  {
  }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Aluno([
            'Status' =>  $row['status'],
            'NomeAluno' =>  $row['seu_nome'],
            'Email' =>  $row['seu_email'],
            'CEP' =>  $row['cep'],
            'Endereco' =>  $row['rua'],
            'Numero' =>  $row['numero'],
            'Bairro' =>  $row['bairro'],
            'Cidade' =>  $row['cidade'],
            'Estado' =>  $row['estado'],
            'FoneCelular' =>  $row['celular'],
            'Nascimento' => $row['data_de_nascimento'],
            'Escolaridade' =>  $row['escolaridade'],
            'Raca' =>  $row['raca'],
            'Genero' =>  $row['genero'],
            'TemFilhos' =>  $row['filhos'],
            // 'id_nucleo' => $this->id
        ]);
    }
}
