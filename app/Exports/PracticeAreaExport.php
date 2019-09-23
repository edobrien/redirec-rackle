<?php

namespace App\Exports;

use App\PracticeArea;
use Maatwebsite\Excel\Concerns\FromCollection;

class PracticeAreaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PracticeArea::all();
    }
}
