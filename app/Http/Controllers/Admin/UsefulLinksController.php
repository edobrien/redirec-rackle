<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UsefulLinksServices;
use App\UsefulLink;

class UsefulLinksController extends Controller
{
    
    private $uselinkServices;

    public function __construct(){
        $this->uselinkServices = new UsefulLinksServices;
    }

    public function index(){
        return view('admin.useful-links.listing');
    }

    public function getInfo($id)
    {
        return $this->uselinkServices->getInfo($id);
    }

    public function listLinks() {
        
        return $this->uselinkServices->listLinks();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->title)){
            $errors[] = "Title is missing";
        }

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }   

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->uselinkServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Link added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->uselinkServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Link deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveUsefulLinks(){

        $useful_links = $this->uselinkServices->getActiveUsefulLinks();

        $rv = array('status' =>  "SUCCESS", "useful_links" => $useful_links);
        
        return response()->json($rv);
    }

    //Listing view
    public function getActiveUsefulLinksListing(){

        $links = $this->uselinkServices->getActiveUsefulLinks();

        return view('links-articles.useful-links', compact('links'));
    }

}
