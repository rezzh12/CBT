<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kelas extends Model
{
    protected $table = 'kelas';

    public function distribusisoal()
    {
        return $this->belongsTo(distribusisoal::class, 'id_kelas','id');
    }
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_user','id');
    }
    public function kelas()
    {
        	return $this->belongsTo(Kelas::class, 'id_kelas','id');
    }
    public function wali()
    {
        return $this->belongsTo(User::class, 'id_wali','id');
    }
    public function siswa()
    {
      return $this->hasMany(User::class, 'id_kelas', 'id')->where('status', 'S');
    }
  }

