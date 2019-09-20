<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmServiceServices;

class FirmServiceController extends Controller
{
    private $firmServiceServices;

    public function __construct(){
        $this->firmServiceServices = new FirmServiceServices;
    }

    public function index(){
        return view('admin.firm.firm-service');
    }

    public function getInfo($id)
    {
        return $this->firmServiceServices->getInfo($id);
    }

    public function listFirmServices() {
        
        return $this->firmServiceServices->listFirmServices();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->service_id)){
            $errors[] = "Service is missing";
        }

        //Check mapping already exists
        if($this->firmServiceServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmServiceServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmServiceServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
