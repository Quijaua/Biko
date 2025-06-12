<?php

namespace App\Imports;

use App\User;
use App\Professores;
use App\Nucleo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProfessoresImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsErrors, SkipsFailures;

    private $insertedCount = 0;

    public function getInsertedCount(): int
    {
        return $this->insertedCount;
    }

    /**
     * Cada linha será mapeada para este método.
     * A array $row é um array associativo onde as chaves são os headings da planilha (em lower case).
     */
    public function model(array $row)
    {
        // 1. Verificar se já existe um User com este e-mail
        $email = trim($row['email']);
        $cpf   = null;
        $raca = mb_strtolower($row['raca'] ?? '', 'UTF-8');

        $rawNascimento = $row['nascimento'] ?? null;
        if (is_numeric($rawNascimento)) {
            $nascimento = ExcelDate::excelToDateTimeObject($rawNascimento)
                        ->format('Y-m-d');
        } elseif (!empty($rawNascimento) && is_string($rawNascimento)) {
            $nascimento = date('Y-m-d', strtotime($rawNascimento));
        } else {
            $nascimento = null;
        }

        $rawGenero = mb_strtolower(trim($row['genero'] ?? ''), 'UTF-8');
        if (str_contains($rawGenero, 'mulher')) {
            $genero = str_contains($rawGenero, 'trans') 
                ? 'mulher_trans_cis' 
                : 'mulher';
        }
        elseif (str_contains($rawGenero, 'homem')) {
            $genero = str_contains($rawGenero, 'trans') 
                ? 'homem_trans_cis' 
                : 'homem';
        }
        else {
            $genero = null;
        }

        // Se já existe professor (na tabela professores) com esse email ou CPF, ignoramos (retornamos null)
        if (Professores::where('Email', $email)->exists()) {
            return null;
        }

        // 2. Localizar (ou criar) o usuário em `users`
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name'  => $row['nome'],
                'email' => $email,
                'password' => Hash::make('uneafro@2019'), // senha padrão
                'role'  => 'professor',
                'email_verified_at' => now(),
            ]);
        }

        // 3. Verificar núcleo: se não encontrar pelo nome, usar id = 1
        $nucleoName = trim($row['nucleo']);
        $nucleo     = Nucleo::where('NomeNucleo', $nucleoName)->first(); 
        // Obs.: ajuste o campo “NomeNucleo” para o nome exato no seu model Nucleo
        if (!$nucleo) {
            $nucleoId = 1;
        } else {
            $nucleoId = $nucleo->id;
        }

        $this->insertedCount++;

        // 4. Criar o registro em `professores`
        return new Professores([
            'id_user'      => $user->id,
            'Status'       => 0,
            'NomeProfessor'=> $row['nome'],
            'Nascimento'   => $nascimento,
            'NomeSocial'   => null,
            'id_nucleo'    => $nucleoId,
            'Foto'         => null,
            'CPF'          => $cpf,
            'RG'           => $row['rg'] ?? null,
            'Raca'         => $raca ?? null,
            'Genero'       => $genero ?? null,
            'concordaSexoDesignado' => null,
            'EstadoCivil'   => null,
            'Disciplinas'   => $row['disciplina'] ?? null,
            'OutrosNucleos' => null,
            'Escolaridade'  => null,
            'FormacaoSuperior' => null,
            'AnoInicioUneafro' => null,
            'aulasForaUneafro' => null,
            'GastoTransporte'   => null,
            'TempoChegada'      => null,
            'Endereco'          => null,
            'Numero'            => null,
            'Bairro'            => null,
            'CEP'               => null,
            'Cidade'            => $row['cidade'] ?? null,
            'Estado'            => $row['estado'] ?? null,
            'Complemento'       => null,
            'FoneComercial'     => null,
            'FoneResidencial'   => null,
            'FoneCelular'       => $row['telefone'] ?? null,
            'Email'             => $email,
            'Empresa'           => null,
            'RamoAtuacao'       => null,
            'RamoAtuacaoOutros' => null,
            'CEPEmpresa'        => null,
            'EnderecoEmpresa'   => null,
            'NumeroEmpresa'     => null,
            'ComplementoEmpresa' => null,
            'BairroEmpresa'      => null,
            'CidadeEmpresa'      => null,
            'EstadoEmpresa'      => null,
            'ProjetosRealizados' => null,
            'ProjetosNome'       => null,
            'ProjetosFuncao'     => null,
            'ComoSoube'          => null,
            'ComoSoubeOutros'    => null,
            'MotivoPrincipal'    => null,
            'EnsinoSuperior'     => null,
            'InstituicaoSuperior'=> null,
            'CursoSuperior1'     => null,
            'AnoCursoSuperior1'  => null,
            'CursoSuperior2'     => null,
            'AnoCursoSuperior2'  => null,
            'Especializacao'     => null,
            'InstEspecializacao' => null,
            'CursoEspecializacao'=> null,
            'AnoCursoEspecializacao' => null,
            'Mestrado'           => null,
            'InstMestrado'       => null,
            'CursoMestrado'      => null,
            'AnoCursoMestrado'   => null,
            'FormacaoAcademicaRecente' => null,
            'terra_indigenas_id' => null,
            'povo_indigenas_id'   => null,
            'pessoa_com_deficiencia' => null,
        ]);
    }

    /**
     * Validações básicas de cada coluna. Se alguma falhar, o pacote irá pular essa linha e registrar a falha.
     */
    public function rules(): array
    {
        return [
            'nome'           => 'required|string|min:3|max:100',
            'email'          => ['required','email','max:255', Rule::unique('professores', 'Email')],
            'nucleo'         => 'required|string|min:1', 
            // demais campos opcionais não precisam de regra
        ];
    }

    /**
     * Se quiser customizar mensagens de erro, pode usar este método (opcional).
     */
    public function customValidationMessages()
    {
        return [
            'nome.required'           => 'O campo “Nome” é obrigatório.',
            'email.required'          => 'O campo “email” é obrigatório.',
            'email.email'             => 'O campo “email” deve ser um e-mail válido.',
            // ...
        ];
    }
}