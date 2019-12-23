<?php

namespace App\Exports;

use App\AnalyticsCaptureClick;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

use Illuminate\Support\Facades\DB;

class AnalyticsClickCountExport implements FromArray, WithTitle
{
    public function array(): array
    {
        $output = [['link','clicked_count']];
        $links = AnalyticsCaptureClick::groupBy('link')
                        ->select('link', DB::raw('count(*) as total'))
                        ->get();
        foreach ($links as $link) {
            array_push($output, [$link->link, $link->total]);
        }
        return $output;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Click count';
    }
}
