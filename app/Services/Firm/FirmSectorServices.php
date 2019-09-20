<?php
/**

Firm sector services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmSector;
use Yajra\Datatables\Datatables;

class FirmSectorServices{

	public function listFirmSectors(){

		$sectors = FirmSector::with('firm','sector')->select('firm_sectors.*');

		return Datatables::of($sectors)
        			->addColumn('status_text',function($sectors){                            
                		return $sectors->getDescriptionText($sectors->is_active);
        			})
                	->addColumn('action', function ($sectors) {
	                    $buttons = ' <button ng-click="editFirmSector(' . $sectors->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteFirmSector(' . $sectors->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_sector = FirmSector::find($id);
        $rv = array("status" => "SUCCESS", "firm_sector" => $firm_sector);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm_sector = FirmSector::find($datas->id);
            } else {
                $firm_sector = new FirmSector;
            }
            
            $firm_sector->firm_id = $datas->firm_id;
            $firm_sector->sector_id = $datas->sector_id;

            if($datas->is_active == FirmSector::FLAG_YES){
                $firm_sector->is_active = FirmSector::FLAG_YES;
            }else{
                $firm_sector->is_active = FirmSector::FLAG_NO;
            }

            $firm_sector->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmSector::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmSector::where('firm_id', $data->firm_id)
                            ->where('sector_id', $data->sector_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmSector::where('firm_id', $data->firm_id)
                            ->where('sector_id', $data->sector_id)
                            ->count();
        }
        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveFirmAreas(){
        return FirmSector::with('firm','sector')
			        ->where('is_active', FirmSector::FLAG_YES)
			        ->get();

    }

}