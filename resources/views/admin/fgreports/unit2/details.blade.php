@extends('admin.layout.app')
@section('content')

<?php
use App\Library\AdminHelper;
 ?>
<style>
    /* .table th {
        padding: 0px !important;
    } */
</style>

<!-- Datatables -->
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">


<div class="main-panel">
<div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">



          <div class="shadow-lg p-3 mb-5 bg-white rounded">
            <div class="x_title">
                <h2>Employees Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="card-body" style="margin-top: -20px;">
                  <div class="table-responsive">
                    <table id="new-datatable" class="table table-striped table-bordered" style="">
                       <thead>
                          <tr style="text-align: center;">
                            <th>S.NO.</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <!-- <th>Shift Start</th>
                            <th>Shift End</th> -->
                            <th>In Time</th>
                            <th>Out Time</th>
                            <!-- <th>Shift Difference</th> -->
                            <!-- <th>In Time Difference</th>
                            <th>Out Time Difference</th> -->
                            <th>Over Time</th>
                            <!-- <th>Over Time(Round)</th> -->
                            <th>OT Included</th>
                            <th>Base Salary</th>
                            <th>Per Day Salary</th>
                            <th>Per Hour Salary</th>
                            <th>Over Time Salary</th>
                          </tr>
                       </thead>
                       <tbody>
                        @if (count($employee_data) > 0)
                          @php $count = 1 @endphp
                          @foreach($employee_data as $key => $data)

                          <?php
                          $over_time = 0;
                          $over_time_include = 0;
                          $per_hour_salary = 0;
                          $over_time_salary = 0;
                          //for sunday data ------------------
                          if($data->over_time == NULL) {
                            $over_time = $data->in_out_diff_in_hour;
                            $per_hour_salary = (float) $data->per_day_sallery /  8.5  ;
                            $over_time_salary = $per_hour_salary * (float) $data->in_out_diff_in_hour ;
                          } else {
                            $over_time = $data->over_time;
                            $per_hour_salary = ((float) $data->shift_diff) >= 0 ? ( (float) $data->per_day_sallery / (float) $data->shift_diff ) : 0;
                            $over_time_salary = $per_hour_salary * (float) $data->over_time ;
                          }
                          $over_time_include = AdminHelper::overTimeCalculation($data->base, $over_time);
                          ?>
                               <tr  style="text-align: center;">
                                 <td>{{ $count++  }}</td>
                                 <td>{{ $data->employee_name  }}</td>
                                 <td>{{ $data->department  }}</td>
                                 <!-- <td>{{ date('Y-m-d H:i:s', strtotime($data->shift_start) )  }}</td>
                                 <td>{{ date('Y-m-d H:i:s', strtotime($data->shift_end) )  }}</td> -->
                                 <td>{{ date('Y-m-d H:i:s', strtotime($data->in_time) )  }}</td>
                                 <td>{{ date('Y-m-d H:i:s', strtotime($data->out_time) ) }}</td>
                                 <!-- <td>{{ date('h:i:s', strtotime($data->shift_diff) )  }}</td>
                                 <td>{{ date('h:i:s', strtotime($data->in_time_diff) )  }}</td>
                                 <td>{{ date('h:i:s', strtotime($data->out_time_diff) ) }}</td> -->
                                 <td>{{ round($over_time, 2)  }}</td>

                                 <!-- <td>{{ round($over_time, 0)  }}</td> -->
                                 <td>{{ ( $over_time_include == 1 ) ? 'Yes' : 'No'  }}</td>
                                 <td>{{ "₹ ". number_format($data->base, 2)  }}</td>
                                 <td>{{ "₹ ".  number_format($data->per_day_sallery, 2)  }}</td>
                                 <td>{{ "₹ ".  number_format( $per_hour_salary, 2)   }}</td>
                                 <td>{{ "₹ ". number_format( $over_time_salary, 2)  }}</td>
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

          <div class="shadow-lg p-3 mb-5 bg-white rounded">
            <div class="x_title">
                <h2>Finish Good Details</h2>
                <div class="clearfix"></div>
              </div>
              <div class="card-body" style="margin-top: -20px;">
                  <div class="table-responsive">
                    <table id="new-datatable-2" class="table table-striped table-bordered" style="">
                       <thead>
                          <tr style="text-align: center;">
                            <th>S.NO.</th>
                            <!-- <th>Customer Code</th> -->
                            <th>Order Caret</th>
                            <th>Finish Good Value</th>
                            <th>Order No.</th>
                            <th>Order Serial</th>
                            <th>Quantity</th>
                            <th>Weight</th>
                          </tr>
                       </thead>
                       <tbody>
                        @if (count($fg_data) > 0)
                          @php $count = 1 @endphp
                          @foreach($fg_data as $key => $data)
                               <tr  style="text-align: center;">
                                 <td>{{ $count++  }}</td>
                                 <!-- <td>{{ $data->odomcmcd  }}</td> -->
                                 <td>{{ $data->odkt  }}</td>
                                 <td>{{ round($data->FgValue, 2)  }}</td>
                                 <td>{{ $data->fdprdodno  }}</td>
                                 <td>{{ $data->fdprdodsr  }}</td>
                                 <td>{{ round($data->fdqty, 0)  }}</td>
                                 <td>{{ round($data->fdgrwt, 2)  }}</td>
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


<!-- Datatables -->
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>

<script>

$(function() {
  $('#new-datatable-2').DataTable( {
    ordering: true,
    dom: 'Bfrtip',
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],     // page length options
    buttons: [
      {
        extend: 'excel',
        text: 'EXCEL',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'fg_data_details_unit_2_' + n;
            }
      },
      {
        extend: 'csv',
        text: 'CSV',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'fg_data_details_unit_2_' + n;
            }
      },
      {
        extend: 'pdf',
        text: 'PDF',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'fg_data_details_unit_2_' + n;
            }
      },
      'copy', 'pageLength']
  } );
  $('#new-datatable').DataTable( {
    ordering: true,
    dom: 'Bfrtip',
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],     // page length options
    // buttons: ['excel', 'csv', 'copy', 'pdf', 'pageLength']
    buttons: [
      {
        extend: 'excel',
        text: 'EXCEL',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'emp_details_unit_2_' + n;
            }
      },
      {
        extend: 'csv',
        text: 'CSV',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'emp_details_unit_2_' + n;
            }
      },
      {
        extend: 'pdf',
        text: 'PDF',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                return 'emp_details_unit_2_' + n;
            }
      },
      'copy', 'pageLength']
  } );
});

</script>

<style>
.dt-buttons.btn-group {
  margin-bottom: -50px;
}
</style>


@endsection
