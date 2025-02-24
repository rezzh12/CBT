<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsoal extends Model
{
    protected $fillable = [
        'id_soal',
            'jenis',
            'soal',
            'audio',
            'pila',
            'pilb',
            'pilc',
            'pild',
            'pile',
            'kunci',
            'score',
            'id_user',
            'status',
            'sesi'
    ];
    public function checkJawab()
	{
        return $this->belongsTo(Jawab::class, 'id','no_soal_id')->where('id_user', Auth::user()->id);

	}

    public static function getDataSoal()
    {
        $detailSoal = Detailsoal::all();
        $detailSoal_filter = [];
  
        for ($i = 0; $i < $detailSoal->count(); $i++) {
            $detailSoal_filter[$i]['id_soal'] = $detailSoal[$i]->id_soal;
            $detailSoal_filter[$i]['soal'] = $detailSoal[$i]->soal;
            $detailSoal_filter[$i]['pila'] = $detailSoal[$i]->pila;
            $detailSoal_filter[$i]['pilb'] = $detailSoal[$i]->pilb;
            $detailSoal_filter[$i]['pilc'] = $detailSoal[$i]->pilc;
            $detailSoal_filter[$i]['pild'] = $detailSoal[$i]->pild;
            $detailSoal_filter[$i]['pile'] = $detailSoal[$i]->pile;
            $detailSoal_filter[$i]['kunci'] = $detailSoal[$i]->kunci;
            $detailSoal_filter[$i]['score'] = $detailSoal[$i]->score;
            ;
        }
  
        return $detailSoal_filter;
    }
  }
  
