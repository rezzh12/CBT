<?php

namespace App\Exports;

use App\Models\Detailsoal;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SoalExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        return Detailsoal::getDataSoal();
    }

    public function headings(): array
    {
        return [
            'id_soal',
            'soal',
            'pila',
            'pilb',
            'pilc',
            'pild',
            'pile',
            'kunci',
            'score',
        ];
    }
}