<?php

namespace Tests\Feature\Fase4;

use App\Aluno;
use App\Console\Commands\CustomServeCommand;
use App\Events\MessageCreated;
use App\Listeners\SendMessageAlunoEmail;
use App\Policies\AlunoPolicy;
use App\Policies\ProfessorPolicy;
use App\Professores;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Garante que o que antes estava em Http/Kernel, Console/Kernel,
 * AuthServiceProvider, EventServiceProvider e RouteServiceProvider
 * continua igual depois da migração para bootstrap/app.php.
 */
class ApplicationStructureTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_logged_in_user_opening_login_goes_to_home(): void
    {
        // O padrão do framework seria a rota "dashboard", que alunos não acessam.
        $this->actingAs($this->createAluno())
            ->get(route('login'))
            ->assertRedirect('/home');
    }

    public function test_custom_middleware_aliases_are_registered(): void
    {
        // O router só recebe os aliases quando o Kernel trata a primeira requisição;
        // a fonte é o próprio Kernel.
        $aliases = $this->app->make(Kernel::class)->getMiddlewareAliases();

        $this->assertSame(\App\Http\Middleware\UserPermissions::class, $aliases['permissions']);
        $this->assertSame(\App\Http\Middleware\RestrictProfessor::class, $aliases['restrict.professor']);
        $this->assertSame(\App\Http\Middleware\RestrictAluno::class, $aliases['restrict.aluno']);
    }

    public function test_api_group_keeps_rate_limit_and_bindings(): void
    {
        $groups = $this->app->make(Kernel::class)->getMiddlewareGroups();

        $this->assertSame(['throttle:60,1', SubstituteBindings::class], $groups['api']);
    }

    public function test_policies_are_registered(): void
    {
        $this->assertInstanceOf(AlunoPolicy::class, Gate::getPolicyFor(Aluno::class));
        $this->assertInstanceOf(ProfessorPolicy::class, Gate::getPolicyFor(Professores::class));
    }

    public function test_message_created_has_exactly_one_listener(): void
    {
        // Se o listener fosse registrado duas vezes, cada aluno receberia o e-mail em dobro.
        $listeners = $this->app['events']->getRawListeners()[MessageCreated::class] ?? [];

        $this->assertCount(1, $listeners);
        $this->assertStringContainsString(SendMessageAlunoEmail::class, (string) $listeners[0]);
    }

    public function test_registered_event_sends_email_verification(): void
    {
        $listeners = collect($this->app['events']->getRawListeners()[Registered::class] ?? [])
            ->map(fn ($listener) => is_string($listener) ? $listener : (is_array($listener) ? $listener[0] : ''))
            ->implode(' ');

        $this->assertStringContainsString(SendEmailVerificationNotification::class, $listeners);
    }

    public function test_console_commands_are_loaded(): void
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('generate-admin-token', $commands);
        $this->assertInstanceOf(CustomServeCommand::class, $commands['serve']);
    }
}
