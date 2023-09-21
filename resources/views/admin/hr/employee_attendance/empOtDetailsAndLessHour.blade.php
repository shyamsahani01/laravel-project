@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
<?php
use App\Library\AdminHelper;
 ?>

<style>
    /* .table th {
        padding: 0px !important;
    } */
</style>
<div class="main-panel">
<div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">



          <div class="shadow-lg p-3 mb-5 bg-white rounded">
            <div class="x_title">
                <h2>Employees OT & Less Hours Detail</h2>
                <div class="clearfix"></div>
              </div>
              <div class="card-body" style="margin-top: -20px;">
                  <div class="table-responsive">
                    <table id="new-datatable" class="data" data-rtc-resizable-table="table.one" style="width:100%">
                       <thead>
                         <tr style="text-align: center;color: black;">
                           <th data-rtc-resizable="sno">S.No.</th>
                            <th data-rtc-resizable="date">Date</th>
                           <th data-rtc-resizable="emp">Employee</th>
                           <th data-rtc-resizable="emp_name">Employee Name</th>
                          <th data-rtc-resizable="in_time">In TIme</th>
                           <th data-rtc-resizable="out_time">Out Time</th>
                           <th data-rtc-resizable="ths">Total Working Hours</th>
                           <th data-rtc-resizable="lesshours">Less Hours</th>
                           <th data-rtc-resizable="ot">OT</th>
                        </tr>
                       </thead>
                       <tbody>
                        @if (count($empOT_data) > 0)
                          @php $count = 1 @endphp
                          @foreach($empOT_data as $key => $data)

                          <?php
                          if($data->in_time == NULL || $data->out_time == NULL ) {

                            $in_time = '0';
                            $out_time = '0';
                            $over_time = '0';
                            $base = '';
                            $over_time_include = '';
                            $per_day_sallery = '';
                            $per_hour_salary = '';
                            $over_time_salary = '';
                            $total_working_hours = '0';
                            $less_hours = '0';

                            if($data->in_time != NULL)
                            {
                              $in_time =  date('H:i:s', strtotime($data->in_time) );
                            }
                            if($data->out_time != NULL)
                            {
                              $out_time =  date('H:i:s', strtotime($data->out_time) );
                            }

                          } else {

                            $over_time = '0';
                            $over_time_include = 0;
                            $less_hours = '0';

                            // echo "<pre>";
                            $date_diff_obj = date_diff(date_create($data->in_time), date_create($data->out_time) );
                            // $date_diff_obj = date_diff(date_create($data->out_time), date_create($data->in_time) );
                            $total_working_hours = sprintf('%02d', $date_diff_obj->h).":".sprintf('%02d', $date_diff_obj->i).":".sprintf('%02d', $date_diff_obj->s);

                            // in case of holiday & weekoff
                            if( $data->start_date == $data->holiday_date ) {
                              $over_time = $total_working_hours;
                            }
                            else {
                              $in_time_diff_obj = date_diff(date_create($data->in_time), date_create($data->shift_start) );
                              $out_time_diff_obj = date_diff(date_create($data->shift_end), date_create($data->out_time) );

                              // means late check in
                              $ot_in_seconds = 0;
                              $in_time_diff = '00:00:00';
                              $in_time_diff=sprintf('%02d', $in_time_diff_obj->h).":".sprintf('%02d', $in_time_diff_obj->i).":".sprintf('%02d', $in_time_diff_obj->s);
                              if($in_time_diff_obj->invert == 1)
                              {
                                $less_hours = $in_time_diff;
                              }
                              else { // check for OT
                                $ot_in_seconds = strtotime($in_time_diff) - strtotime("00:00:00");
                              }


                              // means early check out
                              $ot_out_seconds = 0;
                              $out_time_diff = '00:00:00';
                              $out_time_diff=sprintf('%02d', $out_time_diff_obj->h).":".sprintf('%02d', $out_time_diff_obj->i).":".sprintf('%02d', $out_time_diff_obj->s);
                              if($out_time_diff_obj->invert == 1)
                              {
                                $minus_in_time_second = strtotime($in_time_diff) - strtotime("00:00:00");
                                $less_hours = date('H:i:s', strtotime($out_time_diff)+$minus_in_time_second );
                              }
                              else { // check for OT
                                $ot_out_seconds = strtotime($out_time_diff) - strtotime("00:00:00");
                              }

                              $total_ot_seconds = $ot_in_seconds + $ot_out_seconds;

                              if($total_ot_seconds > 0) {
                                $over_time = gmdate("H:i:s", $total_ot_seconds);
                              }

                            }




                            $in_time = date('H:i:s', strtotime($data->in_time) );
                            $out_time = date('H:i:s', strtotime($data->out_time) );
                            $over_time_include = ( $over_time_include == 1 ) ? 'Yes' : 'No';

                            $base = round($data->base, 2);

                          }

                          ?>
                               <tr  style="text-align: center;color: black;">
                                 <td>{{ $count++  }}</td>
                                 <td>{{ date('Y-m-d', strtotime($data->generated_start_date) ) }}</td>
                                 <td>{{ $data->employee  }}</td>
                                 <td>{{ $data->employee_name  }}</td>
                                 <!-- <td>{{ $data->department  }}</td> -->
                                 <td>{{ $in_time  }}</td>
                                 <td>{{ $out_time }}</td>
                                 <td>{{ $total_working_hours }}</td>
                                 <td>{{ $less_hours }}</td>
                                 <td>{{ $over_time  }}</td>
                                 <!-- <td>{{ $over_time_include  }}</td> -->
                                 <!-- <td>{{ $base  }}</td> -->
                               </tr>
                          @endforeach
                       @else
                         <tr>
                           <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                          </tr>
                       @endif
                       </tbody>
                    </table>
                  </div>
              </div>
          </div>


        </div>
    </div>
</div>

<script src="/admin/assets/newTheme/vendors/resizable/dist/js/bundle/index.js"></script>
    <script src="/admin/assets/newTheme/vendors/resizable/dist/samples/store.js"></script>
    <script>
        (function (window, ResizableTableColumns, undefined) {
            var store = window.store && window.store.enabled
                ? window.store
                : null;
            var els = document.querySelectorAll('table.data');
            for (var index = 0; index < els.length; index++) {
                var table = els[index];
                if (table['rtc_data_object']) {
                    continue;
                }
                var options = {
                    store: store,
                    maxInitialWidth: 100
                };
                if (table.querySelectorAll('thead > tr').length > 1) {
                    options.resizeFromBody = false;
                }
                new ResizableTableColumns(els[index], options);
            }
        })(window, window.validide_resizableTableColumns.ResizableTableColumns, void (0));
    </script>
@endsection
