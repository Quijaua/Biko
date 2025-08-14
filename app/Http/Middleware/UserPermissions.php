<?php

namespace App\Http\Middleware;

use App\Mensagens;
use App\MensagensAluno;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Nucleo;
use App\Aluno;
use App\Coordenadores;
use DB;

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

        if ($role === 'professor') {
            $status = DB::table('professores')->where('id_user', Auth::id())->value('status');
        }

        if (in_array($role, ['aluno', 'professor', 'coordenador'])) {
            $currentPath = $request->path();
            $allowedMensagensIndex = 'mensagens';
            $allowedMensagensRemoved = 'mensagens/removed';
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

            if ($currentPath === $allowedMensagensRemoved) {
                return $next($request);
            }

            if ($request->routeIs('messages.show') || $request->routeIs('messages.destroy')) {
                $mensagemAluno = $request->mensagem->mensagensAluno()->withTrashed()->where('aluno_id', Auth::user()->id)->first();
                $mensagemProfessor = $request->mensagem->remetente_id === Auth::user()->id;

                if ($mensagemAluno || $mensagemProfessor) {
                    return $next($request);
                }
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

        if ($role === 'professor' && $status) {
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
        } else {
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
            $allowedCoordenadoresAdd = 'coordenadores/add';
            $allowedCoordenadoresCreate = 'coordenadores/create';
            $allowedCoordenadoresDetails = 'coordenadores/details/';
            $allowedCoordenadoresEdit = 'coordenadores/edit/';
            $allowedCoordenadoresUpdate = 'coordenadores/update/';
            $allowedCoordenadoresDisable = 'coordenadores/disable/';
            $allowedCoordenadoresEnable = 'coordenadores/enable/';
            $allowedProfessoresIndex = 'professores';
            $allowedProfessoresSearch = 'professores/search';
            $allowedProfessoresAdd = 'professores/add';
            $allowedProfessoresCreate = 'professores/create';
            $allowedProfessoresDetails = 'professores/details/';
            $allowedProfessoresEdit = 'professores/edit/';
            $allowedProfessoresUpdate = 'professores/update/';
            $allowedProfessoresDisable = 'professores/disable/';
            $allowedProfessoresEnable = 'professores/enable/';
            $allowedNucleosIndex = 'nucleos';
            $allowedNucleosDetails = 'nucleos/details/';
//            $allowedNucleosEdit = 'nucleos/edit/' . $user->coordenador->id_nucleo;
//            $allowedNucleosUpdate = 'nucleos/update/' . $user->coordenador->id_nucleo;
$allowedNucleosEdit = 'nucleos/edit/';
$allowedNucleosUpdate = 'nucleos/update/';

if ($user->coordenador && $user->coordenador->id_nucleo) {
    $allowedNucleosEdit .= $user->coordenador->id_nucleo;
    $allowedNucleosUpdate .= $user->coordenador->id_nucleo;
}
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
            if ($currentPath === $allowedCoordenadoresAdd) {
                return $next($request);
            }
            if ($currentPath === $allowedCoordenadoresCreate) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresDetails) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresDisable) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedCoordenadoresEnable) === 0) {
                return $next($request);
            }

            //RULES FOR PROFESSORES ROUTES
            if ($currentPath === $allowedProfessoresIndex) {
                return $next($request);
            }
            if ($currentPath === $allowedProfessoresSearch) {
                return $next($request);
            }
            if ($currentPath === $allowedProfessoresAdd) {
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

        if ($role === 'psicologo') {
            $currentPath = $request->path();
            $allowedAtendimentoPsicologicoIndex = 'atendimento-psicologico';
            $allowedAtendimentoPsicologicoCreate = 'atendimento-psicologico/create';
            $allowedAtendimentoPsicologicoStore = 'atendimento-psicologico/store';
            $allowedAtendimentoPsicologicoEdit = 'atendimento-psicologico/edit/';
            $allowedAtendimentoPsicologicoUpdate = 'atendimento-psicologico/update/';
            $allowedAtendimentoPsicologicoSearch = 'atendimento-psicologico/search';
            $allowedAtendimentoPsicologicoDetails = 'atendimento-psicologico/details/';

            //RULES FOR PSICOLOGOS ROUTES
            if ($allowedAtendimentoPsicologicoIndex === $currentPath) {
                return $next($request);
            }
            if ($allowedAtendimentoPsicologicoCreate === $currentPath) {
                return $next($request);
            }
            if ($allowedAtendimentoPsicologicoStore === $currentPath) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAtendimentoPsicologicoEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAtendimentoPsicologicoUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAtendimentoPsicologicoSearch) !== false) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedAtendimentoPsicologicoDetails) === 0) {
                return $next($request);
            }

            return back();
        }

        if ($role === 'psicologa_supervisora') {
            $currentPath = $request->path();
            $allowedPsicologosIndex = 'psicologos';
            $allowedPsicologosAdd = 'psicologos/add';
            $allowedPsicologosCreate = 'psicologos/create';
            $allowedPsicologosEdit = 'psicologos/edit/';
            $allowedPsicologosUpdate = 'psicologos/update/';
            $allowedPsicologosSearch = 'psicologos/search';
            $allowedPsicologosDetails = 'psicologos/details/';

            //RULES FOR PSICOLOGOS ROUTES
            if ($allowedPsicologosIndex === $currentPath) {
                return $next($request);
            }
            if ($allowedPsicologosAdd === $currentPath) {
                return $next($request);
            }
            if ($allowedPsicologosCreate === $currentPath) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedPsicologosEdit) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedPsicologosUpdate) === 0) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedPsicologosSearch) !== false) {
                return $next($request);
            }
            if (strpos($currentPath, $allowedPsicologosDetails) === 0) {
                return $next($request);
            }

            return back();
        }

        return back();
    }


}
