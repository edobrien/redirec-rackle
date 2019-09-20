<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SurveyServices;

class SurveyController extends Controller
{
    
    private $surveyServices;

    public function __construct(){
        $this->surveyServices = new SurveyServices;
    }

    public function index(){
        return view('admin.surveys.listing');
    }

    public function getInfo($id)
    {
        return $this->surveyServices->getInfo($id);
    }

    public function listSurvies() {
        
        return $this->surveyServices->listSurvies();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->title)){
            $errors[] = "Hyperlink text is missing";
        }

        if(empty($request->url)){
            $errors[] = "Hyperlink is missing";
        }   

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->surveyServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Survey added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->surveyServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Survey deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveSurveys(){

        $surveys = $this->surveyServices->getActiveSurveys();

        $rv = array('status' =>  "SUCCESS", "surveys" => $surveys );
        
        return response()->json($rv);
    }

}
