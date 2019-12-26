<?php

namespace App\Exports;

use App\AnalyticsCaptureClick;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsClicksExport implements FromArray, WithTitle
{
    public function array(): array
    {
        $output = [['link','viewed_on']];
        $clickData = AnalyticsCaptureClick::select('link', 'created_at')->get();
        foreach ($clickData as $click) {
            array_push($output, [$click->link, $click->created_at]);
        }
        return $output;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Click Log';
    }
}
