<?php
/**

Region services class to hold the related action logics

*/

namespace App\Services;

use App\Region;
use App\Location;
use Yajra\Datatables\Datatables;

class RegionServices{

	public function listRegions(){

		$regions = Region::select(['id','name','is_active','ordering']);

		return Datatables::of($regions)
        			->addColumn('status_text',function($regions){
                		return $regions->getDescriptionText($regions->is_active);
        			})
                	->addColumn('action', function ($regions) {
	                    $buttons = ' <button ng-click="editRegion(' . $regions->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteRegion(' . $regions->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $region = Region::find($id);
        $rv = array("status" => "SUCCESS", "region" => $region);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $report = Region::find($datas->id);
            } else {
                $report = new Region;
            }
            
            $report->name = $datas->name;           

            if($datas->is_active == Region::FLAG_YES){
                $report->is_active = Region::FLAG_YES;
            }else{
                $report->is_active = Region::FLAG_NO;
            }

            if(isset($datas->ordering)){
                $report->ordering = $datas->ordering;
            }

            $report->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteRegion($id){
        $mappings = Location::where('region_id', $id)->count();
        if($mappings){
            $error = "Sorry.  There are  {$mappings} mappings available.";
            $rv = array("status" => "FAILED", "error" => $error );
        }else{
            $rv = array("status" =>"SUCCESS");
        }
        return response()->json($rv);
    }

    public function delete($id){
        try{
        	Region::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveRegions(){
        return Region::select('id','name')
                    ->where('is_active', Region::FLAG_YES)
                    ->orderBy('ordering','ASC')
			        ->get();

    }

}