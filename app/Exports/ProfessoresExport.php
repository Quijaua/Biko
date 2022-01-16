<?php

namespace App\Exports;

use App\Professores;
use App\Nucleo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ProfessoresExport implements FromQuery, WithHeadings
{
  use Exportable;
  /**
  * @return \Illuminate\Support\Collection
  */
  public function __construct(int $nucleo)
  {
      $this->nucleo = $nucleo;
  }

  public function headings(): array
  {
      return [
        /*'id_user',*/
        'Status',
        'Nome',
        'Nome Social',
        /*'id_nucleo',*/
        /*'Foto',*/
        'CPF',
        'RG',
        'Raça',
        'Gênero',
        'Concorda Sexo Designado',
        'Estado Civil',
        'Nascimento',
        'Disciplinas',
        'Outros Núcleos',
        'Escolaridade',
        'Formação Superior',
        'Ano Início Uneafro',
        'Aulas Fora Uneafro',
        'Dias Horários',
        'Gasto Transporte',
        'Tempo Chegada',
        'Endereço',
        'Numero',
        'Bairro',
        'CEP',
        'Cidade',
        'Estado',
        'Complemento',
        'Fone Comercial',
        'Fone Residencial',
        'Fone Celular',
        'Email',
        'Ramo Atuação',
        'Ramo Atuação Outros',
        'Empresa',
        'Endereco Empresa',
        'Número Empresa',
        'Complemento Empresa',
        'Bairro Empresa',
        'Cidade Empresa',
        'Estado Empresa',
        'CEP Empresa',
        'Projetos Realizados',
        'Projetos Nome',
        'Projetos Função',
        'Como Soube',
        'Como Soube Outros',
        'Motivo Principal',
        'Ensino Superior',
        'Instituição Superior',
        'Curso Superior 1',
        'Ano Curso Superior 1',
        'Curso Superior 2',
        'Ano Curso Superior 2',
        'Especialização',
        'Inst. Especialização',
        'Curso Especialização',
        'Ano Curso Especialização',
        'Mestrado',
        'Inst. Mestrado',
        'Curso Mestrado',
        'Ano Curso Mestrado',
        'Formação Academica Recente',
        'Cadastrado em',
        'Atualizado em'
      ];
  }

  public function query()
  {
    if($this->nucleo === 0){
      return Professores::query()->select([
        /*'id_user',*/
        'Status',
        'NomeProfessor',
        'NomeSocial',
        /*'id_nucleo',*/
        /*'Foto',*/
        'CPF',
        'RG',
        'Raca',
        'Genero',
        'concordaSexoDesignado',
        'EstadoCivil',
        'Nascimento',
        'Disciplinas',
        'OutrosNucleos',
        'Escolaridade',
        'FormacaoSuperior',
        'AnoInicioUneafro',
        'aulasForaUneafro',
        'DiasHorarios',
        'GastoTransporte',
        'TempoChegada',
        'Endereco',
        'Numero',
        'Bairro',
        'CEP',
        'Cidade',
        'Estado',
        'Complemento',
        'FoneComercial',
        'FoneResidencial',
        'FoneCelular',
        'Email',
        'RamoAtuacao',
        'RamoAtuacaoOutros',
        'Empresa',
        'EnderecoEmpresa',
        'NumeroEmpresa',
        'ComplementoEmpresa',
        'BairroEmpresa',
        'CidadeEmpresa',
        'EstadoEmpresa',
        'CEPEmpresa',
        'ProjetosRealizados',
        'ProjetosNome',
        'ProjetosFuncao',
        'ComoSoube',
        'ComoSoubeOutros',
        'MotivoPrincipal',
        'EnsinoSuperior',
        'InstituicaoSuperior',
        'CursoSuperior1',
        'AnoCursoSuperior1',
        'CursoSuperior2',
        'AnoCursoSuperior2',
        'Especializacao',
        'InstEspecializacao',
        'CursoEspecializacao',
        'AnoCursoEspecializacao',
        'Mestrado',
        'InstMestrado',
        'CursoMestrado',
        'AnoCursoMestrado',
        'FormacaoAcademicaRecente',
        'created_at',
        'updated_at'
      ]);
    };

    return Professores::query()->where('id_nucleo', $this->nucleo)->select([
      /*'id_user',*/
      'Status',
      'NomeProfessor',
      'NomeSocial',
      /*'id_nucleo',*/
      /*'Foto',*/
      'CPF',
      'RG',
      'Raca',
      'Genero',
      'concordaSexoDesignado',
      'EstadoCivil',
      'Nascimento',
      'Disciplinas',
      'OutrosNucleos',
      'Escolaridade',
      'FormacaoSuperior',
      'AnoInicioUneafro',
      'aulasForaUneafro',
      'DiasHorarios',
      'GastoTransporte',
      'TempoChegada',
      'Endereco',
      'Numero',
      'Bairro',
      'CEP',
      'Cidade',
      'Estado',
      'Complemento',
      'FoneComercial',
      'FoneResidencial',
      'FoneCelular',
      'Email',
      'RamoAtuacao',
      'RamoAtuacaoOutros',
      'Empresa',
      'EnderecoEmpresa',
      'NumeroEmpresa',
      'ComplementoEmpresa',
      'BairroEmpresa',
      'CidadeEmpresa',
      'EstadoEmpresa',
      'CEPEmpresa',
      'ProjetosRealizados',
      'ProjetosNome',
      'ProjetosFuncao',
      'ComoSoube',
      'ComoSoubeOutros',
      'MotivoPrincipal',
      'EnsinoSuperior',
      'InstituicaoSuperior',
      'CursoSuperior1',
      'AnoCursoSuperior1',
      'CursoSuperior2',
      'AnoCursoSuperior2',
      'Especializacao',
      'InstEspecializacao',
      'CursoEspecializacao',
      'AnoCursoEspecializacao',
      'Mestrado',
      'InstMestrado',
      'CursoMestrado',
      'AnoCursoMestrado',
      'FormacaoAcademicaRecente',
      'created_at',
      'updated_at'
    ]);
  }
}
