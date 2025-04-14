<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professores extends Model
{
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
    ];

    protected $casts = [
        'Disciplinas' => 'array',
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
}
