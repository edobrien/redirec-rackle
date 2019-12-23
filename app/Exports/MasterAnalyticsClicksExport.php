<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

use App\Exports\AnalyticsClickCountExport;
use App\Exports\AnalyticsClicksExport;

class MasterAnalyticsClicksExport implements WithMultipleSheets, WithTitle
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [new AnalyticsClickCountExport,
                    new AnalyticsClicksExport                    
                ];

        return $sheets;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Click Analytics';
    }
}
