<?php

use App\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Comandos de console em closure. Os comandos em classe ficam em
| app/Console/Commands e são carregados automaticamente.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('generate-admin-token', function () {

    $user = User::find(1);
    $token = Str::random(80);

    $user->update([
      'api_token' => $token
    ]);

})->purpose('Generate/Update Admin API Token');
