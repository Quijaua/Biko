<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Session;
use Carbon\Carbon;
use DB;

use App\Http\Repository\HcaptchaRepository;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->repository = new HcaptchaRepository;
    }

    protected function validator(array $data)
    {
        if( $this->repository->validate($data['h-captcha-response']) ) {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);
          };
    
          return Validator::make($data, [
            'hcaptcha' => ['required'],
          ]);
    }

    public function login(Request $request)
    {
        $credentials = self::validator($request->all())->validate();

        $remember = $request->has('remember');
        $rememberDuration = 1440;

        if (Auth::attempt($credentials, $remember)) {
            if ($remember) {
                $request->session()->regenerate();
                $request->session()->put(Auth::getName(), Auth::user()->getAuthIdentifier());

                $cookie = cookie(
                    Auth::getRecallerName(),
                    Auth::user()->getAuthIdentifier().'|'.Auth::user()->getRememberToken().'|'.Auth::user()->getAuthPassword(),
                    $rememberDuration / 1440
                );

                return redirect()->intended('home')->withCookie($cookie);
            }

            $request->session()->regenerate();
            Session::put('role', Auth::user()->role);

            if (Auth::user()->role == 'aluno') {
                DB::table('alunos_acessos')->insert([
                    'aluno_id' => Auth::user()->aluno->id,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            }

            if (Auth::user()->role == 'psicologo') {
                return redirect()->intended('plantao-psicologico');
            }

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Usuário ou senha incorretos.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
