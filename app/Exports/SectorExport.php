<?php

namespace App\Exports;

use App\Sector;
use Maatwebsite\Excel\Concerns\FromCollection;

class SectorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sector::all();
    }
}
