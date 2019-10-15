<?php
/**

Firm practice area services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmPracticeArea;
use Yajra\Datatables\Datatables;

class FirmPracticeAreaServices{

	public function listFirmPracticeAreas(){

		$areas = FirmPracticeArea::with('firm','practiceArea')->select('firm_practice_areas.*');

		return Datatables::of($areas)
        			->addColumn('status_text',function($areas){                            
                		return $areas->getDescriptionText($areas->is_active);
        			})
                	->addColumn('action', function ($areas) {
	                    $buttons = ' <button ng-click="editFirmArea(' . $areas->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteFirmArea(' . $areas->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_area = FirmPracticeArea::find($id);
        $rv = array("status" => "SUCCESS", "firm_area" => $firm_area);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm_area = FirmPracticeArea::find($datas->id);
            } else {
                $firm_area = new FirmPracticeArea;
            }
            
            $firm_area->firm_id = $datas->firm_id;
            $firm_area->practice_area_id = $datas->practice_area_id;

            if($datas->is_active == FirmPracticeArea::FLAG_YES){
                $firm_area->is_active = FirmPracticeArea::FLAG_YES;
            }else{
                $firm_area->is_active = FirmPracticeArea::FLAG_NO;
            }

            $firm_area->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmPracticeArea::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmPracticeArea::where('firm_id', $data->firm_id)
                            ->where('practice_area_id', $data->practice_area_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmPracticeArea::where('firm_id', $data->firm_id)
                            ->where('practice_area_id', $data->practice_area_id)
                            ->count();
        }
        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveFirmAreas(){
        return FirmPracticeArea::with('firm','practiceArea')
			        ->where('is_active', FirmPracticeArea::FLAG_YES)
			        ->get();

    }

}