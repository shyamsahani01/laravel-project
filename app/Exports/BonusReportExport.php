<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class BonusReportExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
        $this->data = $data;
    }

    public function view(): View
    {

      return view('exports.bonus_report', $this->data);
    }
}
