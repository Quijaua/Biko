<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Libera a rota só para os perfis informados.
 *
 * Uso: ->middleware('role:administrador') ou ->middleware('role:administrador,coordenador')
 *
 * Usa o perfil ativo ($user->role), que respeita a troca coordenador/professor.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                abort(401);
            }

            return redirect()->guest(route('login'));
        }

        abort_unless(in_array($user->role, $roles, true), 403, 'Acesso não autorizado.');

        return $next($request);
    }
}
