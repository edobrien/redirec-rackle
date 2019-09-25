<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataUploadLog extends Model
{
    use SoftDeletes;

    const STATUS_UPLOADED = "UPLOADED";
    const STATUS_STARTED = "STARTED";
    const STATUS_COMPLETED = "COMPLETED";
    const STATUS_CANCELLED = "CANCELLED";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

    const STATUS_UPLOADED_TEXT = "Uploaded";
    const STATUS_STARTED_TEXT = "Started";
    const STATUS_COMPLETED_TEXT = "Completed";
    const STATUS_CANCELLED_TEXT = "Cancelled";

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
            case self::STATUS_UPLOADED:
                return self::STATUS_UPLOADED_TEXT;
                break;
            case self::STATUS_STARTED:
                return self::STATUS_STARTED_TEXT;
                break;
            case self::STATUS_COMPLETED:
                return self::STATUS_COMPLETED_TEXT;
                break;
            case self::STATUS_CANCELLED:
                return self::STATUS_CANCELLED_TEXT;
                break;
        }
    }
}
