<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
  protected $table = "profiles";
  use HasFactory;

  protected $primaryKey = 'user_id';

  protected $fillable = [
    'user_id',
    'birth_place',
    'birth_date',
    'telp_number',
    'phone_number',
    'whatsapp_number',
    'school_origin',
    'major',
    'semester',
    'address',
    'province',
    'region',
    'sub_district',
    'postal_code',
    'facebook_url',
    'twitter_url',
    'instagram_url',
    'youtube_url',
    'linkedin_url',
    'website_url',
    'supervisor_id',
  ];

  public function user()
  {
    return $this->hasOne(User::class);
  }
}
