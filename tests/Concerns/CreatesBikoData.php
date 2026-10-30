<?php

namespace Tests\Concerns;

use App\Aluno;
use App\Coordenadores;
use App\Nucleo;
use App\Professores;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Cria os registros mínimos de cada perfil diretamente pelos models,
 * sem depender de factories (que serão reescritas na Fase 1).
 */
trait CreatesBikoData
{
    protected string $defaultPassword = 'senha-de-teste';

    protected function createNucleo(array $attributes = []): Nucleo
    {
        return Nucleo::create(array_merge([
            'Status' => 1,
            'NomeNucleo' => 'Núcleo '.Str::random(6),
            'Estado' => 'SP',
            'Cidade' => 'São Paulo',
        ], $attributes));
    }

    protected function createUser(string $role, array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => ucfirst($role).' '.Str::random(5),
            'email' => Str::lower($role.'.'.Str::random(8)).'@biko.test',
            'password' => Hash::make($this->defaultPassword),
            'role' => $role,
            'phone' => '11999999999',
            'email_verified_at' => now(),
            'first_login' => false,
        ], $attributes));
    }

    protected function createAdmin(array $attributes = []): User
    {
        return $this->createUser('administrador', $attributes);
    }

    protected function createAluno(?Nucleo $nucleo = null, array $userAttributes = [], array $alunoAttributes = []): User
    {
        $nucleo ??= $this->createNucleo();
        $user = $this->createUser('aluno', $userAttributes);

        Aluno::create(array_merge([
            'NomeAluno' => $user->name,
            'id_user' => $user->id,
            'Status' => 1,
            'FoneCelular' => $user->phone,
            'Email' => $user->email,
            'id_nucleo' => $nucleo->id,
            'NomeNucleo' => $nucleo->NomeNucleo,
            'ListaEspera' => 'Não',
        ], $alunoAttributes));

        return $user->fresh();
    }

    protected function createProfessor(?Nucleo $nucleo = null, int $status = 1, array $userAttributes = []): User
    {
        $nucleo ??= $this->createNucleo();
        $user = $this->createUser('professor', $userAttributes);

        Professores::create([
            'NomeProfessor' => $user->name,
            'id_user' => $user->id,
            'Status' => $status,
            'FoneCelular' => $user->phone,
            'Email' => $user->email,
            'id_nucleo' => $nucleo->id,
        ]);

        return $user->fresh();
    }

    protected function createCoordenador(?Nucleo $nucleo = null, array $userAttributes = []): User
    {
        $nucleo ??= $this->createNucleo();
        $user = $this->createUser('coordenador', $userAttributes);

        $coordenador = Coordenadores::create([
            'NomeCoordenador' => $user->name,
            'id_user' => $user->id,
            'Status' => 1,
            'FoneCelular' => $user->phone,
            'Email' => $user->email,
        ]);

        $coordenador->nucleos()->attach($nucleo->id);

        return $user->fresh();
    }
}
