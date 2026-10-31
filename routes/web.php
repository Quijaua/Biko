<?php

use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\AlunoInfoFamiliaresController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\AmbienteVirtualController;
use App\Http\Controllers\AtendimentoPsicologicoController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Auth\FirstLoginController;
use App\Http\Controllers\CodigoPersonalizadoController;
use App\Http\Controllers\CoordenadoresController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\EadController;
use App\Http\Controllers\GeralController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MensagensController;
use App\Http\Controllers\NucleoController;
use App\Http\Controllers\NucleoProfessoresDisciplinasController;
use App\Http\Controllers\PlantaoPsicologicoController;
use App\Http\Controllers\ProfessoresController;
use App\Http\Controllers\PsicologosController;
use App\Http\Controllers\QuestionarioController;
use App\Http\Controllers\SupervisoraController;
use App\Http\Controllers\VoluntarioController;
use App\User;
use App\Nucleo;
use App\Mail\MessageOtpLogin;
use App\Mail\EmailFormularioCoordenador;
use App\Mail\EmailFormularioSejaUmProfessor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Carregadas por bootstrap/app.php (withRouting) dentro do grupo "web".
|
*/
// Rota inicial
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect('/login');
});


Route::middleware(['auth', 'restrict.aluno', 'restrict.professor'])->group(function () {

  Route::get('/dashboard', function () {
      return view('dashboard');
  })->name('dashboard');

  Route::get('/dashboard/cadastros-json/{dias}', function ($dias) {
    if ($dias === 'all') {
        $dados = DB::select("
            SELECT COUNT(*) as count, DATE_FORMAT(created_at,'%Y-%m-%d') as date 
            FROM users 
            GROUP BY date
            ORDER BY date ASC
        ");
    } else {
        $dias = intval($dias);
        $dados = DB::select("
            SELECT COUNT(*) as count, DATE_FORMAT(created_at,'%Y-%m-%d') as date 
            FROM users 
            WHERE created_at >= CURDATE() - INTERVAL ? DAY 
            GROUP BY date
            ORDER BY date ASC
        ", [$dias]);
    }

    return response()->json($dados);
  });

});

Route::middleware(['auth', 'restrict.professor'])->group(function () {
  Route::post('change_default_password', [FirstLoginController::class, 'changePassword'])->name('change_default_password');
  Route::get('default_username', [FirstLoginController::class, 'username'])->name('default_username');
  Route::post('change_default_username', [FirstLoginController::class, 'changeUsername'])->name('change_default_username');
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
    $email = request()->email;
    $redirect = request()->redirect;
    $user = \App\User::where('email', $email)->first();

    if (!$user) {
        return back()->with('error', 'Email não cadastrado.');
    }

    $otp_hash = \Illuminate\Support\Str::random(40); // melhor que Hash::make por ser persistente
    $user->otp_hash = $otp_hash;
    $user->save();

    $url = route('otp-verify', [
        'email' => $user->email,
        'token' => $otp_hash,
        'redirect' => $redirect,
    ]);

    \Mail::to($user->email)->send(new \App\Mail\MessageOtpLogin($user->email, $url, $user));

    return back()->with('success', 'Quase lá! Confira seu e-mail e clique no link que enviamos para entrar no sistema.');
})->name('otp-login');

Route::get('otp-verify', function () {
    $email = request()->email;
    $otp_hash = request()->token;
    $redirect = request()->redirect;

    $user = \App\User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Usuário não encontrado.');
    }

    if (!$otp_hash || $user->otp_hash !== $otp_hash) {
        return redirect()->route('login')->with('error', 'Token inválido.');
    }

    \Auth::login($user);
    $user->otp_hash = null;
    $user->save();

    if ($redirect && in_array($redirect, ['plantao-psicologico']) && $user->role == 'aluno') {
        return redirect('/plantao-psicologico');
    }

    if ($redirect && in_array($redirect, ['plantao-psicologico']) || $user->role == 'psicologo') {
        return redirect()->route('painel.supervisora');
    }

    if ($redirect && in_array($redirect, ['aula-programa-esperanca-garcia'])) {
        return redirect()->route('ead.register');
    }

    return redirect()->route('home');
})->name('otp-verify');

Route::get('/switch-role/{role}', function ($role) {
    $user = Auth::user();

    $coordenador = \App\Coordenadores::where('id_user', $user->id)->first();

    if ($user->getRealRole() === 'coordenador') {
        if ($role === 'professor' && (!$coordenador || !$coordenador->isProfessor)) {
            return redirect()->back()->with('error', 'Este coordenador não possui perfil de professor.');
        }

        if (in_array($role, ['coordenador', 'professor'])) {
            session(['active_role' => $role]);
            Session::put('role', $role);
        }
    }

    return redirect()->back();
})->name('switch.role');

//GOOGLE
Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/oauth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

// ROUTES FOR NUCLEOS MANAGEMENT
Route::post('nucleos/importar_alunos/{id}', [AlunosController::class, 'importar'])->middleware('permissions')->name('alunos.importar');
Route::get('nucleos', [NucleoController::class, 'index'])->middleware('permissions');
Route::get('nucleos/details/{id}', [NucleoController::class, 'details'])->middleware('permissions');
Route::get('nucleos/add', [NucleoController::class, 'showForm'])->middleware('permissions');
Route::get("nucleo/estados/{estado}", function(Request $request, $estado) {
    $query = DB::table('nucleos')->where('status', 1);
    if($estado != 'all') {
      $query->where('estado', $estado);
    }
    return response()->json($query->get());
});
Route::post('nucleos/create', [NucleoController::class, 'create'])->middleware('permissions');
Route::get('nucleos/edit/{id}', [NucleoController::class, 'edit'])->middleware('permissions');
Route::post('nucleos/update/{id}', [NucleoController::class, 'update'])->middleware('permissions');
Route::get('nucleos/disable/{id}', [NucleoController::class, 'disable'])->middleware('permissions');
Route::get('nucleos/enable/{id}', [NucleoController::class, 'enable'])->middleware('permissions');
Route::delete('nucleos/delete/{id}', [NucleoController::class, 'destroy'])->middleware('permissions');
Route::any('nucleos/search', [NucleoController::class, 'search']);

Route::group(['prefix' => 'nucleo/presences', 'middleware' => ['auth', 'restrict.professor']], function () {
    Route::get('/', [NucleoController::class, 'presences_index'])->name('nucleo/presences');
    Route::get('/new', [NucleoController::class, 'presences_new'])->name('nucleo/presences/new');
    Route::post('/create', [NucleoController::class, 'presences_create'])->name('nucleo/presences/create');
    Route::get('/destroy', [NucleoController::class, 'presences_destroy'])->name('nucleo/presences/destroy');
    Route::any('/search', [NucleoController::class, 'search_presences']);
});

Route::get('nucleo/material', [MaterialController::class, 'index'])->middleware('auth')->name('nucleo.material');
Route::post('nucleo/material/create', [MaterialController::class, 'create'])->middleware('auth')->name('nucleo.material.create');
Route::get('nucleo/material/inactive/{id}', [MaterialController::class, 'inactive'])->middleware('auth')->name('nucleo.material.inactive');
Route::get('nucleo/material/restore/{id}', [MaterialController::class, 'restore'])->middleware('auth')->name('nucleo.material.restore');
Route::delete('nucleo/material/delete/{id}', [MaterialController::class, 'delete'])->middleware('auth')->name('nucleo.material.delete');
Route::get('nucleo/material/search', [MaterialController::class, 'search']);
Route::put('nucleo/material/edit/{id}', [MaterialController::class, 'edit'])->middleware(['auth'/*, 'permissions'*/])->name('material.edit');
Route::get('nucleo/material/download/{id}', [MaterialController::class, 'download'])->middleware(['auth', 'permissions'])->name('material.download');

Route::post('nucleo/professores-disciplinas/create', [NucleoProfessoresDisciplinasController::class, 'create'])->name('professores-disciplinas.create');
Route::put('nucleo/professores-disciplinas/update', [NucleoProfessoresDisciplinasController::class, 'update'])->name('professores-disciplinas.update');
Route::post('nucleo/professores-disciplinas/delete', [NucleoProfessoresDisciplinasController::class, 'delete'])->name('professores-disciplinas.delete');

// ROUTES FOR ALUNOS MANAGEMENT
Route::get('alunos', [AlunosController::class, 'index'])->name('alunos')->middleware('permissions');
Route::get('alunos/details/{id}', [AlunosController::class, 'details'])->middleware('permissions');
Route::get('alunos/add', [AlunosController::class, 'showForm'])->middleware('permissions');
Route::post('alunos/create', [AlunosController::class, 'create'])->middleware('permissions');
Route::get('alunos/edit/{id}', [AlunosController::class, 'edit'])->middleware('permissions');
Route::post('alunos/update/{id}', [AlunosController::class, 'update'])->middleware('permissions');
Route::get('alunos/disable/{id}', [AlunosController::class, 'disable'])->middleware('permissions');
Route::get('alunos/enable/{id}', [AlunosController::class, 'enable'])->middleware('permissions');
Route::any('alunos/search', [AlunosController::class, 'search'])->name('alunos/search');
Route::any('alunos/nucleo/search', [AlunosController::class, 'searchByNucleo'])->name('alunos/nucleo/search');
Route::any('api/alunos/nucleo/search', [AlunosController::class, 'searchByNucleoAPI'])->name('alunos/nucleo/search.api');
Route::post('alunos/familiares/add', [AlunoInfoFamiliaresController::class, 'add'])->name('alunos/familiares/add');
Route::post('alunos/familiares/update/{id}', [AlunoInfoFamiliaresController::class, 'update'])->name('alunos/familiares/update');
Route::post('alunos/familiares/delete/{id}', [AlunoInfoFamiliaresController::class, 'delete'])->name('alunos/familiares/delete');
Route::get('alunos/export/', [AlunosController::class, 'export'])->name('alunos/export/');
Route::get('alunos/log/{id}', [AlunosController::class, 'logActionView'])->name('alunos/log');
Route::delete('alunos/delete/{id}', [AlunosController::class, 'delete'])->name('alunos/delete');
Route::post('alunos/acompanhamento/{id}', [AlunosController::class, 'store'])->middleware('permissions');

// ROUTES FOR COORDENADORES MANAGEMENT
Route::get('coordenadores', [CoordenadoresController::class, 'index'])->middleware('permissions');
Route::get('coordenadores/details/{id}', [CoordenadoresController::class, 'details'])->middleware('permissions');
Route::get('coordenadores/export/', [CoordenadoresController::class, 'export'])->name('coordenadores/export/');
Route::get('coordenadores/add', [CoordenadoresController::class, 'showForm'])/*->middleware('permissions')*/;
Route::post('coordenadores/create', [CoordenadoresController::class, 'create'])->middleware('permissions');
Route::get('coordenadores/edit/{id}', [CoordenadoresController::class, 'edit'])->middleware('permissions');
Route::post('coordenadores/update/{id}', [CoordenadoresController::class, 'update'])->middleware('permissions');
Route::get('coordenadores/disable/{id}', [CoordenadoresController::class, 'disable'])->middleware('permissions');
Route::get('coordenadores/enable/{id}', [CoordenadoresController::class, 'enable'])/*->middleware('permissions')*/;
Route::any('coordenadores/search', [CoordenadoresController::class, 'search'])->name('coordenadores/search');

// ROUTES FOR PROFESSORES MANAGEMENT
Route::get('professores', [ProfessoresController::class, 'index'])->middleware('permissions')->name('professores.index');
Route::get('professores/details/{id}', [ProfessoresController::class, 'details'])->middleware('permissions');
Route::post('professores/import', [ProfessoresController::class, 'import'])->name('professores.import');
Route::get('professores/export/', [ProfessoresController::class, 'export'])->name('professores/export/');
Route::get('professores/add', [ProfessoresController::class, 'showForm'])->middleware('permissions');
Route::post('professores/create', [ProfessoresController::class, 'create'])->middleware('permissions');
Route::get('professores/edit/{id}' , [ProfessoresController::class, 'edit'])->middleware('permissions');
Route::post('professores/update/{id}', [ProfessoresController::class, 'update'])->middleware('permissions');
Route::get('professores/disable/{id}', [ProfessoresController::class, 'disable'])->middleware('permissions');
Route::get('professores/enable/{id}', [ProfessoresController::class, 'enable'])->middleware('permissions');
Route::any('professores/search', [ProfessoresController::class, 'search'])->name('professores/search');

// ROUTES FOR PSICOLOGOS MANAGEMENT
Route::get('psicologos', [PsicologosController::class, 'index'])->middleware('permissions')->name('psicologos.psicologos');
Route::get('psicologos/details/{id}', [PsicologosController::class, 'details'])->middleware('permissions');
Route::get('psicologos/add', [PsicologosController::class, 'show'])->middleware('permissions');
Route::post('psicologos/create', [PsicologosController::class, 'create'])->middleware('permissions');
Route::get('psicologos/edit/{id}' , [PsicologosController::class, 'edit'])->middleware('permissions');
Route::post('psicologos/update/{id}', [PsicologosController::class, 'update'])->middleware('permissions');
Route::any('psicologos/search', [PsicologosController::class, 'search'])->name('psicologos/search');

// ROUTES FOR MESSAGE MANAGEMENT
Route::get('mensagens', [MensagensController::class, 'index'])->middleware('permissions')->name('messages.index');
Route::get('mensagens/removed', [MensagensController::class, 'removed'])->middleware('permissions')->name('messages.removed');
Route::get('mensagens/create', [MensagensController::class, 'create'])->middleware('permissions')->name('messages.create');
Route::post('mensagens/store', [MensagensController::class, 'store'])->middleware('permissions')->name('messages.store');
Route::get('mensagens/{mensagem}/show', [MensagensController::class, 'show'])->middleware('auth')->name('messages.show');
Route::delete('mensagens/{mensagem}/destroy', [MensagensController::class, 'destroy'])->middleware('permissions')->name('messages.destroy');

// ROUTES FOR DISCIPLINAS
Route::group(['prefix' => 'disciplinas'], function () {
    Route::get('/', [DisciplinaController::class, 'index'])->middleware('auth')->name('disciplinas.index');
});
Route::resource('/disciplinas', DisciplinaController::class)->middleware('auth')->except(['index']);

// ROUTES FOR AMBIENTE VIRTUAL
Route::group(['prefix' => 'ambiente-virtual'], function () {
    Route::get('/', [AmbienteVirtualController::class, 'index'])->middleware('auth')->name('ambiente-virtual.index');
    Route::post('comentarios/adicionar/{id}', [AmbienteVirtualController::class, 'comentar'])->middleware('auth')->name('ambiente-virtual.comentar');
    Route::post('comentarios/responder', [AmbienteVirtualController::class, 'responder'])->middleware('auth')->name('ambiente-virtual.responder-comentario');
    Route::post('notas/adicionar/{id}', [AmbienteVirtualController::class, 'anotar'])->middleware('auth')->name('ambiente-virtual.anotar');
    Route::post('assistido/marcar', [AmbienteVirtualController::class, 'marcarAssistido'])->middleware('auth')->name('ambiente-virtual.marcar-assistido');
    Route::post('assistido/desmarcar', [AmbienteVirtualController::class, 'desmarcarAssistido'])->middleware('auth')->name('ambiente-virtual.desmarcar-assistido');
    Route::get('export-watched/{id}', [AmbienteVirtualController::class, 'exportWatched'])->middleware('auth')->name('ambiente-virtual.export-watched');
    Route::any('search', [AmbienteVirtualController::class, 'search'])->name('ambiente-virtual/search');
    Route::get('questionario', [QuestionarioController::class, 'questionario'])->middleware('auth')->name('ambiente-virtual.questionario');
    Route::get('questionario/create/{id}', [QuestionarioController::class, 'create'])->middleware('auth')->name('ambiente-virtual.questionario.create');
    Route::post('questionario/store', [QuestionarioController::class, 'store'])->middleware('auth')->name('ambiente-virtual.questionario.store');
    Route::get('questionario/{id}/edit', [QuestionarioController::class, 'edit'])->middleware('auth')->name('ambiente-virtual.questionario.edit');
    Route::put('questionario/{id}/update', [QuestionarioController::class, 'update'])->middleware('auth')->name('ambiente-virtual.questionario.update');
    Route::delete('questionario/{id}/destroy', [QuestionarioController::class, 'destroy'])->middleware('auth')->name('ambiente-virtual.questionario.destroy');
    Route::post('questionario/responder', [QuestionarioController::class, 'responder'])->middleware('auth')->name('ambiente-virtual.questionario.responder');
});
Route::resource('/ambiente-virtual', AmbienteVirtualController::class)->middleware('auth')->except(['index']);

// ROUTES FOR EAD
Route::group(['prefix' => 'ead', 'middleware' => ['auth', 'restrict.aluno', 'restrict.professor']], function () {
    Route::get('/', [EadController::class, 'index'])->name('ead.index');
    Route::get('/details/{id}', [EadController::class, 'details'])->name('ead.details');
    Route::get('/create', [EadController::class, 'create'])->name('ead.create');
    Route::post('/store', [EadController::class, 'store'])->name('ead.store');
    Route::get('/edit/{id}', [EadController::class, 'edit'])->name('ead.edit');
    Route::post('/update/{id}', [EadController::class, 'update'])->name('ead.update');
    Route::delete('/destroy/{id}', [EadController::class, 'destroy'])->name('ead.destroy');
    Route::get('/remove_material', [EadController::class, 'remove_material'])->name('ead.remove_material');
    Route::post('/register/store', [EadController::class, 'registerStore'])->name('ead.register-store');
    Route::get('/participantes/{id}', [EadController::class, 'participantes'])->name('ead.participantes');
    Route::get('/participacao', [EadController::class, 'participacao'])->name('ead.participacao');
    Route::any('/upload', [EadController::class, 'upload'])->name('ead.upload');
});
Route::get('/aula-programa-esperanca-garcia', [EadController::class, 'register'])->name('ead.register');

// ROUTES FOR ATENDIMENTO PSICOLOGICO
Route::get('atendimento-psicologico', [AtendimentoPsicologicoController::class, 'index'])->middleware('auth')->name('atendimento-psicologico.index');
Route::get('atendimento-psicologico/create', [AtendimentoPsicologicoController::class, 'create'])->middleware('permissions')->name('atendimento-psicologico.create');
Route::post('atendimento-psicologico/store', [AtendimentoPsicologicoController::class, 'store'])->middleware('permissions')->name('atendimento-psicologico.store');
Route::get('atendimento-psicologico/edit/{id}' , [AtendimentoPsicologicoController::class, 'edit'])->middleware('permissions')->name('atendimento-psicologico.edit');
Route::post('atendimento-psicologico/update/{id}' , [AtendimentoPsicologicoController::class, 'update'])->middleware('permissions')->name('atendimento-psicologico.update');
Route::get('atendimento-psicologico/download/{id}', [AtendimentoPsicologicoController::class, 'download'])->middleware('permissions')->name('atendimento-psicologico.download');
Route::get('atendimento-psicologico/details/{id}', [AtendimentoPsicologicoController::class, 'details'])->middleware('permissions')->name('atendimento-psicologico.details');
Route::any('atendimento-psicologico/estudante/{id}', [AtendimentoPsicologicoController::class, 'showByEstudante'])->middleware('permissions')->name('atendimento-psicologico.estudante');
Route::any('atendimento-psicologico/search', [AtendimentoPsicologicoController::class, 'search'])->name('atendimento-psicologico/search');

// ROUTES FOR PLANTAO PSICOLOGICO
Route::middleware(['restrict.professor'])->group(function () {
    Route::get('/plantao-psicologico', [PlantaoPsicologicoController::class, 'index'])->name('plantao-psicologico.index');
    Route::get('/plantao-psicologico/add', [PlantaoPsicologicoController::class, 'show'])->name('plantao-psicologico.show');
    Route::post('/plantao-psicologico/store', [PlantaoPsicologicoController::class, 'store'])->name('plantao-psicologico.store');
    Route::get('/plantao-psicologico/edit/{id}', [PlantaoPsicologicoController::class, 'edit'])->name('plantao-psicologico.edit');
    Route::post('/plantao-psicologico/update/{id}', [PlantaoPsicologicoController::class, 'update'])->name('plantao-psicologico.update');
    Route::post('/plantao-psicologico/agendar', [PlantaoPsicologicoController::class, 'agendar'])->name('plantao-psicologico.agendar');

    Route::get('/api/psicologos/{id}/datas', [PlantaoPsicologicoController::class, 'datasDisponiveis']);
    Route::get('/api/psicologos/{id}/horarios', [PlantaoPsicologicoController::class, 'horariosDisponiveis']);
});

// ROUTES FOR PAINEL SUPERVISORA
Route::get('/apoio-emocional', [SupervisoraController::class, 'index'])->middleware('permissions')->name('painel.supervisora');

// ROUTES FOR AUDITORIA
Route::group(['prefix' => 'auditoria', 'middleware' => ['auth', 'restrict.professor']], function () {
    Route::get('/', [AuditoriaController::class, 'index'])->middleware('auth')->name('auditoria.index');
});

// ROUTES FOR CONFIGURACOES GERAL
Route::group(['prefix' => 'geral'], function () {
    Route::get('/', [GeralController::class, 'index'])->middleware('auth')->name('geral.index');
    Route::post('/update', [GeralController::class, 'update'])->middleware('auth')->name('geral.update');
});

// ROUTES FOR CODIGOS PERSONALIZADOS
Route::group(['prefix' => 'codigo-personalizado'], function () {
    Route::get('/', [CodigoPersonalizadoController::class, 'index'])->middleware('auth')->name('codigo-personalizado.index');
    Route::post('/update', [CodigoPersonalizadoController::class, 'update'])->middleware('auth')->name('codigo-personalizado.update');
});

// SEJA UM PROFESSOR
Route::get('/seja-um-professor', function () {
    return view('seja-um-professor.index');
});

Route::post('/verifica-email-professor', function (Illuminate\Http\Request $request) {
    $existe = App\User::where('email', $request->email)->exists();

    return response()->json(['existe' => $existe]);
});

Route::post('/seja-um-professor', function (Request $request) {

    $user_data = [
        'name' => $request->nome_social,
        'email' => $request->email,
        // Senha inicial = e-mail (mesmo padrão da API de cadastro), agora com hash.
        'password' => Hash::make($request->email),
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
        'povo_indigenas_id' => $request->povo_indigenas_id,
        'terra_indigenas_id' => $request->terra_indigenas_id,
        'Disciplinas' => $request->disciplinas,
    ];

    $professor = App\Professores::create($professor_data);

    // RECUPERA OS COORDENADORES DO NUCLEO SELECIONADO E ENVIA EMAIL
    $myNucleo = Nucleo::find($request->nucleo_id);
    $coordenadores = $myNucleo->coordenadores()->get();

    foreach($coordenadores as $coordenador) {
        if($coordenador['Email']) {
        Mail::to($coordenador['Email'])->send(new EmailFormularioCoordenador([
            'message' => 'Olá, coordenador! Um novo professor foi inserido!',
            'professor_name' => $professor->NomeProfessor,
            'link_cadastro' => url('professores/details/' . $professor->id),
        ]));
        }
    }
    return view('seja-um-professor.index')->with([
        'success' => true,
    ]);

})->name('seja-um-professor.create');

Route::get('/novos-voluntarios', [VoluntarioController::class, 'index'])->name('novos-voluntarios');

// ROUTES FOR ADMINISTRADORES MANAGEMENT
Route::group(['prefix' => 'administradores'], function () {
    Route::get('/', [AdministradoresController::class, 'index'])->middleware('auth')->name('administradores.index');
    Route::get('/create', [AdministradoresController::class, 'create'])->middleware('auth')->name('administradores.create');
    Route::post('/store', [AdministradoresController::class, 'store'])->middleware('auth')->name('administradores.store');
    Route::get('/edit/{id}', [AdministradoresController::class, 'edit'])->middleware('auth')->name('administradores.edit');
    Route::post('/update/{id}', [AdministradoresController::class, 'update'])->middleware('auth')->name('administradores.update');
    Route::delete('/destroy/{id}', [AdministradoresController::class, 'destroy'])->middleware('auth')->name('administradores.destroy');
});

// PROTECTED ROUTES
Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');
