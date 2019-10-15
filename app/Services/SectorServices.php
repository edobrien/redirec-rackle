<?php
/**

Sector services class to hold the related action logics

*/

namespace App\Services;

use App\FirmSector;
use App\Sector;
use Yajra\Datatables\Datatables;

class SectorServices{

	public function listSectors(){

		$sectors = Sector::select('id','name','type','is_active');

		return Datatables::of($sectors)
        			->addColumn('status_text',function($sectors){
                		return $sectors->getDescriptionText($sectors->is_active);
                    })
                    ->addColumn('type_text',function($sectors){
                		return $sectors->getDescriptionText($sectors->type);
        			})
                	->addColumn('action', function ($sectors) {
	                    $buttons = ' <button ng-click="editSector(' . $sectors->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteSector(' . $sectors->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $sector = Sector::find($id);
        $rv = array("status" => "SUCCESS", "sector" => $sector);
        return response()->json($rv);
    }

    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $sector = Sector::find($datas->id);
            } else {
                $sector = new Sector;
            }
            
            $sector->name = $datas->name;
            $sector->type = $datas->type;

            if($datas->is_active == Sector::FLAG_YES){
                $sector->is_active = Sector::FLAG_YES;
            }else{
                $sector->is_active = Sector::FLAG_NO;
            }

            $sector->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteSector($id){
        $mappings = FirmSector::where('sector_id', $id)->count();
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
        	Sector::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveSectors(){
        return Sector::select('id','name', 'type')
			        ->where('is_active', Sector::FLAG_YES)
			        ->get();

    }

}