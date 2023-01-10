<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Services\UserServices;
use App\User;

class UserController extends Controller
{
    
    private $userServices;

    public function __construct(){
        $this->userServices = new UserServices;
    }

    public function index(){
        return view('users');
    }

    public function getInfo($id)
    {
        return $this->userServices->getInfo($id);
    }

    public function listUsers($status = "") {
        
        return $this->userServices->listUsers($status);
    }

    public function updateUser(Request $request){

        $errors = array();

        if(empty($request->name)){
            $errors[] = "Name is missing";
        }

        if(empty($request->firm_name)){
            $errors[] = "Firm name is missing";
        }

        if(empty($request->position)){
            $errors[] = "Position is missing";
        }

        // if(empty($request->contact_number)){
        //     $errors[] = "Contact number is missing";
        // }
        
        if(empty($request->email)){
             $errors[] = "Email is missing";
        }      

        //Check email already exists
        if($this->userServices->emailExists($request)){
            $errors[] = "Email already exists";
        }

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->userServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"User updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }   


        return response()->json($rv);
    }

    public function delete($id){
        if($this->userServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "User deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

}
