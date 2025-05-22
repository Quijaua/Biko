<?php

use App\User;
use App\Mail\MessageOtpLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Rota inicial
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

// Rota protegida (depois de logado)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home'); // ou seu controller
    })->name('home');
});


Route::middleware(['auth'])->group(function () {

  Route::get('/dashboard', function () {
      return view('dashboard');
  })->name('dashboard');

  Route::post('change_default_password', 'Auth\FirstLoginController@changePassword')->name('change_default_password');
  Route::get('default_username', 'Auth\FirstLoginController@username')->name('default_username');
  Route::post('change_default_username', 'Auth\FirstLoginController@changeUsername')->name('change_default_username');
});

Route::get('inscricoes-para-cursinho-pre-vestibular-nucleo-yabas', function () {
    return redirect()->route('pre-cadastro');
})->name('register-slug');

Route::get('pre-cadastro', function () {
    return view('auth.register');
})->name('pre-cadastro');

// ROUTES FOR ALTERNATIVE LOGIN
//OTP
Route::post('otp-login', function () {
    $user = User::where('email', request()->email)->first();

    if (!$user) {
        return back()->with('error', 'Email não cadastrado.');
    }

    $otp_hash = Hash::make(Carbon::now());

    $user->otp_hash = $otp_hash;
    $user->save();

    Mail::to($user->email)->send(new MessageOtpLogin($user->email));

    return back()->with('success', 'Quase lá! Confira seu e-mail e clique no link que enviamos para entrar no sistema.');
})->name('otp-login');

Route::get('otp-verify', function () {
    $user = User::where('email', request()->email)->first();
    $otp_hash = request()->token;

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não encontrado.');
    }

    if (!$otp_hash || $user->otp_hash != $otp_hash) {
        return redirect()->route('login')->with('error', 'Token inválido.');
    }

    Auth::login($user);

    $user->otp_hash = null;
    $user->save();

    return redirect()->route('home');
})->name('otp-verify');

//GOOGLE
Route::get('/google/redirect', 'GoogleLoginController@redirectToGoogle')->name('google.redirect');
Route::get('/oauth/google/callback', 'GoogleLoginController@handleGoogleCallback')->name('google.callback');

// ROUTES FOR NUCLEOS MANAGEMENT
Route::post('nucleos/importar_alunos/{id}', 'AlunosController@importar')->middleware('permissions')->name('alunos.importar');
Route::get('nucleos', 'NucleoController@index')->middleware('permissions');
Route::get('nucleos/details/{id}', 'NucleoController@details')->middleware('permissions');
Route::get('nucleos/add', 'NucleoController@showForm')->middleware('permissions');
Route::get("nucleo/estados/{estado}", function(Request $request, $estado) {
    $query = DB::table('nucleos')->where('status', 1);
    if($estado != 'all') {
      $query->where('estado', $estado);
    }
    return response()->json($query->get());
});
Route::post('nucleos/create', 'NucleoController@create')->middleware('permissions');
Route::get('nucleos/edit/{id}', 'NucleoController@edit')->middleware('permissions');
Route::post('nucleos/update/{id}', 'NucleoController@update')->middleware('permissions');
Route::get('nucleos/disable/{id}', 'NucleoController@disable')->middleware('permissions');
Route::get('nucleos/enable/{id}', 'NucleoController@enable')->middleware('permissions');
Route::any('nucleos/search', 'NucleoController@search');
Route::any('nucleos/search', 'NucleoController@search');
Route::get('nucleo/presences', 'NucleoController@presences_index')->name('nucleo/presences');
Route::get('nucleo/presences/new', 'NucleoController@presences_new')->name('nucleo/presences/new');
Route::post('nucleo/presences/create', 'NucleoController@presences_create')->name('nucleo/presences/create');
Route::get('nucleo/presences/destroy', 'NucleoController@presences_destroy')->name('nucleo/presences/destroy');
Route::any('nucleo/presences/search', 'NucleoController@search_presences');
Route::any('nucleo/presences/search', 'NucleoController@search_presences');

