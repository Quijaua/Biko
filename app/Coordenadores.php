<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Coordenadores extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'id_user',
    'Status',
    'NomeCoordenador',
    'NomeSocial',
    'FuncaoCoordenador',
    'AnoIngresso',
    'Foto',
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
    'terra_indigenas_id',
    'povo_indigenas_id',
    'pessoa_com_deficiencia',
  ];

  public function nucleos()
  {
    return $this->belongsToMany(
      Nucleo::class,
      'coordenador_nucleo',
      'coordenador_id',
      'nucleo_id'
    );
  }

  public static function ativos()
  {
    return self::where('Status', 1)->get();
  }

  public function nucleo()
  {
    return $this->belongsTo('App\Nucleo');
  }

  public function user()
  {
    return $this->hasOne('App\User');
  }

  public function povo_indigenas()
  {
    return $this->belongsTo('App\PovoIndigena', 'povo_indigenas_id');
  }

  public function terra_indigenas()
  {
    return $this->belongsTo('App\TerraIndigena', 'terra_indigenas_id');
  }
}
