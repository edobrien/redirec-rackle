<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SectorServices;

class SectorController extends Controller
{
    private $practiceServices;

    public function __construct(){
        $this->sectorServices = new SectorServices;
    }

    public function index(){
        return view('admin.sector');
    }

    public function getInfo($id)
    {
        return $this->sectorServices->getInfo($id);
    }

    public function listSectors() {
        
        return $this->sectorServices->listSectors();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(empty($request->type)){
            $errors[] = "Type is missing";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->sectorServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Sector added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function canDeleteSector($id){
        return $this->sectorServices->canDeleteSector($id);
    }

    public function delete($id){
        if($this->sectorServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Sector deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
            $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveSectors(){
        $sectors = $this->sectorServices->getActiveSectors();
        $rv = array('status' =>  "SUCCESS", "sectors" => $sectors );
        return response()->json($rv);
    }
}
