<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Marca first_login = true em contas cuja senha ainda é o próprio e-mail
 * (padrão usado ao criar administradores, alunos via API e professores
 * voluntários). No próximo acesso a pessoa é obrigada a trocar a senha.
 *
 * Pode rodar com o site no ar; demora porque testa o bcrypt de cada conta.
 */
class ForcarTrocaSenhaPadrao extends Command
{
    protected $signature = 'biko:forcar-troca-senha-padrao {--dry-run : Só lista, sem alterar}';

    protected $description = 'Obriga a troca de senha nas contas cuja senha é igual ao e-mail';

    public function handle(): int
    {
        $total = 0;

        User::query()
            ->where(fn ($q) => $q->whereNull('first_login')->orWhere('first_login', false))
            ->whereNotNull('password')
            ->select(['id', 'email', 'password', 'role'])
            ->chunkById(200, function ($users) use (&$total) {
                foreach ($users as $user) {
                    if (! $user->email || ! Hash::check($user->email, $user->password)) {
                        continue;
                    }

                    $total++;
                    $this->line("#{$user->id} {$user->role} {$user->email}");

                    if (! $this->option('dry-run')) {
                        User::whereKey($user->id)->update(['first_login' => true]);
                    }
                }
            });

        $acao = $this->option('dry-run') ? 'encontradas' : 'marcadas para troca de senha';
        $this->info("{$total} conta(s) com senha = e-mail {$acao}.");

        return self::SUCCESS;
    }
}
