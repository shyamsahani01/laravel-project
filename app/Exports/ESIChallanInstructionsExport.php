<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class ESIChallanInstructionsExport implements FromView, WithTitle
{
    protected $request;
    
    public function __construct($request)
    {
       
        $this->request = $request;
    }

    public function view(): View
    {
        return view('exports.esi_challan_instructions',);
    }

    public function title(): string
    {
        return 'Instructions & Reason Codes';
    }
}