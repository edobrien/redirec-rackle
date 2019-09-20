<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ServiceServices;

class ServiceController extends Controller
{
    private $serviceServices;

    public function __construct(){
        $this->serviceServices = new ServiceServices;
    }

    public function index(){
        return view('admin.service');
    }

    public function getInfo($id)
    {
        return $this->serviceServices->getInfo($id);
    }

    public function listServices() {
        
        return $this->serviceServices->listServices();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->serviceServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Service added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteService($id){
        return $this->serviceServices->canDeleteService($id);
     }

    public function delete($id){
        if($this->serviceServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Service deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveServices(){
        $services = $this->serviceServices->getActiveServices();
        $rv = array('status' =>  "SUCCESS", "services" => $services );
        return response()->json($rv);
    }
}