Route::get('nucleo/material', 'MaterialController@index')->name('nucleo.material');
Route::post('nucleo/material/create', 'MaterialController@create')->name('nucleo.material.create');
Route::get('nucleo/material/delete/{id}', 'MaterialController@delete')->name('nucleo.material.delete');
Route::get('nucleo/material/restore/{id}', 'MaterialController@restore')->name('nucleo.material.restore');
Route::get('nucleo/material/search', 'MaterialController@search');
Route::put('nucleo/material/edit/{id}', 'MaterialController@edit')->middleware('permissions')->name('material.edit');

Route::post('nucleo/professores-disciplinas/create', 'NucleoProfessoresDisciplinasController@create')->name('professores-disciplinas.create');
Route::put('nucleo/professores-disciplinas/update', 'NucleoProfessoresDisciplinasController@update')->name('professores-disciplinas.update');
Route::post('nucleo/professores-disciplinas/delete', 'NucleoProfessoresDisciplinasController@delete')->name('professores-disciplinas.delete');

// ROUTES FOR ALUNOS MANAGEMENT
Route::get('alunos', 'AlunosController@index')->middleware('permissions');
Route::get('alunos/details/{id}', 'AlunosController@details')->middleware('permissions');
Route::get('alunos/add', 'AlunosController@showForm')->middleware('permissions');
Route::post('alunos/create', 'AlunosController@create')->middleware('permissions');
Route::get('alunos/edit/{id}', 'AlunosController@edit')->middleware('permissions');
Route::post('alunos/update/{id}', 'AlunosController@update')->middleware('permissions');
Route::get('alunos/disable/{id}', 'AlunosController@disable')->middleware('permissions');
Route::get('alunos/enable/{id}', 'AlunosController@enable')->middleware('permissions');
Route::any('alunos/search', 'AlunosController@search')->name('alunos/search');
Route::any('alunos/nucleo/search', 'AlunosController@searchByNucleo')->name('alunos/nucleo/search');
Route::any('api/alunos/nucleo/search', 'AlunosController@searchByNucleoAPI')->name('alunos/nucleo/search.api');
Route::post('alunos/familiares/add', 'AlunoInfoFamiliaresController@add')->name('alunos/familiares/add');
Route::post('alunos/familiares/update/{id}', 'AlunoInfoFamiliaresController@update')->name('alunos/familiares/update');
Route::post('alunos/familiares/delete/{id}', 'AlunoInfoFamiliaresController@delete')->name('alunos/familiares/delete');
Route::get('alunos/export/', 'AlunosController@export')->name('alunos/export/');
Route::get('alunos/log/{id}', 'AlunosController@logActionView')->name('alunos/log');

// ROUTES FOR COORDENADORES MANAGEMENT
Route::get('coordenadores', 'CoordenadoresController@index')->middleware('permissions');
Route::get('coordenadores/details/{id}', 'CoordenadoresController@details')->middleware('permissions');
Route::get('coordenadores/export/', 'CoordenadoresController@export')->name('coordenadores/export/');
Route::get('coordenadores/add', 'CoordenadoresController@showForm')->middleware('permissions');
Route::post('coordenadores/create', 'CoordenadoresController@create')->middleware('permissions');
Route::get('coordenadores/edit/{id}', 'CoordenadoresController@edit')->middleware('permissions');
Route::post('coordenadores/update/{id}', 'CoordenadoresController@update')->middleware('permissions');
Route::get('coordenadores/disable/{id}', 'CoordenadoresController@disable')->middleware('permissions');
Route::get('coordenadores/enable/{id}', 'CoordenadoresController@enable')->middleware('permissions');
Route::any('coordenadores/search', 'CoordenadoresController@search')->name('coordenadores/search');

