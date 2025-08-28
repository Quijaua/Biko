<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Professores;
use App\Nucleo;

class VoluntarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'coordenador' && $user->role !== 'administrador') {
            abort(403, 'Acesso não autorizado.');
        }

        // Filtra usuários do tipo 'professor' daquele núcleo
        $professores = Professores::orderBy('created_at', 'desc')->paginate(25);

        return view('voluntarios.novos', compact('professores'));
    }
}
