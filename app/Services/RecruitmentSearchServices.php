<?php
/**

Recruitment search services class to hold the related action logics

*/

namespace App\Services;

use App\RecruitmentFirm;

class RecruitmentSearchServices{

	public function listFirms($filters){

		$firms = RecruitmentFirm::select('id','name','location','view_count')
                    ->with('firmLocation','firmService','firmRecruitmentType',
                            'firmPracticeArea','firmSector','firmClient','firmRegion');

        if(isset($filters->firm_id)){
            $firms->where('recruitment_firms.id', $filters->firm_id);
        }

        if(isset($filters->location_id)){
            $firms->whereHas('firmLocation', function($q) use($filters){
                $q->where('location_id', $filters->location_id);
            });
        }

        if(isset($filters->recruitment_id)){
            $firms->whereHas('firmRecruitmentType', function($q) use($filters){
                $q->where('recruitment_id', $filters->recruitment_id);
            });
        }

        if(isset($filters->service_id)){
            $firms->whereHas('firmService', function($q) use($filters){
                $q->where('service_id', $filters->service_id);
            });
        }

        if(isset($filters->size)){
            $firms->where('firm_size', $filters->size);
        }

        if(isset($filters->practice_area_id)){
            $firms->whereHas('firmPracticeArea', function($q) use($filters){
                $q->where('practice_area_id', $filters->practice_area_id);
            });
        }

        if(isset($filters->sector_id)){
            $firms->whereHas('firmSector', function($q) use($filters){
                $q->where('sector_id', $filters->sector_id);
            });
        }

        return $firms->get();
	}

    public function saveViewCount($id){

        $firm = RecruitmentFirm::with('firmLocation','firmLocation.location',
                                    'firmService','firmService.service',
                                    'firmRecruitmentType','firmRecruitmentType.recruitmentType',
                                    'firmPracticeArea','firmPracticeArea.practiceArea',
                                    'firmSector','firmSector.sector','firmClient','firmRegion',
                                    'firmRegion.location','firmRegion.location.region')
                    ->find($id);

        if($firm){
            $firm->view_count = intval($firm->view_count) + 1;
            $firm->save();
        }
        
        return $firm;
    }

}