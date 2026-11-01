<?php

namespace Database\Seeders;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdministradorSeeder extends Seeder
{

    public function run() {
        $role = 'administrador';
        $token = Str::random(80);

        $data = [
            'Administrador' => [
                'name' => 'Administrador',
                'email' => 'admin@biko.edu',
                'password' => 'admin@biko.edu',
                'api_token' => $token,
                'phone' => '6430000000',
                'emailVerified' => Carbon::now(),
                'first_login' => true,
            ],
        ];

        foreach ($data as $row) {
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
                'role' => $role,
                'api_token' => $row['api_token'],
                'phone' => $row['phone'],
                'email_verified_at' => $row['emailVerified'],
                'first_login' => $row['first_login'],
            ]);
        }
    }
}
