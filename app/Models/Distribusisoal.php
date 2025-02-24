<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusisoal extends Model
{ public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal','id');

    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas','id');

    }
    public function jawabUser()
    {
        return $this->belongsTo(Jawab::class, 'id_soal','id_soal');

    }
  }