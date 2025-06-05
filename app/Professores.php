<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Professores extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
      'id_user',
      'Status',
      'NomeProfessor',
      'NomeSocial',
      'id_nucleo',
      'Foto',
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
      'terra_indigenas_id',
      'povo_indigenas_id',
      'pessoa_com_deficiencia',
  ];

  protected $casts = [
      'OutrosNucleos' => 'array',
  ];

  public function nucleo()
  {
      return $this->belongsTo('App\Nucleo', 'id_nucleo');
  }

  public function user()
  {
      return $this->hasOne('App\User');
  }

  public function listas()
  {
    return $this->hasMany('App\ListaPresenca', 'professor_id');
  }

  public function horarios()
  {
    return $this->hasMany('App\HorarioAula', 'professor_id');
  }

  public function povo_indigenas()
  {
    return $this->belongsTo('App\PovoIndigenas', 'povo_indigenas_id');
  }

  public function terra_indigenas()
  {
    return $this->belongsTo('App\TerraIndigenas', 'terra_indigenas_id');
  }

  public function nucleosProfessoresDisciplinas()
  {
    return $this->hasMany('App\NucleosProfessoresDisciplinas', 'professor_id');
  }
}
