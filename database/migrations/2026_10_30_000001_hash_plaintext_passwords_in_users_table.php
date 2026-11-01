<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Corrige contas criadas pelo formulário "Seja um professor", que até a
 * Fase 1 do upgrade gravava a senha (o próprio e-mail) em texto puro.
 *
 * Qualquer senha que não seja um hash reconhecido (bcrypt/argon) passa
 * a ser armazenada com hash. O valor da senha não muda: o usuário continua
 * entrando com a mesma senha de antes.
 */
return new class extends Migration
{
    public function up(): void
    {
        $corrigidos = 0;

        DB::table('users')
            ->select(['id', 'password'])
            ->whereNotNull('password')
            ->where('password', '!=', '')
            ->orderBy('id')
            ->chunkById(500, function ($users) use (&$corrigidos) {
                foreach ($users as $user) {
                    if (password_get_info($user->password)['algo'] !== null) {
                        continue; // já é um hash
                    }

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['password' => Hash::make($user->password)]);

                    $corrigidos++;
                }
            });

        Log::info("Migration hash_plaintext_passwords: {$corrigidos} senha(s) em texto puro convertidas para hash.");
    }

    public function down(): void
    {
        // Irreversível de propósito: não há motivo para voltar a guardar senhas em texto puro.
    }
};
