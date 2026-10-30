<?php

namespace App\Exports;

use App\Coordenadores;
use App\Nucleo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class CoordenadoresExport implements FromQuery, WithHeadings
{
  use Exportable;
  /**
  * @return \Illuminate\Support\Collection
  */
  /** @var int[] Núcleos a exportar; vazio = todos */
  private array $nucleos;

  /**
   * @param int|int[]|null $nucleo id do núcleo, lista de ids ou 0/null para todos
   */
  public function __construct(int|array|null $nucleo = 0)
  {
      $this->nucleos = array_values(array_filter(array_map('intval', (array) $nucleo)));
  }

  public function headings(): array
  {
      return [
        /*'id_user',*/
        'Status',
        'Nome',
        'Nome Social',
        /*'id_nucleo',*/
        'Função',
        'Ano Ingresso',
        /*'Foto',*/
        'CPF',
        'RG',
        'Raça',
        'Gênero',
        'Concorda Sexo Designado',
        'Estado Civil',
        'Nascimento',
        'Escolaridade',
        'Formação Superior',
        'Ano Início Uneafro',
        'Aulas Fora Uneafro',
        'Endereço',
        'Número',
        'Bairro',
        'CEP',
        'Cidade',
        'Estado',
        'Complemento',
        'Fone Comercial',
        'Fone Residencial',
        'Fone Celular',
        'Email',
        'Empresa',
        'Ramo Atuação',
        'Ramo Atuação Outros',
        'Endereco Empresa',
        'Número Empresa',
        'Complemento Empresa',
        'Bairro Empresa',
        'Cidade Empresa',
        'Estado Empresa',
        'CEP Empresa',
        'Cargo',
        'Horário De',
        'Horário Até',
        'Projetos Realizados',
        'Projetos Nome',
        'Projetos Função',
        'Como Soube',
        'Como Soube Outros',
        'Motivo Principal',
        'Representante CGU',
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
        'Formação Acadêmica Recente',
        'Cadastrado em',
        'Atualizado em'
      ];
  }

  public function query()
  {
    $query = Coordenadores::query();

    if (! empty($this->nucleos)) {
      $query->whereHas('nucleos', fn ($q) => $q->whereIn('nucleos.id', $this->nucleos));
    }

    return $query->select([
        /*'id_user',*/
        'Status',
        'NomeCoordenador',
        'NomeSocial',
        /*'id_nucleo',*/
        'FuncaoCoordenador',
        'AnoIngresso',
        /*'Foto',*/
        'CPF',
        'RG',
        'Raca',
        'Genero',
        'concordaSexoDesignado',
        'EstadoCivil',
        'Nascimento',
        'Escolaridade',
        'FormacaoSuperior',
        'AnoInicioUneafro',
        'aulasForaUneafro',
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
        'Empresa',
        'RamoAtuacao',
        'RamoAtuacaoOutros',
        'EnderecoEmpresa',
        'NumeroEmpresa',
        'ComplementoEmpresa',
        'BairroEmpresa',
        'CidadeEmpresa',
        'EstadoEmpresa',
        'CEPEmpresa',
        'Cargo',
        'HorarioFrom',
        'HorarioTo',
        'ProjetosRealizados',
        'ProjetosNome',
        'ProjetosFuncao',
        'ComoSoube',
        'ComoSoubeOutros',
        'MotivoPrincipal',
        'RepresentanteCGU',
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
