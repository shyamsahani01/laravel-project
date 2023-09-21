@php
use App\Library\AdminHelper;
@endphp

<table id="new-datatable" class="data" data-rtc-resizable-table="table.one" style="width:100%">
  <thead>
     <tr style="text-align: center;color: black;">
       <th data-rtc-resizable="sno">S.No.</th>
       <th data-rtc-resizable="emp">Employee</th>
       <th data-rtc-resizable="emp_name">Employee Name</th>

       <!-- <th>OT</th> -->
        @for($i=1; $i<=$total_date; $i++)
          <th data-rtc-resizable="date">{{ $i . " " . date("D", strtotime( $year ."-" . $month . "-" . ( ($i<=9) ? "0".$i : $i ) ) ) }}</th>
        @endfor
        <th data-rtc-resizable="prd">Present Days</th>
        <th data-rtc-resizable="pd">Pay Days</th>
        <!-- <th>Total Present</th> -->
        <th data-rtc-resizable="ab">Absent</th>
        <!-- <th>Total HD</th> -->
        <th data-rtc-resizable="le">Leave</th>
        <th data-rtc-resizable="we">WeekOff</th>
        <th data-rtc-resizable="ho">Holidays</th>
        <th data-rtc-resizable="elpl">EL/PL</th>
        <th data-rtc-resizable="cl">CL</th>
        <th data-rtc-resizable="co">CO</th>
        <th data-rtc-resizable="lwp">LWP</th>
     </tr>
  </thead>
  <tbody>
    @if (count($empAttendance_data) > 0)
 @php $count = 1 @endphp
  @foreach($empAttendance_data as $key => $data)
      <tr style="text-align: center;color: black;">
        <td>{{ $count++  }}</td>
        <!-- <td><a href="/hr/employee_report/emp_details?employee={{ $data->employee }}"  style="color: green;">{{ $data->employee}}</td> -->
        <td>
          <!-- <a href="/hr/employee_attendance/emp_ot_details?employee={{ $data->employee }}&company={{ $data->company }}&month={{ $month }}&year={{ $year }}"  style="color: green;"> -->
          {{ $data->employee}}</td>
        <td>{{ $data->employee_name}}</td>

        <!-- <td>{{ 0 }}</td> -->
        <?php
        $status = "";

        $total_present_days = 0;
        $total_pay_days = 0;
        $total_present = 0;
        $total_absent = 0;
        $total_half_day = 0;
        $total_leave = 0;
        $total_weekoff = 0;
        $total_holidays = 0;
        $total_el_pl = 0;
        $total_cl = 0;
        $total_co = 0;
        $total_lwp = 0;

        $empAttendanceDetails = AdminHelper::empAttendanceDetails($data->employee, $month, $year);

        foreach ($empAttendanceDetails as $key2 => $value2) {
          // $status = AdminHelper::getAttendanceStatus($value2->status, $value2->leave_type);

          $temp_status = "";

          $date_of_joining = date_create($data->date_of_joining);
          $current_date = date_create($value2->generated_date);
          $date_diff = date_diff($date_of_joining, $current_date);

          if ($value2->status != "On Leave") {
            if($value2->weekly_off == '1') {
                $temp_status = "WO";
                if($date_diff->invert == 1) {
                    // $total_pay_days += 1;
                } else {
                  $total_pay_days += 1;
                  $total_weekoff += 1;
                }

            }elseif ($value2->weekly_off == '0') {
              $temp_status = "H";
              if($date_diff->invert == 1) {
                  // $total_pay_days += 1;
              } else {
                $total_pay_days += 1;
                $total_holidays += 1;
              }
            }
          }




          if($value2->status == "Present") {
            $temp_status = "P";
            $total_present += 1;
            $total_pay_days += 1;
            $total_present_days += 1;
          } elseif ($value2->status == "Absent") {
            $temp_status = "A";
            $total_absent += 1;
          } elseif ($value2->status == "Half Day") {
            $total_half_day += 1;
            $total_present_days += 0.5;
            $total_pay_days += 0.5;
            $temp_status = "HD" . (isset($value2->leave_type) ? "/". str_replace("/","-",$value2->leave_type) : "");

            if($value2->leave_type == "EL/PL") {
              $total_el_pl += 0.5;
              $total_pay_days += 0.5;
              $total_leave += 0.5;
            }
            elseif($value2->leave_type == "CL") {
              $total_cl += 0.5;
              $total_pay_days += 0.5;
              $total_leave += 0.5;
            }
            elseif($value2->leave_type == "CO") {
              $total_co += 0.5;
              $total_pay_days += 0.5;
              $total_leave += 0.5;
            }
            elseif($value2->leave_type == "LWP") {
              $total_lwp += 0.5;
              $total_leave += 0.5;
            }

          } elseif ($value2->status == "On Leave") {
            $total_leave += 1;
            $temp_status = "L" . (isset($value2->leave_type) ? "/". str_replace("/","-",$value2->leave_type) : "");

            if($value2->leave_type == "EL/PL") {
              $total_el_pl += 1;
              $total_pay_days += 1;
            }
            elseif($value2->leave_type == "CL") {
              $total_cl += 1;
              $total_pay_days += 1;
            }
            elseif($value2->leave_type == "CO") {
              $total_co += 1;
              $total_pay_days += 1;
            }
            elseif($value2->leave_type == "LWP") {
              $total_lwp += 1;
            }



          }

          // if(date_format(date_create($value2->generated_date),"D") == "Sun") {
          //   if($value2->status == NULL) {
          //     // $status = "WO";
          //     $temp_status = "WO";
          //   }
          // }

          $in_time = isset($value2->in_time) ? ( "<br>IN : " . date("m-d h:i:s A", strtotime($value2->in_time) ) ) : "";
          $out_time = isset($value2->out_time) ? ( "<br>OUT : " . date("m-d h:i:s A", strtotime($value2->out_time) ) ) : "";

          // echo "<td>$temp_status $in_time $out_time</td>";
          echo "<td>$temp_status</td>";

        }
        ?>
        <td>{{ $total_present_days }}</td>
        <td>{{ $total_pay_days }}</td>
        <!-- <td>{{ $total_present }}</td> -->
        <td>{{ $total_absent }}</td>
        <!-- <td>{{ $total_half_day }}</td> -->
        <td>{{ $total_leave }}</td>
        <td>{{ $total_weekoff }}</td>
        <td>{{ $total_holidays }}</td>
        <td>{{ $total_el_pl }}</td>
        <td>{{ $total_cl }}</td>
        <td>{{ $total_co }}</td>
        <td>{{ $total_lwp }}</td>


        </tr>
  @endforeach
@else
<tr>
  <td colspan="35" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
 </tr>
@endif
  </tbody>
</table>
