<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\PovoIndigena;

class TrumaiPovoIndigenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PovoIndigena::create([
            'label' => 'Trumai'
        ]);
    }
}
