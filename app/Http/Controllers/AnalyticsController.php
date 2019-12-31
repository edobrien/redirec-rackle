<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Services\AnalyticsServices;
use App\AnalyticsCaptureClick;

class AnalyticsController extends Controller
{
    
    private $analyticsServices;

    public function __construct(){
        $this->analyticsServices = new AnalyticsServices;
    }

    public function index()
    {
        return view('admin.analytics.clicks-listing');
    }

    public function indexLoginCount()
    {
        return view('admin.analytics.login-count-listing');
    }

    public function listCaptureClicks()
    {
        return $this->analyticsServices->listCaptureClicks();
    }

    public function listUserLogins()
    {
        return $this->analyticsServices->listUserLogins();
    }

    public function captureClicks(Request $request)
    {
        return $this->analyticsServices->captureClicks($request);
    }

    public function downloadClickReport()
    {
        return $this->analyticsServices->downloadClickReport();
    }
}
