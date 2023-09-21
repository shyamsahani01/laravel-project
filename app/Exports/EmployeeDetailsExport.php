<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class EmployeeDetailsExport implements FromView, WithTitle
{
    protected $request;

    public function __construct($request, $emp_details_data)
    {

        $this->request = $request;
        $this->emp_details_data = $emp_details_data;
    }

    public function view(): View
    {

      return view("exports.employee_details", [
          "emp_details_data" => $this->emp_details_data
      ]);
    }

    public function title(): string
    {
        return 'Employee Personal Detail';
    }

}
