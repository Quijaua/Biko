<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Nucleo extends Model
{
    protected $fillable = [
        'Status',
        'NomeNucleo',
        'AreaAtuacao',
        'InfoInscricao',
        'EspacoInserido',
        'Endereco',
        'Numero',
        'Bairro',
        'Complemento',
        'Cidade',
        'Estado',
        'CEP',
        'Telefone',
        'Email',
        'Fundacao',
        'Facebook',
        'LinkSite',
        'RedeSocial',
        'TaxaInscricao',
        'TaxaInscricaoValor',
        'Vagas',
        'InscricaoFrom',
        'InscricaoTo',
        'InicioAtividades',
        'whatsapp_url',
        'Regiao',
        'permite_ambiente_virtual',
        'diciplinas',
    ];

    public function alunos()
    {
        return $this->hasMany('App\Aluno', 'id_nucleo');
    }

    public function matriculas()
    {
      return $this->hasMany('App\Aluno', 'id_nucleo')->where('ListaEspera', 'Sim')->where('Status', 1);
    }

    public function professores()
    {
        return $this->hasMany('App\Professores', 'id_nucleo');
    }

    public function coordenadores()
    {
        return $this->hasMany('App\Coordenadores', 'id_nucleo');
    }

    public function listas_presenca()
    {
      return $this->hasMany('App\ListaPresenca')->orderBy('date');
    }

    public function disciplina()
    {
        return $this->hasMany('App\Disciplina', 'nucleo_id');
    }

    public static function whereStatus($value = true)
    {
        return self::query()->where('Status', $value);
    }

    public static function whereUserAtuacao()
    {
        return self::query()->when(Auth::user()->is_professor_or_coordenador, function (Builder $query) {
            return $query->whereHas('professores', function (Builder $query) {
                if (Auth::user()->professor) {
                    if (Auth::user()->professor->OutrosNucleos) {
                        $query->orWhereIn('id_user', Auth::user()->professor->OutrosNucleos);
                    }
                }

                return $query->where('id_user', Auth::user()->id);
            })->orWhereHas('coordenadores', function (Builder $query) {
                return $query->where('id_user', Auth::user()->id);
            });
        })->where('Status', true);
    }

}
