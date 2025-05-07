<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'role',
        'email_verified_at',
        'phone',
        'first_login',
        'otp_hash',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'allowed_send_email',
        'is_professor_or_coordenador',
        'is_professor',
        'is_coordenador',
    ];

    public function aluno()
    {
        return $this->hasOne('App\Aluno', 'id_user');
    }

    public function professor()
    {
        return $this->hasOne('App\Professores', 'id_user');
    }

    public function coordenador()
    {
        return $this->hasOne('App\Coordenadores', 'id_user');
    }

    public function getAllowedSendEmailAttribute()
    {
        return in_array($this->role, ['professor', 'coordenador', 'administrador']);
    }

    public function getIsProfessorOrCoordenadorAttribute()
    {
        return $this->is_professor || $this->is_coordenador;
    }

    public function getIsProfessorAttribute()
    {
        return $this->professor !== null;
    }

    public function getIsCoordenadorAttribute()
    {
        return $this->coordenador !== null;
    }

}
