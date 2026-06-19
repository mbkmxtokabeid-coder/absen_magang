<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jurusan';
    protected $primaryKey = 'jurusanId';
    protected $guarded = [];
    // protected $dates = ['']

    function user()
    {
        return $this->hasMany(User::class);
    }
}
