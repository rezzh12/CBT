<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    public function dataDateri()
    {
        return $this->hasOne(Materi::class,'id','materi');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');
    }
    public function jawab()
    {
        return $this->belongsTo(Jawab::class, 'id_soal','id');

    }
    public function detailSoal()
    {
        return $this->belongsTo(DetailSoal::class, 'id_soal','id');
    }
  
    public function detail_soal_essays()
    {
      return $this->hasMany(DetailSoalEssay::class, 'id_soal', 'id');
    }
  }
  
