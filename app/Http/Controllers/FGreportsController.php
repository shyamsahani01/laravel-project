<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\erp\AttendanceRecords;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Exports\Unit1fgReportExport;
use App\Exports\MahapurafgReportExport;
use App\Exports\Unit2fgReportExport;
use App\Library\AdminHelper;

class FGreportsController extends Controller
{
  public function __construct()
  {
    setlocale(LC_MONETARY, 'en_IN');

    $this->EmrDB = DB::connection('Emr');
    $this->EmrSeetapuraDB = DB::connection('EmrSeetapura');
    $this->erpnextDB = DB::connection('erpnext');
  }

  public function unit1fgReportList(Request $request){


    $title = 'Unit 1 Finish Goods Reports';
    // select odomcmcd,odkt,fdqty,odsalprc*fdqty as FgValue,fdprdodno,fdprdodsr,fdgrwt, FdCoCd
    // from fgd
    // join orddsg on
    //       odno = fdprdodno
    //       and odsr=fdprdodsr
    //       and odtc=fdprdodtc
    //       and odchr=fdprdodchr
    // WHERE ( OdKt = 'S999' or OdKt = 'S925'   )
    //         and FdCoCd = 'PC'

    // select
    //     odomcmcd,odkt,fdqty,odsalprc*fdqty as FgValue,fdprdodno,fdprdodsr,fdgrwt,fgd.FdDt
    //     from fgd
    //     join orddsg on odno = fdprdodno and odsr=fdprdodsr
    //     and odtc=fdprdodtc and odchr=fdprdodchr

    // select odomcmcd,odkt,fdqty,odsalprc*fdqty as FgValue,fdprdodno,fdprdodsr,fdgrwt, FdCoCd,fddt
    // from fgd
    // join orddsg on
    //       odno = fdprdodno
    //       and odsr=fdprdodsr
    //       and odtc=fdprdodtc
    //       and odchr=fdprdodchr
    // WHERE ( OdKt = 'S999' or OdKt = 'S925'   )
    //         and FdCoCd = 'PC'
    //         and fddt = '2022-06-25'



    $query1 = $this->EmrSeetapuraDB->table('Fgd');
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

    if(!empty($request->start_date) && !empty($request->end_date)){
        $query1->whereBetween('FdDt', [$request->start_date, $request->end_date]);
        // $query1->OrderBy('FdDt','ASC');
        $query1->OrderBy('FdDt','DESC');
    }
    else {
      $query1->OrderBy('FdDt','DESC');
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }
    $fgData = $query1->paginate($pagination);

    foreach($fgData as $key => $data) {
      // $query2 = DB::connection('erpnext')->table('tabEmployee');
      // $query2->select(DB::raw("COUNT(*) total_employee,
      //                           SUM( ( base ) / DAY(LAST_DAY('".date('Y-m-d',strtotime($data->FdDt))."') ) )
      //                           per_day_salary
      //                       ") )
      //      ->join('tabEmployee Checkin',
      //                   'tabEmployee Checkin.employee', '=', 'tabEmployee.name' )
      //      ->join('tabSalary Structure Assignment',
      //                   'tabSalary Structure Assignment.employee', '=', 'tabEmployee Checkin.employee' )
      //
      //      ->where('tabEmployee.department', 'like', "%Silver%")
      //      ->where('tabEmployee.company', 'Pinkcity Jewelhouse Private Limited- Unit 1')
      //      ->where('tabEmployee Checkin.log_type', 'IN')
      //      ->whereDate('tabEmployee Checkin.time', date('Y-m-d',strtotime($data->FdDt)));
      //
      //      if(!empty($request->company)){
      //       $query2->where('tabEmployee Checkin.company', $request->company);
      //     }
      //     $fgData[$key]->employee_data = $query2->first();




        $auto_start_date = date('Y-m-d', strtotime($data->FdDt));
        $auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($data->FdDt) ) );

