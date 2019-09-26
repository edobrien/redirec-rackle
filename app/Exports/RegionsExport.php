<?php

namespace App\Exports;

use App\Region;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class RegionsExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Region::select('id','name','is_active')->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Region';
    }
}
