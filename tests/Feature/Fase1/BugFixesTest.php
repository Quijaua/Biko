<?php

namespace Tests\Feature\Fase1;

use App\User;
use Database\Seeders\AdministradorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * Correções feitas na Fase 1 a partir dos problemas encontrados na Fase 0.
 */
class BugFixesTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_guest_on_permissions_only_route_is_sent_to_login(): void
    {
        // nucleos/details/{id} tem só o middleware 'permissions'
        $this->get('/nucleos/details/1')->assertRedirect(route('login'));
    }

    public function test_guest_json_request_on_permissions_only_route_gets_401(): void
    {
        $this->getJson('/nucleos/details/1')->assertUnauthorized();
    }

    public function test_administrador_seeder_persists_api_token(): void
    {
        $this->seed(AdministradorSeeder::class);

        $admin = User::where('email', 'admin@biko.edu')->firstOrFail();

        $this->assertNotNull($admin->api_token);
        $this->assertSame(80, strlen($admin->api_token));
    }

    public function test_migration_hashes_plaintext_passwords_and_keeps_existing_hashes(): void
    {
        $textoPuro = $this->createUser('professor');
        DB::table('users')->where('id', $textoPuro->id)->update(['password' => 'voluntario@biko.test']);

        $comHash = $this->createUser('aluno');
        $hashOriginal = $comHash->password;

        $migration = require database_path('migrations/2026_10_30_000001_hash_plaintext_passwords_in_users_table.php');
        $migration->up();

        $senha = DB::table('users')->where('id', $textoPuro->id)->value('password');
        $this->assertNotSame('voluntario@biko.test', $senha);
        $this->assertTrue(Hash::check('voluntario@biko.test', $senha));

        $this->assertSame($hashOriginal, DB::table('users')->where('id', $comHash->id)->value('password'));
    }

    public function test_professor_created_by_volunteer_form_can_log_in_with_initial_password(): void
    {
        config(['app.env' => 'local']); // dispensa o hCaptcha (ver AuthenticationTest)

        $nucleo = $this->createNucleo();

        $this->post('/seja-um-professor', [
            'nome_social' => 'Professor Novo',
            'email' => 'professor.novo@biko.test',
            'nucleo_id' => $nucleo->id,
        ])->assertOk();

        $this->post(route('login'), [
            'email' => 'professor.novo@biko.test',
            'password' => 'professor.novo@biko.test',
        ])->assertRedirect('/home');

        $this->assertAuthenticated();
    }
}
