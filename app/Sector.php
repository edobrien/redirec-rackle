<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_IN_ACTIVE = "IN_ACTIVE";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

    const SECTOR_GENERAL = "GENERAL";
    const SECTOR_PRIVATE_PRACTICE = "PRIVATE_PRACTICE";
    const SECTOR_INHOUSE = "INHOUSE";

    const STATUS_ACTIVE_TEXT = "Active";
    const STATUS_IN_ACTIVE_TEXT = "In Active";

    const FLAG_YES_TEXT = "Yes";
    const FLAG_NO_TEXT = "No";

    const SECTOR_GENERAL_TEXT = "General";
    const SECTOR_PRIVATE_PRACTICE_TEXT = "Private Practice";
    const SECTOR_INHOUSE_TEXT = "InHouse";

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
            case self::SECTOR_GENERAL:
                return self::SECTOR_GENERAL_TEXT;
                break;
            case self::SECTOR_PRIVATE_PRACTICE:
                return self::SECTOR_PRIVATE_PRACTICE_TEXT;
                break;
            case self::SECTOR_INHOUSE:
                return self::SECTOR_INHOUSE_TEXT;
                break;
        }
    }

    public function firmSector(){
        return $this->hasMany('App\FirmSector','sector_id');
    }
}
