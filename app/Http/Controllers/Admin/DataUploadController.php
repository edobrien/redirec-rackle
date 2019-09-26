<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DataUploadLog;
use App\Http\Controllers\Controller;
use App\Services\DataUploadServices;

class DataUploadController extends Controller
{
    private $dataUploadServices;

    public function __construct(){
        $this->dataUploadServices = new DataUploadServices;
    }

    public function index(){
        return view('admin.data-upload');
    }

   
    public function listDataUploads() {
        
        return $this->dataUploadServices->listDataUploads();
    }

    public function downloadFile($file_id) {

        $file = DataUploadLog::find($file_id);

            if($file){

                $rv = array("status" => "SUCCESS", "file_name" => $file->file_name);

            }else{

                 $rv = array("status" => "FAILED");

            }

        return response()->json($rv);
    }

    
}
