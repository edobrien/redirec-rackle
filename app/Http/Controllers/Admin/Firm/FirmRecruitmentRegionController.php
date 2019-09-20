<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmRecruitmentRegionServices;

class FirmRecruitmentRegionController extends Controller
{
    private $firmRecruitmentServices;

    public function __construct(){
        $this->firmRecruitmentServices = new FirmRecruitmentRegionServices;
    }

    public function index(){
        return view('admin.firm.firm-recruitment-region');
    }

    public function getInfo($id)
    {
        return $this->firmRecruitmentServices->getInfo($id);
    }

    public function listFirmRegions() {
        
        return $this->firmRecruitmentServices->listFirmRegions();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->location_id)){
            $errors[] = "Location is missing";
        }

        //Check mapping already exists
        if($this->firmRecruitmentServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmRecruitmentServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmRecruitmentServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
