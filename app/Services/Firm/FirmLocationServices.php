<?php
/**

Firm Location services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmLocation;
use Yajra\Datatables\Datatables;

class FirmLocationServices{

	public function listFirmlocations(){

		$locations = FirmLocation::with('firm','location')->select('firm_locations.*');

		return Datatables::of($locations)
        			->addColumn('status_text',function($locations){
                            
                		return $locations->getDescriptionText($locations->is_active);
        			})
                	->addColumn('action', function ($locations) {
	                    $buttons = ' <button ng-click="editFirmLocation(' . $locations->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteFirmLocation(' . $locations->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_location = FirmLocation::find($id);
        $rv = array("status" => "SUCCESS", "firm_location" => $firm_location);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if(isset($datas->id)) {
                $firm_location = FirmLocation::find($datas->id);
            } else {
                $firm_location = new FirmLocation;
            }
            
            $firm_location->firm_id = $datas->firm_id;
            $firm_location->location_id = $datas->location_id;
            $firm_location->telephone = $datas->telephone;
            $firm_location->contact_name = $datas->contact_name;
            $firm_location->email = $datas->email;

            if($datas->is_active == FirmLocation::FLAG_YES){
                $firm_location->is_active = FirmLocation::FLAG_YES;
            }else{
                $firm_location->is_active = FirmLocation::FLAG_NO;
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
        	FirmLocation::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmLocation::where('firm_id', $data->firm_id)
                            ->where('location_id', $data->location_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmLocation::where('firm_id', $data->firm_id)
                            ->where('location_id', $data->location_id)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveLocations(){
        return FirmLocation::with('firm','location')
			        ->where('is_active', FirmLocation::FLAG_YES)
			        ->get();

    }

}