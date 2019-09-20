<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HelpfulArticleServices;

class HelpfulArticleController extends Controller
{
    
    private $articleServices;

    public function __construct(){
        $this->articleServices = new HelpfulArticleServices;
    }

    public function index(){
        return view('admin.helpful-articles.listing');
    }

    public function getInfo($id)
    {
        return $this->articleServices->getInfo($id);
    }

    public function listArticles() {
        
        return $this->articleServices->listArticles();
    }

    public function addOrUpdate(Request $request){

        $errors = array();

        if(empty($request->title)){
            $errors[] = "Title is missing";
        }

        if(empty($request->description)){
            $errors[] = "Description is missing";
        }else if($request->description == ""){
            $errors[] = "Description is missing";
        }   

        if(!empty($errors)){
            $rv = array("status" => "FAILED", "errors" => $errors);
        }else{
            if($this->articleServices->addOrUpdate($request)){
                $rv = array("status" => "SUCCESS", "message" =>"Article added/updated successfully");
            }else{               
                $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
            }
        }
        return response()->json($rv);
    }

    public function delete($id){
        if($this->articleServices->delete($id)){
            $rv = array("status" => "SUCCESS", "message" => "Article deleted successfully");
        }else{
            $errors[] = "Please contact administrator";
                $rv = array("status" => "FAILED", "errors" => $errors);
        }
        return response()->json($rv);
    }

    public function getActiveArticles(){

        $articles = $this->articleServices->getActiveArticles();

        $rv = array('status' =>  "SUCCESS", "articles" => $articles);
        
        return response()->json($rv);
    }

    public function getActiveArticleListing(){
        $articles = $this->articleServices->getActiveArticles();
        return view('links-articles.helpful-articles', compact('articles'));
    }

}
