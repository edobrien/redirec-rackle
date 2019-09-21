<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmLocationServices;

class FirmLocationController extends Controller
{
    private $firmLocationServices;

    public function __construct(){
        $this->firmLocationServices = new FirmLocationServices;
    }

    public function index(){
        return view('admin.firm.firm-location');
    }

    public function getInfo($id)
    {
        return $this->firmLocationServices->getInfo($id);
    }

    public function listFirmlocations() {
        
        return $this->firmLocationServices->listFirmlocations();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->location_id)){
            $errors[] = "Location is missing";
        }

        if(empty($request->telephone)){
            $errors[] = "Telephone is missing";
        }else if (!ctype_digit($request->telephone)) {
            $errors[] = "Telephone should contain only numbers";
        }

        //Check mapping already exists
        if($this->firmLocationServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmLocationServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmLocationServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
