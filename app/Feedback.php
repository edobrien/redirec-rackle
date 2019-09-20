<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    const FLAG_YES = "YES";
    const FLAG_NO = "NO";
    
    public function userId(){ 
        return $this->belongsTo("App\User","user_id");
    }
}
