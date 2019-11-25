<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use App\Exports\LocationExport;
use App\Exports\ServiceExport;
use App\Exports\RecrutimentTypeExport;
use App\Exports\PracticeAreaExport;
use App\Exports\SectorExport;
use \Illuminate\Support\Collection;

class MasterDataExport implements WithMultipleSheets, WithTitle
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [new ImportColumns,
                    new LocationExport,
                    new ServiceExport,
                    new RecrutimentTypeExport,
                    new PracticeAreaExport,
                    new SectorExport                    
                ];

        return $sheets;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'ReruitmentFirms';
    }
}
