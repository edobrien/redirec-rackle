<?php

namespace App\Exports;

use App\RecruitmentType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class RecrutimentTypeExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RecruitmentType::select('id','name')
                    ->where('is_active', RecruitmentType::FLAG_YES)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'RecrutimentType';
    }
}
