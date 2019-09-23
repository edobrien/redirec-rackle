<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirmDataLoadServices;

class FirmDataLoadController extends Controller
{
    
    private $firmDataLoadServices;

    public function __construct(){
        $this->firmDataLoadServices = new FirmDataLoadServices;
    }

    public function downloadTemplate()
    {
        return $this->firmDataLoadServices->downloadTemplate();
    }
}
