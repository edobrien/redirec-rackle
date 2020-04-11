<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HireLocationServices;

class HireLocationController extends Controller
{
    private $locationServices;

    public function __construct(){
        $this->locationServices = new HireLocationServices;
    }

    public function index(){
        return view('admin.hire-location');
    }

    public function getInfo($id)
    {
        return $this->locationServices->getInfo($id);
    }

    public function listlocations() {
        
        return $this->locationServices->listlocations();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(empty($request->region_id)){
            $errors[] = "Region is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->locationServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Hire Location added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteLocation($id){
        return $this->locationServices->canDeleteLocation($id);
     }

    public function delete($id){
        if($this->locationServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Hire Location deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveHireLocations(){
        $hire_locations = $this->locationServices->getActiveHireLocations();
        $rv = array('status' =>  "SUCCESS", "hire_locations" => $hire_locations );
        return response()->json($rv);
    }
}
