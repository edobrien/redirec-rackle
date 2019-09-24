<?php
/**

Firm data load services class to hold the related action logics

*/

namespace App\Services;

use App\Exports\MasterDataExport;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use SimpleXLSX;
use DB;

use App\DataUploadLog;
use App\Location;
use App\Service;
use App\RecruitmentType;
use App\PracticeArea;
use App\Sector;

class FirmDataLoadServices{

    private $location;
    private $service;
    private $recruitmentType;
    private $practiceArea;
    private $sector;

    public function __construct(){
        $this->location = Location::pluck('id')->toArray();
        $this->service = Service::pluck('id')->toArray();
        $this->recruitmentType = RecruitmentType::pluck('id')->toArray();
        $this->practiceArea = PracticeArea::pluck('id')->toArray();
        $this->sector = Sector::pluck('id')->toArray();
    }

	public function downloadTemplate() {
        return Excel::download(new MasterDataExport, 'upload.xlsx');
    }

    public function uploadExcel($data){
        try{
            DB::transaction(function () use($data) {
                $log = new DataUploadLog;
                $excel = $data->upload_excel;
                if($excel != 'undefined'){
                    $excelName = time(). '.' . $excel->getClientOriginalExtension();
                    $excel->move(public_path().'/imports/', $excelName);

                    $log->file_name = $excelName;
                    $log->status = DataUploadLog::STATUS_UPLOADED;
                    $log->save();
                }
            });
            return true;
        }catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return false;
        }        
    }

    public function importTemplate(){

        try {
            $file = DB::table('data_upload_logs')
                        ->where('status', DataUploadLog::STATUS_UPLOADED)
                        ->latest('created_at')->first();

            $xlsx = SimpleXLSX::parse(public_path().'/imports/'.$file->file_name);
            //Read only first sheet
            $firm_data = $xlsx->rows(0);

            for($i=1; $i < count($firm_data); $i++){
                $this->cellValidation($firm_data[$i]);
            }exit;
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return false;
        }
    }

    public function cellValidation($row){

        

        $errors = array();
        if(empty(trim($row[0]))){
            $errors[] = "Missing Recruitment firm";          
        }

        if(empty(trim($row[1]))){
            $errors[] = "Missing Website link";          
        }

        if(empty(trim($row[2]))){
            $errors[] = "Missing Recruitment description";          
        }

        if(empty(trim($row[3]))){
            $errors[] = "Missing Firm Size";          
        }

        if(empty(trim($row[4]))){
            $errors[] = "Missing Telephone";          
        }else if (!ctype_digit(trim($row[4]))) {
            $errors[] = "Telephone should contain only numbers";
        }

        if(empty(trim($row[5]))){
            $errors[] = "Missing Contact Name";          
        }

        if(empty(trim($row[7]))){
            $errors[] = "Missing General ranking";          
        }else if(!ctype_digit(trim($row[7]))){
            $errors[] = "General ranking must be numbers";
        }        

        if(empty(trim($row[8]))){
            $errors[] = "Missing Location";          
        }

        if(empty(trim($row[9]))){
            $errors[] = "Missing Practice Area";          
        }

        if(empty(trim($row[10]))){
            $errors[] = "Missing Sector";          
        }       

        if(empty(trim($row[13]))){
            $errors[] = "Missing Location mapping";        
        }else if(count(array_diff(explode("&",$row[13]), $this->location))){
            $errors[] = "Invalid Location mapping";
        }

        if(empty(trim($row[14]))){
            $errors[] = "Missing Service mapping";
        }

        if(empty(trim($row[15]))){
            $errors[] = "Recruitment Type mapping";
        }

        if(empty(trim($row[16]))){
            $errors[] = "Client mapping";
        }

        if(empty(trim($row[17]))){
            $errors[] = "Practice Area mapping";
        }

        if(empty(trim($row[18]))){
            $errors[] = "Sector mapping";
        }

        if(empty(trim($row[19]))){
            $errors[] = "Recruitment Region mapping";
        }
    }
}