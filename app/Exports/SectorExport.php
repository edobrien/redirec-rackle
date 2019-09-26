<?php

namespace App\Exports;

use App\Sector;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class SectorExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sector::select('id','name')
        ->where('is_active', Sector::FLAG_YES)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sector';
    }
}
