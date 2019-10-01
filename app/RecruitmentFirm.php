<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentFirm extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_IN_ACTIVE = "IN_ACTIVE";

    const SIZE_SMALL = "SMALL";
    const SIZE_MEDIUM = "MEDIUM";
    const SIZE_LARGE = "LARGE";
    const SIZE_SMALL_MEDIUM = "SMALL_MEDIUM";
    const SIZE_SMALL_LARGE = "SMALL_LARGE";
    const SIZE_MEDIUM_LARGE = "MEDIUM_LARGE";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

    const STATUS_ACTIVE_TEXT = "Active";
    const STATUS_IN_ACTIVE_TEXT = "In Active";

    const SIZE_SMALL_TEXT = "Small";
    const SIZE_MEDIUM_TEXT= "Medium";
    const SIZE_LARGE_TEXT = "Large";
    const SIZE_SMALL_MEDIUM_TEXT = "Small Medium";
    const SIZE_SMALL_LARGE_TEXT = "Small Large";
    const SIZE_MEDIUM_LARGE_TEXT = "Medium Large";

    const FLAG_YES_TEXT = "Yes";
    const FLAG_NO_TEXT = "No";

    public static function getDescriptionText($text){
        switch($text){
            case self::FLAG_YES:
                return self::FLAG_YES_TEXT;
                break;
            case self::FLAG_NO:
                return self::FLAG_NO_TEXT;
                break;
             case self::STATUS_ACTIVE:
                return self::STATUS_ACTIVE_TEXT;
                break;
            case self::STATUS_IN_ACTIVE:
                return self::STATUS_IN_ACTIVE_TEXT;
                break;
            case self::SIZE_SMALL:
                return self::SIZE_SMALL_TEXT;
                break;
            case self::SIZE_MEDIUM:
                return self::SIZE_MEDIUM_TEXT;
                break;          
            case self::SIZE_LARGE:
                return self::SIZE_LARGE_TEXT;
                break;
            case self::SIZE_SMALL_MEDIUM:
                return self::SIZE_SMALL_MEDIUM_TEXT;
                break;
            case self::SIZE_SMALL_LARGE:
                return self::SIZE_SMALL_LARGE_TEXT;
                break;
            case self::SIZE_MEDIUM_LARGE:
                return self::SIZE_MEDIUM_LARGE_TEXT;
                break;
        }
    }

    public function firmLocation(){
        return $this->hasMany('App\FirmLocation','firm_id');
    }

    public function firmService(){
        return $this->hasMany('App\FirmService','firm_id');
    }

    public function firmRecruitmentType(){
        return $this->hasMany('App\FirmRecruitmentType','firm_id');
    }

    public function firmPracticeArea(){
        return $this->hasMany('App\FirmPracticeArea','firm_id');
    }

    public function firmSector(){
        return $this->hasMany('App\FirmSector','firm_id');
    }

    public function firmRegion(){
        return $this->hasMany('App\FirmRecruitmentRegion','firm_id');
    }

    public function firmClient(){
        return $this->hasMany('App\FirmClient','firm_id');
    } 
}
