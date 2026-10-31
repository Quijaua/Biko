<?php

namespace App\Providers;

use App\Aluno;
use App\Policies\AlunoPolicy;
use App\Policies\ProfessorPolicy;
use App\Professores;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Antes em AuthServiceProvider. Os nomes não seguem a convenção
        // App\Models\X -> App\Policies\XPolicy, então o registro é explícito.
        Gate::policy(Aluno::class, AlunoPolicy::class);
        Gate::policy(Professores::class, ProfessorPolicy::class);

        // Listeners: descobertos automaticamente em app/Listeners
        // (SendMessageAlunoEmail escuta MessageCreated).
    }
}
