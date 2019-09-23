<?php

namespace App\Exports;

use App\Region;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Region::select('id','name','is_active')->get();
    }
}
