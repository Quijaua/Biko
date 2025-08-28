<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

use App\Nucleo;
use App\Material;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Usuário não autenticado.');
    }

    if ($user->role === 'professor') {
      $status = \DB::table('professores')->where('id_user', Auth::id())->value('status');

      if (!$status) {
        abort(403, 'Ops! Seu perfil precisa estar ativo para acessar esta página.');
      }
    }

    if ( $user->role === 'administrador' ) {
      $nucleos = Nucleo::where('Status', 1)->paginate(25);
      $files = Material::paginate(25);
    } elseif ( $user->role === 'coordenador' ) {
//      $coordenadorNucleos = $user->coordenador->nucleos()->pluck('nucleos.id')->toArray();
      $coordenadorNucleos = $user->coordenador?->nucleos()->pluck('nucleos.id')->toArray() ?? [1];
      $nucleos = Nucleo::where('Status', 1)->whereIn('id', $coordenadorNucleos)->get();
      $files = Material::where('status', 1)->whereIn('nucleo_id', $coordenadorNucleos)->paginate(25);
    } elseif ( $user->role === 'professor' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->professor->id_nucleo)->first();
      $files = Material::where('status', 1)->where('nucleo_id', $user->professor->id_nucleo)->paginate(25);
    } else {
      $user = Auth::user();
      $nucleos = NULL;
      $files = Material::where('status', 1)->where('nucleo_id', $user->aluno->id_nucleo)->paginate(25);
    }

    return view('material.index')->with([
      'user' => $user,
      'nucleos' => $nucleos,
      'files' => $files
    ]);
  }

  public function create(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Usuário não autenticado.');
    }

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
      $file->move(public_path('uploads'), $fileName);

      $stored_file = Material::create([
        'user_id' => $user->id,
        'nucleo_id' => $request->nucleo_id,
        'name' => $request->title,
        'file' => $fileName,
        'status' => 1
      ]);

      return back()->with([
        'success' => "DADOS SALVOS COM SUCESSO."
      ]);
    }

    return back()->with('error', 'Nenhum arquivo foi enviado.');
  }

  public function edit($id, Request $request) {
    $material = Material::find($id);
    if(
      !Schema::hasColumn('materials', 'file')
    ) {
      Schema::table('materials', function(Blueprint $table) {
        $table->string('file')->nullable();
      });
      $material->file = $material->name;
    }

    if(!$material->file) {
      $material->file = $material->name;
    }

    $material->name = $request->input('title');
    $material->save();
    return redirect('/nucleo/material')->with([
      'success' => "DADOS SALVOS COM SUCESSO."
    ]);
  }

  public function inactive($id)
  {
    $file = Material::find($id);

    if (!$file) {
      return redirect()->route('nucleo.material')->with('error', 'Material não encontrado.');
    }

    $file->update([
      'status' => 0
    ]);

    return redirect()->route('nucleo.material')->with('success', 'Material desativado com sucesso.');
  }

  public function restore($id)
  {
    $material = Material::findOrFail($id);

    $material->update(['status' => 1]);

    return redirect()->route('nucleo.material')->with('success', 'Material restaurado com sucesso.');
  }

  public function delete($id)
  {
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Usuário não autenticado.');
    }
  
    $file = Material::find($id);
    if (!$file) {
      return redirect()->route('nucleo.material')->with('error', 'Material não encontrado.');
    }

    if ($user->role == 'professor' && $file->user_id !== $user->id) {
      abort(403, 'Ops! Só é possível excluir materiais que você criou');
    }

    $filePath = public_path('uploads/' . $file->file);

    if (!empty($file->file) && file_exists($filePath)) {
      unlink($filePath);
    }

    $file->delete();

    return redirect()->route('nucleo.material')->with('success', 'Material e arquivo excluídos com sucesso.');
  }

  public function search(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Usuário não autenticado.');
    }

    $params = self::getParams($request);

    $files = DB::table('materials')
      ->when($params['inputQuery'], function ($query) use ($params) {
          return $query->where('materials.name', 'LIKE', '%' . $params['inputQuery'] . '%');
      })
      ->when($params['status'], function ($query) use ($params) {
          return $query->where('materials.status', '=', $params['status'] === 'ativo' ? 1 : 0);
      })
      ->when($params['nucleo'], function ($query) use ($params) {
          return $query->where('materials.nucleo_id', '=', $params['nucleo']);
      })
      ->paginate(25);

    if ( $user->role === 'administrador' ) {
      $nucleos = Nucleo::where('Status', 1)->paginate(25);
    }
    if ( $user->role === 'coordenador' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->coordenador->id_nucleo)->first();
    }
    if ( $user->role === 'professor' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->professor->id_nucleo)->first();
    }
    if ( $user->role === 'aluno' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->aluno->id_nucleo)->first();
    }

    return view('material.index')->with([
      'user' => $user,
      'files' => $files,
      'nucleos' => $nucleos,
    ]);
  }

  private static function getParams($request)
  {
    return [
      'inputQuery' => $request->input('inputQuery'),
      'status' => $request->input('status'),
      'nucleo' => $request->input('nucleo'),
    ];
  }

  public function download($id)
  {
    $material = Material::findOrFail($id);
    $filePath = public_path('uploads/' . $material->file);

    if (empty($material->file) || !file_exists($filePath)) {
      abort(404, 'Arquivo não encontrado.');
    }

    return response()->download($filePath);
  }
}
