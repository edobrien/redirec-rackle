<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RecruitmentTypeServices;

class RecruitmentTypeController extends Controller
{
    private $recruitmentServices;

    public function __construct(){
        $this->recruitmentServices = new RecruitmentTypeServices;
    }

    public function index(){
        return view('admin.recruitment-type');
    }

    public function getInfo($id)
    {
        return $this->recruitmentServices->getInfo($id);
    }

    public function listTypes() {
        
        return $this->recruitmentServices->listTypes();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->recruitmentServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Recruitment type added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteRecruitment($id){
        return $this->recruitmentServices->canDeleteRecruitment($id);
     }

    public function delete($id){
        if($this->recruitmentServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Recruitment type deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveRecruitmentTypes(){
        $types = $this->recruitmentServices->getActiveRecruitmentTypes();
        $rv = array('status' =>  "SUCCESS", "types" => $types );
        return response()->json($rv);
    }
}
