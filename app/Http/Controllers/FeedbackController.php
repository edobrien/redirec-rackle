<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Services\FeedbackServices;
use App\User;

class FeedbackController extends Controller
{
    
    private $feedbackServices;

    public function __construct(){
        $this->feedbackServices = new FeedbackServices;
    }

    public function index()
    {
        return view('admin.feedbacks.listing');
    }

    public function getInfo($id)
    {
        return $this->feedbackServices->getInfo($id);
    }

    public function listFeedbacks() {
        
        return $this->feedbackServices->listFeedbacks();
    }

    public function saveForm(Request $request){

        $errors = array();

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->feedbackServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Feedback submitted successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function registerNewsletter(){

        if($this->feedbackServices->registerNewsletter()){
            $rv = array("status" => "SUCCESS", "message" => "Newsletter registered successfully");
        }else{
            $errors[] = "Registration failed. Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

}
