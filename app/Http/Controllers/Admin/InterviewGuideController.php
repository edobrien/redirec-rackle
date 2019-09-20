<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InterviewGuideServices;
use App\InterviewGuide;

class InterviewGuideController extends Controller
{
    
    private $interviewGuideServices;

    public function __construct(){
        $this->interviewGuideServices = new InterviewGuideServices;
    }

    public function index(){
        return view('admin.interview-guides.listing');
    }

    public function getInfo($id)
    {
        return $this->interviewGuideServices->getInfo($id);
    }

    public function listGuides() {
        
        return $this->interviewGuideServices->listGuides();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->title)){
            $errors[] = "Title is missing";
        }

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }else if($request->description == ""){
            $errors[] = "Description is missing";
        }

        if(empty($request->ordering)){
            $errors[] = "Ordering is missing";
        }    

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->interviewGuideServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Interview Guide added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->interviewGuideServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Interview Guide deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveGuides(){

        $guides = $this->interviewGuideServices->getActiveGuides();

        $rv = array('status' =>  "SUCCESS", "interview_guides" => $guides );
        
        return response()->json($rv);
    }

    //Listing view
    public function getActiveInterviewGuides(){
        $guides = $this->interviewGuideServices->getActiveGuides();
        return view('interview-guides.interview-guides', compact('guides'));
    }

    public function saveViewCount(Request $request){

        if($this->interviewGuideServices->saveViewCount($request->detail_id)){
            $rv = array('status' =>  "SUCCESS");
        }else{
            $rv = array('status' =>  "FAILURE");
        }
        return response()->json($rv);
    }

    public function getGuideView($id){
        $guide = InterviewGuide::find($id);

        if($guide){
            return view('interview-guides.interview-guides-details', compact('guide'));
        }else{
            return view('error');
        }
    }

}
