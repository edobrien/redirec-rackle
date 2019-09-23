<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Exports\LocationExport;
use App\Exports\ServiceExport;
use App\Exports\RecrutimentTypeExport;
use App\Exports\PracticeAreaExport;
use App\Exports\SectorExport;
use \Illuminate\Support\Collection;

class MasterDataExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [new LocationExport,
                    new ServiceExport,
                    new RecrutimentTypeExport,
                    new PracticeAreaExport,
                    new SectorExport,
                    new ImportColumns,
                ];

        return $sheets;
    }
}
