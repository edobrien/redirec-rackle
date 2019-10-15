<?php
/**

Firm Location services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\FirmClient;
use Yajra\Datatables\Datatables;

class FirmClientServices{

	public function listFirmClients(){

		$clients = FirmClient::with('firm')->select('firm_clients.*');

		return Datatables::of($clients)
        			->addColumn('status_text',function($clients){
                            
                		return $clients->getDescriptionText($clients->is_active);
        			})
                	->addColumn('action', function ($clients) {
	                    $buttons = ' <button ng-click="editFirmClientLocation(' . $clients->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteFirmClientLocation(' . $clients->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm_client = FirmClient::find($id);
        $rv = array("status" => "SUCCESS", "firm_client" => $firm_client);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if(isset($datas->id)) {
                $firm_client = FirmClient::find($datas->id);
            } else {
                $firm_client = new FirmClient;
            }
            
            $firm_client->firm_id = $datas->firm_id;
            $firm_client->client_location = $datas->client_location;

            if($datas->is_active == FirmClient::FLAG_YES){
                $firm_client->is_active = FirmClient::FLAG_YES;
            }else{
                $firm_client->is_active = FirmClient::FLAG_NO;
            }

            $firm_client->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	FirmClient::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function mappingExists($data){

        if(isset($data)){
            $mapping = FirmClient::where('firm_id', $data->firm_id)
                            ->where('client_location', $data->client_location)
                            ->where('id', '!=', $data->id)
                            ->count();
        }else{
            $mapping = FirmClient::where('firm_id', $data->firm_id)
                            ->where('client_location', $data->client_location)
                            ->count();
        }

        if($mapping){
            return true;
        }
        return false;
        
    }

    public function getActiveClientLocations(){
        return FirmClient::with('firm','location')
			        ->where('is_active', FirmClient::FLAG_YES)
			        ->get();

    }
}