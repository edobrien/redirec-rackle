<?php
/**

Recruitment Type services class to hold the related action logics

*/

namespace App\Services;

use App\FirmRecruitmentType;
use App\RecruitmentType;
use Yajra\Datatables\Datatables;

class RecruitmentTypeServices{

	public function listTypes(){

		$types = RecruitmentType::select('id','name','is_active');

		return Datatables::of($types)
        			->addColumn('status_text',function($types){
                		return $types->getDescriptionText($types->is_active);
        			})
                	->addColumn('action', function ($types) {
	                    $buttons = ' <button ng-click="editType(' . $types->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteType(' . $types->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $type = RecruitmentType::find($id);
        $rv = array("status" => "SUCCESS", "type" => $type);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $type = RecruitmentType::find($datas->id);
            } else {
                $type = new RecruitmentType;
            }
            
            $type->name = $datas->name;

            if($datas->is_active == RecruitmentType::FLAG_YES){
                $type->is_active = RecruitmentType::FLAG_YES;
            }else{
                $type->is_active = RecruitmentType::FLAG_NO;
            }

            $type->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteRecruitment($id){
        $mappings = FirmRecruitmentType::where('recruitment_id', $id)->count();
        if($mappings){
            $error = "Sorry. There are  {$mappings} mappings available.";
            $rv = array("status" => "FAILED", "error" => $error );
        }else{
            $rv = array("status" =>"SUCCESS");
        }
        return response()->json($rv);
    }

    public function delete($id){
        try{
        	RecruitmentType::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveRecruitmentTypes(){
        return RecruitmentType::select('id','name')
			        ->where('is_active', RecruitmentType::FLAG_YES)
			        ->get();

    }

}