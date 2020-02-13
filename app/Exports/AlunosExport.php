<?php

namespace App\Exports;

use App\Aluno;
use App\Nucleo;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

//class AlunosExport implements FromCollection
class AlunosExport implements FromQuery, WithHeadings
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
          'Nome',
          'Status (1-ativo)',
          'Lista de Espera',
          'Núcleo',
          'CPF',
          'RG',
          'Raça',
          'Gênero',
          'Estado Civil',
          'Nascimento',
          'CEP',
          'Endereço',
          'Número',
          'Bairro',
          'Cidade',
          'Estado',
          'Complemento',
          'Fone Comercial',
          'Fone Residencial',
          'Fone Celular',
          'Empresa',
          'CEP Empresa',
          'Endereco Empresa',
          'Número Empresa',
          'Bairro Empresa',
          'Cidade Empresa',
          'Estado Empresa',
          'Complemento Empresa',
          'Cargo',
          'Horário Entrada',
          'Horário Saida',
          'Nome Mãe',
          'Nome Pai',
          'CEP Família',
          'Endereco Família',
          'Numero Família',
          'Complemento Família',
          'Bairro Família',
          'Cidade Família',
          'Estado Família',
          'Telefone Família',
          'Aux. Governo',
          'Ens. Fundamental',
          'Porcentagem Bolsa',
          'Ens. Médio',
          'Porcentagem Bolsa Ens. Médio',
          'Vestibular',
          'Opção Vestibular 1',
          'Opção Vestibular 2',
          'Vestibular Outra Cidade',
          'Como Soube',
          'Aux. Tipo',
          'Faculdade Tipo',
          'Nome Faculdade',
          'Curso Faculdade',
          'Ano Faculdade',
          'Como Soube (Outros)',
          'Email'
      ];
  }

  public function query()
  {
    if($this->nucleo === 0){
      return Aluno::query()->select([
        'NomeAluno',
        'Status',
        'ListaEspera',
        'NomeNucleo',
        'CPF',
        'RG',
        'Raca',
        'Genero',
        'EstadoCivil',
        'Nascimento',
        'CEP',
        'Endereco',
        'Numero',
        'Bairro',
        'Cidade',
        'Estado',
        'Complemento',
        'FoneComercial',
        'FoneResidencial',
        'FoneCelular',
        'Empresa',
        'CEPEmpresa',
        'EnderecoEmpresa',
        'NumeroEmpresa',
        'BairroEmpresa',
        'CidadeEmpresa',
        'EstadoEmpresa',
        'ComplementoEmpresa',
        'Cargo',
        'HorarioFrom',
        'HorarioTo',
        'NomeMae',
        'NomePai',
        'CEPFamilia',
        'EnderecoFamilia',
        'NumeroFamilia',
        'ComplementoFamilia',
        'BairroFamilia',
        'CidadeFamilia',
        'EstadoFamilia',
        'TelefoneFamilia',
        'AuxGoverno',
        'EnsFundamental',
        'PorcentagemBolsa',
        'EnsMedio',
        'PorcentagemBolsaMedio',
        'Vestibular',
        'OpcoesVestibular1',
        'OpcoesVestibular2',
        'VestibularOutraCidade',
        'ComoSoube',
        'AuxTipo',
        'FaculdadeTipo',
        'NomeFaculdade',
        'CursoFaculdade',
        'AnoFaculdade',
        'ComoSoubeOutros',
        'Email'
      ]);
    };

    return Aluno::query()->where('id_nucleo', $this->nucleo)->select([
      'NomeAluno',
      'Status',
      'NomeNucleo',
      'CPF',
      'RG',
      'Raca',
      'Genero',
      'EstadoCivil',
      'Nascimento',
      'CEP',
      'Endereco',
      'Numero',
      'Bairro',
      'Cidade',
      'Estado',
      'Complemento',
      'FoneComercial',
      'FoneResidencial',
      'FoneCelular',
      'Empresa',
      'CEPEmpresa',
      'EnderecoEmpresa',
      'NumeroEmpresa',
      'BairroEmpresa',
      'CidadeEmpresa',
      'EstadoEmpresa',
      'ComplementoEmpresa',
      'Cargo',
      'HorarioFrom',
      'HorarioTo',
      'NomeMae',
      'NomePai',
      'CEPFamilia',
      'EnderecoFamilia',
      'NumeroFamilia',
      'ComplementoFamilia',
      'BairroFamilia',
      'CidadeFamilia',
      'EstadoFamilia',
      'TelefoneFamilia',
      'AuxGoverno',
      'EnsFundamental',
      'PorcentagemBolsa',
      'EnsMedio',
      'PorcentagemBolsaMedio',
      'Vestibular',
      'OpcoesVestibular1',
      'OpcoesVestibular2',
      'VestibularOutraCidade',
      'ComoSoube',
      'AuxTipo',
      'FaculdadeTipo',
      'NomeFaculdade',
      'CursoFaculdade',
      'AnoFaculdade',
      'ComoSoubeOutros',
      'Email'
    ]);
  }
}
