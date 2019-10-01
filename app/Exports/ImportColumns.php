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
            ['name','website_link','description','firm_size(SMALL/MEDIUM/LARGE/SMALL_MEDIUM/SMALL_LARGE/MEDIUM_LARGE)','telephone',
            'contact_name','testimonials','general_ranking',
            'location(GLOBAL/UK)','practice_area(GENERAL/SPECIALIST)',
            'sector(GENERAL/PRIVATE_PRACTICE/INHOUSE)','established_year','is_active(YES/NO)',
            'locations(&)','location_contact(&)'
            ,'location_phone(&)','location_email(&)'
            ,'services','recruitment_type','client','practice_area',
            'sector','recruitment_region'],
        ];
    }
}