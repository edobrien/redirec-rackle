<?php
/**

Firm service services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmService;
use Yajra\Datatables\Datatables;

class FirmServiceServices{

	public function listFirmServices(){

		$services = FirmService::with('firm','service')->select('firm_services.*');

		return Datatables::of($services)
        			->addColumn('status_text',function($services){                            
                		return $services->getDescriptionText($services->is_active);
        			})
                	->addColumn('action', function ($services) {
	                    $buttons = ' <button ng-click="editFirmService(' . $services->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteFirmService(' . $services->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_service = FirmService::find($id);
        $rv = array("status" => "SUCCESS", "firm_service" => $firm_service);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm_service = FirmService::find($datas->id);
            } else {
                $firm_service = new FirmService;
            }
            
            $firm_service->firm_id = $datas->firm_id;
            $firm_service->service_id = $datas->service_id;

            if($datas->is_active == FirmService::FLAG_YES){
                $firm_service->is_active = FirmService::FLAG_YES;
            }else{
                $firm_service->is_active = FirmService::FLAG_NO;
            }

            $firm_service->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmService::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmService::where('firm_id', $data->firm_id)
                            ->where('service_id', $data->service_id)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmService::where('firm_id', $data->firm_id)
                            ->where('service_id', $data->service_id)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveLocations(){
        return FirmService::with('firm','service')
			        ->where('is_active', FirmService::FLAG_YES)
			        ->get();

    }

}