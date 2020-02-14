<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\RecruitmentSearchServices;

class RecruitmentSearchController extends Controller
{
    
    private $searchServices;

    public function __construct(){
        $this->searchServices = new RecruitmentSearchServices;
    }

    public function searchFirm(Request $request)
    {
        if(isset($request->firm_id)){
            $request->session()->put('firm_id',$request->firm_id);
            $request->session()->forget('location_id');
            $request->session()->forget('hire_loc_id');
            $request->session()->forget('service_id');
            $request->session()->forget('recruitment_id');
            $request->session()->forget('firm_size');
            $request->session()->forget('practice_area_id');
            $request->session()->forget('sector_id');
        }
        else{
            $request->session()->forget('firm_id');

            if(isset($request->search_locations)){
                $request->session()->put('location_id',$request->search_locations);
            }else{
                $request->session()->forget('location_id');
            }

            if(isset($request->hire_locations)){
                $request->session()->put('hire_loc_id',$request->hire_locations);
            }else{
                $request->session()->forget('hire_loc_id');
            }
    
            if(isset($request->service_id)){
                $request->session()->put('service_id',$request->service_id);
            }else{
                $request->session()->forget('service_id');
            }
    
            if(isset($request->recruitment_id)){
                $request->session()->put('recruitment_id',$request->recruitment_id);
            }else{
                $request->session()->forget('recruitment_id');
            }
    
            if(isset($request->size)){
                $request->session()->put('firm_size',$request->size);
            }else{
                $request->session()->forget('firm_size');
            }
    
            if(isset($request->practice_area_id)){
                $request->session()->put('practice_area_id',$request->practice_area_id);
            }else{
                $request->session()->forget('practice_area_id');
            }
    
            if(isset($request->sector_id)){
                $request->session()->put('sector_id',$request->sector_id);
            }else{
                $request->session()->forget('sector_id');
            }
    
        }
       
        $firms = $this->filterFirm($request);

        return view('search-results', compact('firms'));
    }

    public function filterFirm($filters) {
        
        return $this->searchServices->listFirms($filters);
    }

    public function saveViewCount($id){

        $firm = $this->searchServices->saveViewCount($id);
        if($firm){
            $rv = array('status' =>  "SUCCESS", "firm" => $firm);
        }else{
            $rv = array('status' =>  "FAILURE");
        }
        return response()->json($rv);
    }

}
