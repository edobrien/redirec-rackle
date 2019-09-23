<?php

namespace App\Exports;

use App\RecrutimentType;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecrutimentTypeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RecrutimentType::all();
    }
}
