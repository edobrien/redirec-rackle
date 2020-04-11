<?php
/**

Interview guide section services class to hold the related action logics

*/

namespace App\Services;

use App\InterviewGuideSection;
use App\InterviewGuide;
use Yajra\Datatables\Datatables;

class InterviewGuideSectionServices{

	public function listSections(){

        $sections = InterviewGuideSection::select(['id','title','is_active','ordering'])
                    ->orderBy('title', 'ASC');

		return Datatables::of($sections)
        			->addColumn('status_text',function($sections){
                		return $sections->getDescriptionText($sections->is_active);
        			})
                	->addColumn('action', function ($sections) {
	                    $buttons = ' <button ng-click="editSection(' . $sections->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteSection(' . $sections->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);
	}

	public function getInfo($id) {

        $interview_section = InterviewGuideSection::find($id);
        $rv = array("status" => "SUCCESS", "interview_section" => $interview_section);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $section = InterviewGuideSection::find($datas->id);
            } else {
                $section = new InterviewGuideSection;
            }
            
            $section->title = $datas->title;

            if($datas->is_active == InterviewGuideSection::FLAG_YES){
                $section->is_active = InterviewGuideSection::FLAG_YES;
            }else{
                $section->is_active = InterviewGuideSection::FLAG_NO;
            }

            if(isset($datas->ordering)){
                $section->ordering = $datas->ordering;
            }

            $section->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteSection($id){
        $mappings = InterviewGuide::where('section_id', $id)
                        ->count();
        if($mappings)
            return true;

        return false;
    }

    public function delete($id){
        try{
        	InterviewGuideSection::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveSections(){
        return InterviewGuideSection::select('id','title')
                    ->where('is_active', InterviewGuideSection::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }
}