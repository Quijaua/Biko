<?php

namespace App\Policies;

use App\Aluno;
use App\User;
use Illuminate\Auth\Access\Response;

class AlunoPolicy
{
    public function viewSensitiveData(User $user, Aluno $aluno)
    {
        // Administrador pode tudo
        if ($user->role === 'administrador') {
            return true;
        }

        // Coordenador só pode se for do mesmo núcleo
        if ($user->role === 'coordenador' && $user->id_nucleo == $aluno->id_nucleo) {
            return true;
        }

        // Professor NÃO pode ver dados sensíveis
        return false;
    }
}
