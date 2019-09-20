<?php
/**

Practice Area services class to hold the related action logics

*/

namespace App\Services;

use App\FirmPracticeArea;
use App\PracticeArea;
use Yajra\Datatables\Datatables;

class PracticeAreaServices{

	public function listPracticeAreas(){

		$areas = PracticeArea::select('id','name','type','is_active');

		return Datatables::of($areas)
        			->addColumn('status_text',function($areas){
                		return $areas->getDescriptionText($areas->is_active);
                    })
                    ->addColumn('type_text',function($areas){
                		return $areas->getDescriptionText($areas->type);
        			})
                	->addColumn('action', function ($areas) {
	                    $buttons = ' <button ng-click="editArea(' . $areas->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteArea(' . $areas->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $area = PracticeArea::find($id);
        $rv = array("status" => "SUCCESS", "area" => $area);
        return response()->json($rv);
    }

    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $area = PracticeArea::find($datas->id);
            } else {
                $area = new PracticeArea;
            }
            
            $area->name = $datas->name;
            $area->type = $datas->type;

            if($datas->is_active == PracticeArea::FLAG_YES){
                $area->is_active = PracticeArea::FLAG_YES;
            }else{
                $area->is_active = PracticeArea::FLAG_NO;
            }

            $area->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function canDeleteArea($id){
        $mappings = FirmPracticeArea::where('practice_area_id', $id)->count();
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
        	PracticeArea::destroy($id); 
        	return true;
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActivePracticeAreas(){
        return PracticeArea::select('id','name', 'type')
			        ->where('is_active', PracticeArea::FLAG_YES)
			        ->get();

    }

}