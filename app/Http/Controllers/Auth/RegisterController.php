<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

use App\User;
use App\Aluno;
use App\Nucleo;
use App\Coordenadores;
use App\Http\Repository\HcaptchaRepository;
use App\Mail\EmailFormularioCoordenador;
use App\Mail\EmailFormularioEstudante;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->repository = new HcaptchaRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (in_array(config('app.env'), ['local', 'develop'])) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                //'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'min:11']
            ]);
        }

        $hcaptchaResponse = $data['h-captcha-response'] ?? null;

        if ($hcaptchaResponse && $this->repository->validate($hcaptchaResponse)) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                //'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'min:11']
            ]);
        }

        return Validator::make($data, [
            'hcaptcha' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      $remove = array("(", ")", "-", " ");
      $phone = intval(str_replace($remove, "", $data['phone']));
      $fundamental = isset($data['inputEnsFundamental']) ? json_encode($data['inputEnsFundamental']) : NULL;
      $medio = isset($data['inputEnsMedio']) ? json_encode($data['inputEnsMedio']) : NULL;

        /*
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
        */

        /*$user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone']
        ]);*/

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(md5($data['email'])),
            'role' => $data['role'],
            'phone' => $phone
        ]);

        $my_token = app('auth.password.broker')->createToken($user);

        $nucleoId = $data['inputNucleo'] ?? null;
        if ($nucleoId) {
          $myNucleo = Nucleo::find($nucleoId);
        } else {
          $myNucleo = Nucleo::where('permite_ambiente_virtual', 1)->where('Status', 1)->first();
          $nucleoId = $myNucleo->id;
        }
        $nomeNucleo = $myNucleo ? $myNucleo->NomeNucleo : null;

        Session::put('verified',$user->email_verified_at);

        $aluno = Aluno::create([
            'NomeAluno' => $user->name,
            'NomeSocial' => isset($data['NomeSocial']) ? $data['NomeSocial'] : NULL,
            'id_user' => $user->id,
            'Status' => 0,
            'FoneCelular' => $user->phone,
            'Escolaridade' => $data['inputEscolaridade'],
            'Email' => $data['email'],
            'id_nucleo' => $nucleoId,
            'NomeNucleo' => $nomeNucleo,
            'ListaEspera' => 'Sim',
            'Raca' => $data['inputRaca'],
            'Genero' => $data['inputGenero'],
            'concordaSexoDesignado' => isset($data['concordaSexoDesignado']) ? $data['concordaSexoDesignado'] : NULL,
            'Nascimento' => $data['inputNascimento'],
            'responsavelCuidadoOutraPessoa' => isset($data['responsavelCuidadoOutraPessoa']) ? $data['responsavelCuidadoOutraPessoa'] : NULL,
            'temFilhos' => $data['temFilhos'],
            'filhosQt' => $data['filhosQt'],
            /*'filhosIdade' => $data['filhosIdade'],*/
            'CEP' => $data['inputCEP'],
            'CEPProprio' => isset($data['inputCEPProprio']) ? $data['inputCEPProprio'] : NULL,
            'Endereco' => $data['inputEndereco'],
            'Numero' => $data['inputNumero'],
            'Bairro' => isset($data['inputBairro']) ? $data['inputBairro'] : NULL,
            'Cidade' => $data['inputCidade'],
            'Estado' => $data['inputEstado'],
            'Complemento' => $data['inputComplemento'],
            'EnsFundamental' => $fundamental,
            'PorcentagemBolsa' => isset($data['inputPorcentagemBolsa']) ? $data['inputPorcentagemBolsa'] : NULL,
            'EnsMedio' => $medio,
            'PorcentagemBolsaMedio' => isset($data['inputPorcentagemBolsaMedio']) ? $data['inputPorcentagemBolsaMedio'] : NULL,
            'Vestibular' => isset($data['inputVestibular']) ? $data['inputVestibular'] : NULL,
            'Enem' => isset($data['inputEnem']) ? $data['inputEnem'] : NULL,
            'OpcoesVestibular1' => isset($data['inputOpcoesVestibular1']) ? $data['inputOpcoesVestibular1'] : NULL,
            'OpcoesVestibular2' => isset($data['inputOpcoesVestibular2']) ? $data['inputOpcoesVestibular2'] : NULL,
            'VestibularOutraCidade' => isset($data['inputVestibularOutraCidade']) ? $data['inputVestibularOutraCidade'] : NULL,
            'ComoSoube' => isset($data['inputComoSoube']) ? $data['inputComoSoube'] : NULL,
            'ComoSoubeOutros' => isset($data['inputComoSoubeOutros']) ? $data['inputComoSoubeOutros'] : NULL,
            'localizacao_curso' => isset($data['localizacao_curso']) ? $data['localizacao_curso'] : NULL,
            'pessoa_com_deficiencia' => $data['pessoa_com_deficiencia'] ?? NULL,
            'povo_indigenas_id' => $data['povo_indigenas_id'] ?? NULL,
            'terra_indigenas_id' => $data['terra_indigenas_id'] ?? NULL,
        ]);

        // Envia e-mail
        // Busca coordenadores do núcleo
        $coordenadores = $myNucleo ? $myNucleo->coordenadores()->get() : collect();

        // Se não houver coordenadores, envia para o admin (id = 1)
        if ($coordenadores->isEmpty()) {
            $admin = User::find(1); // Administrador
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new EmailFormularioCoordenador([
                    'message' => 'Olá, administrador! Um novo estudante foi inserido (nenhum coordenador no núcleo).',
                    'aluno_nome' => $user->name,
                    'link_cadastro' => url('alunos/details/' . $aluno->id),
                ]));
            }
        } else {
            foreach ($coordenadores as $coordenador) {
                if ($coordenador && !empty($coordenador->Email)) {
                    Mail::to($coordenador->Email)->send(new EmailFormularioCoordenador([
                        'message' => 'Olá, coordenador! Um novo estudante foi inserido!',
                        'aluno_nome' => $user->name,
                        'link_cadastro' => url('alunos/details/' . $aluno->id),
                    ]));
                }
            }
        }

        Mail::to($data['email'])->send(new EmailFormularioEstudante([
          'message' => 'Olá, estudante! Seja bem-vindo.'
        ]));

        return User::find($user->id);
    }
}
