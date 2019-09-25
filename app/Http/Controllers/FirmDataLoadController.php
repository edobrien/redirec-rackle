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
            if((!empty($request->upload_excel)) ||
                    ($request->upload_excel != "undefined")){
                $size = $request->file('upload_excel')->getSize();

            }

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
                    $rv = $this->importTemplate();
                }else{
                    $rv = array("status" => "FAILED", "errors" => ["Error in uploading file"]);
                }
            }
            return response()->json($rv);
        }catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            $rv = array("status" => "FAILED", "errors" => ["Something went wrong"]);
            return response()->json($rv);
        }
    }

    //Used to validate excel for valid fields and datatype
    public function importTemplate()
    {
        //Data analysis reading excel
        $result = $this->firmDataLoadServices->importTemplate();
        if(is_bool($result)){
            if($result){
                return array("status" => "SUCCESS", "messgae" => "Your data uploading process will start shortely");
            }else{
                return array("status" => "FAILED", "errors" => ["Error in uploading file"]);
            }            
        }
        return array("status" => "SUCCESS", "message" => "File uploaded successfully");
    }
}
