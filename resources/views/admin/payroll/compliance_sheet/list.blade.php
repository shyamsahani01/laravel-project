@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/hr/compliance_sheet?show='.request()->show.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&month='.request()->month.'&year='.request()->year);
@endphp


<?php



function outTimeConvert($attendance_data=[])
{
  $ot_hour = 0;
  $in_time = 0;
  $in_time_hour = 0;
  $in_time_minute = 0;
  $out_time_hour = 0;
  $out_time = 0;
  $out_time_minute = 0;
  // $in_time = isset($attendance_data->in_time) ? strtotime($attendance_data->in_time) : 0;
  // $out_time = isset($attendance_data->out_time) ? strtotime($attendance_data->out_time) : 0;
  $total_hours_round = isset($attendance_data->total_hours_round) ? $attendance_data->total_hours_round : 0;

  if($total_hours_round == 0  ) {
    $in_time = 0;
    $out_time = 0;
  }
  else {
    $in_time = strtotime($attendance_data->in_time);
    $out_time = strtotime($attendance_data->out_time);

    $in_time_minute = date("i", $in_time);
    $in_time_hour = date("H", $in_time);
    $out_time_hour = date("H", $out_time);
    $in_time = date("H:i", $in_time);

    $hour = date("H", $out_time); //hour
    if( ( (int) $hour >= 18 || (int) $hour < 8 ) )  {
      $hour = 18;

      $minute = date("i", $out_time); //hour
      $first = $minute/10;
      $second = $minute%10;
      $new_minute = (int)$first + (int)$second;
      if($new_minute == 0) {$new_minute = '00';}
      if($new_minute > 0 && $new_minute <= 9 ) {$new_minute = '0' . $new_minute;}

      // if($attendance_data->ot_hours_round >= 1 && $attendance_data->ot_hours_round < 2) {
      //   $ot_hour = 1;
      // }
      // if($attendance_data->ot_hours_round >= 2 ) {
      //   $ot_hour = 2;
      // }

      $out_time = $hour . ":" . $new_minute ;

      $out_time_minute = $new_minute;
    }
    else { $out_time = date("H:i", $out_time); }
   }

   return ["in_time"=>$in_time, "in_time_hour"=>$in_time_hour, "in_time_minute"=>$in_time_minute, "out_time"=>$out_time,  "out_time_hour"=>$out_time_hour,
           "ot_hour"=>$ot_hour, "out_time_minute" => $out_time_minute ];
  }







 ?>

    <div class="main-panel">
        <div class="content">
            @includeif('admin.payroll.compliance_sheet.filters')
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="clearfix"></div>
                        <div class="row">
                     <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                           <div class="x_content">
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="card-box table-responsive">

                                       <table id="datatable" class="table table-bordered" style="width:100%">
                                          <thead>
                                             <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                               <th>S.No.</th>
                                               <th style="min-width: 170px;">ERP Code</th>
                                               <th style="min-width: 180px;">Employee Name</th>
                                               <th style="min-width: 180px;" >Department</th>
                                               <th>ESSL Code</th>
                                               <th>Particular</th>
                                               @for($i=1; $i<=$total_date; $i++)
                                                 <th>{{ $i . " " . date("D", strtotime( $year ."-" . $month . "-" . ( ($i<=9) ? "0".$i : $i ) ) ) }}</th>
                                               @endfor
                                               <!-- <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Days</th> -->
                                               <th>Total Pay Days</th>
                                               <th>Total OT</th>
                                               <!-- <th>Total Actual OT</th> -->
                                               <th>Total Paid OT</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                        @if (count($compliance_data) > 0)
                                           @php
                                             $count = 1;
                                             $in_time_minute = 15;
                                             $p_out_minute = 10;
                                             $hd_out_minute = 10;
                                           @endphp
                                            @foreach($compliance_data as $key => $data)

                                            <?php

                                            $attendance_data = $data->attendance_data;
                                            $total_present = 0;
                                            $total_half_day = 0;
                                            $total_pay_days = 0;
                                            $total_leave = 0;
                                            $total_absent = 0;
                                            $total_week_off = 0;
                                            $total_holiday = 0;

                                            $weekly_ot = 0;
                                            $monthly_ot = 0;
                                            $act_monthly_ot = 0;

                                            $week= 1;
                                            $for_ot_data= [];
                                            $count_p= 0;

                                            $date_data = [];


                                            for($i=1; $i<=$total_date; $i++) {
                                              $check_holiday = 0; $check_valid_holiday=0;

                                              foreach($holiday_list as $k3 => $v3) {
                                                if($i == (int) date("d", strtotime($v3->holiday_date) ) ) {
                                                  $date_diff_obj = date_diff( date_create($data->date_of_joining), date_create($v3->holiday_date) );

                                                  if($v3->weekly_off == 1) {

                                                    $weekly_ot = 0;
                                                    $count_p = 0;
                                                    $week++;
                                                    if($date_diff_obj->invert == 0) {
                                                      $date_data[$i]['status'] = 'WO';
                                                      $date_data[$i]['background'] = "#f9e9bb";
                                                      $check_valid_holiday=1;
                                                      $total_week_off++;
                                                      $total_pay_days++;
                                                    }
                                                  }
                                                  else {
                                                    if($date_diff_obj->invert == 0) {
                                                      $date_data[$i]['status'] = 'H';
                                                      $date_data[$i]['background'] = "#f9e9bb";
                                                      $check_valid_holiday=1;
                                                      $total_pay_days++;
                                                      $total_holiday++;
                                                    }
                                                  }
                                                  $check_holiday = 1;  $check_date=1; break;
                                                }
                                              }

                                              if($check_holiday == 1) {
                                                $date_data[$i]['in_time'] = "";
                                                $date_data[$i]['leave_type'] = "";
                                                $date_data[$i]['out_time'] = "";
                                                $date_data[$i]['duration'] = "";
                                                // continue;
                                              }


                                              foreach($attendance_data as $k2 => $v2) {


                                                if($i == (int) date("d", strtotime($v2->attendance_date) ) ) {

                                                  if($check_valid_holiday == 1) {
                                                    if($v2->status == "Present" || $v2->status == "Half Day" || $v2->status == "Absent") {
                                                      break;
                                                    }
                                                  }

                                                  if($v2->leave_type == "EL/PL")  { $v2->leave_type = "EL-PL";}

                                                  // $act_monthly_ot += $v2->ot_hours_round;
                                                  $act_monthly_ot = 0;

                                                  $out_time_data = outTimeConvert($v2);
                                                  $in_time_string = $out_time_data['in_time'];
                                                  $in_time_minute = $out_time_data['in_time_minute'];
                                                  $in_time_hour = $out_time_data['in_time_hour'];
                                                  $out_time_hour = $out_time_data['out_time_hour'];
                                                  $out_time_string = $out_time_data['out_time'];
                                                  $out_time_minute = $out_time_data['out_time_minute'];
                                                  $ot_hour_string = "00:00";
                                                  $ot_hour = $out_time_data['ot_hour'];
                                                  $check_valid_date = 0;

                                                  if( ($in_time_hour > 0 && $in_time_hour < 9  ) ||  $in_time_hour > 10 || ($in_time_hour == 9 && $in_time_minute < 15 ) ) {
                                                     $in_time_string = "09:" . ( $in_time_minute++ );
                                                     if($in_time_minute >= 30) { $in_time_minute = 15;}
                                                  }

                                                    if($v2->status == "Present") {
                                                      $check_valid_date = 1;
                                                      $check_date = 1;
                                                      if($in_time_string == 0) {
                                                        $in_time_string = "09:30";
                                                        $out_time_string = "18:00";
                                                        $out_time_hour = 18;
                                                        $out_time_minute = "00";
                                                      }
                                                      $total_present++;
                                                      $total_pay_days++;

                                                      // if($ot_hour == 2) {
                                                      //   if($weekly_ot == 3) { $ot_hour = 1;}
                                                      //   if($monthly_ot == 15) { $ot_hour = 1;}
                                                      // }
                                                      //
                                                      // if($monthly_ot >=16 || $weekly_ot >= 4){
                                                      //   $ot_hour = 0;
                                                      // }
                                                      //
                                                      // $monthly_ot = $monthly_ot + $ot_hour;
                                                      // $weekly_ot = $monthly_ot + $ot_hour;
                                                      //
                                                      //
                                                      // if($monthly_ot >=16 ){
                                                      //   $monthly_ot = 16;
                                                      // }

                                                      if($ot_hour == 1) { $ot_hour_string = "01:00";  $out_time_string = "19:" . $out_time_minute;}
                                                      if($ot_hour == 2) { $ot_hour_string = "02:00";  $out_time_string = "20:" . $out_time_minute;}

                                                      $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );

                                                      // $hours = round ( ( ( $time_diff->h ) + (  $time_diff->i / 60) ) , 1);
                                                      $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);

                                                      if($time_diff->h < 6) {
                                                        $out_time_string = "18:" . ( $p_out_minute++ );
                                                        if($p_out_minute >= 15) { $p_out_minute = 10;}
                                                        $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                        $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                      }

                                                      if($time_diff->h >= 9 && $ot_hour < 1) {
                                                        $in_time_string = "09:30";
                                                        $out_time_string = "18:00";
                                                        $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                        $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                      }

                                                      if($ot_hour == 0){
                                                        $for_ot_data[$week]['remain_days'][$count_p]['date'] = $v2->attendance_date;
                                                        $for_ot_data[$week]['remain_days'][$count_p]['in_time'] = $in_time_string;
                                                        $for_ot_data[$week]['remain_days'][$count_p]['out_time_hour'] = $out_time_hour;
                                                        $for_ot_data[$week]['remain_days'][$count_p]['out_time_minute'] = $out_time_minute;
                                                        // $for_ot_data[$week]['weekly_ot'] = $weekly_ot;
                                                        // $for_ot_data['monthly_ot'] = $monthly_ot;
                                                        $count_p++;
                                                      }

                                                      $date_data[$i]['date'] = $v2->attendance_date;
                                                      $date_data[$i]['status'] = "P";
                                                      $date_data[$i]['leave_type'] = "";
                                                      $date_data[$i]['background'] = "#8cb9e9"; // blue
                                                      $date_data[$i]['in_time'] = $in_time_string;
                                                      $date_data[$i]['out_time'] = $out_time_string;
                                                      $date_data[$i]['duration'] = $hours;

                                                      break;
                                                    }
                                                    if($v2->status == "Half Day") {
                                                      $check_valid_date = 1;
                                                      $check_date = 1;
                                                      if($in_time_string == 0) {
                                                        $in_time_string = "09:30";
                                                        $out_time_string = "14:00";
                                                      }
                                                      $total_half_day = $total_half_day+0.5;
                                                      if($v2->leave_type == "EL-PL" || $v2->leave_type == "CL" || $v2->leave_type == "CO" ) { $date_data[$i]['background'] = "#e1c368"; // yellow
                                                        $total_pay_days++; $total_leave =  $total_leave +0.5; }
                                                      else  {
                                                      $date_data[$i]['background'] = "#e76874"; // red
                                                      $total_pay_days = $total_pay_days + 0.5;}

                                                      $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );

                                                      // $hours = round ( ( ( $time_diff->h ) + (  $time_diff->i / 60) ) , 1);
                                                      $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);

                                                      // if($time_diff->h < 2 || $out_time_hour > 14) {
                                                      //   $out_time_string = "14:" . ( $hd_out_minute++ );
                                                      //   if($hd_out_minute >= 15) { $hd_out_minute = 10;}
                                                      //   $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                      //   $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                      // }

                                                      // if($time_diff->h < 4 || $out_time_hour > 14 || $time_diff->h > 4 || ( $out_time_hour == 14 && $out_time_minute >=16  ) ) {
                                                      //   $out_time_string = "13:" . ( $hd_out_minute++ );
                                                      //   if($hd_out_minute >= 16) { $hd_out_minute = 11;}
                                                      //   $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                      //   $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                      // }

                                                      if($time_diff->h < 4 || $out_time_hour > 14 || $time_diff->h > 4 || ( $out_time_hour == 14 && $out_time_minute >=59  ) ) {
                                                        $out_time_string = "13:" . ( $hd_out_minute++ );
                                                        if($hd_out_minute >= 59) { $hd_out_minute = 30;}
                                                        $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                        if($time_diff->h < 4 || $time_diff->h > 4 ) {
                                                           $in_time_string = "09:30";
                                                          $out_time_string = "13:" . ( $hd_out_minute++ );
                                                          if($hd_out_minute >= 59) { $hd_out_minute = 30;}
                                                          $time_diff  = date_diff( date_create($in_time_string), date_create($out_time_string) );
                                                        }
                                                        $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                      }

                                                      $date_data[$i]['date'] = $v2->attendance_date;
                                                      $date_data[$i]['status'] = "HD" . ($v2->leave_type ? ( "/". $v2->leave_type ): "" );
                                                      $date_data[$i]['leave_type'] = ($v2->leave_type ? ( "/". $v2->leave_type ): "" );
                                                      $date_data[$i]['in_time'] = $in_time_string;
                                                      $date_data[$i]['out_time'] = $out_time_string;
                                                      $date_data[$i]['duration'] = $hours;
                                                      break;
                                                    }
                                                    if($v2->status == "On Leave") {

                                                      if($check_holiday == 1) {
                                                        if($check_valid_holiday == 1) {
                                                          $total_pay_days = $total_pay_days - 1;
                                                          if($date_data[$i]['status'] == "WO") { $total_week_off--;}
                                                          if($date_data[$i]['status'] == "H") { $total_holiday--;}
                                                        }
                                                      }

                                                      $check_date = 1;
                                                      $total_leave++;
                                                      $date_data[$i]['date'] = $v2->attendance_date;
                                                      $date_data[$i]['status'] = "L" . ($v2->leave_type ? ( "/". $v2->leave_type ): "" );
                                                      $date_data[$i]['leave_type'] = ($v2->leave_type ? ( "/". $v2->leave_type ): "" );
                                                      $date_data[$i]['out_time'] = "";
                                                      $date_data[$i]['duration'] = "";
                                                      if($v2->leave_type == "EL-PL" || $v2->leave_type == "CL" || $v2->leave_type == "CO" ) {
                                                        $date_data[$i]['background'] = "#a5ebde"; // light blue
                                                        $total_pay_days++;}
                                                      else  {
                                                        $date_data[$i]['background'] = "#e76874"; // red
                                                      }

                                                      break;
                                                    }
                                                    if($v2->status == "Absent") {
                                                      $check_date = 1;
                                                      $total_absent++;
                                                      $date_data[$i]['date'] = $v2->attendance_date;
                                                      $date_data[$i]['status'] = "A";
                                                      $date_data[$i]['leave_type'] = "";
                                                      $date_data[$i]['background'] = "#9ceddd" ; // green
                                                      $date_data[$i]['in_time'] = "";
                                                      $date_data[$i]['out_time'] = "";
                                                      $date_data[$i]['duration'] = "";
                                                      break;
                                                    }
                                                }
                                              }

                                              if($check_date == 0) {
                                                 // blank
                                              }

                                            }

                                            $count_week = 0;
                                            $check_week_array = [];
                                            $check_week = 0;
                                            $count_loop = 0;
                                            $monthly_ot = 0;
                                            $remaining_ot = $data->ot_hour;
                                            // while($monthly_ot > $data->ot_hour || $monthly_ot >= 16 || $count_week >= $week) {
                                            while($count_week < ($week-1) || $remaining_ot <= 0) {
                                              // print_r("<br>hi11<br>");

                                              // print_r("<br>count_loop : $count_loop hi177#");
                                              $count_loop++;
                                              if($count_loop >= 20) {
                                                break;
                                              }

                                              // $all_week = range(1, $week-1);

                                              $all_week = range(1, $week);
                                              // print_r("<br>hi18#<br>");
                                              // print_r($all_week);
                                              // $week_rand_order = array_rand($all_week, count($all_week));
                                              // $week_rand_order = shuffle($all_week);
                                               shuffle($all_week);

                                              // print_r("<br>hi15#<br>");
                                              // print_r($all_week);
                                              // print_r("<br>hi16#<br>");
                                              // print_r($week_rand_order);

                                              for($q=0; $q<$week-1; $q++) {
                                                $get_week = $all_week[$q];



                                                // $get_week = rand(1, ($week-1));
                                                // $get_week = 1;

                                                // $check_week = 0;
                                                // print_r(in_array($get_week, $check_week_array));
                                                // print_r("<br>");
                                                // // print_r("<br>get_week : " . $get_week . "<br>");
                                                // if(in_array($get_week, $check_week_array)){
                                                //   print_r("<br>get_week : $get_week hi13#");
                                                //   continue;
                                                // }
                                                // else {
                                                //   print_r("<br>get_week : $get_week hi14#");
                                                //   array_push($check_week_array, $get_week);
                                                // }
                                                // }

                                                $weekly_ot = 0;

                                                // $loop_count = 0;


                                                $week_p = isset($for_ot_data[$get_week]['remain_days']) ? count($for_ot_data[$get_week]['remain_days']) : 0 ;
                                                // print_r($for_ot_data[$get_week]['remain_days']);
                                                // print_r("<br>week_p : " . $week_p . "<br>");
                                                // print_r($check_week_array);

                                                $count_week++;

                                                if($remaining_ot <= 0) {
                                                  break;
                                                }

                                                if($week_p <= 2 & $week_p > 0) {

                                                  $break_here = 0;
                                                  foreach ($for_ot_data[$get_week]['remain_days'] as $k3 => $v3) {

                                                    $ot_hour_rand = 2;
                                                    // $ot_hour_rand = rand(1,2);
                                                    if($remaining_ot <= 2) { $ot_hour_rand = $remaining_ot; }

                                                    for($i=1; $i<=count($date_data); $i++) {
                                                      if($break_here == 1) { break; } // for all ot given
                                                      if(isset($date_data[$i]['date'])) {
                                                        if($date_data[$i]['date'] == $v3['date']) {

                                                          // print_r("<br>date: " .$date_data[$i]['date']);

                                                          $date_data[$i]['out_time'] = ( 18  + $ot_hour_rand ) . ":".  sprintf("%02d", $v3['out_time_minute']);
                                                          $time_diff  = date_diff( date_create($date_data[$i]['in_time']), date_create($date_data[$i]['out_time']) );
                                                          $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                          $date_data[$i]['duration'] = $hours;
                                                          $monthly_ot += $ot_hour_rand;

                                                          $remaining_ot = $remaining_ot - $ot_hour_rand;
                                                          if($remaining_ot <= 0) { $break_here = 1;} // for all ot given

                                                        }
                                                      }
                                                    }
                                                    if($break_here == 1) { break; } // for all ot given
                                                  }
                                                  // if($break_here == 1) { break; } // for all ot given
                                                }
                                                elseif($week_p == 3 ) {

                                                  $break_here = 0;

                                                  $get_rand_index = array_rand($for_ot_data[$get_week]['remain_days'],3);

                                                  for($k=0; $k<3; $k++) {


                                                    $ot_hour_rand = rand(1,2);
                                                    if($remaining_ot <= 2) { $ot_hour_rand = $remaining_ot; }
                                                    elseif($remaining_ot >= 2 && $k == 2) { $ot_hour_rand = 4 - $weekly_ot; }
                                                    // elseif($count_ot > 4) { $break_here = 1; }; // max ot given

                                                    for($i=1; $i<=count($date_data); $i++) {
                                                      if($break_here == 1) { break; } // for all ot given
                                                      if(isset($date_data[$i]['date'])) {
                                                        if($date_data[$i]['date'] == $for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['date']) {
                                                          // print_r("<br>hi55<br>");
                                                          // print_r($for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['out_time_minute']);

                                                          if($weekly_ot >=3 && $ot_hour_rand >= 1) {
                                                            $ot_hour_rand = 4 - $weekly_ot;
                                                          }


                                                          $date_data[$i]['out_time'] =  (18  + $ot_hour_rand ) . ":". sprintf("%02d", $for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['out_time_minute']) ;

                                                          $time_diff  = date_diff( date_create($date_data[$i]['in_time']), date_create($date_data[$i]['out_time']) );
                                                          $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                          $date_data[$i]['duration'] = $hours;
                                                          $weekly_ot += $ot_hour_rand;
                                                          if($weekly_ot >= 4 ) { $break_here = 1; } // for max ot given
                                                          $monthly_ot += $ot_hour_rand;


                                                          print_r("<br>date: " .$date_data[$i]['date']);
                                                          // print_r("<br>weekly_ot: $weekly_ot<br>");
                                                          // print_r("<br>monthly_ot: $monthly_ot<br>");

                                                          $remaining_ot = $remaining_ot - $ot_hour_rand;
                                                          if($remaining_ot <= 0) { $break_here = 1;} // for all ot given
                                                        }
                                                      }

                                                    }
                                                    if($break_here == 1) { break; } // for all ot given
                                                  }

                                                  // if($break_here == 1) { break; } // for all ot given or max ot given

                                                }
                                                elseif($week_p > 3 ) {
                                                  $break_here = 0;
                                                  // print_r("<br>hi22<br>");

                                                  $get_rand_index = array_rand($for_ot_data[$get_week]['remain_days'],4);
                                                  // print_r($get_rand_index);
                                                  // print_r("<br>hi33<br>");


                                                  for($k=0; $k<4; $k++) {

                                                    $count_ot = 0;
                                                    $ot_hour_rand = rand(1,2);
                                                    if($remaining_ot <= 2) { $ot_hour_rand = $remaining_ot;  }

                                                    for($i=1; $i<=count($date_data); $i++) {
                                                      // print_r("<br>$get_rand_index[$k]<br>");
                                                      // print_r("<br>hi44<br>");
                                                      if($break_here == 1) { break; } // for all ot given
                                                      if(isset($date_data[$i]['date'])) {
                                                        if($date_data[$i]['date'] == $for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['date']) {

                                                          if($weekly_ot >=3 && $ot_hour_rand >= 1) {
                                                            $ot_hour_rand = 4 - $weekly_ot;
                                                          }

                                                          // if($weekly_ot > 2 && $ot_hour_rand >=  2) {
                                                          //   $ot_hour_rand = 4 - $weekly_ot;
                                                          // }
                                                          // print_r("<br>hi66<br>");
                                                          // print_r($for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['out_time_minute']);
                                                          $date_data[$i]['out_time'] =  (18  + $ot_hour_rand ) . ":". sprintf("%02d", $for_ot_data[$get_week]['remain_days'][$get_rand_index[$k]]['out_time_minute']) ;


                                                          $time_diff  = date_diff( date_create($date_data[$i]['in_time']), date_create($date_data[$i]['out_time']) );
                                                          $hours = ($time_diff->h < 10 ? ("0". $time_diff->h) : $time_diff->h) . ":" . ($time_diff->i < 10 ? ("0". ( (int) $time_diff->i) ) : $time_diff->i);
                                                          $date_data[$i]['duration'] = $hours;

                                                          $weekly_ot += $ot_hour_rand;
                                                          if($weekly_ot >= 4 ) { $break_here = 1; } // for max ot given
                                                          else {}

                                                          $monthly_ot += $ot_hour_rand;

                                                          // print_r("<br>date: " .$date_data[$i]['date']);
                                                          // print_r("<br>ot_hour_rand: $ot_hour_rand<br>");
                                                          // print_r("<br>weekly_ot: $weekly_ot<br>");
                                                          // print_r("<br>monthly_ot: $monthly_ot<br>");

                                                          $remaining_ot = $remaining_ot - $ot_hour_rand;
                                                          if($remaining_ot <= 0) { $break_here = 1;} // for all ot given
                                                        }
                                                      }
                                                    }
                                                    if($break_here == 1) { break; } // for all ot given
                                                  }

                                                  // if($break_here == 1) { break; } // for all ot given or max ot given

                                                }
                                                // $get_week++;
                                            }
                                          }

                                            // print_r($check_week_array);



                                           ?>



                                             @for($i= 0; $i<4; $i++)
                                                 @if($i==0)
                                                 <tr>
                                                   <td rowspan="4" >{{ $compliance_data->firstItem() +  $key  }}</td>
                                                   <td rowspan="4" >{{ $data->employee  }}</td>
                                                   <td rowspan="4" >{{ $data->employee_name }}</td>
                                                   <td rowspan="4" >{{ $data->parent_department }}</td>
                                                   <td rowspan="4" >{{ $data->employee_number_new }}</td>
                                                   <td>Status</td>
                                                   @for($j=1; $j<=$total_date; $j++)
                                                     @if(isset($date_data[$j]['status'])) <td style="font-weight: bold; background: @if(isset($date_data[$j]['background'])){{ $date_data[$j]['background'] }}@endif">  {{ $date_data[$j]['status'] }} </td>
                                                     @else <td ></td>
                                                     @endif
                                                   @endfor

                                                   <!-- <td style="text-align: center;border: 1px solid black;">Total Present: {{ $total_present }} <br>  Total Leave: {{ $total_leave }} <br> Total Absent: {{ $total_absent }} <br> Total WO: {{ $total_week_off }} <br> Total Holiday:{{ $total_holiday }}  </td> -->
                                                   <td rowspan="4" style="font-weight: bold;" >{{ $total_pay_days }}</td>
                                                   <td rowspan="4" style="font-weight: bold;" >{{ $monthly_ot }}</td>
                                                   <!-- <td rowspan="4" >{{ $act_monthly_ot }}  </td> -->
                                                   <!-- <td rowspan="4" > // $data->ot_hours_round   </td> -->
                                                   <td rowspan="4" style="font-weight: bold; background: @if($monthly_ot != $data->ot_hour ){{ '#77e9c3' }}@endif" >{{ $data->ot_hour }}  </td>
                                                 </tr>

                                                 @elseif($i==1)
                                                 <tr>
                                                   <td>In Time</td>
                                                   @for($j=1; $j<=$total_date; $j++)
                                                     @if(isset($date_data[$j]['in_time']))  <td> {{ $date_data[$j]['in_time'] }}  </td>
                                                     @else <td></td>
                                                     @endif
                                                   @endfor
                                                 </tr>
                                                 @elseif($i==2)
                                                 <tr>
                                                   <td>Out Time</td>
                                                   @for($j=1; $j<=$total_date; $j++)
                                                     @if(isset($date_data[$j]['out_time']))  <td> {{ $date_data[$j]['out_time'] }} </td>
                                                     @else <td></td>
                                                     @endif
                                                   @endfor
                                                 </tr>
                                                 @else
                                                 <tr>
                                                   <td >Duration</td>
                                                   @for($j=1; $j<=$total_date; $j++)
                                                     @if(isset($date_data[$j]['duration']))  <td> {{ $date_data[$j]['duration'] }} </td>
                                                     @else <td></td>
                                                     @endif
                                                   @endfor
                                                 </tr>
                                                 @endif
                                             @endfor

                                            @endforeach

                                        @else
                                          <tr>
                                            <td colspan="10" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                           </tr>
                                        @endif
                                    </tbody>
                                 </table>
                                 <div class="btn-group">
            						            <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
            						            <button type="button" onclick="changenumber(20)" class="btn btn-default btn-sm btn-paging @if(request()->show == 20) btn-info @endif " data-value="20">20</button>
            						            <button type="button" onclick="changenumber(30)" class="btn btn-default btn-sm btn-paging @if(request()->show == 30) btn-info @endif " data-value="30">30</button>
                                  </div>
                                    <div class="pagination pull-right">
                                    {{ $compliance_data->links('vendor.pagination.bootstrap-4') }}
                                </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('footer-scripts')
<script>

</script>
<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
