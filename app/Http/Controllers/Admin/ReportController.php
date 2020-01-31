<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReportServices;

class ReportController extends Controller
{
    private $reportServices;

    public function __construct(){
        $this->reportServices = new ReportServices;
    }

    public function index(){
        return view('admin.reports.listing');
    }

    public function getInfo($id)
    {
        return $this->reportServices->getInfo($id);
    }

    public function listReports() {
        
        return $this->reportServices->listReports();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }

        if(empty($request->report_doc) || $request->report_doc == 'undefined'){
            $errors= "Please upload report document";
        }else {
            $size = $request->report_doc->getSize();
            $validator = $request->report_doc->getClientOriginalExtension();
            if(!in_array($validator, ['pdf'])){
                $errors = "Please upload report in pdf format";
            }else if (round($size / 1024 / 1024, 1)>10){
                $errors = "Please upload a smaller file (Less than 10 MB)" ;            
            }
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->reportServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Report added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->reportServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Report deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveReports(){

        $reports = $this->reportServices->getActiveReports();
        $rv = array('status' =>  "SUCCESS", "reports" => $reports);
        return response()->json($rv);
    }

    //Listing view
    public function getActiveReportListing(){
        $reports =  $this->reportServices->getActiveReports();
        return view('reports-analysis', compact('reports'));
    }
    public function notifyReportRequest(Request $request){
        if($this->reportServices->notifyReportRequest($request)){
            $rv = array("status" => "SUCCESS", "message" => "Report requested to Admin");
        }else{
            $errors[] = "Please contact administrator. Error in notifying Admin";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

}
