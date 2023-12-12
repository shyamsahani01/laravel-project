<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class ESIChallanExport implements FromView, WithTitle
{
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
    }

    public function view(): View
    {
        $query1 = DB::connection('erpnext')
                ->table('tabEmployee')
                ->select(DB::raw("esic_no,
                              employee_name,
                              0 payment_days,
                              0 esi_earnings,
                              2 workings_day1,
                              esic_exit_date as last_working_day") )
              ->where('esic_no', '!=', NULL);

          if(!empty($this->request->employee_name)){
                $query1->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
            }

          if(!empty($this->request->company)){
              $query1->where('company', $this->request->company);
          }

          if(!empty($this->request->month) && !empty($this->request->year)){
            $current_month = $this->request->month;
            $current_year = $this->request->year;
            $previous_month =  $current_month - 1;
            $previous_year = $current_year;
            if($previous_month <= 0) { $previous_month = 12;  $previous_year =  $current_year - 1; }

            // $query1->whereRaw(" ( ( MONTH(relieving_date) = '$previous_month' AND YEAR(relieving_date) = '$previous_year' ) OR
            //                     ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");
            $query1->whereRaw(" (
                                ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");


          } else {

            $current_month = date("m", time());
            $current_year = date("Y", time());
            $previous_month =  $current_month - 1;
            $previous_year = $current_year;
            if($previous_month <= 0) { $previous_month = 12;  $previous_year =  $current_year - 1; }

            // $query1->whereMonth('relieving_date', $previous_month);
            // $query1->whereYear('relieving_date', $previous_year);

            $query1->whereRaw(" ( 
                                ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");
            // $query1->whereRaw(" ( ( MONTH(relieving_date) = '$previous_month' AND YEAR(relieving_date) = '$previous_year' ) OR
            //                     ( MONTH(esic_exit_date) = '$previous_month' AND YEAR(esic_exit_date) = '$previous_year' ) )");

          }


  $query2 = DB::connection('erpnext')
              ->table('tabSalary Slip')
              ->select(DB::raw("esic_no,
                            employee_name,
                            round(payment_days) payment_days,
                            round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
                            `tabSalary Detail`.parent and td.abbr='WA' ),0)) esi_earnings,
                            (if (payment_days>0,0,1)) workings_day1,
                            esic_exit_date as last_working_day") )
              ->leftJoin('tabSalary Detail', function ($join) {
                $join->on('tabSalary Slip.name', '=', 'tabSalary Detail.parent')
                ->where('tabSalary Detail.abbr', '=', 'B');
              })
              ->whereRaw("( SELECT amount FROM  `tabSalary Detail` tsd WHERE tsd.parent = `tabSalary Slip`.name and  tsd.abbr = 'ESI' ) > 0")
              // ->whereRaw("round(gross_pay- IFNULL( (select amount from `tabSalary Detail` td where td.parent=
              // `tabSalary Detail`.parent and td.abbr='WA' ),0)) <= 21000")
              ->whereNull('esic_exit_date')
              ->where('esic_no', '!=', NULL)
              ->where('payment_days', "!=", NULL)
              ->union($query1);

    if(!empty($this->request->employee_name)){
          $query2->where('employee_name', 'like', '%' . $this->request->employee_name. '%');
      }

    if(!empty($this->request->company)){
        $query2->where('company', $this->request->company);
    }

    if(!empty($this->request->month) && !empty($this->request->year)){
      $query2->whereMonth('start_date', $this->request->month);
      $query2->whereMonth('end_date', $this->request->month);
      $query2->whereYear('start_date', $this->request->year);
      $query2->whereYear('end_date', $this->request->year);
    }

        $data = $query2->get();

        return view('exports.esi_challan', ['esi_challan_data' => $data]);
    }

    public function title(): string
    {
        return 'Sheet1';
    }

}
