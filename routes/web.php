<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', function () {
      return view('dashboard');
  });
});


// ROUTES FOR NUCLEOS MANAGEMENT
Route::get('nucleos', 'NucleoController@index')->middleware('permissions');
Route::get('nucleos/details/{id}', 'NucleoController@details')->middleware('permissions');
Route::get('nucleos/add', 'NucleoController@showForm')->middleware('permissions');
Route::post('nucleos/create', 'NucleoController@create')->middleware('permissions');
Route::get('nucleos/edit/{id}', 'NucleoController@edit')->middleware('permissions');
Route::post('nucleos/update/{id}', 'NucleoController@update')->middleware('permissions');
Route::get('nucleos/disable/{id}', 'NucleoController@disable')->middleware('permissions');
Route::get('nucleos/enable/{id}', 'NucleoController@enable')->middleware('permissions');
Route::any('nucleos/search', 'NucleoController@search')->middleware('permissions');
Route::get('nucleo/presences', 'NucleoController@presences_index')->name('nucleo/presences');
Route::get('nucleo/presences/new', 'NucleoController@presences_new')->name('nucleo/presences/new');
Route::post('nucleo/presences/create', 'NucleoController@presences_create')->name('nucleo/presences/create');
Route::get('nucleo/presences/destroy', 'NucleoController@presences_destroy')->name('nucleo/presences/destroy');

Route::get('nucleo/material', 'MaterialController@index')->name('nucleo.material');
Route::post('nucleo/material/create', 'MaterialController@create')->name('nucleo.material.create');
Route::get('nucleo/material/delete/{id}', 'MaterialController@delete')->name('nucleo.material.delete');
Route::get('nucleo/material/restore/{id}', 'MaterialController@restore')->name('nucleo.material.restore');

// ROUTES FOR ALUNOS MANAGEMENT
Route::get('alunos', 'AlunosController@index')->middleware('permissions');
Route::get('alunos/details/{id}', 'AlunosController@details')->middleware('permissions');
Route::get('alunos/add', 'AlunosController@showForm')->middleware('permissions');
Route::post('alunos/create', 'AlunosController@create')->middleware('permissions');
Route::get('alunos/edit/{id}', 'AlunosController@edit')->middleware('permissions');
Route::post('alunos/update/{id}', 'AlunosController@update')->middleware('permissions');
Route::get('alunos/disable/{id}', 'AlunosController@disable')->middleware('permissions');
Route::get('alunos/enable/{id}', 'AlunosController@enable')->middleware('permissions');
Route::any('alunos/search', 'AlunosController@search')->middleware('permissions')->name('alunos/search');
Route::any('alunos/nucleo/search', 'AlunosController@searchByNucleo')->middleware('permissions')->name('alunos/nucleo/search');
Route::any('api/alunos/nucleo/search', 'AlunosController@searchByNucleoAPI')->middleware('permissions')->name('alunos/nucleo/search.api');
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
Route::get('professores', 'ProfessoresController@index')->middleware('permissions');
Route::get('professores/details/{id}', 'ProfessoresController@details')->middleware('permissions');
Route::get('professores/export/', 'ProfessoresController@export')->name('professores/export/');
Route::get('professores/add', 'ProfessoresController@showForm')->middleware('permissions');
Route::post('professores/create', 'ProfessoresController@create')->middleware('permissions');
Route::get('professores/edit/{id}' , 'ProfessoresController@edit')->middleware('permissions');
Route::post('professores/update/{id}', 'ProfessoresController@update')->middleware('permissions');
Route::get('professores/disable/{id}', 'ProfessoresController@disable')->middleware('permissions');
Route::get('professores/enable/{id}', 'ProfessoresController@enable')->middleware('permissions');
Route::any('professores/search', 'ProfessoresController@search')->middleware('permissions')->name('professores/search');


// ROUTES FOR MESSAGE MANAGEMENT
Route::get('mensagens', 'MensagensController@index')->middleware('permissions')->name('messages.index');
Route::get('mensagens/removed', 'MensagensController@removed')->middleware('permissions')->name('messages.removed');
Route::get('mensagens/create', 'MensagensController@create')->middleware('permissions')->name('messages.create');
Route::post('mensagens/store', 'MensagensController@store')->middleware('permissions')->name('messages.store');
Route::get('mensagens/{mensagem}/show', 'MensagensController@show')->middleware('permissions')->name('messages.show');
Route::delete('mensagens/{mensagem}/destroy', 'MensagensController@destroy')->middleware('permissions')->name('messages.destroy');

// PROTECTED ROUTES
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
