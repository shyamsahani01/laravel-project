<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\EmployeeDetailsExport;
use App\Exports\ESIChallanInstructionsExport;
use DB;

class EmployeeDetailMultipleSheetExport implements WithMultipleSheets
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function sheets(): array
    {
      $erpnextDB = DB::connection("erpnext");
    $query = $erpnextDB
                ->table("tabEmployee")
                ->where("employee", $this->request->employee);
    $emp_details_data = $query->first();

    $query1 = $erpnextDB
                ->table("tabSalary Slip")
                ->select(DB::raw(
                      "`tabSalary Slip`.name,
                      `tabSalary Slip`.employee,
                      `tabSalary Slip`.employee_name,
                      `tabSalary Slip`.payment_days,
                      `tabSalary Slip`.net_pay,
                      `tabSalary Slip`.start_date,
                      `tabSalary Slip`.gross_pay,
                      `tabSalary Slip`.net_pay,
                      `tabSalary Slip`.gross_monthly_salary,
                      `tabSalary Slip`.base_net_pay,
                      `tabSalary Slip`.total_working_days,
                      `tabSalary Detail`.abbr,
                      ( SELECT
                           SUM( IF(tabAttendance.status = 'Present', 1,
                                      IF(tabAttendance.status = 'Half Day', 0.5, 0 )
                                  )
                            )
                           FROM tabAttendance
                           WHERE tabAttendance.employee = '$this->request->employee'
                           AND ( tabAttendance.attendance_date BETWEEN
                                    `tabSalary Slip`.start_date
                                    AND  `tabSalary Slip`.end_date  )
                      ) as total_present
                      "
                  ))
                ->join("tabSalary Detail", "tabSalary Detail.parent", "tabSalary Slip.name")
                ->groupBy("tabSalary Slip.name")
                ->where("employee", $this->request->employee);
    $emp_salary_data = $query1->get();


        return [
            'Sheet1' => new EmployeeDetailsExport($this->request, $emp_details_data),
            'Sheet2' => new EmployeeMonthlySalaryExport($this->request, $emp_salary_data),
            'Sheet3' => new EmployeeYearlySalaryExport($this->request, $emp_salary_data),
            'Sheet4' => new EnployeeTheoreticalSalaryExport($this->request, $emp_salary_data),

        ];
    }
}
