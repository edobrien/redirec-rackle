<?php
/**

Recruitment firm services class to hold the related action logics

*/

namespace App\Services\Firm;

use App\RecruitmentFirm;
use App\FirmPracticeArea;
use App\FirmLocation;
use App\FirmService;
use App\FirmRecruitmentType;
use App\FirmSector;
use App\FirmClient;
use App\FirmRecruitmentRegion;

use Yajra\Datatables\Datatables;

class RecruitmentServices{

	public function listFirms(){

        $firms = RecruitmentFirm::select(['id','name','view_count','firm_size',
                    'telephone','contact_name','established_year','is_active']);

		return Datatables::of($firms)
        			->addColumn('status_text',function($firms){
                		return $firms->getDescriptionText($firms->is_active);
                    })
                    ->addColumn('size_text',function($firms){
                		return $firms->getDescriptionText($firms->firm_size);
        			})
                	->addColumn('action', function ($firms) {
	                    $buttons = ' <button ng-click="editFirm(' . $firms->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteFirm(' . $firms->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $firm = RecruitmentFirm::find($id);
        $rv = array("status" => "SUCCESS", "firm" => $firm);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $firm = RecruitmentFirm::find($datas->id);
            } else {
                $firm = new RecruitmentFirm;
            }
            
            $firm->name = $datas->name;
            $firm->website_link = $datas->website_link;
            $firm->description = $datas->description;
            $firm->telephone = $datas->telephone;
            $firm->contact_name = $datas->contact_name;
            if(isset($datas->overview)){
                $firm->testimonials = $datas->overview;
            }
            
            $firm->location = $datas->location;
            $firm->general_ranking = $datas->general_ranking;
            $firm->practice_area = $datas->practice_area;
            $firm->sector = $datas->sector;
            $firm->established_year = $datas->established_year;
            $firm->firm_size = $datas->firm_size;

            if($datas->is_active == RecruitmentFirm::FLAG_YES){
                $firm->is_active = RecruitmentFirm::FLAG_YES;
            }else{
                $firm->is_active = RecruitmentFirm::FLAG_NO;
            }

            //Upload Image
            $image = $datas->logo;
            if($image != 'undefined' && $image != 'null'){
                $logo_name = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'/asset/img/firm-logo/', $logo_name);

                //Delete previous image if replaced
                if($firm->logo){
                    try{
                        unlink(public_path().'/asset/img/firm-logo/'.$firm->logo);
                    }catch(\Exception $e){
                        \Illuminate\Support\Facades\Log::error($e->getMessage());
                    }
                }

                $firm->logo = $logo_name;
            }

            $firm->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteFirm($id){

        $mappings = FirmPracticeArea::where('firm_id', $id)->count() +
                    FirmLocation::where('firm_id', $id)->count() +
                    FirmService::where('firm_id', $id)->count() +
                    FirmRecruitmentType::where('firm_id', $id)->count() +
                    FirmRecruitmentRegion::where('firm_id', $id)->count() +
                    FirmClient::where('firm_id', $id)->count() +
                    FirmSector::where('firm_id', $id)->count();

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
        	RecruitmentFirm::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function deleteLogo($id){
        try{
            $firm = RecruitmentFirm::find($id);
            if(isset($firm->logo)){
                unlink(public_path().'/asset/img/firm-logo/'.$firm->logo);
                $firm->logo = NULL;
                $firm->save();
            }
            return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveFirms(){
        return RecruitmentFirm::select('id','name')
			        ->where('is_active', RecruitmentFirm::FLAG_YES)
			        ->get();

    }

}