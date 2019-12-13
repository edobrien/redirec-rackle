<?php
/**

Firm recruitment type services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmRecruitmentType;
use Yajra\Datatables\Datatables;

class FirmRecruitmentTypeServices{

	public function listFirmRecruitmentTypes(){

		$types = FirmRecruitmentType::with('firm','recruitmentType')->select('firm_recruitment_types.*');

		return Datatables::of($types)
        			->addColumn('status_text',function($types){                            
                		return $types->getDescriptionText($types->is_active);
        			})
                	->addColumn('action', function ($types) {
	                    $buttons = ' <button ng-click="editFirmRecrutimentType(' . $types->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteFirmRecrutimentType(' . $types->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_recruitment_type = FirmRecruitmentType::find($id);
        $rv = array("status" => "SUCCESS", "firm_recruitment_type" => $firm_recruitment_type);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm_recruitment_type = FirmRecruitmentType::find($datas->id);
            } else {
                $firm_recruitment_type = new FirmRecruitmentType;
            }
            
            $firm_recruitment_type->firm_id = $datas->firm_id;
            $firm_recruitment_type->recruitment_id = $datas->recruitment_id;

            if($datas->is_active == FirmRecruitmentType::FLAG_YES){
                $firm_recruitment_type->is_active = FirmRecruitmentType::FLAG_YES;
            }else{
                $firm_recruitment_type->is_active = FirmRecruitmentType::FLAG_NO;
            }

            $firm_recruitment_type->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmRecruitmentType::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmRecruitmentType::where('firm_id', $data->firm_id)
                            ->where('recruitment_id', $data->recruitment_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmRecruitmentType::where('firm_id', $data->firm_id)
                            ->where('recruitment_id', $data->recruitment_id)
                            ->count();
        }
        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveLocations(){
        return FirmRecruitmentType::with('firm','service')
			        ->where('is_active', FirmRecruitmentType::FLAG_YES)
			        ->get();

    }

}