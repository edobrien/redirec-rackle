<?php
/**

Firm data load services class to hold the related action logics

*/

namespace App\Services;

use App\Exports\RegionsExport;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class FirmDataLoadServices{

	public function downloadTemplate() {
        return Excel::download(new RegionsExport, 'region.xlsx');
    }
}