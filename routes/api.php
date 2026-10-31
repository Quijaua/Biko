<?php

use App\Http\Controllers\API\AlunoController as ApiAlunoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Carregadas por bootstrap/app.php (withRouting) com prefixo /api e
| grupo de middleware "api".
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
      return $request->user();
    });

    Route::post('/cadastro-aluno', [ApiAlunoController::class, 'cadastraAluno']);

});
