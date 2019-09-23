<?php

namespace App\Exports;

use App\Location;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class LocationExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Location::select('locations.id','locations.name as location_name','regions.name')
                ->join('regions','regions.id','=','locations.region_id')
                ->where('locations.is_active', Location::FLAG_YES)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Locations';
    }
}
