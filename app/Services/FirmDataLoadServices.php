<?php
/**

Firm data load services class to hold the related action logics

*/

namespace App\Services;

use App\HelpfulArticle;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class FirmDataLoadServices{

	public function downloadTemplate() {
        $data = HelpfulArticle::get()->toArray();
		return Excel::create('bulk_upload_template', function($excel) use ($data) {
			$excel->sheet('HelpfulArticles', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download('xlsx');
    }
}