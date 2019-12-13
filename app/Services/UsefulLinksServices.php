<?php
/**

Interview guide services class to hold the related action logics

*/

namespace App\Services;

use App\UsefulLink;
use Yajra\Datatables\Datatables;

class UsefulLinksServices{

	public function listLinks(){

		$links = UsefulLink::select(['id','title','description','is_active',
												'ordering'])->orderBy('ordering', 'ASC');

		return Datatables::of($links)
        			->addColumn('status_text',function($links){
                		return $links->getDescriptionText($links->is_active);
        			})
                	->addColumn('action', function ($links) {
	                    $buttons = ' <button ng-click="editLink(' . $links->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteLink(' . $links->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $links = UsefulLink::find($id);
        $rv = array("status" => "SUCCESS", "links" => $links);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $link = UsefulLink::find($datas->id);
            } else {
                $link = new UsefulLink;
            }
            
            $link->title = $datas->title;
            $link->description = $datas->description;
            if(isset($datas->ordering)){
                $link->ordering = $datas->ordering;
            }            

            if($datas->is_active == UsefulLink::FLAG_YES){
                $link->is_active = UsefulLink::FLAG_YES;
            }else{
                $link->is_active = UsefulLink::FLAG_NO;
            }

            $link->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	UsefulLink::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveUsefulLinks(){
        return UsefulLink::select('id','title','description')
                    ->where('is_active', UsefulLink::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }

}