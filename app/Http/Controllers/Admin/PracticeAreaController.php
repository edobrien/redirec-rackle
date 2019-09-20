<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PracticeAreaServices;

class PracticeAreaController extends Controller
{
    private $practiceServices;

    public function __construct(){
        $this->practiceServices = new PracticeAreaServices;
    }

    public function index(){
        return view('admin.practice-area');
    }

    public function getInfo($id)
    {
        return $this->practiceServices->getInfo($id);
    }

    public function listPracticeAreas() {
        
        return $this->practiceServices->listPracticeAreas();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(empty($request->type)){
            $errors[] = "Type is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->practiceServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Practice area added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteArea($id){
        return $this->practiceServices->canDeleteArea($id);
     }

    public function delete($id){
        if($this->practiceServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Practice area deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActivePracticeAreas(){
        $areas = $this->practiceServices->getActivePracticeAreas();
        $rv = array('status' =>  "SUCCESS", "areas" => $areas );
        return response()->json($rv);
    }
}
