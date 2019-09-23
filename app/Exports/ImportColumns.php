<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ImportColumns implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            ['name','website_link','description','firm_size','telephone',
            'contact_name','testimonials','view_count','general_ranking',
            'location','practice_area','sector','established_year','is_active',
            'locations','services','recruitment_type','client','practice_area',
            'sector','recruitment_region'],
        ];
    }
}