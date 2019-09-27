<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\DataUploadNotification;
use SimpleXLSX;
use Mail;

use App\RecruitmentFirm;
use App\DataUploadLog;
use App\FirmLocation;
use App\FirmService;
use App\FirmRecruitmentType;
use App\FirmClient;
use App\FirmPracticeArea;
use App\FirmSector;
use App\FirmRecruitmentRegion;

class UploadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command is used to upload data in system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            //Take file which is uploaded 5 minutes before
            $currentDate = strtotime(date('Y-m-d H:i:s'));
            $futureDate = $currentDate-(60*5);
            $formatDate = date("Y-m-d H:i:s", $futureDate);

            $file = DataUploadLog::where('status', DataUploadLog::STATUS_UPLOADED)
                            ->where('created_at', '<', $formatDate)->first();

            if(!is_null($file)){
                $file->status = DataUploadLog::STATUS_STARTED;
                $file->save();

                $xlsx = SimpleXLSX::parse(public_path().'/imports/'.$file->file_name);
                //Read only first sheet
                $firm_data = $xlsx->rows(0);
                for($i=1; $i < count($firm_data); $i++){ 
                    $this->readCell($firm_data[$i], $i);
                }

                $file->status = DataUploadLog::STATUS_COMPLETED;
                $file->save();

                //Mail::send(new DataUploadNotification($file));
            }
            
        }catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
        }
    }

    public function readCell($row, $count){

        $firm = new RecruitmentFirm;
        if(empty($row[0])){
            return true;
        }
        $firm->name = $row[0];
        $firm->website_link = $row[1];
        $firm->description = $row[2];
        $firm->firm_size = $row[3];
        $firm->telephone = $row[4];
        $firm->contact_name = $row[5];
        if(isset($row[6])){
            $firm->testimonials = $row[6];
        }
        $firm->general_ranking = $row[7];
        $firm->location = $row[8];        
        $firm->practice_area = $row[9];
        $firm->sector = $row[10];
        if(isset($row[11])){
            $firm->established_year = $row[11];
        }
        if(isset($row[12])){
            $firm->is_active = $row[12];
        }else{
            $firm->is_active = RecruitmentFirm::FLAG_YES;
        }
        $firm->save();

        //Location Mapping 
        $loc_ids = explode("&", $row[13]);
        $loc_contacts = explode("&", $row[14]);
        $loc_phones = explode("&", $row[15]);
        $loc_emails = explode("&", $row[16]);

        if(count($loc_ids)){
            for($i=0; $i<count($loc_ids); $i++){
                $location = new FirmLocation;
                $location->firm_id = $firm->id;
                $location->location_id = $loc_ids[$i];
                if(isset($loc_phones[$i])){
                    $location->telephone = $loc_phones[$i];
                }
                if(isset($loc_phones[$i])){
                    $location->contact_name = $loc_phones[$i];
                }
                if(isset($loc_phones[$i])){
                    $location->email = $loc_phones[$i];
                }
                $location->is_active = FirmLocation::FLAG_YES;
                $location->save();
            }
        }        

        //Service Mapping 
        $services = explode("&", $row[17]);

        if(count($services)){
            for($i=0; $i<count($services); $i++){
                $service = new FirmService;
                $service->firm_id = $firm->id;
                $service->service_id = $services[$i];
                $service->is_active = FirmService::FLAG_YES;
                $service->save();
            }
        }
        
        //Recruitment Type Mapping 
        $types = explode("&", $row[18]);

        if(count($types)){
            for($i=0; $i<count($types); $i++){
                $type = new FirmRecruitmentType;
                $type->firm_id = $firm->id;
                $type->recruitment_id = $types[$i];
                $type->is_active = FirmService::FLAG_YES;
                $type->save();
            }
        }

        //Firm Client Mapping 
        if(!empty(trim($row[19]))){
            $clients = explode("&", $row[19]);

            if(count($clients)){
                for($i=0; $i<count($clients); $i++){
                    $type = new FirmRecruitmentType;
                    $type->firm_id = $firm->id;
                    $type->client_location = $clients[$i];
                    $type->is_active = FirmRecruitmentType::FLAG_YES;
                    $type->save();
                }
            }
        }

        //Firm Practice Area Mapping 
        $areas = explode("&", $row[19]);

        if(count($areas)){
            for($i=0; $i<count($areas); $i++){
                $type = new FirmPracticeArea;
                $type->firm_id = $firm->id;
                $type->practice_area_id = $areas[$i];
                $type->is_active = FirmPracticeArea::FLAG_YES;
                $type->save();
            }
        }

        //Firm Sector Mapping 
        $sectors = explode("&", $row[19]);

        if(count($sectors)){
            for($i=0; $i<count($sectors); $i++){
                $type = new FirmSector;
                $type->firm_id = $firm->id;
                $type->sector_id = $sectors[$i];
                $type->is_active = FirmSector::FLAG_YES;
                $type->save();
            }
        }

        //Firm Recruitment Region Mapping 
        if(!empty(trim($row[19]))){
            $regions = explode("&", $row[19]);

            if(count($regions)){
                for($i=0; $i<count($regions); $i++){
                    $type = new FirmRecruitmentRegion;
                    $type->firm_id = $firm->id;
                    $type->location_id = $regions[$i];
                    $type->is_active = FirmRecruitmentRegion::FLAG_YES;
                    $type->save();
                }
            }
        }       

        return true;
    }
}