        // $query_string  = "SELECT COUNT(*) AS total_employee,
        //                           sum(   base  / DAY (
        //                                                 LAST_DAY('$auto_start_date')
        //                                               )
        //                               ) per_day_sallery,
        //                               sum(
        //                                 IF((
        //                                     (
        //                                       IF(
        //                                         TIME_TO_SEC(
        //                                           TIMEDIFF(
        //                                             `tabEmployee Checkin`.shift_start,
        //                                             tabAttendance.in_time
        //                                           )
        //                                         ) <= 0,
        //                                         0,
        //                                         TIME_TO_SEC(
        //                                           TIMEDIFF(
        //                                             `tabEmployee Checkin`.shift_start,
        //                                             tabAttendance.in_time
        //                                           )
        //                                         )
        //                                       ) + IF(
        //                                         TIME_TO_SEC(
        //                                           TIMEDIFF(
        //                                             tabAttendance.out_time,
        //                                             `tabEmployee Checkin`.shift_end
        //                                           )
        //                                         ) <= 0,
        //                                         0,
        //                                         TIME_TO_SEC(
        //                                           TIMEDIFF(
        //                                             tabAttendance.out_time,
        //                                             `tabEmployee Checkin`.shift_end
        //                                           )
        //                                         )
        //                                       )
        //                                     ) / (60 * 60)
        //                                   ) >= 1,
        //                                   (
        //                                       (
        //                                         IF(
        //                                           TIME_TO_SEC(
        //                                             TIMEDIFF(
        //                                               `tabEmployee Checkin`.shift_start,
        //                                               tabAttendance.in_time
        //                                             )
        //                                           ) <= 0,
        //                                           0,
        //                                           TIME_TO_SEC(
        //                                             TIMEDIFF(
        //                                               `tabEmployee Checkin`.shift_start,
        //                                               tabAttendance.in_time
        //                                             )
        //                                           )
        //                                         ) + IF(
        //                                           TIME_TO_SEC(
        //                                             TIMEDIFF(
        //                                               tabAttendance.out_time,
        //                                               `tabEmployee Checkin`.shift_end
        //                                             )
        //                                           ) <= 0,
        //                                           0,
        //                                           TIME_TO_SEC(
        //                                             TIMEDIFF(
        //                                               tabAttendance.out_time,
        //                                               `tabEmployee Checkin`.shift_end
        //                                             )
        //                                           )
        //                                         )
        //                                       ) / (60 * 60)
        //                                     )
        //                                   ,
        //                                   0)
        //                                    * (
        //                                     ((base) / DAY(LAST_DAY('$auto_start_date'))) / ( TIME_TO_SEC( TIMEDIFF(`tabEmployee Checkin`.shift_end,
        //                                                                                       `tabEmployee Checkin`.shift_start) ) / ( 60 * 60 ) )
        //                                   )
        //                                 ) AS over_time_sallery
        //     FROM tabEmployee
        //     JOIN `tabEmployee Checkin` ON `tabEmployee Checkin`.employee = tabEmployee.name
        //     JOIN tabAttendance on `tabEmployee Checkin`.attendance  = tabAttendance.name
        //     JOIN  `tabSalary Structure Assignment` ON `tabSalary Structure Assignment`.employee = tabEmployee.name
        //     WHERE tabEmployee.department LIKE  '%silver%'
        //           AND tabEmployee.company = 'Pinkcity Jewelhouse Private Limited- Unit 1'
        //           AND ( `tabEmployee Checkin`.log_type = 'IN' )
        //           AND ( `tabEmployee Checkin`.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
        //
        //      ORDER BY `tabSalary Structure Assignment`.creation DESC";

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
        // $fgData[$key]->employee_data =  (object) $temp_data;

