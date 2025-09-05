<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Aluno;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $cpf = Aluno::where('id_user', $user->id)->pluck('CPF');

        if($user->role === 'aluno'){
          if($cpf[0] === null){
            Session::put('cpf', 'null');
          }else{
            Session::put('cpf', 'OK');
          }
        }

        Session::put('role', $user->role);
        Session::put('verified', $user->email_verified_at);

        if ($user->role === 'coordenador') {
          $nucleos = $user->coordenador?->nucleos()->get() ?? DB::table('nucleos')->get();
        } else {
          $nucleos = DB::table('nucleos')->get();
        }

        if ($user->first_login) {
            return view('first_login.change_password');
        };

        return view('home')->with([
          'user' => $user,
          'nucleos' => $nucleos,
        ]);
    }
}
