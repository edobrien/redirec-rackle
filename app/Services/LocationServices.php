<?php
/**

Location services class to hold the related action logics

*/

namespace App\Services;

use App\FirmLocation;
use App\FirmRecruitmentRegion;
use App\Location;
use Yajra\Datatables\Datatables;

class LocationServices{

	public function listLocations(){

		$locations = Location::with('region');

		return Datatables::of($locations)
        			->addColumn('status_text',function($locations){
                		return $locations->getDescriptionText($locations->is_active);
        			})
                	->addColumn('action', function ($locations) {
	                    $buttons = ' <button ng-click="editLocation(' . $locations->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteLocation(' . $locations->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $location = Location::find($id);
        $rv = array("status" => "SUCCESS", "location" => $location);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $location = Location::find($datas->id);
            } else {
                $location = new Location;
            }
            
            $location->name = $datas->name;
            $location->region_id = $datas->region_id;
            // if(isset($datas->ordering)){
            //     $location->ordering = $datas->ordering;
            // }
            if($datas->is_active == Location::FLAG_YES){
                $location->is_active = Location::FLAG_YES;
            }else{
                $location->is_active = Location::FLAG_NO;
            }

            $location->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteLocation($id){
        $mappings = FirmRecruitmentRegion::where('location_id', $id)->count() + 
                        FirmLocation::where('location_id', $id)->count();
        if($mappings){
            $error = "Sorry. There are  {$mappings} mappings available.";
            $rv = array("status" => "FAILED", "error" => $error );
        }else{
            $rv = array("status" =>"SUCCESS");
        }
        return response()->json($rv);
    }

    public function delete($id){
        try{
        	Location::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveLocations(){
        return Location::with('region')
                    ->where('is_active', Location::FLAG_YES)
                    ->orderBy('name')->get();

    }

}