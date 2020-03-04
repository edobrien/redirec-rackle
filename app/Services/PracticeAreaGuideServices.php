<?php
/**

Practice area guide services class to hold the related action logics

*/

namespace App\Services;

use App\PracticeAreaGuide;
use App\PracticeAreaSection;
use Yajra\Datatables\Datatables;

class PracticeAreaGuideServices{

	public function listGuides(){

		$guides = PracticeAreaGuide::select(['id','title','description','is_active',
												'ordering','view_count'])->orderBy('ordering', 'ASC');

		return Datatables::of($guides)
        			->addColumn('status_text',function($guides){
                		return $guides->getDescriptionText($guides->is_active);
        			})
                	->addColumn('action', function ($guides) {
	                    $buttons = ' <button ng-click="editGuide(' . $guides->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteGuide(' . $guides->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $practice_guide = PracticeAreaGuide::find($id);
        $rv = array("status" => "SUCCESS", "practice_guide" => $practice_guide);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $guide = PracticeAreaGuide::find($datas->id);
            } else {
                $guide = new PracticeAreaGuide;
            }
            
            $guide->title = $datas->title;
            $guide->section_id = $datas->section_id;
            $guide->description = $datas->description;
            $guide->ordering = $datas->ordering;

            if($datas->is_active == PracticeAreaGuide::FLAG_YES){
                $guide->is_active = PracticeAreaGuide::FLAG_YES;
            }else{
                $guide->is_active = PracticeAreaGuide::FLAG_NO;
            }

            $guide->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	PracticeAreaGuide::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveGuides(){
        //Get active section
        $sections = PracticeAreaSection::select('id','title')
                        ->where('is_active', PracticeAreaSection::FLAG_YES)
                        ->orderBy('ordering', 'ASC')
                        ->get();
        
        $output = array();
        foreach ($sections as $section) {
            $guides = PracticeAreaGuide::select('id','title','view_count')
                        ->where('section_id', $section->id)
                        ->where('is_active', PracticeAreaGuide::FLAG_YES)
                        ->orderBy('ordering', 'ASC')
                        ->get();
                        
            if(count($guides)){
                $output[$section->title] = $guides;
            }            
        }
        return $output;
    }

    public function saveViewCount($id){

        $guide = PracticeAreaGuide::find($id);

        if($guide){
            $guide->view_count = intval($guide->view_count) + 1;
            $guide->save();
            return true;
        }
        
        return false;
    }

}