<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model implements Auditable
{
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $casts = [
    'created_at' => 'date'
  ];

  protected $fillable = [
    'user_id',
    'nucleo_id',
    'name',
    'status',
  ];

  public function nucleo()
  {
    return $this->belongsTo('App\Nucleo');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
