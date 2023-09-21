@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/essl/check_in_local/list?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name);
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
                        <form method="GET" id="filter_form" action="{{ url('/essl/check_in_local/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <a href="{{ url('/essl/check_in_local/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a>
                                <a href="{{ url('/essl/check_in_local/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
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
                                          <option value="Color Stone" @if(request()->company == 'Color Stone') Selected @endif>PINKCITY COLORSTONES PVT. LTD.</option>
                                          <option value="PC-M" @if(request()->company == 'PC-M') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                                          <option value="PC-I" @if(request()->company == 'PC-I') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                                          <option value="PC-II" @if(request()->company == 'PC-II') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
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
                        <table id="new-datatable" class="table-responsive table-bordered table" style="display:table" >
                          <thead>
                            <tr style="text-align: center;color: black;">
                              <th>S.No.</th>
                              <th>Employee Code</th>
                              <th>Employee Name</th>
                              <th>Department</th>
                              <th>Designation</th>
                              <th>Company</th>
                              <!-- <th>LogType</th> -->
                              <th>In Time</th>
                              <th>Out Time</th>
                              <th>Time Diff</th>
                             </tr>
                          </thead>
                          <tbody>
                            @if (count($check_in_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($check_in_data as $key => $data)
                              <tr  style="text-align: center;color: black;">
                                <td>{{ $check_in_data->firstItem() + $key  }}</td>
                                <td>{{ $data->employee_id  }}</td>
                                <td>{{ $data->emp_name  }}</td>
                                <td>{{ $data->department  }}</td>
                                <td>{{ $data->designation  }}</td>
                                <td>{{ $data->company  }}</td>
                                <!-- <td style="color: @if($data->type==1){{ 'green'}}@else{{ 'red' }}@endif">{{ ($data->type == 1 ) ? "In" : "Out" }}</td> -->
                                <td>{{ date("D, Y-m-d H:i:s", strtotime($data->in_time) ) }}</td>
                                <td>@if(isset($data->out_time)){{ date("D, Y-m-d H:i:s", strtotime($data->out_time) ) }}@endif</td>
                                <td>
                                  @if(isset($data->out_time))
                                    @php
                                      $time_diff = "";
                                      $date_diff = date_diff(date_create($data->out_time), date_create($data->in_time));
                                      $time_diff = ( $date_diff->days * 60 * 60 * 24 ) + ($date_diff->h * 60 * 60 ) + ($date_diff->i * 60 ) + + ($date_diff->s);
                                    @endphp
                                    {{ $time_diff }}
                                  @endif
                                </td>
                              </tr>
                         @endforeach
                          @else
                            <tr>
                              <td colspan="8" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
                         {{ $check_in_data->links('vendor.pagination.bootstrap-4') }}
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