// ROUTES FOR PROFESSORES MANAGEMENT
Route::get('professores', 'ProfessoresController@index')->middleware('permissions')->name('professores.index');
Route::get('professores/details/{id}', 'ProfessoresController@details')->middleware('permissions');
Route::get('professores/export/', 'ProfessoresController@export')->name('professores/export/');
Route::get('professores/add', 'ProfessoresController@showForm')->middleware('permissions');
Route::post('professores/create', 'ProfessoresController@create')->middleware('permissions');
Route::get('professores/edit/{id}' , 'ProfessoresController@edit')->middleware('permissions');
Route::post('professores/update/{id}', 'ProfessoresController@update')->middleware('permissions');
Route::get('professores/disable/{id}', 'ProfessoresController@disable')->middleware('permissions');
Route::get('professores/enable/{id}', 'ProfessoresController@enable')->middleware('permissions');
Route::any('professores/search', 'ProfessoresController@search')->name('professores/search');


// ROUTES FOR MESSAGE MANAGEMENT
Route::get('mensagens', 'MensagensController@index')->middleware('permissions')->name('messages.index');
Route::get('mensagens/removed', 'MensagensController@removed')->middleware('permissions')->name('messages.removed');
Route::get('mensagens/create', 'MensagensController@create')->middleware('permissions')->name('messages.create');
Route::post('mensagens/store', 'MensagensController@store')->middleware('permissions')->name('messages.store');
Route::get('mensagens/{mensagem}/show', 'MensagensController@show')->middleware('permissions')->name('messages.show');
Route::delete('mensagens/{mensagem}/destroy', 'MensagensController@destroy')->middleware('permissions')->name('messages.destroy');

// ROUTES FOR DISCIPLINAS
Route::group(['prefix' => 'disciplinas'], function () {
    Route::get('/', 'DisciplinaController@index')->name('disciplinas.index');
});
Route::resource('/disciplinas', 'DisciplinaController')->except(['index']);

// ROUTES FOR AMBIENTE VIRTUAL
Route::group(['prefix' => 'ambiente-virtual'], function () {
    Route::get('/', 'AmbienteVirtualController@index')->name('ambiente-virtual.index');
    Route::post('comentarios/adicionar/{id}', 'AmbienteVirtualController@comentar')->name('ambiente-virtual.comentar');
    Route::post('notas/adicionar/{id}', 'AmbienteVirtualController@anotar')->name('ambiente-virtual.anotar');
});
Route::resource('/ambiente-virtual', 'AmbienteVirtualController')->except(['index']);

// ROUTES FOR AUDITORIA
Route::group(['prefix' => 'auditoria'], function () {
    Route::get('/', 'AuditoriaController@index')->name('auditoria.index');
});

// ROUTES FOR CONFIGURACOES GERAL
Route::group(['prefix' => 'geral'], function () {
    Route::get('/', 'GeralController@index')->name('geral.index');
    Route::post('/update', 'GeralController@update')->name('geral.update');
});

// ROUTES FOR CODIGOS PERSONALIZADOS
Route::group(['prefix' => 'codigo-personalizado'], function () {
    Route::get('/', 'CodigoPersonalizadoController@index')->name('codigo-personalizado.index');
    Route::post('/update', 'CodigoPersonalizadoController@update')->name('codigo-personalizado.update');
});

// SEJA UM PROFESSOR
Route::get('/seja-um-professor', function () {
    return view('seja-um-professor.index');
});

Route::post('/seja-um-professor', function (Request $request) {

    $user_data = [
        'name' => $request->nome_social,
        'email' => $request->email,
        'password' => $request->email,
        'role' => 'professor',
    ];

    $user = App\User::create($user_data);

    $professor_data = [
        'id_user' => $user->id,
        'NomeProfessor' => $request->nome_social,
        'Status' => 0,
        'Nascimento' => $request->data_nascimento,
        'Email' => $request->email,
        'FoneCelular' => $request->telefone,
        'RamoAtuacaoOutros' => $request->profissao,
        'Cidade' => $request->cidade_professor,
        'Estado' => $request->estado,
        'Raca' => $request->raca_cor,
        'Genero' => $request->genero,
        'id_nucleo' => $request->nucleo_id,
        'Disciplinas' => $request->disciplinas,
    ];

    $professor = App\Professores::create($professor_data);

    return view('seja-um-professor.index')->with([
        'success' => true,
    ]);

})->name('seja-um-professor.create');

// PROTECTED ROUTES
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
