<?php
/**

Report services class to hold the related action logics

*/

namespace App\Services;

use App\Report;
use App\User;
use App\Mail\NotifyReport;
use Yajra\Datatables\Datatables;
use Mail;
use App\SiteConstants;

class ReportServices{

	public function listReports(){

        $reports = Report::select(['id','name','description','is_active',
                    'ordering'])->orderBy('ordering', 'ASC');

		return Datatables::of($reports)
        			->addColumn('status_text',function($reports){
                		return $reports->getDescriptionText($reports->is_active);
        			})
                	->addColumn('action', function ($reports) {
	                    $buttons = ' <button ng-click="editReport(' . $reports->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pl-0">'
	                            . '<i class="icon ion-md-create"></i></button>';

	                    $buttons .= ' <button ng-click="deleteReport(' . $reports->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pl-0">'
	                            . '<i class="icon ion-md-close"></i></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $report = Report::find($id);
        $rv = array("status" => "SUCCESS", "report" => $report);
        return response()->json($rv);
    }


    public function addOrUpdate($data) {
        try {

            if (isset($data->id)) {
                $report = Report::find($data->id);
            } else {
                $report = new Report;
            }
            
            $report->name = $data->name;
            $report->description = $data->description;
            if(isset($data->ordering)){
                $report->ordering = $data->ordering;
            }

            $report_doc = $data->report_doc;
            if($report_doc !="" && $report_doc != 'undefined'){
                $file_name = time() . '.' . $report_doc->getClientOriginalExtension();
                $report_doc->move(public_path(). SiteConstants::APP_ASSET_REPORT, $file_name);

                //Delete old file if exists
                if($data->id && !empty($report->report_doc)){
                    unlink(public_path().SiteConstants::APP_ASSET_REPORT. $report->report_doc);
                }
                $report->report_doc = $file_name;
            }

            if($data->is_active == Report::FLAG_YES){
                $report->is_active = Report::FLAG_YES;
            }else{
                $report->is_active = Report::FLAG_NO;
            }

            $report->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
            //Delete file and delete record
            $report = Report::find($id);
            unlink(public_path().SiteConstants::APP_ASSET_REPORT. $report->report_doc);
        	Report::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveReports(){
        return Report::select('id','name','description','report_doc')
                    ->where('is_active', Report::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();

    }

    public function notifyReportRequest($data){
        try {
            $user = \Illuminate\Support\Facades\Auth::user();

            Mail::send(new NotifyReport(User::find($user->id), $data->report_name));

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
        
    }
}