<?php
/**

Interview guide services class to hold the related action logics

*/

namespace App\Services;

use App\InterviewGuide;
use Yajra\Datatables\Datatables;

class InterviewGuideServices{

	public function listGuides(){

		$guides = InterviewGuide::select(['id','title','description','is_active',
												'ordering','view_count'])->orderBy('ordering', 'ASC');

		return Datatables::of($guides)
        			->addColumn('status_text',function($guides){
                		return $guides->getDescriptionText($guides->is_active);
        			})
                	->addColumn('action', function ($guides) {
	                    $buttons = ' <button ng-click="editGuide(' . $guides->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteGuide(' . $guides->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $interview_guide = InterviewGuide::find($id);
        $rv = array("status" => "SUCCESS", "interview_guide" => $interview_guide);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $guide = InterviewGuide::find($datas->id);
            } else {
                $guide = new InterviewGuide;
            }
            
            $guide->title = $datas->title;
            $guide->description = $datas->description;
            $guide->ordering = $datas->ordering;

            if($datas->is_active == InterviewGuide::FLAG_YES){
                $guide->is_active = InterviewGuide::FLAG_YES;
            }else{
                $guide->is_active = InterviewGuide::FLAG_NO;
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
        	InterviewGuide::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveGuides(){
        return InterviewGuide::select('id','title','view_count')
                    ->where('is_active', InterviewGuide::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }

    public function saveViewCount($id){

        $guide = InterviewGuide::find($id);

        if($guide){
            $guide->view_count = intval($guide->view_count) + 1;
            $guide->save();
            return true;
        }
        
        return false;
    }

}