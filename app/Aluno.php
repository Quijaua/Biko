<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Aluno extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'Status',
        'NomeAluno',
        'NomeSocial',
        'NomeNucleo',
        'id_user',
        'id_nucleo',
        'Foto',
        'ListaEspera',
        'Bolsista',
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
        'pessoa_com_deficiencia',
        'participante_quilombola',
        'participante_quilombola_qual',
    ];

    /**
     * Quem volta a ficar ativo (por transferência, reativação do Núcleo ou
     * edição manual) deixa de ter o aviso de "Núcleo desativado".
     */
    protected static function booted(): void
    {
        static::saving(function (self $registro) {
            if ((int) $registro->Status === 1) {
                $registro->inativado_por_nucleo_id = null;
            }
        });
    }

    public function nucleo()
    {
        return $this->belongsTo('App\Nucleo', 'id_nucleo');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user'); 
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

    // public function questionarios()
    // {
    //     return $this->hasMany('App\Models\QuizAttempt', 'aluno_id');
    // }

    public function onlyBasicData()
    {
        return $this->only([
            'id',
            'NomeAluno',
            'NomeSocial',
            'Foto',
            'created_at',
            'updated_at',
        ]);
    }

}
