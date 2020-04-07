<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Nucleo;
use App\Aluno;
use App\Coordenadores;

class UserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $role = $user->role;
        $id = $user->id;

        if ($role === 'administrador') {
            return $next($request);
        }

        if (in_array($role, ['aluno', 'professor', 'coordenador'])) {
            $currentPath = $request->path();
            $allowedMensagensIndex = 'mensagens';
            $allowedMensagensCreate = 'mensagens/create';
            $allowedMensagensStore = 'mensagens/store';

            if ($user->allowed_send_email) {
                if ($currentPath === $allowedMensagensCreate) {
                    return $next($request);
                }
                if ($currentPath === $allowedMensagensStore) {
                    return $next($request);
                }
            }

            if ($currentPath === $allowedMensagensIndex) {
                return $next($request);
            }
        }

        if ($role === 'aluno') {
            $currentPath = $request->path();
            $allowedAlunosIndex = 'alunos';
            $allowedAlunosDetails = 'alunos/details/' . $user->aluno->id;
            $allowedAlunosEdit = 'alunos/edit/' . $user->aluno->id;
            $allowedAlunosUpdate = 'alunos/update/' . $user->aluno->id;
            $allowedAlunosSearch = 'alunos/search';

            if ($allowedAlunosIndex === $currentPath) {
                return $next($request);
            }
            if ($allowedAlunosDetails === $currentPath) {
                return $next($request);
            }
            if ($allowedAlunosEdit === $currentPath) {
                return $next($request);
            }
            if ($allowedAlunosUpdate === $currentPath) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosSearch) !== false) {
                return $next($request);
            }

            return back();
        }

        if ($role === 'professor') {
            $currentPath = $request->path();
            $allowedProfessoresIndex = 'professores';
            $allowedAlunosIndex = 'alunos';
            $allowedAlunosDetails = 'alunos/details/';
            $allowedNucleosIndex = 'nucleos';
            $allowedNucleosDetails = 'nucleos/details/';
            $allowedNucleosEdit = 'nucleos/edit/';
            $allowedProfessoresDetails = 'professores/details/' . $user->professor->id;
            $allowedProfessoresEdit = 'professores/edit/' . $user->professor->id;
            $allowedProfessoresUpdate = 'professores/update/' . $user->professor->id;
            $allowedCoordenadoresList = 'coordenadores';
            $allowedInactive = 'professores/disable/';
            $allowedNucleosSearchApi = 'api/alunos/nucleo/search';

            if ($allowedNucleosSearchApi === $currentPath) {
                return $next($request);
            }
            if ($allowedProfessoresIndex === $currentPath) {
                return $next($request);
            }
            if ($allowedProfessoresEdit === $currentPath) {
                return $next($request);
            }
            if ($allowedProfessoresUpdate === $currentPath) {
                return $next($request);
            }
            if ($allowedAlunosIndex === $currentPath) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosDetails) !== false) {
                return $next($request);
            }
            if ($allowedNucleosIndex === $currentPath) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosDetails) !== false) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosEdit) !== false) {
                return back();
            }
            if ($allowedProfessoresDetails === $currentPath) {
                return $next($request);
            }
            if ($allowedCoordenadoresList === $currentPath) {
                return $next($request);
            }
            if ($allowedInactive === $currentPath) {
                return back();
            }

            return back();
        }

        if ($role === 'coordenador') {
            $currentPath = $request->path();
            $allowedAlunosIndex = 'alunos';
            $allowedAlunosAdd = 'alunos/add';
            $allowedAlunosCreate = 'alunos/create';
            $allowedAlunosSearch = 'alunos/search';
            $allowedAlunosDetails = 'alunos/details/';
            $allowedAlunosEdit = 'alunos/edit/';
            $allowedAlunosUpdate = 'alunos/update/';
            $allowedAlunosInactive = 'alunos/disable/';
            $allowedAlunosActive = 'alunos/enable/';
            $allowedCoordenadoresList = 'coordenadores';
            $allowedCoordenadoresDetails = 'coordenadores/details/';
            $allowedCoordenadoresEdit = 'coordenadores/edit/' . $user->coordenador->id;
            $allowedCoordenadoresUpdate = 'coordenadores/update/';
            $allowedProfessoresIndex = 'professores';
            $allowedProfessoresSearch = 'professores/search';
            $allowedProfessoresCreate = 'professores/add';
            $allowedProfessoresDetails = 'professores/details/';
            $allowedProfessoresEdit = 'professores/edit/';
            $allowedProfessoresUpdate = 'professores/update/';
            $allowedProfessoresDisable = 'professores/disable/';
            $allowedProfessoresEnable = 'professores/enable/';
            $allowedNucleosIndex = 'nucleos';
            $allowedNucleosDetails = 'nucleos/details/';
            $allowedNucleosEdit = 'nucleos/edit/' . $user->coordenador->id_nucleo;
            $allowedNucleosUpdate = 'nucleos/update/' . $user->coordenador->id_nucleo;
            $allowedNucleosSearch = 'alunos/nucleo/search';
            $allowedNucleosSearchApi = 'api/alunos/nucleo/search';

            //RULES FOR ALUNOS ROUTES
            if ($currentPath === $allowedAlunosIndex) {
                return $next($request);
            }
            if ($currentPath === $allowedAlunosAdd) {
                return $next($request);
            }
            if ($currentPath === $allowedAlunosCreate) {
                return $next($request);
            }
            if ($currentPath === $allowedAlunosSearch) {
                return $next($request);
            }
            if ($currentPath === $allowedNucleosSearchApi) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosDetails) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosInactive) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAlunosActive) === 0) {
                return $next($request);
            }

            //RULES FOR COORDENADORES ROUTES
            if ($currentPath === $allowedCoordenadoresList) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresDetails) === 0) {
                return $next($request);
            }
            if ($currentPath === $allowedCoordenadoresEdit) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresUpdate) === 0) {
                return $next($request);
            }

            //RULES FOR PROFESSORES ROUTES
            if ($currentPath === $allowedProfessoresIndex) {
                return $next($request);
            }
            if ($currentPath === $allowedProfessoresSearch) {
                return $next($request);
            }
            if ($currentPath === $allowedProfessoresCreate) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedProfessoresDetails) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedProfessoresEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedProfessoresUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedProfessoresDisable) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedProfessoresEnable) === 0) {
                return $next($request);
            }

            //RULES FOR NUCLEOS ROUTES
            if ($currentPath === $allowedNucleosIndex) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosDetails) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedNucleosSearch) === 0) {
                return $next($request);
            }

            return back();
        }

        return back();
    }


}
