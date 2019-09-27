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
    private $practiceAreaType;
    private $sectorType;

    public function __construct(){
        $this->location = Location::pluck('id')->toArray();
        $this->service = Service::pluck('id')->toArray();
        $this->recruitmentType = RecruitmentType::pluck('id')->toArray();
        $this->practiceArea = PracticeArea::pluck('id')->toArray();
        $this->sector = Sector::pluck('id')->toArray();
        $this->practiceAreaType = array(PracticeArea::AREA_GENERAL,
                                        PracticeArea::AREA_SPECIAL);
        $this->sectorType = array(Sector::SECTOR_GENERAL,
                                Sector::SECTOR_PRIVATE_PRACTICE,
                                Sector::SECTOR_INHOUSE);
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
            $errors = array();
            $file = DB::table('data_upload_logs')
                        ->where('status', DataUploadLog::STATUS_UPLOADED)
                        ->latest('created_at')->first();

            $xlsx = SimpleXLSX::parse(public_path().'/imports/'.$file->file_name);
            //Read only first sheet
            $firm_data = $xlsx->rows(0);

            if(count($xlsx->rows()) < 2){
                $this->deleteUploadedFile($file);
                $errors = ['No data to upload'];
                return $errors;
            }
            
            for($i=1; $i < count($firm_data); $i++){ 
                $row_errors = $this->cellValidation($firm_data[$i]);
                if(!empty($row_errors)){
                    $errors[] = "Row ".$i." - ".implode(", ",$this->cellValidation($firm_data[$i]));
                }                
            }

            //Return true if no error found
            if(count($errors) < 1){
                return true;
            }
            $this->deleteUploadedFile($file);
            return $errors;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            $this->deleteUploadedFile($file);
            return false;
        }
    }

    public function cellValidation($row){
        
        $errors = array();
        if(empty($row[0])){
            return $errors;
        }

        if(empty(trim($row[0]))){
            $errors[] = "Missing recruitment firm";          
        }
        
        if(empty(trim($row[1]))){
            $errors[] = "Missing website link";          
        }
        
        if(empty(trim($row[2]))){
            $errors[] = "Missing recruitment description";          
        }

        if(empty(trim($row[3]))){
            $errors[] = "Missing firm size";          
        }

        if(empty(trim($row[4]))){
            $errors[] = "Missing Telephone";          
        }else if (!ctype_digit(trim($row[4]))) {
            $errors[] = "Telephone should contain only numbers";
        }

        if(empty(trim($row[5]))){
            $errors[] = "Missing contact name";          
        }

        if(empty(trim($row[7]))){
            $errors[] = "Missing general ranking";          
        }else if(!ctype_digit(trim($row[7]))){
            $errors[] = "General ranking must be numbers";
        }        

        if(empty(trim($row[8]))){
            $errors[] = "Missing location";          
        }

        if(empty(trim($row[9]))){
            $errors[] = "Missing practice area";          
        }else if(!in_array(trim($row[9]),$this->practiceAreaType)){
            $errors[] = "Invalid practice area type";
        }

        if(empty(trim($row[10]))){
            $errors[] = "Missing sector";          
        }else if(!in_array(trim($row[10]),$this->sectorType)){
            $errors[] = "Invalid sector type";
        }      

        if(empty(trim($row[13]))){
            $errors[] = "Missing location mapping";        
        }else if(count(array_diff(explode("&",$row[13]), $this->location))){
            $errors[] = "Invalid location mapping";
        }

        if(empty(trim($row[17]))){
            $errors[] = "Missing service mapping";
        }else if(count(array_diff(explode("&",$row[17]), $this->service))){
            $errors[] = "Invalid service mapping";
        }

        if(empty(trim($row[18]))){
            $errors[] = "Recruitment type mapping";
        }else if(count(array_diff(explode("&",$row[18]), $this->recruitmentType))){
            $errors[] = "Invalid recruitment type mapping";
        }

        if(count(explode("&",$row[19])) < 1){
            $errors[] = "Invalid client mapping";
        }

        if(empty(trim($row[20]))){
            $errors[] = "Practice area mapping";
        }else if(count(array_diff(explode("&",$row[20]), $this->practiceArea))){
            $errors[] = "Invalid practice area mapping";
        }

        if(empty(trim($row[21]))){
            $errors[] = "Sector mapping";
        }else if(count(array_diff(explode("&",$row[21]), $this->sector))){
            $errors[] = "Invalid sector mapping";
        }

        if(count(array_diff(explode("&",$row[22]), $this->location))){
            $errors[] = "Invalid recruitment region mapping";
        }
        return $errors;
    }

    public function deleteUploadedFile($file){

        if(file_exists(public_path().'/imports/'.$file->file_name)){
            unlink(public_path().'/imports/'.$file->file_name);
            //Delete uploaded file
            DataUploadLog::destroy($file->id);
        }        
    }
}