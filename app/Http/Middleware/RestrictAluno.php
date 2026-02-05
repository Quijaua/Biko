<?php

namespace App\Http\Middleware;

use Closure;
use App\Aluno;
use Illuminate\Support\Facades\Auth;

class RestrictAluno
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        $isAluno = Aluno::where('id_user', $user->id)->exists();

        if ($isAluno) {
            return abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}