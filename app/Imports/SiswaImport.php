<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements WithHeadingRow, ToModel
{
    /**
     * Mengonversi baris data dari Excel menjadi model.
     */
    public function model(array $row)
    {
        return new User([
           'id_kelas' => $row['id_kelas'],
            'nama' => $row['nama'], 
            'no_induk' => $row['no_induk'],
            'nisn' => $row['nisn'],
            'jk' => $row['jenis_kelamin'],
            'status' => 'S',
            'status_sekolah' => 'Y',
            'email' => trim(strtolower($row['no_induk'])) . '@conelo.com',
            'password' => bcrypt('123456'),
        ]);
    }
}