<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\Library\AdminHelper;

class Unit1fgReportExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->EmrSitapuraDB = DB::connection('EmrSitapura');
        $this->erpnextDB = DB::connection('erpnext');
    }

    public function view(): View
    {
      $query1 = $this->EmrSitapuraDB->table('Fgd');
      $query1->select(DB::raw("sum(FdQty) quantity,
                            sum(FdGrWt) weight,
                            FdDt") )
           ->join('OrdDsg','odno', '=', 'fdprdodno' )
          ->where("FdCoCd", "PJ") // "PC" or "PJ"
          ->where(function($query) {
            $query->where("OdKt", "S999")
                  ->orWhere("OdKt", "S925");
          })
          ->whereRaw("odsr=fdprdodsr")
          ->whereRaw("odtc=fdprdodtc")
          ->whereRaw("odchr=fdprdodchr")
          ->groupBy("FdDt");

      if(!empty($this->request->start_date) && !empty($this->request->end_date)){
          $query1->whereBetween('FdDt', [$this->request->start_date, $this->request->end_date]);
          // $query1->OrderBy('FdDt','ASC');
          $query1->OrderBy('FdDt','DESC');
      }
      else {
        $query1->OrderBy('FdDt','DESC');
      }

      if(!empty($this->request->show)){
        $query1->limit($this->request->show);
      }else{
        $query1->limit(10);
      }
      $fgData = $query1->get();

      foreach($fgData as $key => $data) {


          $auto_start_date = date('Y-m-d', strtotime($data->FdDt));
          $auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($data->FdDt) ) );

          $query_string  = "SELECT tabEmployee.employee_name,
                                   tabEmployee.name,
                                   tabEmployee.department,
                                  `tabEmployee Checkin`.shift_start,
                                  `tabEmployee Checkin`.shift_end,
                                   `tabEmployee Checkin`.time in_time,
                                   checkIn2.time out_time,
                                   TIMEDIFF(`tabEmployee Checkin`.shift_start,
                                             `tabEmployee Checkin`.time ) in_time_diff,
                                   TIMEDIFF(checkIn2.time,
                                            `tabEmployee Checkin`.shift_end) out_time_diff,
                                   TIMEDIFF(`tabEmployee Checkin`.shift_end,
                                            `tabEmployee Checkin`.shift_start) shift_diff,
                                   ( TIME_TO_SEC( TIMEDIFF(`tabEmployee Checkin`.shift_end,
                                                         `tabEmployee Checkin`.shift_start) ) / ( 60 * 60 ) ) shift_diff_in_hour,
                                   TIMEDIFF(checkIn2.time,
                                            `tabEmployee Checkin`.time) in_out_diff,
                                   ( TIME_TO_SEC( TIMEDIFF(checkIn2.time,
                                                         `tabEmployee Checkin`.time) ) / ( 60 * 60 ) ) in_out_diff_in_hour,
                                   base,
                                  ( base  / DAY( LAST_DAY('$auto_start_date') ) ) per_day_sallery,
                                  ( ( ( IF( TIME_TO_SEC(
                                                    TIMEDIFF(`tabEmployee Checkin`.shift_start,
                                                      `tabEmployee Checkin`.time ) ) <= 0,
                                                  0, TIME_TO_SEC(
                                                        TIMEDIFF( `tabEmployee Checkin`.shift_start,
                                                                  `tabEmployee Checkin`.time )
                                                                )
                                            )
                                        + IF( TIME_TO_SEC(
                                                    TIMEDIFF(
                                                      checkIn2.time,
                                                      `tabEmployee Checkin`.shift_end )
                                                            ) <= 0,
                                                  0, TIME_TO_SEC(
                                                      TIMEDIFF( checkIn2.time,
                                                                `tabEmployee Checkin`.shift_end )
                                                              )
                                              )
                                        ) / (60 * 60)
                                      )
                                    ) AS over_time
              FROM tabEmployee
              JOIN `tabEmployee Checkin` ON `tabEmployee Checkin`.employee = tabEmployee.name
              JOIN `tabEmployee Checkin` checkIn2 ON checkIn2.employee = tabEmployee.name
              JOIN  `tabSalary Structure Assignment` ON `tabSalary Structure Assignment`.employee = tabEmployee.name
                     AND `tabSalary Structure Assignment`.is_active = 1
              WHERE tabEmployee.department LIKE  '%silver%'
                    AND tabEmployee.company = 'Pinkcity Jewelhouse Private Limited- Unit 1'
                    AND ( `tabEmployee Checkin`.log_type = 'IN' )
                    AND ( `tabEmployee Checkin`.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
                    AND ( checkIn2.log_type = 'OUT' )
                    AND ( checkIn2.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
               GROUP BY tabEmployee.name";
          $employee_data = $this->erpnextDB->select($query_string);

          $total_employee = 0;
          $actual_over_time_amount = 0;
          $net_over_time_amount = 0;
          $per_day_sallery = 0;
          $manpower_cost = 0;
          $over_time_count = 0;

          foreach ($employee_data as $key2 => $data) {

            $manpower_cost = $manpower_cost + $data->per_day_sallery;

            if(stripos($data->department, "silver") !== false) {

              $total_employee++;

              $per_day_sallery = $per_day_sallery + $data->per_day_sallery;


              // this happened only on sunday data
              if($data->over_time == NULL) {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->in_out_diff_in_hour);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount = $actual_over_time_amount +  ( ( (float) $data->per_day_sallery / (float) 8.5 ) * (float) $data->in_out_diff_in_hour ) ;
                  $net_over_time_amount = $net_over_time_amount + $data->per_day_sallery;
                }

              } else {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->over_time);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount = $actual_over_time_amount +  ( ( (float) $data->per_day_sallery / (float) $data->shift_diff ) * (float) $data->over_time ) ;
                  $net_over_time_amount = $net_over_time_amount + $data->per_day_sallery;
                }
              }

            }
            else {
              // echo "hi11<br>";
            }

          }

          $temp_data = ["total_employee"=>$total_employee,
                        "per_day_sallery"=>round($per_day_sallery, 2),
                        "over_time_sallery"=>round($actual_over_time_amount, 2),
                        "actual_over_time_amount"=>round($actual_over_time_amount, 2),
                        "net_over_time_amount"=>round($net_over_time_amount, 2),
                        "manpower_cost"=>round($manpower_cost, 2),
                       ];

          $fgData[$key]->employee_data =  (object) $temp_data;

      }

      return view('exports.unit1fgReport', ['fgData' => $fgData] );
    }


}
