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
use App\Http\Repository\HcaptchaRepository;

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

      if( $this->repository->validate($data['h-captcha-response']) ) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:11']
        ]);
      };

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

        $nucleo = $data['inputNucleo'];
        $myNucleo = Nucleo::find($nucleo);
        Session::put('verified',$user->email_verified_at);

        $aluno = Aluno::create([
            'NomeAluno' => $user->name,
            'NomeSocial' => $data['NomeSocial'],
            'id_user' => $user->id,
            'Status' => 0,
            'FoneCelular' => $user->phone,
            'Escolaridade' => $data['inputEscolaridade'],
            'Email' => $data['email'],
            'id_nucleo' => $nucleo,
            'NomeNucleo' => $myNucleo->NomeNucleo,
            'ListaEspera' => 'Sim',
            'Raca' => $data['inputRaca'],
            'Genero' => $data['inputGenero'],
            'concordaSexoDesignado' => isset($data['concordaSexoDesignado']) ? $data['concordaSexoDesignado'] : NULL,
            'Nascimento' => $data['inputNascimento'],
            'responsavelCuidadoOutraPessoa' => $data['responsavelCuidadoOutraPessoa'],
            'temFilhos' => $data['temFilhos'],
            'filhosQt' => $data['filhosQt'],
            /*'filhosIdade' => $data['filhosIdade'],*/
            'CEP' => $data['inputCEP'],
            'CEPProprio' => $data['inputCEPProprio'],
            'Endereco' => $data['inputEndereco'],
            'Numero' => $data['inputNumero'],
            'Bairro' => $data['inputBairro'],
            'Cidade' => $data['inputCidade'],
            'Estado' => $data['inputEstado'],
            'Complemento' => $data['inputComplemento'],
            'EnsFundamental' => $fundamental,
            'PorcentagemBolsa' => $data['inputPorcentagemBolsa'],
            'EnsMedio' => $medio,
            'PorcentagemBolsaMedio' => $data['inputPorcentagemBolsaMedio'],
            'Vestibular' => isset($data['inputVestibular']) ? $data['inputVestibular'] : NULL,
            'Enem' => isset($data['inputEnem']) ? $data['inputEnem'] : NULL,
            'OpcoesVestibular1' => $data['inputOpcoesVestibular1'],
            'OpcoesVestibular2' => $data['inputOpcoesVestibular2'],
            'VestibularOutraCidade' => $data['inputVestibularOutraCidade'],
            'ComoSoube' => $data['inputComoSoube'],
            'ComoSoubeOutros' => $data['inputComoSoubeOutros'],
            'localizacao_curso' => $data['localizacao_curso'],
            'pessoa_com_deficiencia' => $data['pessoa_com_deficiencia'],
        ]);

        return User::find($user->id);
    }
}
