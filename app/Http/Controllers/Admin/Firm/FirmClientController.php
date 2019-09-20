<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmClientServices;

class FirmClientController extends Controller
{
    private $firmClientServices;

    public function __construct(){
        $this->firmClientServices = new FirmClientServices;
    }

    public function index(){
        return view('admin.firm.firm-clients');
    }

    public function getInfo($id)
    {
        return $this->firmClientServices->getInfo($id);
    }

    public function listFirmClients() {
        
        return $this->firmClientServices->listFirmClients();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->client_location)){
            $errors[] = "Client location is missing";
        }

        //Check mapping already exists
        if($this->firmClientServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmClientServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmClientServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
