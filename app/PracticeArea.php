<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeArea extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_IN_ACTIVE = "IN_ACTIVE";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

    const AREA_GENERAL = "GENERAL";
    const AREA_ALL = "ALL";
    const AREA_SPECIAL = "SPECIAL";
    const AREA_GENERAL_AND_SPECIAL = "GENERAL_AND_SPECIAL";

    const STATUS_ACTIVE_TEXT = "Active";
    const STATUS_IN_ACTIVE_TEXT = "In Active";

    const FLAG_YES_TEXT = "Yes";
    const FLAG_NO_TEXT = "No";

    const AREA_GENERAL_TEXT = "Generalist";
    const AREA_ALL_TEXT = "Generalist All";
    const AREA_SPECIAL_TEXT = "Specialist";
    const AREA_GENERAL_AND_SPECIAL_TEXT = "Generalist & Specialist";

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
            case self::AREA_GENERAL:
                return self::AREA_GENERAL_TEXT;
                break;
            case self::AREA_ALL:
                return self::AREA_ALL_TEXT;
                break;
            case self::AREA_SPECIAL:
                return self::AREA_SPECIAL_TEXT;
                break;
            case self::GENERAL_AND_SPECIAL:
                return self::GENERAL_AND_SPECIAL_TEXT;
                break;    
        }
    }

    public function firmPracticeArea(){
        return $this->hasMany('App\FirmPracticeArea','practice_area_id');
    }
}
