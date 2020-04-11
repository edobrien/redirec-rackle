<?php
/**

Firm Location services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmHireLocation;
use Yajra\Datatables\Datatables;

class FirmHireLocationServices{

	public function listFirmlocations(){

        $locations = FirmHireLocation::with('firm','hireLocation')->select('firm_hire_locations.*');
        
        //print_r($locations);exit;
		return Datatables::of($locations)
        			->addColumn('status_text',function($locations){
                            
                		return $locations->getDescriptionText($locations->is_active);
        			})
                	->addColumn('action', function ($locations) {
	                    $buttons = ' <button ng-click="editFirmLocation(' . $locations->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteFirmLocation(' . $locations->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_location = FirmHireLocation::find($id);
        
        $rv = array("status" => "SUCCESS", "firm_location" => $firm_location);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if(isset($datas->id)) {
                $firm_location = FirmHireLocation::find($datas->id);
            } else {
                $firm_location = new FirmHireLocation;
            }
            
            $firm_location->firm_id = $datas->firm_id;
            $firm_location->hire_location_id = $datas->hire_location_id;

            if($datas->is_active == FirmHireLocation::FLAG_YES){
                $firm_location->is_active = FirmHireLocation::FLAG_YES;
            }else{
                $firm_location->is_active = FirmHireLocation::FLAG_NO;
            }

            $firm_location->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmHireLocation::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmHireLocation::where('firm_id', $data->firm_id)
                            ->where('hire_location_id', $data->hire_location_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmHireLocation::where('firm_id', $data->firm_id)
                            ->where('hire_location_id', $data->hire_location_id)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveLocations(){
        return FirmHireLocation::with('firm','hireLocation')
			        ->where('is_active', FirmHireLocation::FLAG_YES)
			        ->get();

    }

}