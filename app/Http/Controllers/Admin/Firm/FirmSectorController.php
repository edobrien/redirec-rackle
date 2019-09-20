<?php

namespace App\Http\Controllers\Admin\Firm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Firm\FirmSectorServices;

class FirmSectorController extends Controller
{
    private $firmSectorServices;

    public function __construct(){
        $this->firmSectorServices = new FirmSectorServices;
    }

    public function index(){
        return view('admin.firm.firm-sector');
    }

    public function getInfo($id)
    {
        return $this->firmSectorServices->getInfo($id);
    }

    public function listFirmSectors() {
        
        return $this->firmSectorServices->listFirmSectors();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->firm_id)){
            $errors[] = "Firm is missing";
        }

        if(empty($request->sector_id)){
            $errors[] = "Sector is missing";
        }

        //Check mapping already exists
        if($this->firmSectorServices->mappingExists($request)){
            $errors[] = "Mapping already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->firmSectorServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Mapping added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->firmSectorServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Mapping deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }
}
