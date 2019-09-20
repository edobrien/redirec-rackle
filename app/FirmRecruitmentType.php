<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirmRecruitmentType extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_IN_ACTIVE = "IN_ACTIVE";

    const STATUS_ACTIVE_TEXT = "Active";
    const STATUS_IN_ACTIVE_TEXT = "In Active";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

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
        }
    }

    public function firm(){
        return $this->belongsTo('App\RecruitmentFirm','recruitment_id');
    }

    public function recruitmentType(){
        return $this->belongsTo('App\RecruitmentType','recruitment_id');
    }
}
