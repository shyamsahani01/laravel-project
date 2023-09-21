<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\Library\AdminHelper;

class Unit2fgReportExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->EmrSeetapuraDB = DB::connection('EmrSeetapura');
        $this->erpnextDB = DB::connection('erpnext');
    }

    public function view(): View
    {
      $query1 = $this->EmrSeetapuraDB->table('Fgd');
      $query1->select("FdDt")->distinct()->groupBy("FdDt");


      if(!empty($this->this->request->start_date) && !empty($this->request->end_date)){
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
          $auto_end_date = date('Y-m-d', strtotime ('+1 day' , strtotime($data->FdDt) ) );

          $auto_shift_start_date = $auto_start_date . " 09:30:00";
          $auto_shift_end_date = $auto_start_date ." 18:00:00";

          $query_string  = "SELECT odomcmcd,
                                   odkt,
                                   fdqty,
                                   odsalprc*fdqty as FgValue,
                                   fdprdodno,
                                   fdprdodsr,
                                   fdgrwt,
                                   FdCoCd
                            FROM fgd
                            JOIN orddsg ON odno = fdprdodno
                                  AND odsr = fdprdodsr
                                  AND odtc = fdprdodtc
                                  AND odchr = fdprdodchr
                            WHERE ( OdKt = 'S999' OR OdKt = 'S925' OR OdKt LIKE '%kt%'   )
                                    AND FdCoCd = 'PJ2'
                                    and fddt = '$auto_start_date' ";
          $fg_data_temp = $this->EmrSeetapuraDB->select($query_string);

          $qty_silver = 0;
          $wt_silver = 0;

          $qty_gold = 0;
          $wt_gold = 0;


          foreach ($fg_data_temp as $key3 => $data3) {

            if(stripos($data3->odkt, "S999") !== false || stripos($data3->odkt, "S925") !== false ) {
              $qty_silver = $qty_silver + $data3->fdqty;
              $wt_silver = $wt_silver + $data3->fdgrwt;
            }
            elseif(stripos($data3->odkt, "kt") !== false) {
              $qty_gold = $qty_gold + $data3->fdqty;
              $wt_gold = $wt_gold + $data3->fdgrwt;
            }
            else {
              // echo "hi11<br>";
            }

          }

          $temp_data_fg = [
                        "qty_silver"=>$qty_silver,
                        "wt_silver"=>round($wt_silver, 2),

                        "qty_gold"=>$qty_gold,
                        "wt_gold"=>round($wt_gold, 2),
                       ];

          $fgData[$key]->fg_data =  (object) $temp_data_fg;


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
              WHERE (tabEmployee.department LIKE  '%silver%'
                    OR tabEmployee.department LIKE  '%gold%' )
                    AND tabEmployee.company = 'Pinkcity Jewelhouse Private Limited-Unit 2'
                    AND ( `tabEmployee Checkin`.log_type = 'IN' )
                    AND ( `tabEmployee Checkin`.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
                    AND ( checkIn2.log_type = 'OUT' )
                    AND ( checkIn2.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
               GROUP BY tabEmployee.name";
          $employee_data = $this->erpnextDB->select($query_string);

          $total_employee_silver = 0;
          $actual_over_time_amount_silver = 0;
          $net_over_time_amount_silver = 0;
          $per_day_sallery_silver = 0;

          $total_employee_gold = 0;
          $actual_over_time_amount_gold = 0;
          $net_over_time_amount_gold = 0;
          $per_day_sallery_gold = 0;

          $manpower_cost = 0;
          $over_time_count = 0;

          foreach ($employee_data as $key2 => $data) {

            $manpower_cost = $manpower_cost + $data->per_day_sallery;

            if(stripos($data->department, "silver") !== false) {

              $total_employee_silver++;

              $per_day_sallery_silver = $per_day_sallery_silver + $data->per_day_sallery;

              // this happened only on sunday data
              if($data->over_time == NULL) {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->in_out_diff_in_hour);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount_silver = $actual_over_time_amount_silver +  ( ( (float) $data->per_day_sallery / (float) 8.5 ) * (float) $data->in_out_diff_in_hour ) ;
                  $net_over_time_amount_silver = $net_over_time_amount_silver + $data->per_day_sallery;
                }


              } else {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->in_out_diff_in_hour);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount_silver = $actual_over_time_amount_silver +  ( ( (float) $data->per_day_sallery / (float) $data->shift_diff ) * (float) $data->over_time ) ;
                  $net_over_time_amount_silver = $net_over_time_amount_silver + $data->per_day_sallery;
                }


              }

            }
            elseif(stripos($data->department, "gold") !== false) {

              $total_employee_gold++;

              $per_day_sallery_gold = $per_day_sallery_gold + $data->per_day_sallery;

              // this happened only on sunday data
              if($data->over_time == NULL) {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->in_out_diff_in_hour);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount_gold = $actual_over_time_amount_gold +  ( ( (float) $data->per_day_sallery / (float) 8.5 ) * (float) $data->in_out_diff_in_hour ) ;
                  $net_over_time_amount_gold = $net_over_time_amount_gold + $data->per_day_sallery;
                }

              } else {

                $over_time_include = 0;
                $over_time_include = AdminHelper::overTimeCalculation($data->base, $data->in_out_diff_in_hour);

                if( $over_time_include == 1 ) {
                  $actual_over_time_amount_gold = $actual_over_time_amount_gold +  ( ( (float) $data->per_day_sallery / (float) $data->shift_diff ) * (float) $data->over_time ) ;
                  $net_over_time_amount_gold = $net_over_time_amount_gold + $data->per_day_sallery;
                }

              }

            }
            else {
              // echo "hi11<br>";
            }

          }

          $temp_data = [
                        "total_employee_silver"=>$total_employee_silver,
                        "per_day_sallery_silver"=>round($per_day_sallery_silver, 2),
                        "actual_over_time_amount_silver"=>round($actual_over_time_amount_silver, 2),
                        "net_over_time_amount_silver"=>round($net_over_time_amount_silver, 2),

                        "total_employee_gold"=>$total_employee_gold,
                        "per_day_sallery_gold"=>round($per_day_sallery_gold, 2),
                        "actual_over_time_amount_gold"=>round($actual_over_time_amount_gold, 2),
                        "net_over_time_amount_gold"=>round($net_over_time_amount_gold, 2),

                        "manpower_cost"=>round($manpower_cost, 2),
                       ];

          $fgData[$key]->employee_data =  (object) $temp_data;
          // $fgData[$key]->employee_data =  (object) $temp_data;

          // print_r($temp_data);
      }

      return view('exports.unit2fgReport', ['fgData' => $fgData] );
    }


}
