<?php

namespace App\Exports;

use App\Models\erp\Employee;
use Illuminate\Contracts\View\View;
use App\Library\Helper;
use Maatwebsite\Excel\Concerns\FromView;

class CheckinCheckoutExport implements FromView
{
    protected $request;
    
    public function __construct($userid)
    {
        $this->userid = $userid;
    }

    public function view(): View
    {
        $records = Helper::CheckinData();
        $employee = Employee::where('employee_number',$this->userid)->first();
        //dd($employee);
      
        return view('exports.checkin-checkout', ['records' => $records,'employee' => $employee]);
    }
}