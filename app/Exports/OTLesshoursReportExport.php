<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class OTLesshoursReportExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
    }

    public function view(): View
    {

      $erpnextDB = DB::connection("erpnext");

      $query = $erpnextDB
                    ->table("report_emp_attendace_detail")
                    ->select(DB::raw("report_emp_attendace_detail.*,
                                        tabEmployee.employee,
                                        tabEmployee.employee_name,
                                        tabEmployee.attendance_device_id,
                                        tabEmployee.company") )
                    ->leftJoin('tabEmployee', 'tabEmployee.employee', 'report_emp_attendace_detail.emp');


        if(!empty($this->request->employee_name)){
              $query->where('tabEmployee.employee_name', 'like', '%' . $this->request->employee_name. '%');
              // $query->where('tabEmployee.employee', $request->employee);
          }

        if(!empty($this->request->company)){
            $query->where('tabEmployee.company',$this->request->company);
        }

        if(!empty($this->request->start_date)){
            $query->whereDate('report_emp_attendace_detail.date', ">=", $this->request->start_date);
            $query->orderBy('report_emp_attendace_detail.date', "ASC");
        }
        else {
          $query->orderBy('report_emp_attendace_detail.date', "DESC");
          $auto_start_date = date('Y-m-d', strtotime ( '-2 day' , time() ) );
          $query->whereDate('report_emp_attendace_detail.date', $auto_start_date);
          $this->request->start_date = $auto_start_date;
        }

        if(!empty($this->request->end_date)){
            $query->whereDate('report_emp_attendace_detail.date', "<=", $this->request->end_date);
        }

        $query->limit(1500);

        $ot_lesshours_data = $query->get();

        return view("exports.ot_lesshours", [
            "ot_lesshours_data" => $ot_lesshours_data,
        ]);

    }
}
