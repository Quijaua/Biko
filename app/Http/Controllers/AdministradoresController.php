<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdministradorRequest;
use App\User;

class AdministradoresController extends Controller
{
    public function index()
    {
        $administradores = User::where('role', 'administrador')->get();
        return view('administradores.index')->with('administradores', $administradores);
    }

    public function create()
    {
        return view('administradores.create');
    }

    public function store(StoreAdministradorRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'role' => 'administrador',
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador criado com sucesso!');
    }

    public function edit($id)
    {
        $administrador = User::find($id);
        return view('administradores.edit')->with('administrador', $administrador);
    }

    public function update(StoreAdministradorRequest $request, $id)
    {
        $administrador = User::find($id);
        $administrador->name = request('name');
        $administrador->email = request('email');
        $administrador->save();

        return redirect()->route('administradores.index')->with('success', 'Administrador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('administradores.index')->with('success', 'Administrador excluido com sucesso!');
    }
}
