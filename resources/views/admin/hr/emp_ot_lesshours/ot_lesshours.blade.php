@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
use App\Library\AdminHelper;
$showurl = url('/hr/emp_ot_lesshours/ot_lesshours_report?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name);
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
                        <form method="GET" id="filter_form" action="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">OT Report</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a>
                                <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-6 col-sm-12  form-group">
                                      <label class="diesign1-form1">Start Date</label>
                                      <input name="start_date" name="start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->start_date }}">
                                  </div>
                                  <div class="col-md-6 col-sm-12  form-group">
                                      <label class="diesign1-form1">End Date</label>
                                      <input name="end_date" name="end_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->end_date }}">
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

                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <!-- <table id="new-datatable" class="table-responsive table-bordered table"  style="width:100%"> -->
                        <table id="new-datatable" class="table-responsive table-bordered table" >
                          <thead>
                            <tr style="text-align: center;color: black;">
                              <th>S.No.</th>
                              <th>Employee Code</th>
                              <th>Employee Name</th>
                              <th>ESSL Code</th>
                              <th style="width: 150px;">Date</th>
                              <th>In Time</th>
                              <th>Out Time</th>
                              <th>Multiple Check-IN</th>
                              <th>All In Out</th>
                              <th>Actual Total Working Hrs</th>
                              <th>Actual OT Hrs</th>
                              <th>Actual Less Hrs</th>
                              <th>Actual Access Hrs</th>
                              <th>Total Working Hrs</th>
                              <th>OT Include</th>
                              <th>OT Hrs</th>
                              <th>Less Hrs</th>
                              <th>Access Hrs</th>
                              <th>Monthly Salary</th>
                              <th>Per Day Salary</th>
                              <th>Per Hour Salary</th>
                              <th>Modified OT Hours</th>
                              <!-- <th>Final Calculated OT Hrs</th> -->
                              <th>Final OT Amount</th>
                              <th>Action</th>
                             </tr>
                          </thead>
                          <tbody>
                            @if (count($ot_lesshours_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($ot_lesshours_data as $key => $data)
                              <tr  style="text-align: center;color: black;">
                                <td>{{ $ot_lesshours_data->firstItem() + $key  }}</td>
                                <td>{{ $data->employee  }}</td>
                                <td>{{ $data->employee_name  }}</td>
                                <td>{{ $data->attendance_device_id  }}</td>
                                <td>{{ date("Y-m-d, D", strtotime($data->date) ) }}</td>
                                <td>{{ date("H:i:s", strtotime($data->in_time) ) }}</td>
                                <td>{{ date("H:i:s", strtotime($data->out_time) )  }}</td>
                                <td>{{ ($data->multiple_checkin == 1 ) ? "Multi Check-IN Yes" : "No" }}</td>
                                <td>
                                  @if($data->multiple_checkin == 1)
                                  <a href="javascript:void(0)" onclick="openAllCheckin({{ $data->id  }})" style="color: white;" class="btn btn-success design1-form1-btn"><i class="fa fa-eye"></i></a>
                                  @endif
                                </td>
                                <td>{{ $data->total_hours }}</td>
                                <td>{{ $data->ot_hours }}</td>
                                <td>{{ $data->less_hours }}</td>
                                <td>{{ $data->access_hours }}</td>
                                <td>{{ $data->total_hours_round }}</td>
                                <td>{{ ($data->ot_includes == 1 ) ?  "Yes" : "No" }}</td>
                                <td>{{ $data->ot_hours_round }}</td>
                                <td>{{ $data->less_hours_round }}</td>
                                <td>{{ $data->access_hours_round }}</td>
                                <td>{{ $data->gross_monthly_salary }}</td>
                                <td >{{ round($data->per_day_salary) }}</td>
                                <td class="per_hour_salary">{{ round($data->per_hour_salary) }}</td>
                                <td class="user_modified_hour">
                                  <input style="width: 80px;"  step="any" type="number" onchange="performEmpCalculation(this, {{$data->id}})" id="final_ot_hour_id_{{$data->id}}" name="final_ot_hour" value="{{ $data->final_ot_hour }}" class="form-control">
                                </td>
                                <td class="final_amount">{{ round($data->final_ot_hour_salary) }}</td>
                                <td >
                                  <a href="javascript:void(0)"  title="Save" onclick="saveForm(this, {{$data->id}})" class="btn btn-success">Save</a>
                                </td>
                              </tr>
                         @endforeach
                          @else
                            <tr>
                              <td colspan="18" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
                         {{ $ot_lesshours_data->links('vendor.pagination.bootstrap-4') }}
                         </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- confirm Modal -->
<div class="modal fade" id="all_check_in_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="all_check_in_modal_label">All Check In Details </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table id="table" class="table-bordered table" >
          <thead>
            <tr style="text-align: center;color: black;">
              <th>S.No.</th>
              <th>In Time</th>
              <th>Out Time</th>
             </tr>
          </thead>
          <tbody id="all_check_in_table_body">
            <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
            </tr>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}




    function openAllCheckin(id) {
      $("#all_check_in_table_body").html("")


           $.ajax({
                 url: '{{  url("/hr/emp_ot_lesshours/getHTMLData") }}',
                 cache: false,
                 headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                 type: "post",
                 data: { "id": id },
                 dataType: "json",
                 beforeSend: function (obj) {
                   $('#loader').removeClass('hidden')
                 },
                 success: function(obj){
                   $('#loader').addClass('hidden')
                    if(obj.status) {
                       $("#all_check_in_table_body").html(obj.html_data)
                       $("#all_check_in_modal").modal("show")

                    }else {
                       alert(obj.msg)
                    }


                 },
                 error: function(obj){
                   $('#loader').addClass('hidden')
                    var error_msg = ""
                    $.each(obj.responseJSON.errors, function (key, val) {
                        error_msg +=  val[0] + "\n";
                    });
                    alert(error_msg)

                 },
             });

    }


function performEmpCalculation(this_instance, id) {

  var per_hour_td = $(this_instance).closest('td').siblings('td.per_hour_salary')

  if( per_hour_td.length > 0) {
    var per_hour_salary = 0;
    if(checkValue($(per_hour_td)[0].innerText) == 1) {
      per_hour_salary = parseFloat($(per_hour_td)[0].innerText)
    }
    var final_amount = 0;
    final_amount = parseFloat( per_hour_salary ) * parseFloat( $(this_instance).val() );
    final_amount = final_amount.toFixed()
    if(checkValue(final_amount) == 0 || final_amount == NaN ){
      final_amount = 0
    }

    var final_amount_td = $(this_instance).closest('td').siblings('td.final_amount')
    $(final_amount_td).html( final_amount )
  }

}




  function checkValue(value) {
      var check = 0;
        // if(parseFloat(value) == NaN || parseFloat(value) <= 0  ||  value <= 0 || value == "" ||  value == undefined) {
        if(parseFloat(value) == NaN || value == NaN || value == "NaN" || parseFloat(value) < 0   || value == "" ||  value == undefined) {
          check = 0;
        }
        else {
          check = 1;
        }
        return check;
    }


    function saveForm(this_instance, id) {
      var final_ot_hour =  $('#final_ot_hour_id_'+id).val();
      console.log("final_ot_hour : " + final_ot_hour);

      if(final_ot_hour < 0 ) {
        alert("Please enter OT amount.")
      }
      else {

           $.ajax({
                 url: '{{  url("/hr/emp_ot_lesshours/updateData") }}',
                 cache: false,
                 headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                 type: "post",
                 data: {"final_ot_hour" : $('#final_ot_hour_id_'+id).val(), "type": "ot_update", "id": id },
                 dataType: "json",
                 beforeSend: function (obj) {
                   $('#loader').removeClass('hidden')
                 },
                 success: function(obj){
                   $('#loader').addClass('hidden')
                    if(obj.status) {
                       alert("OT updated successfully.")

                    }else {
                       alert(obj.msg)
                    }


                 },
                 error: function(obj){
                   $('#loader').addClass('hidden')
                    var error_msg = ""
                    $.each(obj.responseJSON.errors, function (key, val) {
                        error_msg +=  val[0] + "\n";
                    });
                    alert(error_msg)

                 },
             });
      }

    }


</script>

@endsection
