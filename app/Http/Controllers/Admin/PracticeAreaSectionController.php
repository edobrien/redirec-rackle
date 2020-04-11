<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PracticeAreaSectionServices;
use App\PracticeAreaSection;

class PracticeAreaSectionController extends Controller
{
    private $practiceSectionServices;

    public function __construct(){
        $this->practiceSectionServices = new PracticeAreaSectionServices;
    }

    public function index(){
        return view('admin.practice-area-section.listing');
    }

    public function getInfo($id)
    {
        return $this->practiceSectionServices->getInfo($id);
    }

    public function listSections() {
        
        return $this->practiceSectionServices->listSections();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty(trim($request->title))){
            $errors[] = "Title is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->practiceSectionServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Practice section added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        //Check mapping exists for guide
        if($this->practiceSectionServices->canDeleteSection($id)){
            $errors[] = "Unable to delete because mapping available in guide section";
                    $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->practiceSectionServices->delete($id)){
                $rv = array("status" => "SUCCESS", "message" => "Practice section deleted successfully");
            }else{
                $errors[] = "Please contact administrator";
                    $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }        
        return response()->json($rv);
    }

    public function getActiveSections(){

        $sections = $this->practiceSectionServices->getActiveSections();
        $rv = array('status' =>  "SUCCESS", "practice_sections" => $sections );
        return response()->json($rv);
    }
}
