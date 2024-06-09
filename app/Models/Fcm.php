<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fcm extends Model
{
  use HasFactory;
  public $table = "fcm";
  protected $primaryKey = 'fcm_token';
  public $keyType = "string";
  protected $guarded = [];
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
