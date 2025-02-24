<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password','status','id_kelas','no_induk','nisn','jenis_kelamin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getKelas()
  {
    return $this->belongsTo(Kelas::class, 'id_kelas','id');
}

  public function simpanGuru($request)
  {
    if ($request->nama == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong!";
    } elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong!";
    } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid!";
    } elseif ($request->password == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Password tidak boleh kosong!";
    } elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong!";
    } else {
      $cek_email = User::where('id', '!=', $request->id)->where('email', $request->email)->first();
      if ($cek_email != "") {
        return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email sudah terdaftar, silahkan ganti dengan yang lain!";
      } else {
        if ($request->id == 'N') {
          $query = new User;
          $query->password = bcrypt($request->password);
          if ($request->no_induk == "") {
            $query->no_induk = '-';
          } else {
            $query->no_induk = $request->no_induk;
          }
        } else {
          $query = User::where('id', $request->id)->first();
          if ($request->password != "") {
            $query->password = bcrypt($request->password);
          }
          $query->no_induk = $request->no_induk;
        }
        $query->nama = $request->nama;
        $query->email = $request->email;
        $query->jk = $request->jk;
        $query->status = "G";
        if ($query->save()) {
          return 'ok';
        }
      }
    }
  }

  public static function getDataUser()
  {
      $user = User::all();

      $user_filter = [];

      for ($i = 0; $i < $user->count(); $i++) {
          $user_filter[$i]['id_kelas'] = $user[$i]->id_kelas;
          $user_filter[$i]['nama'] = $user[$i]->nama;
          $user_filter[$i]['no_induk'] = $user[$i]->no_induk;
          $user_filter[$i]['nisn'] = $user[$i]->nisn;
          $user_filter[$i]['jenis_kelamin'] = $user[$i]->jenis_kelamin;
      }

      return $user_filter;
  }
}
