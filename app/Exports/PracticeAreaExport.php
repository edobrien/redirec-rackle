<?php

namespace App\Exports;

use App\PracticeArea;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class PracticeAreaExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PracticeArea::select('id','name')
                ->where('is_active', PracticeArea::FLAG_YES)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'PracticeArea';
    }
}
