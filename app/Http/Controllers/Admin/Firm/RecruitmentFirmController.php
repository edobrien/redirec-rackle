<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\RecruitmentServices;

class RecruitmentFirmController extends Controller
{
    private $recruitmentServices;

    public function __construct(){
        $this->recruitmentServices = new RecruitmentServices;
    }

    public function index(){
        return view('admin.recruitment-firm');
    }

    public function getInfo($id)
    {
        return $this->recruitmentServices->getInfo($id);
    }

    public function listFirms() {
        
        return $this->recruitmentServices->listFirms();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Firm name is missing";
        }

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }else if($request->description == ""){
            $errors[] = "Description is missing";
        }

        if(empty($request->website_link)){
            $errors[] = "Website link is missing";
        }

        if(empty($request->telephone)){
            $errors[] = "Telephone is missing";
        }else if (!ctype_digit($request->telephone)) {
            $errors[] = "Telephone should contain only numbers";
        }

        if(empty($request->contact_name)){
            $errors[] = "Contact name is missing";
        }

        if(empty($request->firm_size)){
            $errors[] = "Size is missing";
        }

        if(empty($request->location)){
            $errors[] = "Location is missing";
        }

        if(empty($request->general_ranking)){
            $errors[] = "General ranking is missing";
        }

        if(empty($request->practice_area)){
            $errors[] = "Practice area is missing";
        }

        if(empty($request->sector)){
            $errors[] = "Sector is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->recruitmentServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Recruitment firm added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteFirm($id){
        return $this->recruitmentServices->canDeleteFirm($id);
    }

    public function delete($id){
        if($this->recruitmentServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Recruitment firm deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveFirms(){

        $firms = $this->recruitmentServices->getActiveFirms();

        $rv = array('status' =>  "SUCCESS", "firms" => $firms );
        
        return response()->json($rv);
    }
}
