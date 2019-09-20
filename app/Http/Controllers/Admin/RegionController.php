<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RegionServices;

class RegionController extends Controller
{
    private $regionServices;

    public function __construct(){
        $this->regionServices = new RegionServices;
    }

    public function index(){
        return view('admin.region');
    }

    public function getInfo($id)
    {
        return $this->regionServices->getInfo($id);
    }

    public function listRegions() {
        
        return $this->regionServices->listRegions();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        } 

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->regionServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Region added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteRegion($id){
        return $this->regionServices->canDeleteRegion($id);
     }

    public function delete($id){
        if($this->regionServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Region deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveRegions(){
        $regions = $this->regionServices->getActiveRegions();
        $rv = array('status' =>  "SUCCESS", "regions" => $regions );
        return response()->json($rv);
    }
}
