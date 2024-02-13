<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class ComplianceSheetExport implements FromView
{
    protected $request;

    public function __construct($request, $data =[])
    {

        $this->request = $request;
    }

    public function view(): View
    {
      $months = ["01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April",
      "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August",
      "09"=>"September", "10"=>"Octomber", "11"=>"November", "12"=>"December"];

      $erpnextDB = DB::connection("erpnext");

      $month = 0;
      $month_name = 0;
      $company = "";
      $year = 0;
      if(!empty($this->request->month) && !empty($this->request->year)){
        // print_r("hi22");
        $month = $this->request->month;
        $year = $this->request->year;
        $month_name = $months[$month];
        $total_date = cal_days_in_month(CAL_GREGORIAN,$this->request->month,$this->request->year);
      }
      else {
        // print_r("hi33");
        $month = date("m", time());
        $month_name = date("F", time());
        $year = date("Y", time());
        $total_date = cal_days_in_month(CAL_GREGORIAN, date("m", time()) ,date("Y", time()));
      }

      $this->month = $month;
      $this->year = $year;

      // print_r($month);
      // die;

      $query = $erpnextDB
                  ->table("tabEmployee AS te")
                  // ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour, SUM(report_emp_attendace_detail.ot_hours_round) ot_hours_round") )
                  ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour") )
                  // ->select(DB::Raw("te.*, tei.payroll_date, tei.ot_hour ") )
                  ->join('tabAttendance', "tabAttendance.employee", "te.employee")
                  ->leftJoin('tabAdditional Salary as tas', function ($join) {
                        $join->on('tas.employee', '=', 'te.employee')
                        ->whereMonth('tas.payroll_date', $this->month)
                        ->whereYear('tas.payroll_date', $this->year)
                        ->where('tas.salary_component', 'OT');
                    })

                  // ->leftJoin('tabEmployee Incentive as tei', function ($join) {
                  //       $join->on('tei.employee', '=', 'te.employee')
                  //       ->whereMonth('tei.payroll_date', $this->month)
                  //       ->whereYear('tei.payroll_date', $this->year)
                  //       ->where('tei.salary_component', 'OT');
                  //   })
                  // ->leftJoin('report_emp_attendace_detail', function ($join) {
                  //       $join->on('report_emp_attendace_detail.emp', '=', 'te.employee')
                  //       ->whereMonth('report_emp_attendace_detail.date', $this->month)
                  //       ->whereYear('report_emp_attendace_detail.date', $this->year);
                  //   })
                  ->whereMonth('tabAttendance.attendance_date', $month)
                  ->whereYear('tabAttendance.attendance_date', $year)
                  ->where('tabAttendance.docstatus', 1)
                  ->groupBy('te.employee');

        // $query = $erpnextDB
        //             ->table("tabEmployee AS te")
        //             // ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour, SUM(report_emp_attendace_detail.ot_hours_round) ot_hours_round") )
        //             ->select(DB::Raw("te.*, tas.payroll_date, tas.amount, tas.ot_hour") )
        //             ->join('tabAttendance', "tabAttendance.employee", "te.employee")
        //             ->leftJoin('tabAdditional Salary as tas', function ($join) {
        //                   $join->on('tas.employee', '=', 'te.employee')
        //                   ->whereMonth('tas.payroll_date', $this->month)
        //                   ->whereYear('tas.payroll_date', $this->year)
        //                   ->where('tas.salary_component', 'OT');
        //               })
        //             ->whereMonth('tabAttendance.attendance_date', $month)
        //             ->whereYear('tabAttendance.attendance_date', $year)
        //             ->where('tabAttendance.docstatus', 1)
        //             ->groupBy('te.employee');


        if(!empty($this->request->employee_name)){
              $query->where('te.employee_name', 'like', '%' . $this->request->employee_name. '%');
          }

        if(!empty($this->request->company)){
            $query->where('te.company',$this->request->company);
            $company = $this->request->company;
        }


        $query->limit(1000);


        $compliance_data = $query->get();

        foreach ($compliance_data as $key => $value) {
          // $compliance_data[$key]->attendance_data = $erpnextDB
          //             ->table("report_emp_attendace_detail")
          //             ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type")
          //             // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )
          //
          //             ->leftjoin('tabAttendance', function ($join) {
          //                 $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
          //                      ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
          //             })
          //             ->where('report_emp_attendace_detail.emp', $value->employee)
          //             ->where('tabAttendance.docstatus', 1)
          //             ->whereMonth('report_emp_attendace_detail.date', $month)
          //             ->whereYear('report_emp_attendace_detail.date', $year)
          //
          //             // ->groupBy('report_emp_attendace_detail.date')
          //             ->get();
          // $compliance_data[$key]->attendance_data = $erpnextDB
          //             ->table("report_emp_attendace_detail")
          //             ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type")
          //             // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )
          //
          //             ->crossJoin('tabAttendance', function ($join) {
          //                 $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
          //                      ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
          //             })
          //             ->where('report_emp_attendace_detail.emp', $value->employee)
          //             ->where('tabAttendance.docstatus', 1)
          //             ->whereRaw("( ( MONTH(report_emp_attendace_detail.date) = $month and YEAR(report_emp_attendace_detail.date) = $year ) OR ( MONTH(tabAttendance.attendance_date) = $month and YEAR(tabAttendance.attendance_date) = $year ) ) ")
          //             ->get();

          $compliance_data[$key]->attendance_data = $erpnextDB
                      ->table("tabAttendance")
                      ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type", "tabAttendance.attendance_date",)
                      // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )

                      ->leftJoin('report_emp_attendace_detail', function ($join) {
                          $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
                               ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
                      })
                      ->where('tabAttendance.employee', $value->employee)
                      ->where('tabAttendance.docstatus', 1)
                      ->whereRaw("( ( MONTH(report_emp_attendace_detail.date) = $month and YEAR(report_emp_attendace_detail.date) = $year ) OR ( MONTH(tabAttendance.attendance_date) = $month and YEAR(tabAttendance.attendance_date) = $year ) ) ")
                      ->get();

          // $compliance_data[$key]->attendance_data = $erpnextDB
          //             ->table("tabAttendance")
          //             ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type", "tabAttendance.attendance_date",)
          //             // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )
          //
          //             ->leftJoin('report_emp_attendace_detail', function ($join) {
          //                 $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
          //                      ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
          //             })
          //             ->where('tabAttendance.employee', $value->employee)
          //             ->where('tabAttendance.docstatus', 1)
          //             ->whereRaw("( ( MONTH(report_emp_attendace_detail.date) = $month and YEAR(report_emp_attendace_detail.date) = $year ) OR ( MONTH(tabAttendance.attendance_date) = $month and YEAR(tabAttendance.attendance_date) = $year ) ) ")
          //             ->get();

          // $compliance_data[$key]->attendance_data = $erpnextDB
          //             ->table("tabAttendance")
          //             ->select("report_emp_attendace_detail.*", "tabAttendance.status", "tabAttendance.leave_type")
          //             // ->select(DB::Raw("report_emp_attendace_detail.*, tabAttendance.status, tabAttendance.leave_type, SUM(ot_hours_round) AS ot_hour_total") )
          //
          //             ->leftjoin('report_emp_attendace_detail', function ($join) {
          //                 $join->on('tabAttendance.employee', '=', 'report_emp_attendace_detail.emp')
          //                      ->whereRaw("DATE(report_emp_attendace_detail.date) = DATE(tabAttendance.attendance_date)");
          //             })
          //             ->where('tabAttendance.employee', $value->employee)
          //             ->where('tabAttendance.docstatus', 1)
          //             ->whereMonth('tabAttendance.attendance_date', $month)
          //             ->whereYear('tabAttendance.attendance_date', $year)
          //
          //             // ->groupBy('report_emp_attendace_detail.date')
          //             ->get();
        }

        $holiday_list = $erpnextDB
                    ->table("tabHoliday")
                    ->whereMonth('holiday_date', $month)
                    ->whereYear('holiday_date', $year)
                    ->get();

        $data['compliance_data'] = $compliance_data;
        $data['holiday_list'] = $holiday_list;
        $data['total_date'] = $total_date;
        $data['month'] = $month;
        $data['month_name'] = $month_name;
        $data['year'] = $year;
        $data['company'] = $company;

        // echo "<pre>";
        // print_r($compliance_data);


        return view("exports.compliance_sheet", $data);

    }
}
