<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\InterviewGuideSectionServices;
use App\InterviewGuideSection;

class InterviewGuideSectionController extends Controller
{
    private $interviewSectionServices;

    public function __construct(){
        $this->interviewSectionServices = new InterviewGuideSectionServices;
    }

    public function index(){
        return view('admin.interview-guide-section.listing');
    }

    public function getInfo($id)
    {
        return $this->interviewSectionServices->getInfo($id);
    }

    public function listSections() {
        
        return $this->interviewSectionServices->listSections();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty(trim($request->title))){
            $errors[] = "Title is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->interviewSectionServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Interview guide section added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        //Check mapping exists for guide
        if($this->interviewSectionServices->canDeleteSection($id)){
            $errors[] = "Unable to delete because mapping available in advice section";
                    $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->interviewSectionServices->delete($id)){
                $rv = array("status" => "SUCCESS", "message" => "Interview guide section deleted successfully");
            }else{
                $errors[] = "Please contact administrator";
                    $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }        
        return response()->json($rv);
    }

    public function getActiveSections(){

        $sections = $this->interviewSectionServices->getActiveSections();
        $rv = array('status' =>  "SUCCESS", "interview_sections" => $sections );
        return response()->json($rv);
    }
}
