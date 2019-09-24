<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataUploadLog extends Model
{
    use SoftDeletes;

    const STATUS_UPLOADED = "UPLOADED";
    const STATUS_PROCESSED = "PROCESSED";

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";

    const STATUS_UPLOADED_TEXT = "Uploaded";
    const STATUS_PROCESSED_TEXT = "Processed";

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
            case self::STATUS_PROCESSED:
                return self::STATUS_PROCESSED_TEXT;
                break;
        }
    }
}
