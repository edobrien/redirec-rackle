<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmPracticeAreaServices;

class FirmPracticeAreaController extends Controller
{
    private $firmPracticeAreaServices;

    public function __construct(){
        $this->firmPracticeAreaServices = new FirmPracticeAreaServices;
    }

    public function index(){
        return view('admin.firm.firm-practice-area');
    }

    public function getInfo($id)
    {
        return $this->firmPracticeAreaServices->getInfo($id);
    }

    public function listFirmPracticeAreas() {
        
        return $this->firmPracticeAreaServices->listFirmPracticeAreas();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->practice_area_id)){
            $errors[] = "Practice Area is missing";
        }

        //Check mapping already exists
        if($this->firmPracticeAreaServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmPracticeAreaServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmPracticeAreaServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
