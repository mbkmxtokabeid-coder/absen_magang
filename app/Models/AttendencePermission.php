<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendencePermission extends Model
{
    use HasFactory;
    protected $table = "attendence_permissions";
    protected $guarded = [];
}
