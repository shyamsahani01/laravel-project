@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
use App\Library\AdminHelper;
$showurl = url('/hr/employee_report?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name);
@endphp
<style>
    table td,th {
    padding: 8px !important;
}
</style>
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                        <form method="GET" id="filter_form" action="{{ url('/hr/employee_attendance/emp_attendance_report') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">Employee Attendance Report</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <a href="{{ url('/hr/employee_attendance/emp_attendance_report/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.$month.'&year='.$year.'&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a>
                                <a href="{{ url('/hr/employee_attendance/emp_attendance_report') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Select Month</label>
                                        <select name="month" class="form-control diesign1-form1-input">
                                            <option value=""></option>
                                            @php $months = ["01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"Octomber", "11"=>"November", "12"=>"December"]; @endphp @if(!empty($months)) @foreach($months as $key => $value)
                                            <option value="{{ $key }}" @if(request()->month == $key || $month == $key) Selected @endif>{{ $value }}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Select Year</label>
                                        <select name="year" class="form-control diesign1-form1-input">
                                            <option value=""></option>
                                            @for($i=2021; $i
                                            <=date( "Y", time()); $i++) <option value="{{ $i }}" @if(request()->year == $i || $year == $i ) Selected @endif>{{ $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Select Company</label>
                                        <select name="company" class="form-control diesign1-form1-input">
                                            <option value=""></option>
                                            <option value="PINKCITY COLORSTONES PVT. LTD." @if(request()->company == 'PINKCITY COLORSTONES PVT. LTD.') Selected @endif>PINKCITY COLORSTONES PVT. LTD.</option>
                                            <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                                            <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                                            <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Search Employee</label>
                                        <input name="employee_name" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->employee_name }}">
                                    </div>
                                    <!-- <div class="col-md-2 col-sm-6">
                                        <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i>
                                        </button>
                                        <a href="{{ url('/hr/employee_attendance/emp_attendance_report') }}" style="color: white;">
                                            <button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i>
                                            </button>
                                        </a>
                                        <a href="{{ url('/hr/employee_attendance/emp_attendance_report/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a>
                                    </div> -->
                                </div>
                            </div>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important; width:max-content">
                      <div class="card-body">
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
                                <!-- <td>{{ $count++  }}</td> -->
                                <td>
                                  <!-- <a href="/hr/employee_attendance/emp_ot_details?employee={{ $data->employee }}&company={{ $data->company }}&month={{ $month }}&year={{ $year }}"  style="color: green;">
                                  {{ $empAttendance_data->firstItem() +  $key  }}
                                  </a> -->

                                  {{ $empAttendance_data->firstItem() +  $key  }}

                                </td>
                                <td><a href="/hr/employee_report/emp_details?employee={{ $data->employee }}"  style="color: green;">{{ $data->employee}}</td>
                                <td>
                                  <!-- <a href="/hr/employee_attendance/emp_ot_details?employee={{ $data->employee }}&company={{ $data->company }}&month={{ $month }}&year={{ $year }}" target="_blank" style="color: green;"> -->
                                  {{ $data->employee_name}} </td>
                                <!-- <td><a href="/hr/employee_attendance/empOtDetailsAndLessHour?employee={{ $data->employee }}&company={{ $data->company }}&month={{ $month }}&year={{ $year }}" target="_blank" style="color: green;">
                                  {{ $data->employee_name}}</a></td> -->

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

                                $check_ab_sun_mon = 0;
                                $check_ab_three_day_week = 0;
                                $count_ab = 0;

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

                                    $day = date("D", strtotime( $value2->generated_date ) ); {

                                      $temp_status = "A";
                                      $check_ab_three_day_week++;
                                      if($day == "Mon") {
                                        $check_ab_sun_mon++;
                                      }
                                      if($day == "Sat") {
                                        $check_ab_sun_mon++;
                                      }
                                      if($check_ab_sun_mon == 2) {
                                        // $temp_status = "A-Need LWP for Sun";
                                      }
                                      if($check_ab_three_day_week == 3) {
                                        // $temp_status = "A-Need LWP for Sun";
                                      }

                                    }

                                    $count_ab = $count_ab + 1;
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
                                  $str = "<td ";
                                  if($check_ab_sun_mon >= 2) { $check_ab_sun_mon = 0; $str .= " style='background: palevioletred;' " ; }
                                  if($check_ab_three_day_week >= 3 ) { $check_ab_three_day_week = 0; $str .= " style='background: palevioletred;' " ; }
                                  $str .= "> $temp_status </td>";

                                  echo $str;

                                  $day = date("D", strtotime( $value2->generated_date ) ); {
                                    if($day == "Mon") {
                                      $check_ab_sun_mon=0;
                                    }
                                    if($day == "Sun") {
                                      $check_ab_three_day_week=0;
                                    }
                                  }

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
                        <div class="btn-group">
                           <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                           <button type="button" onclick="changenumber(50)" class="btn btn-default btn-sm btn-paging @if(request()->show == 50) btn-info @endif " data-value="50">50</button>
                           <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                           <!-- <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button> -->
                        </div>
                        <div class="pagination pull-right">
                           {{ $empAttendance_data->links('vendor.pagination.bootstrap-4') }}
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/admin/assets/newTheme/vendors/resizable/dist/js/bundle/index.js"></script>
    <script src="/admin/assets/newTheme/vendors/resizable/dist/samples/store.js"></script>
    <script>
        // (function (window, ResizableTableColumns, undefined) {
        //     var store = window.store && window.store.enabled
        //         ? window.store
        //         : null;
        //     var els = document.querySelectorAll('table.data');
        //     for (var index = 0; index < els.length; index++) {
        //         var table = els[index];
        //         if (table['rtc_data_object']) {
        //             continue;
        //         }
        //         var options = {
        //             store: store,
        //             maxInitialWidth: 100
        //         };
        //         if (table.querySelectorAll('thead > tr').length > 1) {
        //             options.resizeFromBody = false;
        //         }
        //         new ResizableTableColumns(els[index], options);
        //     }
        // })(window, window.validide_resizableTableColumns.ResizableTableColumns, void (0));
    </script>
@endsection
@section('footer-scripts')
<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
