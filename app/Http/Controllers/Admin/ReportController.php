<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReportServices;
use App\Http\Requests\NotifySelectedReportRequest;

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
            $errors= "Please add report link";
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
    public function notifySelectedReport(NotifySelectedReportRequest $request){

    
        $validated = $request->validated();
      
        if($this->reportServices->notifySelectedReportRequest($request)){
            $rv = array("status" => "SUCCESS", "message" => "Many thanks for requesting this market report/update. We shall be sending this to you within the next 48 hours. If you need the report urgently, please email edobrien@recdirec.com");
        }else{
            $errors[] = "Please contact administrator. Error in notifying Admin";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }

        return response()->json($rv);
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
