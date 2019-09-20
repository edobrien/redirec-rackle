<?php
/**

Firm Location services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmRecruitmentRegion;
use Yajra\Datatables\Datatables;

class FirmRecruitmentRegionServices{

	public function listFirmRegions(){

		$locations = FirmRecruitmentRegion::with('firm','location')->select('firm_recruitment_regions.*');

		return Datatables::of($locations)
        			->addColumn('status_text',function($locations){
                            
                		return $locations->getDescriptionText($locations->is_active);
        			})
                	->addColumn('action', function ($locations) {
	                    $buttons = ' <button ng-click="editFirmRegion(' . $locations->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteFirmRegion(' . $locations->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_region = FirmRecruitmentRegion::find($id);
        $rv = array("status" => "SUCCESS", "firm_region" => $firm_region);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm_region = FirmRecruitmentRegion::find($datas->id);
            } else {
                $firm_region = new FirmRecruitmentRegion;
            }
            
            $firm_region->firm_id = $datas->firm_id;
            $firm_region->location_id = $datas->location_id;

            if($datas->is_active == FirmRecruitmentRegion::FLAG_YES){
                $firm_region->is_active = FirmRecruitmentRegion::FLAG_YES;
            }else{
                $firm_region->is_active = FirmRecruitmentRegion::FLAG_NO;
            }

            $firm_region->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmRecruitmentRegion::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmRecruitmentRegion::where('firm_id', $data->firm_id)
                            ->where('location_id', $data->location_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmRecruitmentRegion::where('firm_id', $data->firm_id)
                            ->where('location_id', $data->location_id)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveRecruitmentRegions(){
        return FirmRecruitmentRegion::with('firm','location')
			        ->where('is_active', FirmLocation::FLAG_YES)
			        ->get();

    }

}