<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmRecruitmentTypeServices;

class FirmRecruitmentTypeController extends Controller
{
    private $firmServiceServices;

    public function __construct(){
        $this->firmRecruitmentTypeServices = new FirmRecruitmentTypeServices;
    }

    public function index(){
        return view('admin.firm.firm-recrutiment-type');
    }

    public function getInfo($id)
    {
        return $this->firmRecruitmentTypeServices->getInfo($id);
    }

    public function listFirmRecruitmentTypes() {
        
        return $this->firmRecruitmentTypeServices->listFirmRecruitmentTypes();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->recruitment_id)){
            $errors[] = "Recruitment Type is missing";
        }

        //Check mapping already exists
        if($this->firmRecruitmentTypeServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmRecruitmentTypeServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmRecruitmentTypeServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
