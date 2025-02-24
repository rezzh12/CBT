<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawab extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');

    }
    public function detailSoal()
    {
        return $this->belongsTo(DetailSoal::class, 'no_soal_id','id');
    }
  }
