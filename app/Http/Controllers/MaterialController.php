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

    if ( $user->role === 'administrador' ) {
      $nucleos = Nucleo::where('Status', 1)->get();
      $files = Material::withTrashed()->get();
    } elseif ( $user->role === 'coordenador' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->coordenador->id_nucleo)->first();
      $files = Material::where('status', 1)->where('nucleo_id', $user->coordenador->id_nucleo)->get();
    } elseif ( $user->role === 'professor' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->professor->id_nucleo)->first();
      $files = Material::where('status', 1)->where('nucleo_id', $user->professor->id_nucleo)->get();
    } else {
      $user = Auth::user();
      $nucleos = NULL;
      $files = Material::where('status', 1)->where('nucleo_id', $user->aluno->id_nucleo)->get();
    }

    return view('material.index')->with([
      'user' => $user,
      'nucleos' => $nucleos,
      'files' => $files
    ]);
  }

  public function create(Request $request)
  {
    $user_id = Auth::user()->id;
    $fileName = $request->file->getClientOriginalName();
    $request->file->move(public_path('uploads'), $fileName);

    if(
      !Schema::hasColumn('materials', 'file')
    ) {
      Schema::table('materials', function(Blueprint $table) {
        $table->string('file')->nullable();
      });
    }

    $stored_file = Material::create([
      'user_id' => $user_id,
      'nucleo_id' => $request->nucleo_id,
      'file' => $fileName,
      'status' => 1
    ]);

    return back();
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

  public function delete($id)
  {
    $file = Material::find($id);

    $file->update([
      'status' => 0
    ]);

    $file->delete($file);

    return back();
  }

  public function restore($id)
  {
    $file = Material::withTrashed()->find($id);
    $file->status = 1;
    $file->restore();

    return back();
  }

  public function search(Request $request)
  {
    $user = Auth::user();
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
      $nucleos = Nucleo::where('Status', 1)->get();
    }
    if ( $user->role === 'coordenador' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->coordenador->id_nucleo)->first();
    }
    if ( $user->role === 'professor' ) {
      $nucleos = Nucleo::where('Status', 1)->where('id', $user->professor->id_nucleo)->first();
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
}
