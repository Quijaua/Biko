<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Illuminate\Support\Facades\Auth;

class RestrictProfessor
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $status = DB::table('professores')->where('id_user', Auth::id())->value('status');

        if ($user && $user->role === 'professor' && $status == 0) {
            // Rotas permitidas
            $allowedRoutes = [
                route('home', [], false),
                route('logout', [], false),
            ];

            // Se a rota atual não está na lista, redireciona para home
            if (!in_array($request->path(), $allowedRoutes)) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}