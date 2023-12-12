<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\File;


class AttendanceController extends Controller
{

  public function __construct()
  {
    $this->erpnextDB = DB::connection('erpnext');
    $this->attendanceDB = DB::connection('Attendance');
    $this->localdesignDB = DB::connection('localdesign');
  }

  public function getEmployeeAttendance(Request $request) {

    ini_set('max_execution_time', '1000000');
      if(empty($request->start_date)){
          echo "Start Date Is Required For Attendnce Entry";
          exit;
      }
      if(empty($request->end_date)){
          echo "End Date Is Required For Attendnce Entry";
          exit;
      }


        $first_date = new \DateTime($request->start_date);
        $second_date = new \DateTime($request->end_date);

        $date_diff = $first_date->diff($second_date);

        if($date_diff->d > 1 ) { // 1 day diff
          echo "Date difference must be one";
          exit;
        }

        // for stop attendance on holidays and sundays
        // $this->checkHolidays($request->end_date, $request->bypass);

        $table_name1 = ""; $table_name2 = "";

        $start_date_month = date("n", strtotime($request->start_date));
        $start_date_year = date("Y", strtotime($request->start_date));

        $end_date_month = date("n", strtotime($request->end_date));
        $end_date_year = date("Y", strtotime($request->end_date));

        $check = 1;

        if($start_date_month == $end_date_month && $start_date_year == $end_date_year) {
          $check = 1;
          $table_name1 = "DeviceLogs_".$start_date_month."_".$start_date_year;
        }
        else {
          $check = 2;
          $table_name1 = "DeviceLogs_".$start_date_month."_".$start_date_year;
          $table_name2 = "DeviceLogs_".$end_date_month."_".$end_date_year;
        }


        // die("hi339#");

        // for mahapura ------------------------------------------------------ start ---------------
        $erpnextDB = $this->erpnextDB;
        $employee =    $erpnextDB
                      ->table('tabEmployee')
                      ->where("status", "Active")
                      // ->where("employee_number_new", "PC0525")
                      ->where("company", "Pinkcity Jewelhouse Private Ltd-Mahapura")
                      // ->limit(5)
                      ->get();
        $start_date = $request->start_date . " 07:00:00"; //7AM
        $end_date = $request->end_date . " 06:59:00"; //6:59AM

        // print_r($employee);
        // die;

        $this->insertEmployeeAttendance($employee, $start_date, $end_date, $check, $table_name1, $table_name2);
        // for mahapura ------------------------------------------------------ end ---------------


        // for COLORSTONES ------------------------------------------------------ start ---------------
        $erpnextDB = $this->erpnextDB;
        $employee =    $erpnextDB
                      ->table('tabEmployee')
                      ->where("status", "Active")
                      // ->where("employee_number_new", "PC0525")
                      ->where("company", "PINKCITY COLORSTONES PVT. LTD.")
                      // ->limit(5)
                      ->get();
        $start_date = $request->start_date . " 07:00:00"; //7AM
        $end_date = $request->end_date . " 06:59:00"; //6:59AM

        // print_r($employee);
        // die;

        $this->insertEmployeeAttendance($employee, $start_date, $end_date, $check, $table_name1, $table_name2);
        // for COLORSTONES ------------------------------------------------------ end ---------------

        // for unit1  ------------------------------------------------------ start ---------------
        $erpnextDB = $this->erpnextDB;
        $employee =    $erpnextDB
                      ->table('tabEmployee')
                      ->where("status", "Active")
                      // ->where("employee_number_new", "PC0525")
                      ->where("company", "Pinkcity Jewelhouse Private Limited- Unit 1")
                      // ->limit(5)
                      ->get();

        $start_date = $request->start_date . " 08:00:00"; //8AM
        $end_date = $request->end_date . " 07:59:00"; //7:59AM

        $this->insertEmployeeAttendance($employee, $start_date, $end_date, $check, $table_name1, $table_name2);
        // for unit1 ------------------------------------------------------ end ---------------

        // for unit 2 ------------------------------------------------------ start ---------------
        $erpnextDB = $this->erpnextDB;
        $employee =    $erpnextDB
                      ->table('tabEmployee')
                      ->where("status", "Active")
                      ->where("company", "Pinkcity Jewelhouse Private Limited-Unit 2")
                      // ->limit(5)
                      ->get();

        $start_date = $request->start_date . " 08:00:00"; //8AM
        $end_date = $request->end_date . " 07:59:00"; //7:59AM

        $this->insertEmployeeAttendance($employee, $start_date, $end_date, $check, $table_name1, $table_name2);
        // for& unit 2 ------------------------------------------------------ end ---------------

        $this->localdesignDB->table('cronjobs')
                            ->insert([
                                  "type"=>"attandance",
                                  "last_run"=>$request->start_date,
                                ]);

      echo "Record Inserted Successfully for Date between  : " . $request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time()) ;
      \Log::info("Cron is working fine for Date between  : " . $request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time()) );

      if($request->attend == "yes") {
          $this->autoEmployeeMarkAttendance($request->start_date, $request->end_date);
      }

  }



  public function checkHolidays($date="", $bypass = "")
  {
    $query_atte = $this->erpnextDB
                ->table('tabHoliday')
                ->select(DB::raw("holiday_date") )
                ->where('holiday_date', $date)
                ->first();

    if( $bypass == 'yes' ) {
      return ;
    }
    if( isset($query_atte->holiday_date) ) {
      echo "stop attendance & check for holidays";
      \Log::info("stop attendance & check for holidays" );
      die;;
    }
  }


    public function insertEmployeeAttendance($employee=[], $start_date, $end_date, $check, $table_name1 = "", $table_name2 = "")
    {
      // for better time
      // we can also user Date > && Date <
      $attendanceDB = $this->attendanceDB;
      foreach($employee as $key=>$value) {
        if($check == 1) {
          $attendanceData = $attendanceDB
                  ->table($table_name1)
                  ->where("UserId", $value->attendance_device_id)
                  ->whereBetween("LogDate", [$start_date, $end_date])
                  ->get();
        }
        else {

        $query_string =   "SELECT UserId, LogDate, DeviceLogId
                              FROM $table_name1 WHERE UserId = '". $value->attendance_device_id."'
                              AND LogDate BETWEEN '".$start_date."' AND '".$end_date."'
                           UNION
                              SELECT UserId, LogDate, DeviceLogId
                              FROM $table_name2 WHERE UserId = '". $value->attendance_device_id."'
                              AND LogDate BETWEEN '".$start_date."' AND '".$end_date."'
                           ORDER BY LogDate ASC";

        $attendanceData = $attendanceDB
                          ->select($query_string);


        }

        // and then you can get query log
        // dd(DB::getQueryLog());
        echo "<pre>";

        // echo "<br>hi55<br>";
        // print_r($attendanceData);
        // echo "<br>hi66<br>";
        // print_r($start_date);
        // echo "<br>hi77<br>";
        // print_r($end_date);


        // echo "<br>hi88<br>";
        // print_r($table_name1);
        // echo "<br>hi99<br>";
        // print_r($table_name2);
        //
        // echo "<br>hi1010<br>";
        // print_r($check);
        // die;


          $attendanceDataSize = count($attendanceData);

          // echo "<pre>";
          print_r($value);
          print_r($attendanceData);
          $date_in = "";
          $date_out = "";
          $all_in_out = [];
          echo "hi44<br>";

          foreach ($attendanceData as $key2 => $value2) {
            $all_in_out[] = $value2->LogDate;
          }
          $all_in_out_str = implode(",",$all_in_out);
          // die;

          if($attendanceDataSize == 0) {
            // continue
            echo "hi11<br>";
          }
          elseif($attendanceDataSize == 1 )
          {
            echo "hi22<br>";
            $date_in = date('Y-m-d H:i:s', strtotime($attendanceData[0]->LogDate));
            $deviceidin = mt_rand(100000, 999999);
            $datain = [
                          'employee_field_value' => $value->attendance_device_id,
                          'log_type' => 'IN',
                          'timestamp'   => $date_in.'.000000',
                          'device_id'   => $attendanceData[0]->DeviceLogId
                      ];

            print_r($datain);
            $response = Helper::AttendnceCheckin($datain);
          }
          elseif($attendanceDataSize > 1 )
          {
            echo "hi33<br>";
            $date_in = date('Y-m-d H:i:s', strtotime($attendanceData[0]->LogDate));
            $deviceidin = mt_rand(100000, 999999);
            $datain = [
                        'employee_field_value' => $value->attendance_device_id,
                        'log_type' => 'IN',
                        'timestamp'   => $date_in.'.000000',
                        'device_id'   => $attendanceData[0]->DeviceLogId
                      ];

            $response = Helper::AttendnceCheckin($datain);

            $first_entry = new \DateTime($attendanceData[0]->LogDate);
            $last_entry = new \DateTime($attendanceData[$attendanceDataSize - 1]->LogDate);

            $time_diff = $first_entry->diff($last_entry);

            if($time_diff->h >= 1 ) { // 1 hour diff
              // echo "hour difference must be one";
              // exit;

              $date_out = date('Y-m-d H:i:s', strtotime($attendanceData[$attendanceDataSize - 1]->LogDate));
              $deviceidin = mt_rand(100000, 999999);
              $datain = [
                          'employee_field_value' => $value->attendance_device_id,
                          'log_type' => 'OUT',
                          'timestamp' => $date_out.'.000000',
                          'device_id' => $attendanceData[$attendanceDataSize - 1]->DeviceLogId
                        ];

              print_r($datain);
              $response = Helper::AttendnceCheckin($datain);

            }
          }


          // die("hi336#");
            $this->insertOTandLessHours($value->employee,
                                        $value->attendance_device_id,
                                        $date_in,
                                        $date_out,
                                        date("Y-m-d", strtotime($start_date) ),
                                        round($value->gross_monthly_salary, 2),
                                        $all_in_out_str
                                      );
      }
      // die("hi337#");

    }


    public function insertOTandLessHours($emp_id='', $attendance_device_id='', $in_time = NULL, $out_time = NULL, $attendance_date = '', $gross_monthly_salary = '', $all_in_out_str = '')
    {
      $in_time_data = 0;
      $out_time_data = 0;
      $over_time_data = 0;
      $access_time_data = 0;
      $total_working_hours_data = 0;
      $less_hours_data = 0;

      $less_hours_round_data = 0;
      $access_time_round_data = 0;
      $over_time_round_data = 0;
      $total_working_hours_round_data = 0;

      $last_day = date("t", strtotime($attendance_date) );
      $per_day_salary = $gross_monthly_salary / $last_day;
      $per_hour_salary = $per_day_salary / 8.5; // 8.5 is total work hour in a day

      $less_in_seconds = 0;
      $ot_in_seconds = 0;
      $access_in_seconds = 0;
      $less_out_seconds = 0;
      $ot_out_seconds = 0;
      $access_out_seconds = 0;

      $total_less_seconds = 0;
      $total_access_seconds = 0;
      $total_ot_seconds = 0;
      $total_working_hours_seconds = 0;

      $ot_includes = 0;
      $multiple_checkin = 0;

      $all_in_out_for_json = [];
      // $all_in_out_array = explode(",", $all_in_out_str);
      // $multiple_checkin = 0;

      $query = $this->erpnextDB
                  ->table('tabHoliday')
                  ->select(DB::raw("holiday_date") )
                  ->where('holiday_date', $attendance_date);

      $holiday_date = "";
      $query_data = $query->first();
      if( isset($query_data->holiday_date) ) {
        $holiday_date = date('Y-m-d', strtotime($query_data->holiday_date) );
      }


      if($in_time == NULL || $out_time == NULL ) {

        if($in_time != NULL)
        {
          $in_time_data =  date('Y-m-d H:i:s', strtotime($in_time) );
        }
        if($out_time != NULL)
        {
          $out_time_data =  date('Y-m-d H:i:s', strtotime($out_time) );
        }

      } else {

        // echo "<pre>";
        $date_diff_obj = date_diff( date_create($in_time), date_create($out_time) );
        // $date_diff_obj = date_diff(date_create($data->out_time), date_create($data->in_time) );
        $total_working_hours_data = sprintf('%02d', $date_diff_obj->h).":".sprintf('%02d', $date_diff_obj->i).":".sprintf('%02d', $date_diff_obj->s);
        $total_working_hours_seconds = strtotime($total_working_hours_data) - strtotime("00:00:00");

        $all_in_out_array = explode(",",$all_in_out_str);
        // for($i=0; $i<count($all_in_out_array) - 1; $i++) {
        //   $first_time = $all_in_out_array[$i];
        //   $second_time = $all_in_out_array[$i+1];
        // }

        $i=0; $j = 1; $k=0;
        $count_all_check_in = count($all_in_out_array);
        $all_check_in = count($all_in_out_array);
        $total_working_hours_seconds = 0;
        while($count_all_check_in >= 1) {

          if($all_check_in <=2 ) {}
          else { if($j>=count($all_in_out_array) - 1) {break;} }

          $first_time = $all_in_out_array[$i];
          $second_time = $all_in_out_array[$j];
          $date_diff = date_diff( date_create($first_time), date_create($second_time) );
          print_r("<br>hi227#<br>");
          print_r($first_time);
          print_r($second_time);
          print_r($date_diff);
          if($date_diff->days <=0 && $date_diff->h <=0 && $date_diff->i <=4) {
            print_r("<br>hi225#<br>");
            $j++;
            $count_all_check_in=$count_all_check_in-1;
            continue;
          } else {
            print_r("<br>hi226#<br>");
            $all_in_out_for_json[$k]['in_time'] = $first_time;
            $all_in_out_for_json[$k]['out_time'] = $second_time;
            $total_working_hours_data = sprintf('%02d', $date_diff->h).":".sprintf('%02d', $date_diff->i).":".sprintf('%02d', $date_diff->s);
            $total_working_hours_seconds += (int) ( strtotime($total_working_hours_data) - strtotime("00:00:00") );
            $i=$j+1;
            $j=$j+2;
            if($k >= 1) {$multiple_checkin = 1;}
            $k++;
            $count_all_check_in=$count_all_check_in-2;
          }
        }

        // in case of holiday & weekoff
        if( $attendance_date == $holiday_date ) {
          // $over_time_data = $total_working_hours_data;
          $total_ot_seconds = $total_working_hours_seconds;
        }
        else {
          $in_time_diff_obj = date_diff(date_create($in_time), date_create($attendance_date . " 09:30:00") );
          $out_time_diff_obj = date_diff(date_create($attendance_date . " 18:00:00"), date_create($out_time) );

          // means late check in
          $in_time_diff = '00:00:00';
          $in_time_diff=sprintf('%02d', $in_time_diff_obj->h).":".sprintf('%02d', $in_time_diff_obj->i).":".sprintf('%02d', $in_time_diff_obj->s);
          if($in_time_diff_obj->invert == 1)
          {
            $less_in_seconds = strtotime($in_time_diff) - strtotime("00:00:00");
            // for less hour give 5 minute gap
            // if($less_in_seconds > (5*60) ) { $less_in_seconds = $less_in_seconds - (5*60); }
            // else {
            //   $less_in_seconds = 0;
            // }

            $less_hours_data =  gmdate("H:i:s", $less_in_seconds);
          }
          else { // check for OT
            // $ot_in_seconds = strtotime($in_time_diff) - strtotime("00:00:00");
            $access_in_seconds = strtotime($in_time_diff) - strtotime("00:00:00");
          }


          // means early check out

          $out_time_diff = '00:00:00';
          $out_time_diff=sprintf('%02d', $out_time_diff_obj->h).":".sprintf('%02d', $out_time_diff_obj->i).":".sprintf('%02d', $out_time_diff_obj->s);
          if($out_time_diff_obj->invert == 1)
          {
            $less_out_seconds = strtotime($out_time_diff) - strtotime("00:00:00");
            // $minus_in_time_second = strtotime($in_time_diff) - strtotime("00:00:00");
            // $less_hours_data = date('H:i:s', strtotime($out_time_diff)+$less_in_seconds );
          }
          else { // check for OT
            $ot_out_seconds = strtotime($out_time_diff) - strtotime("00:00:00");
            $access_out_seconds = strtotime($out_time_diff) - strtotime("00:00:00");
          }

          $total_less_seconds = $less_in_seconds + $less_out_seconds;
          $total_access_seconds = $access_in_seconds + $access_out_seconds;
          $total_ot_seconds = $ot_out_seconds;

        }


        if($total_working_hours_seconds > 0) {
          $total_working_hours_data = gmdate("H:i:s", $total_working_hours_seconds);
          $total_working_hours_round_data = $this->timeToHour($total_working_hours_seconds);
        }

        if($total_less_seconds > 0) {
          $less_hours_data = gmdate("H:i:s", $total_less_seconds);
          $less_hours_round_data = $this->timeToHour($total_less_seconds);
        }

        if($total_access_seconds > 0) {
          $access_time_data = gmdate("H:i:s", $total_access_seconds);
          $access_time_round_data = $this->timeToHour($total_access_seconds);
        }

        // OT will be start after 6:55
        if( $total_ot_seconds > (55*60) ) {
          $over_time_data = gmdate("H:i:s", $total_ot_seconds);
          $over_time_round_data = $this->timeToOTHour($total_ot_seconds);
          print_r("<br>hi11-88#<br>");
          print_r($over_time_round_data);
          $ot_includes = $this->checkOTPolicies($gross_monthly_salary, $over_time_round_data);
          if($ot_includes == 0) {
            $over_time_round_data = 0;
            $over_time_data = 0;
          }
        }

        $in_time_data = date('Y-m-d H:i:s', strtotime($in_time) );
        $out_time_data = date('Y-m-d H:i:s', strtotime($out_time) );

      }

      $temp_data_array = ['emp' => $emp_id,
                          "date"=>$attendance_date,
                          "in_time"=>$in_time_data,
                          "out_time"=>$out_time_data,
                          "total_hours"=>$total_working_hours_data,
                          "less_hours"=>$less_hours_data,
                          "ot_hours"=>$over_time_data,
                          "access_hours"=>$access_time_data,
                          "gross_monthly_salary"=>$gross_monthly_salary,

                          "per_day_salary"=>$per_day_salary,
                          "per_hour_salary"=>$per_hour_salary,

                          "total_hours_round"=>$total_working_hours_round_data,
                          "less_hours_round"=>$less_hours_round_data,
                          "access_hours_round"=>$access_time_round_data,
                          "ot_hours_round"=>$over_time_round_data,

                          "ot_hours_round"=>$over_time_round_data,
                          "final_ot_hour"=> $over_time_round_data,
                          "final_ot_hour_salary"=> ( $over_time_round_data * round($per_hour_salary) ),

                          "ot_includes"=>$ot_includes,
                          "all_in_out"=>$all_in_out_str,
                          "multiple_checkin"=>$multiple_checkin,
                          "all_in_out_json"=>json_encode($all_in_out_for_json),
                        ];


      print_r("<br>hi11-##<br>");
      print_r($temp_data_array);

      $this->erpnextDB->table('report_emp_attendace_detail')
                      ->updateOrInsert(
                          ['date' => $attendance_date,
                            'emp' => $emp_id,
                          ],
                          $temp_data_array

                        );

    }



    public function updateLeaveBalance(Request $request)
    {
      ini_set('max_execution_time', '1000000');

      $month =0;
      $year =0;
      // $month = date("m", strtotime($request->date) );
      // $year = date("Y", strtotime($request->date) );
        if(empty($request->month)){
            echo "month is required for updateLeaveBalance.";
            exit;
        }
        $month = $request->month;
        if(empty($request->year)){
            echo "year is required for updateLeaveBalance.";
            exit;
        }
        $year = $request->year;

//       SELECT te.employee, te.employee_name, te.department, te.designation,  sum(CASE
// 				when ta.status = 'Present' then 1
// 				when ta.status = 'Half Day' then 0.5
// 				ELSE 0
// 		   END) total_attend,sum(CASE
// 				when ta.status = 'Present' then 1
// 				when ta.status = 'Half Day' then 0.5
// 				ELSE 0
// 		   END)/20 total_pl
// 		   FROM tabEmployee te
// LEFT JOIN tabAttendance ta on ta.employee = te.employee
// WHERE te.company = 'Pinkcity Jewelhouse Private Limited-Unit 2' and ta.attendance_date > '2021-12-31'



      $check_el_pl = 0;
      $check_cl = 0;

      $query1_data = $this->erpnextDB
                  ->table('tabAttendance AS ta')
                  ->select(DB::raw("sum(CASE
                    when ta.status = 'Present' then 1
                    when ta.status = 'Half Day' then 0.5
                    ELSE 0
                   END) total_present, employee, employee_name, company") )
                  // ->where('ta.employee', "HR-EMP-PJHM-0627")
                  // ->where('ta.employee', "HR-EMP-PCPL-0029")
                  ->where('ta.attendance_date', ">", ($year - 1) ."-12-31")
                  ->where('ta.attendance_date', "<",  ($year + 1) ."-01-01")
                  ->where('ta.docstatus', "=",  "1")
                  ->groupBy('ta.employee')
                  ->get();
      echo "<pre>";

      print_r($query1_data);
      // print_r("<br>$month<br>");
      // print_r("<br>$year<br>");
      // die;

      foreach ($query1_data as $key => $query1) {

              $check_el_pl = 0;
              print_r("<br>hi12#<br>");
              // print_r($query1);
                if(!empty($query1)) {
                  if( $query1->total_present > 0) {
                    $check_el_pl = 1;
                  }
                }

              if($check_el_pl == 1) {
                $query2 = $this->erpnextDB
                            ->table('tabLeave Ledger Entry')
                            ->where('from_date', "$year-01-01")
                            ->where('to_date', "$year-12-31")
                            ->where('leave_type', "EL/PL")
                            ->where('is_carry_forward', 0)
                            ->where('transaction_type', "Leave Allocation")
                            ->where('employee', $query1->employee)
                            ->get();

                print_r("<br>hi13#<br>");
                print_r($query2);

                if(empty($query2)) {

                  // print_r("<br>Please add employee : $query1->employee  :: leave allocation :: EL/PL <br>");
                  //
                  // print_r("<br>hi131#<br>");
                  //
                  //   $name = "";
                  //     // generate unique name feild ================ start =============================
                  //     $check = 0;
                  //     $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
                  //     while($check == 0) {
                  //       $name = "";
                  //       for($i=0; $i<10; $i++) {
                  //         $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
                  //       }
                  //
                  //       $checkName = DB::connection('erpnext')
                  //           ->table('tabLeave Ledger Entry')
                  //           ->where('name', 'like', '%' . $name ."%")
                  //           ->first();
                  //
                  //       if(empty($checkName)) {
                  //         $check = 1;
                  //       }
                  //     }
                  //     // generate unique name feild ================ end =============================
                  //
                  //
                  //
                  //   $total_el_pl = ($query1->total_present/20);
                  //   if($total_el_pl >= 15 ) { $total_present = 15;}
                  //
                  //   $data = $this->erpnextDB
                  //   ->table('tabLeave Ledger Entry')
                  //   ->insert(["name"=> $name,
                  //             "creation"=> date('Y-m-d h:i:s', time()),
                  //             "modified"=> date('Y-m-d h:i:s', time()),
                  //             "modified_by"=> "Administrator",
                  //             "owner"=> "Administrator",
                  //             "docstatus"=>1,
                  //             "parent"=>null,
                  //             "parentfield"=>null,
                  //             "parenttype"=>null,
                  //             "idx"=>0,
                  //             "employee"=>$query1->employee,
                  //             "employee_name"=>$query1->employee_name,
                  //             "leave_type"=>"EL/PL",
                  //             "transaction_type"=>"Leave Allocation",
                  //             "transaction_name"=>null,
                  //             "leaves"=>$total_el_pl,
                  //             "from_date"=>"$year-01-01",
                  //             "to_date"=>"$year-12-31",
                  //             "holiday_list"=>null,
                  //             "is_carry_forward"=>0,
                  //             "is_expired"=>0,
                  //             "is_lwp"=>0,
                  //             "amended_from"=>null,
                  //             "_user_tags"=>null,
                  //             "_comments"=>null,
                  //             "_assign"=>null,
                  //             "_liked_by"=>null,
                  //             "company"=>$query1->company,
                  //           ]);
                  //
                  // $data = $this->erpnextDB
                  //         ->table('tabLeave Allocation')
                  //         ->where('employee',  $query1->employee )
                  //         ->where('leave_type',  "EL/PL" )
                  //         ->where('from_date',  "$year-01-01" )
                  //         ->where('to_date',  "$year-12-31" )
                  //         ->update(['total_leaves_allocated'=> DB::raw( "previous_year_leave + ". $total_el_pl ) ]);


                } else {
                  print_r("<br>hi132#<br>");

                  // for($i=0; $i<count($query2); $i++) {
                  //   if($i>= 1) {
                  //
                  //   }
                  // }

                  $count_i=0;
                  foreach ($query2 as $k11 => $v11) {
                    if($count_i>=1) {
                      $data = $this->erpnextDB
                              ->table('tabLeave Ledger Entry')
                              ->where('name',  $v11->name )
                              ->delete();
                    }
                    $count_i++;
                  }

                  $total_el_pl = ($query1->total_present/20);
                  if($total_el_pl >= 15 ) { $total_present = 15;}
                  $data = $this->erpnextDB
                          ->table('tabLeave Ledger Entry')
                          ->where('employee',  $query1->employee )
                          ->where('leave_type',  "EL/PL" )
                          ->where('is_carry_forward', 0)
                          ->where('transaction_type', "Leave Allocation")
                          ->where('from_date',  "$year-01-01" )
                          ->where('to_date',  "$year-12-31" )
                          ->update(['leaves'=> $total_el_pl ]);

                  $data = $this->erpnextDB
                          ->table('tabLeave Allocation')
                          ->where('employee',  $query1->employee )
                          ->where('leave_type',  "EL/PL" )
                          ->where('from_date',  "$year-01-01" )
                          ->where('to_date',  "$year-12-31" )
                          ->update(['total_leaves_allocated'=> DB::raw( "previous_year_leave + ". $total_el_pl ) ]);
                }
              }
      }



      // for CL ------

      $emp_data = DB::connection('erpnext')
                ->table('tabEmployee')
                ->where('status', "Active")
                // ->where('employee', "HR-EMP-PJHM-0627")
                // ->where('employee', "HR-EMP-PCPL-0029")
                // ->where('company', "Pinkcity Jewelhouse Private Ltd-Mahapura")
                ->get();

                // sum(CASE
                //   when ta.status = 'Present' then 1
                //   ELSE 0
                //  END)

      foreach ($emp_data as $k1 => $v1) {
        $query3_data = $this->erpnextDB
                    ->table('tabAttendance AS ta')
                    ->select(DB::raw("sum(CASE
                      when ta.status = 'Present' then 1
                      when ta.status = 'Half Day' then 0.5
                      ELSE 0
                     END) total_present, ta.employee, ta.employee_name, ta.company, tm.month_full, tm.month_no ") )
                     ->join('tabMonth AS tm', function ($join) {
                         $join->on("tm.month_no", "=", DB::raw( "MONTH(ta.attendance_date)"));
                     })
                    // ->where('ta.employee', "HR-EMP-PJHM-0627")
                    // ->where('ta.employee', "HR-EMP-PCPL-0030")
                    ->where('ta.attendance_date', ">", ($year - 1) ."-12-31")
                    ->where('ta.attendance_date', "<",  ($year + 1) ."-01-01")
                    ->where('ta.docstatus', "=",  "1")
                    ->where('ta.employee', $v1->employee)
                    ->groupBy('tm.month_no')
                    ->get();

          print_r("<br>hi144#<br>");
          print_r($query3_data);


          $total_cl = 0;
          foreach ($query3_data as $k2 => $v2) {
            if($v2->total_present >= 10) {
              $total_cl += 0.59;
            }
          }

          if($total_cl >= 7) { $total_cl = 7; }

            print_r("<br>total_cl : $total_cl<br>");

          $query4 = $this->erpnextDB
                      ->table('tabLeave Ledger Entry')
                      ->where('from_date', "$year-01-01")
                      ->where('to_date', "$year-12-31")
                      ->where('leave_type', "CL")
                      ->where('is_carry_forward', 0)
                      ->where('employee', $v1->employee)
                      ->get();


            if(empty($query4)) {
              //
              //   print_r("<br>hi141#<br>");
              //
              //   // print_r("<br>Please add employee : $query3->employee  :: leave allocation :: CL <br>");
              //
              //   $name = "";
              //     // generate unique name feild ================ start =============================
              //     $check = 0;
              //     $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
              //     while($check == 0) {
              //       $name = "";
              //       for($i=0; $i<10; $i++) {
              //         $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
              //       }
              //
              //       $checkName = DB::connection('erpnext')
              //           ->table('tabLeave Ledger Entry')
              //           ->where('name', 'like', '%' . $name ."%")
              //           ->first();
              //
              //       if(empty($checkName)) {
              //         $check = 1;
              //       }
              //     }
              //     // generate unique name feild ================ end =============================
              //
              //
              //
              //   $data = $this->erpnextDB
              //   ->table('tabLeave Ledger Entry')
              //   ->insert(["name"=> $name,
              //             "creation"=> date('Y-m-d h:i:s', time()),
              //             "modified"=> date('Y-m-d h:i:s', time()),
              //             "modified_by"=> "Administrator",
              //             "owner"=> "Administrator",
              //             "docstatus"=>1,
              //             "parent"=>null,
              //             "parentfield"=>null,
              //             "parenttype"=>null,
              //             "idx"=>0,
              //             "employee"=>$v1->employee,
              //             "employee_name"=>$v1->employee_name,
              //             "leave_type"=>"CL",
              //             "transaction_type"=>"Leave Allocation",
              //             "transaction_name"=>null,
              //             "leaves"=>$total_cl,
              //             "from_date"=>"$year-01-01",
              //             "to_date"=>"$year-12-31",
              //             "holiday_list"=>null,
              //             "is_carry_forward"=>0,
              //             "is_expired"=>0,
              //             "is_lwp"=>0,
              //             "amended_from"=>null,
              //             "_user_tags"=>null,
              //             "_comments"=>null,
              //             "_assign"=>null,
              //             "_liked_by"=>null,
              //             "company"=>$v1->company,
              //           ]);
              //
              //
              // // try to update it through sum of given cl data -----------------------------
              // $data = $this->erpnextDB
              //         ->table('tabLeave Allocation')
              //         ->where('employee',  $v1->employee )
              //         ->where('leave_type',  "CL" )
              //         ->where('from_date',  "$year-01-01" )
              //         ->where('to_date',  "$year-12-31" )
              //         ->update(['total_leaves_allocated'=>$total_cl ]);

            }
            else {
              print_r("<br>hi133#<br>");

              $count_j=0;
              foreach ($query4 as $k22 => $v22) {
                if($count_j>=1) {
                  $data = $this->erpnextDB
                          ->table('tabLeave Ledger Entry')
                          ->where('name',  $v22->name )
                          ->delete();
                }
                $count_j++;
              }

              $data = $this->erpnextDB
                      ->table('tabLeave Ledger Entry')
                      ->where('employee',  $v1->employee )
                      ->where('leave_type',  "CL" )
                      ->where('is_carry_forward', 0)
                      ->where('transaction_type', "Leave Allocation")
                      ->where('from_date',  "$year-01-01" )
                      ->where('to_date',  "$year-12-31" )
                      ->update(['leaves'=> $total_cl ]);

              $data = $this->erpnextDB
                      ->table('tabLeave Allocation')
                      ->where('employee',  $v1->employee )
                      ->where('leave_type',  "CL" )
                      ->where('from_date',  "$year-01-01" )
                      ->where('to_date',  "$year-12-31" )
                      ->update(['total_leaves_allocated'=> $total_cl ]);
            }
          }


      // }



      // $query3_data = $this->erpnextDB
      //             ->table('tabAttendance AS ta')
      //             ->select(DB::raw("sum(CASE
      //               when ta.status = 'Present' then 1
      //               ELSE 0
      //              END) total_present, employee, employee_name, company ") )
      //             // ->where('ta.employee', "HR-EMP-PJHM-0627")
      //             // ->where('ta.employee', "HR-EMP-PJHM-0684")
      //             ->whereMonth('ta.attendance_date', $month)
      //             ->whereYear('ta.attendance_date', $year)
      //             ->groupBy('ta.employee')
      //             ->get();
      //
      // print_r("<br>hi14#<br>");
      // print_r($query3_data);
      //
      // foreach ($query3_data as $key => $query3) {
      //   $check_cl = 0;
      //   if(!empty($query3)) {
      //     if( $query3->total_present >= 10) {
      //       $check_cl = 1;
      //     }
      //   }
      //
      //
      //   if($check_cl == 1) {
      //
      //
      //     $query4 = $this->erpnextDB
      //                 ->table('tabLeave Ledger Entry')
      //                 ->whereMonth('from_date', $month)
      //                 ->whereYear('from_date', $year)
      //                 ->where('to_date', "$year-12-31")
      //                 ->where('leave_type', "CL")
      //                 ->where('is_carry_forward', 0)
      //                 ->where('employee', $query3->employee)
      //                 ->first();
      //
      //   print_r("<br>hi15#<br>");
      //   print_r($query4);
      //
      //     if(empty($query4)) {
      //
      //         print_r("<br>hi141#<br>");
      //
      //         print_r("<br>Please add employee : $query3->employee  :: leave allocation :: CL <br>");
      //
      //       //   $name = "";
      //       //     // generate unique name feild ================ start =============================
      //       //     $check = 0;
      //       //     $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
      //       //     while($check == 0) {
      //       //       $name = "";
      //       //       for($i=0; $i<10; $i++) {
      //       //         $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
      //       //       }
      //       //
      //       //       $checkName = DB::connection('erpnext')
      //       //           ->table('tabLeave Ledger Entry')
      //       //           ->where('name', 'like', '%' . $name ."%")
      //       //           ->first();
      //       //
      //       //       if(empty($checkName)) {
      //       //         $check = 1;
      //       //       }
      //       //     }
      //       //     // generate unique name feild ================ end =============================
      //       //
      //       //
      //       //
      //       //   $data = $this->erpnextDB
      //       //   ->table('tabLeave Ledger Entry')
      //       //   ->insert(["name"=> $name,
      //       //             "creation"=> date('Y-m-d h:i:s', time()),
      //       //             "modified"=> date('Y-m-d h:i:s', time()),
      //       //             "modified_by"=> "Administrator",
      //       //             "owner"=> "Administrator",
      //       //             "docstatus"=>1,
      //       //             "parent"=>null,
      //       //             "parentfield"=>null,
      //       //             "parenttype"=>null,
      //       //             "idx"=>0,
      //       //             "employee"=>$query3->employee,
      //       //             "employee_name"=>$query3->employee_name,
      //       //             "leave_type"=>"CL",
      //       //             "transaction_type"=>"Leave Allocation",
      //       //             "transaction_name"=>null,
      //       //             "leaves"=>0.59,
      //       //             "from_date"=>"$year-".sprintf('%02s', $month)."-01",
      //       //             "to_date"=>"$year-12-31",
      //       //             "holiday_list"=>null,
      //       //             "is_carry_forward"=>0,
      //       //             "is_expired"=>0,
      //       //             "is_lwp"=>0,
      //       //             "amended_from"=>null,
      //       //             "_user_tags"=>null,
      //       //             "_comments"=>null,
      //       //             "_assign"=>null,
      //       //             "_liked_by"=>null,
      //       //             "company"=>$query3->company,
      //       //           ]);
      //       //
      //       //
      //       // // // try to update it through sum of given cl data -----------------------------
      //       // // $data = $this->erpnextDB
      //       // //         ->table('tabLeave Allocation')
      //       // //         ->where('employee',  $query3->employee )
      //       // //         ->where('leave_type',  "CL" )
      //       // //         ->where('from_date',  "$year-01-01" )
      //       // //         ->where('to_date',  "$year-12-31" )
      //       // //         ->update(['total_leaves_allocated'=>DB::raw("total_leaves_allocated + ". (0.59) ) ]);
      //
      //     }
      //
      //     if(isset($query4->leaves) ) {
      //       print_r("<br>hi142#<br>");
      //
      //             if($query4->leaves == 0) {
      //               print_r("<br>hi143#<br>");
      //
      //               $data = $this->erpnextDB
      //                       ->table('tabLeave Ledger Entry')
      //                       ->where('employee',  $query3->employee )
      //                       ->where('leave_type',  "CL" )
      //                       ->where('is_carry_forward', 0)
      //                       ->where('transaction_type', "Leave Allocation")
      //                       ->where('from_date',  "$year-".sprintf('%02s', $month)."-01" )
      //                       ->where('to_date',  "$year-12-31" )
      //                       ->update(['leaves'=> 0.59 ]);
      //
      //             // $query_data = $this->erpnextDB
      //             //             ->table('tabLeave Ledger Entry')
      //             //             ->select(DB::raw("sum(leaves) total_cl, employee, employee_name, company") )
      //             //             ->where('ta.employee', "HR-EMP-PJHM-0627")
      //             //             ->whereYear('ta.attendance_date', ">", ($year - 1) ."-12-31")
      //             //             ->where('ta.attendance_date', "<",  ($year + 1) ."-01-01")
      //             //             ->first();
      //             // try to update it through sum of given cl data -----------------------------
      //
      //               // $data = $this->erpnextDB
      //               //         ->table('tabLeave Allocation')
      //               //         ->where('employee',  $query3->employee )
      //               //         ->where('leave_type',  "CL" )
      //               //         ->where('from_date',  "$year-01-01" )
      //               //         ->where('to_date',  "$year-12-31" )
      //               //         ->update(['total_leaves_allocated'=>DB::raw("total_leaves_allocated + ". (0.59) ) ]);
      //             }
      //
      //     }
      //
      //
      //   }
      //
      // }



    }

    public function timeToHour($time = 0)
    {
      print_r("<br>hello11<br>");
      print_r($time);
      print_r("<br>hello22<br>");
      if($time == 0) { return 0; }
      $total_hour = 0;
      $hour = gmdate("G", $time); //hour
      $minute = gmdate("i", $time); //hour
      $total_hour = round( ( (float) $hour + ( (float)$minute / 60 ) ), 2 ) ;
      return $total_hour;
    }

    public function timeToOTHour($time = 0)
    {
      if($time == 0) { return 0; }
      $total_hour = 0;
      $hour = 0; //hour
      $minute = 0; //minute
      $act_hour = gmdate("G", $time); //hour
      $act_minute = gmdate("i", $time); //minute

      echo "<br>hi11-17#<br>";

      //first rule for only 55 minutes
      if($act_hour == 0 && (int) $act_minute >= 55) {
        echo "<br>hi11-12#<br>";
        $hour = 1;
      } elseif( $act_hour > 0) {
        $hour = $act_hour;
        echo "<br>hi11-13#<br>";
        if( (int) $act_minute >= 0 && (int) $act_minute <= 20) {
          echo "<br>hi11-14#<br>";
          $minute = 0; // 0 to 20 count as 0
        }
        if( (int) $act_minute > 20  && (int) $act_minute <= 50) {
          echo "<br>hi11-15#<br>";
          $minute = 0.5; // 20 to 50 count as 0.5
        }
        if( (int) $act_minute > 50  ) {
          echo "<br>hi11-16#<br>";
          $minute = 0; // > 50 plus one hour
          $hour = $hour + 1;
        }
      }

      echo "<br>hi11-10#<br>";
      echo "<br>$hour<br>";
      echo "<br>hi11-11#<br>";
      echo "<br>$minute<br>";

      $total_hour = round( ( (float) $hour + (float) $minute ), 2 );

      return $total_hour;
    }

    public static function checkOTPolicies($base_salary = 0, $over_time = 0)
  	{
  		$check = 0;
      echo "<br>hi11-00<br>";
  		if(  $base_salary < 25000 &&  $over_time >= 1) {
        echo "<br>hi11-11<br>";
  			$check = 1;
  		}
  		elseif( $base_salary >= 25000 && $base_salary < 35000 && $over_time >= 3) {
        echo "<br>hi11-22<br>";
        $check = 1;
  		}
  		elseif( $base_salary >= 35000 && $base_salary < 50000 && $over_time >= 6) {
        echo "<br>hi11-33<br>";
        $check = 1;
  		}
  		elseif( $base_salary >= 50000) {
        echo "<br>hi11-44<br>";
        $check = 0;
  		}
  		return $check;
  	}



  public function getEmployeeMarkAttendance(Request $request)
  {

    ini_set('max_execution_time', '1000000');
      if(empty($request->start_date)) {
          echo "Start Date Is Required For Attendance Entry";
          exit;
      }
      if(empty($request->end_date)) {
          echo "End Date Is Required For Attendance Entry";
          exit;
      }


    // for stop attendance on holidays and sundays
    $this->checkHolidays($request->end_date, $request->bypass);


    $query = $this->localdesignDB->table('cronjobs')
                          ->whereDate("last_run", $request->start_date)
                          ->first();
    if(isset($query->last_run)) {
      // continue the work
    } else {
      echo "Attendnce query not run for Date between  : " . $request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time()) ;
      \Log::info("Attendnce query not run for Date between  : " . $request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time()) );
      die;
    }


    // $auto_start_date = date('Y-m-d', strtotime ( '-1 day' , time() ) );
    // $auto_end_date = date('Y-m-d', time());

    $auto_start_date = $request->start_date;
    $auto_end_date = $request->end_date;

    $allUnits = [
      "Mahapura Unit Shift"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 06:59:59",
      ],
      "ColorStones Unit Shift"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 06:59:59",
      ],
      "Unit 1 Shift Sitapura"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 07:59:59",
      ],
      "Unit 2 Shift Sitapura"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 07:59:59",
      ],
    ];

    $erpnextDB = DB::connection("erpnext");
    $query2 = $erpnextDB
                ->table("tabShift Type")
                // ->where('name', 'Unit 1 Shift Sitapura');
                ->where('name', 'Mahapura Unit Shift')
                ->orWhere('name', 'Unit 1 Shift Sitapura')
                ->orWhere('name', 'ColorStones Unit Shift')
                ->orWhere('name', 'Unit 2 Shift Sitapura');
    $allUnits_data = $query2->get();


    $check_mahapura = 0;
    $check_colorstones = 0;
    $check_unit1 = 0;
    $check_unit2 = 0;



    foreach ($allUnits_data as $key => $value) {

      if($value->name == 'Mahapura Unit Shift') {
        $check_mahapura++;
      }
      if($value->name == 'ColorStones Unit Shift') {
        $check_colorstones++;
      }
      if($value->name == 'Unit 1 Shift Sitapura') {
        $check_unit1++;
      }
      if($value->name == 'Unit 2 Shift Sitapura') {
        $check_unit2++;
      }

      if($check_mahapura > 1 || $check_unit1 > 1 || $check_unit2 > 1  ) {
        continue;
      }

      $name = ["name"=>$value->name ."",
               "owner"=>$value->owner ."" ,
               "creation"=>$value->creation ."",
               "modified"=>$value->modified ."" ,
               "modified_by"=>$value->modified_by ."",
               "idx"=>$value->idx ,
               "docstatus"=>$value->docstatus  ,
               "disabled"=>$value->disabled ,
               "start_time"=>date('H:i:s', strtotime($value->start_time)) ."",
               "end_time"=>date('H:i:s', strtotime($value->end_time)) ."",
               // "start_time"=>$value->start_time ,
               // "end_time"=>$value->end_time ,
               "holiday_list"=>$value->holiday_list ."" ,
               "enable_auto_attendance"=>$value->enable_auto_attendance ,
               "determine_check_in_and_check_out"=>$value->determine_check_in_and_check_out ."",
               "working_hours_calculation_based_on"=>$value->working_hours_calculation_based_on ."",
               "begin_check_in_before_shift_start_time"=>$value->begin_check_in_before_shift_start_time ,
               "allow_check_out_after_shift_end_time"=>$value->allow_check_out_after_shift_end_time ,
               "working_hours_threshold_for_half_day"=> (int) $value->working_hours_threshold_for_half_day,
               "working_hours_threshold_for_absent"=> (int) $value->working_hours_threshold_for_absent,
               "process_attendance_after"=>$allUnits[$value->name]['auto_start_date'] ,
               "last_sync_of_checkin"=>$allUnits[$value->name]['auto_end_date']  ,
               "enable_entry_grace_period"=>$value->enable_entry_grace_period  ,
               "late_entry_grace_period"=>$value->late_entry_grace_period ,
               "enable_exit_grace_period"=>$value->enable_exit_grace_period ,
               "doctype"=>"Shift Type",
               // "__last_sync_on"=>$value->last_sync_of_checkin,
             ];

        $post_data = ['docs'=> json_encode($name), 'method'=> 'process_auto_attendance'];

        $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://erp.pinkcityindia.com/api/method/run_doc_method',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
              'X-Custom-Header: value',
              "Authorization: token 8df39ff6e216a4b:4f0295ed14f70b9",
            ),
          ));

          $response = curl_exec($curl);

          echo "<pre>";

          echo $response;
          echo "<br>hi33<br>";
          print_r($name);
          echo "<br>hi22<br>";
          print_r($post_data);
          echo "<br>hi11<br>";
          curl_close($curl);

    }


    echo "<br>check_mahapura : $check_mahapura<br>";
    echo "<br>check_colorstones : $check_colorstones<br>";
    echo "<br>check_unit1 : $check_unit1<br>";
    echo "<br>check_unit2 : $check_unit2<br>";

    \Log::info("MarkAttendance Cron is working fine for Date between  : " .$request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time()));
    echo " MarkAttendance Cron is working fine for Date between  : " . $request->start_date . " to " . $request->end_date . " on time : " . date("Y-m-d h:i:s", time());

  }

  public function autoEmployeeMarkAttendance($start_date = "", $end_date = "")
  {

    ini_set('max_execution_time', '1000000');

    // for stop attendance on holidays and sundays
    $this->checkHolidays($start_date, $end_date);


    $query = $this->localdesignDB->table('cronjobs')
                          ->whereDate("last_run", $start_date)
                          ->first();
    if(isset($query->last_run)) {
      // continue the work
    } else {
      echo "Attendnce query not run for Date between  : " . $start_date . " to " . $end_date . " on time : " . date("Y-m-d h:i:s", time()) ;
      \Log::info("Attendnce query not run for Date between  : " . $start_date . " to " . $end_date . " on time : " . date("Y-m-d h:i:s", time()) );
      die;
    }



    // $auto_start_date = date('Y-m-d', strtotime ( '-1 day' , time() ) );
    // $auto_end_date = date('Y-m-d', time());

    $auto_start_date = $start_date;
    $auto_end_date = $end_date;

    $allUnits = [
      "Mahapura Unit Shift"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 06:59:59",
      ],
      "ColorStones Unit Shift"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 06:59:59",
      ],
      "Unit 1 Shift Sitapura"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 07:59:59",
      ],
      "Unit 2 Shift Sitapura"=>[
        "auto_start_date"=> $auto_start_date,
        "auto_end_date"=> $auto_end_date . " 07:59:59",
      ],
    ];

    $erpnextDB = DB::connection("erpnext");
    $query2 = $erpnextDB
                ->table("tabShift Type")
                // ->where('name', 'Unit 1 Shift Sitapura');
                ->where('name', 'Mahapura Unit Shift')
                ->orWhere('name', 'ColorStones Unit Shift')
                ->orWhere('name', 'Unit 1 Shift Sitapura')
                ->orWhere('name', 'Unit 2 Shift Sitapura');
    $allUnits_data = $query2->get();


    $check_mahapura = 0;
    $check_colorstones = 0;
    $check_unit1 = 0;
    $check_unit2 = 0;



    foreach ($allUnits_data as $key => $value) {

      if($value->name == 'Mahapura Unit Shift') {
        $check_mahapura++;
      }
      if($value->name == 'ColorStones Unit Shift') {
        $check_colorstones++;
      }
      if($value->name == 'Unit 1 Shift Sitapura') {
        $check_unit1++;
      }
      if($value->name == 'Unit 2 Shift Sitapura') {
        $check_unit2++;
      }

      if($check_mahapura > 1 || $check_unit1 > 1 || $check_unit2 > 1  ) {
        continue;
      }

      $name = ["name"=>$value->name ."",
               "owner"=>$value->owner ."" ,
               "creation"=>$value->creation ."",
               "modified"=>$value->modified ."" ,
               "modified_by"=>$value->modified_by ."",
               "idx"=>$value->idx ,
               "docstatus"=>$value->docstatus  ,
               "disabled"=>$value->disabled ,
               "start_time"=>date('H:i:s', strtotime($value->start_time)) ."",
               "end_time"=>date('H:i:s', strtotime($value->end_time)) ."",
               // "start_time"=>$value->start_time ,
               // "end_time"=>$value->end_time ,
               "holiday_list"=>$value->holiday_list ."" ,
               "enable_auto_attendance"=>$value->enable_auto_attendance ,
               "determine_check_in_and_check_out"=>$value->determine_check_in_and_check_out ."",
               "working_hours_calculation_based_on"=>$value->working_hours_calculation_based_on ."",
               "begin_check_in_before_shift_start_time"=>$value->begin_check_in_before_shift_start_time ,
               "allow_check_out_after_shift_end_time"=>$value->allow_check_out_after_shift_end_time ,
               "working_hours_threshold_for_half_day"=> (int) $value->working_hours_threshold_for_half_day,
               "working_hours_threshold_for_absent"=> (int) $value->working_hours_threshold_for_absent,
               "process_attendance_after"=>$allUnits[$value->name]['auto_start_date'] ,
               "last_sync_of_checkin"=>$allUnits[$value->name]['auto_end_date']  ,
               "enable_entry_grace_period"=>$value->enable_entry_grace_period  ,
               "late_entry_grace_period"=>$value->late_entry_grace_period ,
               "enable_exit_grace_period"=>$value->enable_exit_grace_period ,
               "doctype"=>"Shift Type",
               // "__last_sync_on"=>$value->last_sync_of_checkin,
             ];

        $post_data = ['docs'=> json_encode($name), 'method'=> 'process_auto_attendance'];

        $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://erp.pinkcityindia.com/api/method/run_doc_method',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
              'X-Custom-Header: value',
              // "Authorization: token " .getenv("ERP_TOKEN"),
              "Authorization: token 8df39ff6e216a4b:4f0295ed14f70b9",
            ),
          ));

          $response = curl_exec($curl);

          echo "<pre>";

          echo $response;
          echo "<br>hi33<br>";
          print_r($name);
          echo "<br>hi22<br>";
          print_r($post_data);
          echo "<br>hi11<br>";
          curl_close($curl);

    }


    echo "<br>check_mahapura : $check_mahapura<br>";
    echo "<br>check_colorstones : $check_colorstones<br>";
    echo "<br>check_unit1 : $check_unit1<br>";
    echo "<br>check_unit2 : $check_unit2<br>";


    \Log::info("MarkAttendance Cron is working fine for Date between  : " .$start_date . " to " . $end_date . " on time : " . date("Y-m-d h:i:s", time()));
    echo " MarkAttendance Cron is working fine for Date between  : " . $start_date . " to " . $end_date . " on time : " . date("Y-m-d h:i:s", time());

  }



}
