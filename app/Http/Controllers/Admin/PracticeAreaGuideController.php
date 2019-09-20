<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PracticeAreaGuideServices;
use App\PracticeAreaGuide;

class PracticeAreaGuideController extends Controller
{
    
    private $practiceGuideServices;

    public function __construct(){
        $this->practiceGuideServices = new PracticeAreaGuideServices;
    }

    public function index(){
        return view('admin.practice-area-guides.listing');
    }

    public function getInfo($id)
    {
        return $this->practiceGuideServices->getInfo($id);
    }

    public function listGuides() {
        
        return $this->practiceGuideServices->listGuides();
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
            if($this->practiceGuideServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Practice Guide added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->practiceGuideServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Practice Guide deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveGuides(){

        $guides = $this->practiceGuideServices->getActiveGuides();

        $rv = array('status' =>  "SUCCESS", "practice_guides" => $guides );
        
        return response()->json($rv);
    }

    //Listing view
    public function getActivePracticeGuides(){

        $guides = $this->practiceGuideServices->getActiveGuides();

        return view('practice-area-guide.practice-area-guide', compact('guides'));
    }

    public function saveViewCount(Request $request){

        if($this->practiceGuideServices->saveViewCount($request->detail_id)){
            $rv = array('status' =>  "SUCCESS");
        }else{
            $rv = array('status' =>  "FAILURE");
        }
        return response()->json($rv);
    }

    public function getGuideView($id){
        $guide = PracticeAreaGuide::find($id);

        if($guide){
            return view('practice-area-guide.practice-guide-details', compact('guide'));
        }else{
            return view('error');
        }
    }

}
