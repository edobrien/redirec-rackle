<?php
/**

Practice area section services class to hold the related action logics

*/

namespace App\Services;

use App\PracticeAreaSection;
use App\PracticeAreaGuide;
use Yajra\Datatables\Datatables;

class PracticeAreaSectionServices{

	public function listSections(){

        $sections = PracticeAreaSection::select(['id','title','is_active','ordering'])
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

        $practice_section = PracticeAreaSection::find($id);
        $rv = array("status" => "SUCCESS", "practice_section" => $practice_section);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $section = PracticeAreaSection::find($datas->id);
            } else {
                $section = new PracticeAreaSection;
            }
            
            $section->title = $datas->title;

            if(isset($datas->ordering)){
                $section->ordering = $datas->ordering;
            }
            
            if($datas->is_active == PracticeAreaSection::FLAG_YES){
                $section->is_active = PracticeAreaSection::FLAG_YES;
            }else{
                $section->is_active = PracticeAreaSection::FLAG_NO;
            }

            $section->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteSection($id){
        $mappings = PracticeAreaGuide::where('section_id', $id)
                        ->count();
        if($mappings)
            return true;

        return false;
    }

    public function delete($id){
        try{
        	PracticeAreaSection::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveSections(){
        return PracticeAreaSection::select('id','title')
                    ->where('is_active', PracticeAreaSection::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }
}