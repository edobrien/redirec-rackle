<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmHireLocationServices;

class FirmHireLocationController extends Controller
{
    private $firmHireLocationsServices;

    public function __construct(){
        $this->firmHireLocationsServices = new FirmHireLocationServices;
    }

    public function index(){
        return view('admin.firm.firm-hire-location');
    }

    public function getInfo($id)
    {
        return $this->firmHireLocationsServices->getInfo($id);
    }

    public function listFirmlocations() {
        
        return $this->firmHireLocationsServices->listFirmlocations();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

         if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
         }

         if(empty($request->hire_location_id)){
             $errors[] = "Location is missing";
         }

        //Check mapping already exists
        if($this->firmHireLocationsServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmHireLocationsServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmHireLocationsServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
