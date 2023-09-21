<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class EmployeeAttendanceExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
    }

    public function view(): View
    {
      $month = 0;
      $year = 0;
      if(!empty($this->request->month) && !empty($this->request->year)){
        $month = $this->request->month;
        $year = $this->request->year;
        $total_date = cal_days_in_month(CAL_GREGORIAN,$this->request->month,$this->request->year);
      }
      else {
        $month = date("m", time());
        $year = date("Y", time());
        $total_date = cal_days_in_month(CAL_GREGORIAN, date("m", time()) ,date("Y", time()));
      }

      $query = DB::connection('erpnext')
                  ->table('tabEmployee')
                  ->select(DB::raw("tabEmployee.name,
                                    tabEmployee.employee,
                                    tabEmployee.employee_name,
                                    tabEmployee.company,
                                    tabEmployee.date_of_joining") )
                  ->leftJoin('tabAttendance', 'tabEmployee.name', 'tabAttendance.employee')
                  // ->where('tabEmployee.status', 'Active')
                  ->orderBy('tabEmployee.employee_name', "ASC")
                  ->groupBy('tabEmployee.name');

        if(!empty($this->request->employee_name)){
              $query->where('tabEmployee.employee_name', 'like', '%' . $this->request->employee_name. '%');
          }

        if(!empty($this->request->company)){
            $query->where('tabEmployee.company',$this->request->company);
        }

        if(!empty($this->request->month) && !empty($this->request->year)){
          $query->whereMonth('tabAttendance.attendance_date', $this->request->month);
          $query->whereYear('tabAttendance.attendance_date', $this->request->year);
        }
        else {
          $query->whereMonth('tabAttendance.attendance_date', date("m", time()));
          $query->whereYear('tabAttendance.attendance_date', date("Y", time()));
        }


      // if(!empty($this->request->show)){
      //   $query->limit($this->request->show);
      // }else{
      //   $query->limit(10);
      // }

      $query->limit(600);


      $empAttendance_data = $query->get();

      $data['empAttendance_data'] = $empAttendance_data;
      $data['total_date'] = $total_date;
      $data['month'] = $month;
      $data['year'] = $year;

      return view('exports.employee_attendance', $data);
    }
}
