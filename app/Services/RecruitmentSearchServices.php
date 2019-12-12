<?php
/**

Recruitment search services class to hold the related action logics

*/

namespace App\Services;

use App\RecruitmentFirm;
use App\FirmPracticeArea;
use App\PracticeArea;
use App\FirmSector;
use App\Sector;

use Illuminate\Support\Facades\DB;

class RecruitmentSearchServices{

	public function listFirms($filters){

        $generalists = array();
        $firms = DB::table('recruitment_firms')->select('recruitment_firms.id',
                                        'recruitment_firms.name',
                                        'recruitment_firms.location',
                                        'recruitment_firms.view_count',
                                        'recruitment_firms.is_verified',
                                        'recruitment_firms.is_specialism');
        //Search by firm name or other filters
       

        
        if(((isset($filters->firm_id))&&(((!isset($filters->search_locations))&&(!isset($filters->service_id))&&(!isset($filters->recruitment_id))&&(!isset($filters->size))&&(!isset($filters->practice_area_id))&&(!isset($filters->sector_id))))))
        {
            $firms->where('recruitment_firms.id', $filters->firm_id)
            ->where('recruitment_firms.is_active', RecruitmentFirm::FLAG_YES)
            ->whereNull('recruitment_firms.deleted_at');
        }
        
        
        else{
            if(isset($filters->search_locations)){
                $firms->join('firm_locations','recruitment_firms.id', '=','firm_locations.firm_id')
                    ->where('location_id', $filters->search_locations)
                    ->where('firm_locations.is_active', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_locations.deleted_at');
            }

            if(isset($filters->service_id)){
                $firms->join('firm_services','recruitment_firms.id', '=','firm_services.firm_id')
                    ->where('service_id', $filters->service_id)
                    ->where('firm_services.is_active', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_services.deleted_at');
            }

            if(isset($filters->recruitment_id)){
                $firms->join('firm_recruitment_types','recruitment_firms.id', '=','firm_recruitment_types.firm_id')
                    ->where('recruitment_id', $filters->recruitment_id)
                    ->where('firm_recruitment_types.is_active', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_recruitment_types.deleted_at');
            }        

            if(isset($filters->size)){
                $firms->where('firm_size', $filters->size);
            }

            if((isset($filters->practice_area_id))&&(isset($filters->sector_id))){


                $firms->join('firm_practice_areas','recruitment_firms.id', '=','firm_practice_areas.firm_id')
                    ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                    ->join('firm_sectors','recruitment_firms.id', '=','firm_sectors.firm_id')
                    ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                    ->where(function($query) use ($filters){
                        $query-> where('practice_area_id', $filters->practice_area_id)
                        ->orWhere('sector_id', $filters->sector_id);   
                    })
                    ->where('firm_sectors.is_active', FirmSector::FLAG_YES)
                    ->where('firm_practice_areas.is_active', FirmPracticeArea::FLAG_YES)
                    ->whereNull('firm_practice_areas.deleted_at')
                    ->whereNull('practice_areas.deleted_at')
                    ->whereNull('firm_sectors.deleted_at')
                    ->whereNull('sectors.deleted_at');

                $generalists = DB::table('recruitment_firms')
                                    ->select('recruitment_firms.id',
                                            'recruitment_firms.name',
                                            'recruitment_firms.location',
                                            'recruitment_firms.view_count',
                                            'recruitment_firms.is_verified',
                                            'recruitment_firms.is_specialism')
                                ->join('firm_practice_areas','recruitment_firms.id', '=','firm_practice_areas.firm_id')
                                ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                                ->join('firm_sectors','recruitment_firms.id', '=','firm_sectors.firm_id')
                                ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                                ->where('firm_sectors.is_active', FirmSector::FLAG_YES)
                                ->where('firm_practice_areas.is_active', FirmPracticeArea::FLAG_YES)
                                ->where('practice_areas.type', PracticeArea::AREA_ALL)
                                ->where('sectors.type', Sector::SECTOR_ALL)
                                ->whereNull('firm_practice_areas.deleted_at')
                                ->whereNull('practice_areas.deleted_at')
                                ->whereNull('firm_sectors.deleted_at')
                                ->whereNull('sectors.deleted_at')
                                ->orderBy('general_ranking', 'ASC')
                                ->distinct('recruitment_firms.*')
                                ->get();

            }
            if((isset($filters->practice_area_id))&&(!isset($filters->sector_id))){
                $firms->join('firm_practice_areas','recruitment_firms.id', '=','firm_practice_areas.firm_id')
                    ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                    ->where('practice_area_id', $filters->practice_area_id)  
                    ->where('firm_practice_areas.is_active','=', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_practice_areas.deleted_at')
                    ->whereNull('practice_areas.deleted_at');

                    $generalists = DB::table('recruitment_firms')
                                        ->select('recruitment_firms.id',
                                                'recruitment_firms.name',
                                                'recruitment_firms.location',
                                                'recruitment_firms.view_count',
                                                'recruitment_firms.is_verified',
                                                'recruitment_firms.is_specialism')
                                    ->join('firm_practice_areas','recruitment_firms.id', '=','firm_practice_areas.firm_id')
                                    ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                                    ->where('firm_practice_areas.is_active', FirmPracticeArea::FLAG_YES)
                                    ->where('practice_areas.type', PracticeArea::AREA_ALL)
                                    ->whereNull('firm_practice_areas.deleted_at')
                                    ->whereNull('practice_areas.deleted_at')
                                    ->orderBy('general_ranking', 'ASC')
                                    ->distinct('recruitment_firms.*')
                                    ->get();
            }
            if((isset($filters->sector_id))&&(!isset($filters->practice_area_id))){

                $firms->join('firm_sectors','recruitment_firms.id', '=','firm_sectors.firm_id')
                    ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                    ->where('sector_id', $filters->sector_id)
                    ->where('firm_sectors.is_active', FirmSector::FLAG_YES)
                    ->whereNull('firm_sectors.deleted_at')
                    ->whereNull('sectors.deleted_at');


                    $generalists = DB::table('recruitment_firms')
                                        ->select('recruitment_firms.id',
                                                'recruitment_firms.name',
                                                'recruitment_firms.location',
                                                'recruitment_firms.view_count',
                                                'recruitment_firms.is_verified',
                                                'recruitment_firms.is_specialism')
                                    ->join('firm_sectors','recruitment_firms.id', '=','firm_sectors.firm_id')
                                    ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                                    ->where('firm_sectors.is_active', FirmSector::FLAG_YES)
                                    ->where('sectors.type', Sector::SECTOR_ALL)
                                    ->whereNull('firm_sectors.deleted_at')
                                    ->whereNull('sectors.deleted_at')
                                    ->orderBy('general_ranking', 'ASC')
                                    ->distinct('recruitment_firms.*')
                                    ->get();

            }
            
            if((!isset($filters->sector_id))&&(!isset($filters->practice_area_id))){

                    $firms->join('firm_practice_areas','recruitment_firms.id', '=','firm_practice_areas.firm_id')
                    ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                    ->join('firm_sectors','recruitment_firms.id', '=','firm_sectors.firm_id')
                    ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                   
                    ->where(function($query) use ($filters){
                        $query ->where('practice_areas.type', '=',PracticeArea::AREA_GENERAL)
                        ->orWhere('sectors.type', '=',Sector::SECTOR_GENERAL);
   
                    })
                    ->where('firm_practice_areas.is_active','=', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_practice_areas.deleted_at')
                    ->whereNull('practice_areas.deleted_at')
                    ->where('firm_sectors.is_active','=', RecruitmentFirm::FLAG_YES)
                    ->whereNull('firm_sectors.deleted_at')
                    ->whereNull('sectors.deleted_at');
            }

        }
        //  print_r($firms->distinct('recruitment_firms.*')->toSql());
        $filter_query = $firms->orderBy('general_ranking', 'ASC')
                            ->distinct('recruitment_firms.*')
                            ->get();

        $resultSet = array();
        foreach($filter_query as $query){
            array_push($resultSet, $query);
        }

        //If specialism is selected add generalist data to end
        if(count($generalists)){
            foreach ($generalists as $list) {
                array_push($resultSet, $query);
            }
        }
        return $resultSet;
	}

    public function saveViewCount($id){

        $firm = RecruitmentFirm::with(['firmLocation' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmLocation.location' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },
                                    'firmService' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmService.service' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },
                                    'firmRecruitmentType' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmRecruitmentType.recruitmentType' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },
                                    'firmPracticeArea' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmPracticeArea.practiceArea' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },
                                    'firmSector' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmSector.sector' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmClient' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmRegion' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },
                                    'firmRegion.location' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    },'firmRegion.location.region' => function($q) {
                                        $q->where('is_active', RecruitmentFirm::FLAG_YES);
                                    }])
                    ->find($id);

        if($firm){
            $firm->view_count = intval($firm->view_count) + 1;
            $firm->save();
        }
        
        return $firm;
    }

}