        // print_r($temp_data);


    }



    return view('admin.fgreports.unit1.list',compact('title', 'fgData'));
  }

  public function unit1fgReportDetails(Request $request){

    $title = 'Unit 1 Finish Goods Details';

    if(!empty($request->fg_date)){
        $fg_date = $request->fg_date;
    }
    else {
      $fg_date = date('Y-m-d', strtotime(time()));
    }

    $auto_start_date = date('Y-m-d', strtotime($fg_date));
    $auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($fg_date) ) );


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


    // $query1 = $this->EmrDB->table('fgd')
    //                       ->where('FdDt',  date('Y-m-d', strtotime($fg_date) ) );
    // $fg_data =  $query1->get();

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
                      WHERE ( OdKt = 'S999' OR OdKt = 'S925'   )
                              AND FdCoCd = 'PJ'
                              and fddt = '$auto_start_date'";
    $fg_data = $this->EmrSeetapuraDB->select($query_string);


    return view('admin.fgreports.unit1.details',compact('title', 'employee_data', 'fg_data'));
  }

  public function unit1fgReportExport(Request $request){

    $file_name = 'unit1fgReport';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


    return Excel::download(new Unit1fgReportExport($request), $file_name);
  }

  public function mahapuraFGReportList(Request $request){

    $title = 'Mahapura Finish Goods Reports';

    $query1 = $this->EmrDB->table('Fgd');
    $query1->select(DB::raw("sum(FdQty) quantity,
                          sum(FdGrWt) weight,
                          FdDt") )
         ->join('OrdDsg','odno', '=', 'fdprdodno' )
        ->where("FdCoCd", "PC") // "PC" or "PJ"
        ->where(function($query) {
          $query->where("OdKt", "S999")
                ->orWhere("OdKt", "S925");
        })
        ->whereRaw("odsr=fdprdodsr")
        ->whereRaw("odtc=fdprdodtc")
        ->whereRaw("odchr=fdprdodchr")
        ->groupBy("FdDt");

    if(!empty($request->start_date) && !empty($request->end_date)){
        $query1->whereBetween('FdDt', [$request->start_date, $request->end_date]);
        // $query1->OrderBy('FdDt','ASC');
        $query1->OrderBy('FdDt','DESC');
    }
    else {
      $query1->OrderBy('FdDt','DESC');
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }
    $fgData = $query1->paginate($pagination);

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
                  AND tabEmployee.company = 'Pinkcity Jewelhouse Private Ltd-Mahapura'
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
        // $fgData[$key]->employee_data =  (object) $temp_data;

        // print_r($temp_data);


    }



    return view('admin.fgreports.mahapura.list',compact('title', 'fgData'));
  }

  public function mahapuraFGReportDetails(Request $request){

    $title = 'Mahapura Finish Goods Details';

    if(!empty($request->fg_date)){
        $fg_date = $request->fg_date;
    }
    else {
      $fg_date = date('Y-m-d', strtotime(time()));
    }

    $auto_start_date = date('Y-m-d', strtotime($fg_date));
    $auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($fg_date) ) );


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
              AND tabEmployee.company = 'Pinkcity Jewelhouse Private Ltd-Mahapura'
              AND ( `tabEmployee Checkin`.log_type = 'IN' )
              AND ( `tabEmployee Checkin`.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
              AND ( checkIn2.log_type = 'OUT' )
              AND ( checkIn2.time BETWEEN '$auto_start_date 08:00:00' AND '$auto_end_date 07:59:59' )
         GROUP BY tabEmployee.name";
    $employee_data = $this->erpnextDB->select($query_string);


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
                      WHERE ( OdKt = 'S999' OR OdKt = 'S925'   )
                              AND FdCoCd = 'PC'
                              and fddt = '$auto_start_date'";
    $fg_data = $this->EmrDB->select($query_string);

    return view('admin.fgreports.mahapura.details',compact('title', 'employee_data', 'fg_data'));
  }

  public function mahapuraFGReportExport(Request $request){

    $file_name = 'mahapuraFGReport';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';


    return Excel::download(new MahapurafgReportExport($request), $file_name);
  }

  public function unit2fgReportList(Request $request){


    $title = 'Unit 2 Finish Goods Reports';


    $query1 = $this->EmrSeetapuraDB->table('Fgd');
    $query1->select("FdDt")->distinct()->groupBy("FdDt");


    if(!empty($request->start_date) && !empty($request->end_date)){
        $query1->whereBetween('FdDt', [$request->start_date, $request->end_date]);
        // $query1->OrderBy('FdDt','ASC');
        $query1->OrderBy('FdDt','DESC');
    }
    else {
      $query1->OrderBy('FdDt','DESC');
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 10;
    }
    $fgData = $query1->paginate($pagination);

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




    return view('admin.fgreports.unit2.list',compact('title', 'fgData'));
  }

  public function unit2fgReportDetails(Request $request){

    $title = 'Unit 2 Finish Goods Details';

    if(!empty($request->fg_date)){
        $fg_date = $request->fg_date;
    }
    else {
      $fg_date = date('Y-m-d', strtotime(time()));
    }

    $auto_start_date = date('Y-m-d', strtotime($fg_date));
    $auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($fg_date) ) );

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

    // $query1 = $this->EmrDB->table('fgd')
    //                       ->where('FdDt',  date('Y-m-d', strtotime($fg_date) ) );
    // $fg_data =  $query1->get();

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
                              and fddt = '$auto_start_date'";
    $fg_data = $this->EmrSeetapuraDB->select($query_string);


    return view('admin.fgreports.unit2.details',compact('title', 'employee_data', 'fg_data'));
  }

  public function unit2fgReportExport(Request $request){

    $file_name = 'unit2fgReport';

    if(!empty($request->company)){
      $file_name .= '-' . $request->company;
    }

    $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';

    return Excel::download(new Unit2fgReportExport($request), $file_name);
  }
}
