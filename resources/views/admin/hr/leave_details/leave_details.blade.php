@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/hr/leave_details?show='.request()->show.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&year='.request()->year);
@endphp


<?php

function checkNull($value=0)
{
  $check_value = 0;
  if($value  == null || $value == "" ) {
    $check_amount = 0;
  }
  else {
    $check_value = $value;
  }

  return $check_value;
}


 ?>

    <div class="main-panel">
        <div class="content">
            @includeif('admin.hr.leave_details.filters')
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
                                               <th>S.NO.</th>
                                               <th>Employee ID</th>
                                               <th>Employee Name</th>
                                               <th>Department</th>
                                               <th>Date Of Joining</th>
                                               <th>Status</th>
                                               <th>Current Month Present</th>
                                               <th>Current Month Half Day</th>

                                               <!-- <th>Total CL</th> -->
                                               <th>Current Month CL</th>
                                               <th>Taken CL</th>

                                               <th>Previours Year EL/PL</th>
                                               <th>Current Month EL/PL</th>
                                               <th>Taken EL/PL</th>

                                             </tr>
                                          </thead>
                                          <tbody>
                                        @if (count($leave_details) > 0)
                                           @php $count = 1; @endphp
                                            @foreach($leave_details as $key => $data)
                                                <tr  style="text-align: center;">
                                                  <td>{{ $leave_details->firstItem() +  $key  }}</td>
                                                  <td><a href="/hr/employee_report/emp_details?employee={{ $data->employee }}" target="_blank"  style="color: green;">{{ $data->employee}}</a></td>
                                                  <td>{{ $data->employee_name }}</td>
                                                  <td>{{ $data->department }}</td>
                                                  <td>{{ $data->date_of_joining }}</td>
                                                  <td>{{ $data->status }}</td>
                                                  <td>{{ checkNull($data->current_present) }}</td>
                                                  <td>{{ checkNull($data->current_half_day) }}</td>
                                                  <!-- <td>{{ round( checkNull($data->total_cl), 4 ) }}</td> -->
                                                  <td>{{ round( (checkNull($data->current_present) >= 10 ? '0.59' : '0' ), 4 ) }}</td>
                                                  <td>{{ round(checkNull($data->taken_cl), 4 ) }}</td>
                                                  <td>{{ round(checkNull($data->total_el_pl), 4 ) }}</td>
                                                  <td>{{ round( ( ( checkNull($data->current_present) + checkNull($data->current_half_day) ) / 20), 4 ) }}</td>
                                                  <td>{{ round( checkNull($data->taken_el_pl), 4 ) }}</td>
                                                </tr>
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
            						            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
            						            <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                                  </div>
                                    <div class="pagination pull-right">
                                    {{ $leave_details->links('vendor.pagination.bootstrap-4') }}
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
