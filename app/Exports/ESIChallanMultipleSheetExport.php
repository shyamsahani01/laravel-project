<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\ESIChallanExport;
use App\Exports\ESIChallanInstructionsExport;
use DB;

class ESIChallanMultipleSheetExport implements WithMultipleSheets
{
    protected $request;
    
    public function __construct($request)
    {
       
        $this->request = $request;
    }

    public function sheets(): array
    {
        return [
            'Sheet1' => new ESIChallanExport($this->request),
            'Sheet2' => new ESIChallanInstructionsExport($this->request),
        ];
    }
}