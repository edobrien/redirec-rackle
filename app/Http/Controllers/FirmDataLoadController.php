<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirmDataLoadServices;

class FirmDataLoadController extends Controller
{
    
    private $firmDataLoadServices;

    public function __construct(){
        $this->firmDataLoadServices = new FirmDataLoadServices;
    }

    public function downloadTemplate()
    {
        return $this->firmDataLoadServices->downloadTemplate();
    }

    public function uploadData(Request $request)
    {
        try {

            $errors = array();
            $size = filesize($request->upload_excel);

            if(empty($request->upload_excel) || 
                    $request->upload_excel == "undefined"){
                $errors[] = "Please upload spreadsheet";
            }else if(round($size / 1024 /1024, 1) > 4){
                $errors[] = "Please upload file with size less than 2MB";
            }else if(!in_array($request->upload_excel->getClientOriginalExtension(), 
                        ["xlsx","XLSX"])){
                $errors[] = "Incorrect file format. Upload file with extension .xlsx";
            }

            if(!empty($errors)){
                $rv = array("status" => "FAILED", "errors" => $errors);
            }else{
                if($this->firmDataLoadServices->uploadExcel($request)){
                    $rv = array("status" => "SUCCESS", "message" => "File uploaded successfully");
                    //Data analysis reading excel
                    //$result = $this->firmDataLoadServices->importTemplate();
                    
                }else{
                    $rv = array("status" => "FAILED", "errors" => ["Error in uploading file"]);
                }
            }

            return response()->json($rv);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            $rv = array("status" => "FAILED", "errors" => ["Something went wrong"]);
            return response()->json($rv);
        }
    }

    //Used to validate excel for valid fields and datatype
    public function importTemplate()
    {
        if($this->firmDataLoadServices->importTemplate()){
            $rv = array("status" => "SUCCESS", "message" => "Validation successful");
        }else{
            $rv = array("status" => "FAILED", "errors" => ["Error in uploading file"]);
        }
        return response()->json($rv);
    }
}
