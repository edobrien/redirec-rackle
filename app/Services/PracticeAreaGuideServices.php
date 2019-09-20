<?php
/**

Practice area guide services class to hold the related action logics

*/

namespace App\Services;

use App\PracticeAreaGuide;
use Yajra\Datatables\Datatables;

class PracticeAreaGuideServices{

	public function listGuides(){

		$guides = PracticeAreaGuide::select(['id','title','description','is_active',
												'ordering','view_count']);

		return Datatables::of($guides)
        			->addColumn('status_text',function($guides){
                		return $guides->getDescriptionText($guides->is_active);
        			})
                	->addColumn('action', function ($guides) {
	                    $buttons = ' <button ng-click="editGuide(' . $guides->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteGuide(' . $guides->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
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
        return PracticeAreaGuide::select('id','title','view_count')
			        ->where('is_active', PracticeAreaGuide::FLAG_YES)
			        ->get();

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