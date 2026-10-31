<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\RestrictAluno;
use App\Http\Middleware\RestrictProfessor;
use App\Http\Middleware\UserPermissions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Usuário já logado que abre /login, /register etc. vai para /home
        // (o padrão do framework seria a rota "dashboard", bloqueada para alunos).
        $middleware->redirectUsersTo('/home');

        $middleware->alias([
            'permissions' => UserPermissions::class,
            'restrict.professor' => RestrictProfessor::class,
            'restrict.aluno' => RestrictAluno::class,
            'role' => EnsureUserHasRole::class,
        ]);

        // Mesmo grupo "api" de antes: 60 requisições/minuto + route model binding.
        $middleware->group('api', [
            'throttle:60,1',
            SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
