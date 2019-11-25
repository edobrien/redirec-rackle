<?php
/**

Practice Area services class to hold the related action logics

*/

namespace App\Services;

use App\DataUploadLog;
use Yajra\Datatables\Datatables;

class DataUploadServices{

	public function listDataUploads(){

		$dataUpload = DataUploadLog::select('id','file_name','status');

		return Datatables::of($dataUpload)
        			->addColumn('file_name',function($dataUpload){
                		return $dataUpload->file_name;
                    })
                    ->addColumn('status_text',function($dataUpload){
                		return $dataUpload->getDescriptionText($dataUpload->status);
        			})
                	->addColumn('action', function ($dataUpload) {
	                    $buttons = ' <button ng-click="downloadFile(' . $dataUpload->id . ')" '
	                            . 'title="Download" alt="Download" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                  
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $area = DataUploadLog::find($id);
        $rv = array("status" => "SUCCESS", "area" => $area);
        return response()->json($rv);
    }

    

}