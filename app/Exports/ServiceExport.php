<?php

namespace App\Exports;

use App\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class ServiceExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Service::select('id','name')
        ->where('is_active', Service::FLAG_YES)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Service';
    }
}
