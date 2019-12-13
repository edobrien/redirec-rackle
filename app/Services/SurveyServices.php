<?php
/**

Survey services class to hold the related action logics

*/

namespace App\Services;

use App\Survey;
use Yajra\Datatables\Datatables;

class SurveyServices{

	public function listSurvies(){

        $surveys = Survey::select(['id','title','url','ordering','is_active'])
                        ->orderBy('ordering', 'ASC');

		return Datatables::of($surveys)
        			->addColumn('status_text',function($surveys){
                		return $surveys->getDescriptionText($surveys->is_active);
        			})
                	->addColumn('action', function ($surveys) {
	                    $buttons = ' <button ng-click="editSurvey(' . $surveys->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteSurvey(' . $surveys->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $survey = Survey::find($id);
        $rv = array("status" => "SUCCESS", "survey" => $survey);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $survey = Survey::find($datas->id);
            } else {
                $survey = new Survey;
            }
            
            $survey->title = $datas->title;
            $survey->url = $datas->url;

            if(isset($datas->ordering)){
                $survey->ordering = $datas->ordering;
            }            

            if($datas->is_active == Survey::FLAG_YES){
                $survey->is_active = Survey::FLAG_YES;
            }else{
                $survey->is_active = Survey::FLAG_NO;
            }

            $survey->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	Survey::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveSurveys(){
        return Survey::select('id','title','url')
                    ->where('is_active', Survey::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }

}