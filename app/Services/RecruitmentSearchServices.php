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

use DB;

class RecruitmentSearchServices{

	public function listFirms($filters){

        $firms = RecruitmentFirm::select('recruitment_firms.id',
                                        'recruitment_firms.name',
                                        'recruitment_firms.location',
                                        'recruitment_firms.view_count')
                    ->with('firmLocation','firmService','firmRecruitmentType',
                    'firmPracticeArea','firmPracticeArea.practiceArea',
                    'firmSector','firmSector.sector',
                    'firmClient','firmRegion');

        if(isset($filters->firm_id)){
            $firms->where('recruitment_firms.id', $filters->firm_id)
            ->where('is_active', RecruitmentFirm::FLAG_YES);
        }

        if(isset($filters->location_id)){
            $firms->whereHas('firmLocation', function($q) use($filters){
                $q->where('location_id', $filters->location_id)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
        }

        if(isset($filters->recruitment_id)){
            $firms->whereHas('firmRecruitmentType', function($q) use($filters){
                $q->where('recruitment_id', $filters->recruitment_id)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
        }

        if(isset($filters->service_id)){
            $firms->whereHas('firmService', function($q) use($filters){
                $q->where('service_id', $filters->service_id)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
        }

        if(isset($filters->size)){
            $firms->where('firm_size', $filters->size);
        }

        if(isset($filters->practice_area_id)){

            $specialist = FirmPracticeArea::select('practice_area_id')
                            ->where('practice_area_id', $filters->practice_area_id)
                            ->where('firm_practice_areas.is_active', RecruitmentFirm::FLAG_YES);
                        
            $general = FirmPracticeArea::select('practice_area_id')
                        ->join('practice_areas','practice_areas.id','=','firm_practice_areas.practice_area_id')
                        ->where('practice_areas.type', PracticeArea::AREA_GENERAL)
                        ->where('firm_practice_areas.is_active', RecruitmentFirm::FLAG_YES);
                       
            if(!empty($specialist) && !empty($general)){
                $areas = $specialist->union($general)->get();
            }else if(!empty($specialist)){
                $areas = $specialist->get();
            }else{
                $areas = $general->get();
            }
            
            $area_ids = array();
            foreach($areas as $area){
                array_push($area_ids, $area->practice_area_id);
            }

            $firms->whereHas('firmPracticeArea', function($q) use($area_ids){
                $q->whereIn('practice_area_id', $area_ids)
                ->where('is_active', FirmPracticeArea::FLAG_YES);
            });

        }

        if(isset($filters->sector_id)){
            $specialist = FirmSector::select('sector_id')
                            ->where('sector_id', $filters->sector_id)
                            ->where('firm_sectors.is_active', RecruitmentFirm::FLAG_YES);

            $general = FirmSector::select('sector_id')
                        ->join('sectors','sectors.id','=','firm_sectors.sector_id')
                        ->where('sectors.type', Sector::SECTOR_GENERAL)
                        ->where('firm_sectors.is_active', RecruitmentFirm::FLAG_YES);

            if(!empty($specialist) && !empty($general)){
                $areas = $specialist->union($general)->get();
            }else if(!empty($specialist)){
                $areas = $specialist->get();
            }else{
                $areas = $general->get();
            }            
            
            $sector_ids = array();
            foreach($areas as $area){
                array_push($sector_ids, $area->sector_id);
            }

            $firms->whereHas('firmSector', function($q) use($sector_ids){
                $q->whereIn('sector_id', $sector_ids)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
        }

        if(isset($filters->sector_id)){
            //$firms->orderByRaw('CASE WHEN recruitment_firms.firm_sectors.sectors.type AND != "GENERAL" THEN 1 ELSE 2 END');
        }
        return $firms->orderBy('general_ranking', 'ASC')->get();
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