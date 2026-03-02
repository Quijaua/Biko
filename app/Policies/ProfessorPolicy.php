<?php

namespace App\Policies;

use App\Professores;
use App\User;
use Illuminate\Auth\Access\Response;

class ProfessorPolicy
{
    public function viewSensitiveData(User $user, Professores $professor)
    {
        // Administrador pode tudo
        if ($user->role === 'administrador') {
            return true;
        }

        // Coordenador só pode se for do mesmo núcleo
        if ($user->role === 'coordenador') {
            return $user->coordenador?->nucleos()
                ->where('nucleos.id', $professor->id_nucleo)
                ->exists();
        }

        // Caso contrário NÃO pode ver dados sensíveis
        return false;
    }
}
