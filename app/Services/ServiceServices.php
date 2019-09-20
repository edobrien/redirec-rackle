<?php
/**

Location services class to hold the related action logics

*/

namespace App\Services;

use App\FirmService;
use App\Service;
use Yajra\Datatables\Datatables;

class ServiceServices{

	public function listServices(){

		$services = Service::select('id','name','is_active');

		return Datatables::of($services)
        			->addColumn('status_text',function($services){
                		return $services->getDescriptionText($services->is_active);
        			})
                	->addColumn('action', function ($services) {
	                    $buttons = ' <button ng-click="editService(' . $services->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteService(' . $services->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $service = Service::find($id);
        $rv = array("status" => "SUCCESS", "service" => $service);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $service = Service::find($datas->id);
            } else {
                $service = new Service;
            }
            
            $service->name = $datas->name;

            if($datas->is_active == Service::FLAG_YES){
                $service->is_active = Service::FLAG_YES;
            }else{
                $service->is_active = Service::FLAG_NO;
            }

            $service->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteService($id){
        $mappings = FirmService::where('service_id', $id)->count();
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
        	Service::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveServices(){
        return Service::select('id','name')
			        ->where('is_active', Service::FLAG_YES)
			        ->get();

    }

}