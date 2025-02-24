<?php

namespace App\Imports;

use App\Models\Detailsoal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements WithHeadingRow, ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Detailsoal([
           'id_soal' =>$row['id_soal'],
            'jenis' => 1, 
            'soal' => '<p>'.$row['soal'].'</p>',
            'audio' => null,
            'pila' => '<p>'.$row['pila'].'</p>',
            'pilb' => '<p>'.$row['pilb'].'</p>',
            'pilc' => '<p>'.$row['pilc'].'</p>',
            'pild' => '<p>'.$row['pild'].'</p>',
            'pile' => '<p>'.$row['pile'].'</p>',
            'kunci' => $row['kunci'],
            'score' => $row['score'],
            'id_user' => 1,
            'status' => 'Y',
            'sesi' => null,
        ]);
    }
}
