<?php
/**

Recruitment search services class to hold the related action logics

*/

namespace App\Services;

use App\RecruitmentFirm;

class RecruitmentSearchServices{

	public function listFirms($filters){

        $firms = RecruitmentFirm::select('recruitment_firms.id','recruitment_firms.name',
                                        'recruitment_firms.location','recruitment_firms.view_count')
                    ->with('firmLocation','firmService','firmRecruitmentType',
                            'firmClient','firmRegion')
                    ->leftJoin('firm_practice_areas','recruitment_firms.id', '=', 'firm_practice_areas.firm_id')
                    ->leftJoin('firm_sectors','recruitment_firms.id', '=', 'firm_sectors.firm_id');

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
            $firms->whereHas('firmPracticeArea', function($q) use($filters){
                $q->where('practice_area_id', $filters->practice_area_id)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
        }

        if(isset($filters->sector_id)){
            $firms->whereHas('firmSector', function($q) use($filters){
                $q->where('sector_id', $filters->sector_id)
                ->where('is_active', RecruitmentFirm::FLAG_YES);
            });
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