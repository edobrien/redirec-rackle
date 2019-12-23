<?php
/**

Analytics services class to hold the related action logics

*/

namespace App\Services;

use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\AnalyticsCaptureClick;
use App\User;
use App\Exports\MasterAnalyticsClicksExport;

class AnalyticsServices{

	public function listCaptureClicks(){

        $links = AnalyticsCaptureClick::groupBy('link')
                        ->select('link', DB::raw('count(*) as total'))
                        ->get();

        return Datatables::of($links)
                ->addColumn('count',function($links){
                    return $links->total;
                })->make(true);
    }
    
    public function listUserLogins(){

        $logins = User::select('name','firm_name','position','last_login_at','successful_login_count');

        return Datatables::of($logins)->make(true);
	}

	public function getInfo($id) {

        $area = DataUploadLog::find($id);
        $rv = array("status" => "SUCCESS", "area" => $area);
        return response()->json($rv);
    }

    public function captureClicks($data){

        $click = new AnalyticsCaptureClick();
        $click->link = $data->href;
        $click->save();

        $rv = array("status" => "SUCCESS");
        return response()->json($rv);
    }

    public function downloadClickReport() {
        return Excel::download(new MasterAnalyticsClicksExport, 'clicks-report.xlsx');
    }
}