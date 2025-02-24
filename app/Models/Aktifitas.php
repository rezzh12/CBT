<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    protected $table = "aktifitas";

  public function dataAktifitasUser()
  {
  	return $this->belongsTo(User::class, 'id_user','id');
  	// return $this->belongsTo('App\Models\Materi', 'materi');
  }
}
