<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisors extends Model
{
  use HasFactory;
  protected $table = "supervisors";
  protected $guarded = [];
  protected $primaryKey = 'user_id';

  public function campus()
  {
    return $this->belongsTo(Campus::class, 'campus_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
