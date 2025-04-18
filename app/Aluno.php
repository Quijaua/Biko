<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'Status',
        'NomeAluno',
        'NomeSocial',
        'NomeNucleo',
        'id_user',
        'id_nucleo',
        'Foto',
        'ListaEspera',
        'CPF',
        'RG',
        'temFilhos',
        'filhosQt',
        'Email',
        'Raca',
        'Genero',
        'concordaSexoDesignado',
        'IdentificaGenero',
        'EstadoCivil',
        'Nascimento',
        'responsavelCuidadoOutraPessoa',
        'temFilhos',
        'filhosIdade',
        'CEP',
        'CEPProprio',
        'Endereco',
        'Numero',
        'Bairro',
        'Cidade',
        'Estado',
        'Complemento',
        'FoneComercial',
        'FoneResidencial',
        'FoneCelular',
        'Escolaridade',
        'RamoAtuacao',
        'RamoAtuacaoOutros',
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
        'AuxTipo',
        'EnsFundamental',
        'PorcentagemBolsa',
        'EnsMedio',
        'PorcentagemBolsaMedio',
        'Enem',
        'Vestibular',
        'FaculdadeTipo',
        'NomeFaculdade',
        'CursoFaculdade',
        'AnoFaculdade',
        'OpcoesVestibular1',
        'OpcoesVestibular2',
        'VestibularOutraCidade',
        'ComoSoube',
        'ComoSoubeOutros',
        'localizacao_curso',
        'terra_indigenas_id',
        'povo_indigenas_id',
    ];

    public function nucleo()
    {
        return $this->belongsTo('App\Nucleo', 'id_nucleo');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function familiares()
    {
        return $this->hasMany('App\AlunoInfoFamiliares', 'id_user');
    }

    public function frequencia()
    {
      return $this->hasMany('App\Frequencia', 'aluno_id');
    }

    public function ausencias()
    {
      return $this->hasMany('App\Frequencia', 'aluno_id')->where('is_present', false);
    }

    public static function whereStatus($value = true)
    {
        return self::query()->where('Status', $value);
    }

    public static function whereNucleo($nucleo)
    {
        return self::query()->where('id_nucleo', $nucleo);
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
