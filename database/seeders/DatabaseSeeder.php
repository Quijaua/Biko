<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(NucleosSeeder::class);
        $this->call(AdministradorSeeder::class);
        $this->call(AlunosSeeder::class);
        $this->call(ProfessoresSeeder::class);
        $this->call(CoordenadoresSeeder::class);
        $this->call(TerraIndigenaTableSeeder::class);
        $this->call(PovoIndigenaTableSeeder::class);
    }
}
