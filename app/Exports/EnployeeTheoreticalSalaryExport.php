<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class EnployeeTheoreticalSalaryExport implements FromView, WithTitle
{
    protected $request;

    public function __construct($request, $emp_salary_data)
    {

        $this->request = $request;
        $this->emp_salary_data = $emp_salary_data;
    }

    public function view(): View
    {
        return view("exports.employee_theoretical_salary", [
            "emp_salary_data" => $this->emp_salary_data
        ]);
    }

    public function title(): string
    {
        return 'Theoretical Salary';
    }
}
