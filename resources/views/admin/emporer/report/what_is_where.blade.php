@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&order_type='.request()->order_type;
$str .= '&year='.request()->year;
$str .= '&order_start_date='.request()->order_start_date;
$str .= '&order_end_date='.request()->order_end_date;
$str .= '&expected_order_start_date='.request()->expected_order_start_date;
$str .= '&expected_order_end_date='.request()->expected_order_end_date;
$str .= '&customer_code='.request()->customer_code;
$str .= '&company_code='.request()->company_code;
$str .= '&order_no='.request()->order_no;
$showurl = url("/emporer/report/what-is-where?$str");
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/report/what-is-where') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/report/what-is-where') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Order Date - From</label>
                                      <input name="order_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Order Date - To</label>
                                      <input name="order_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Select Customer Code</label>
                                      <select name="customer_code" id="customer_code" class="form-control select2-lib-dropdown-customer_code "> <?php if(isset(request()->customer_code)) { echo  '
                                        <option value="'.request()->customer_code.'" Selected >'.request()->customer_code.'</option>'; } ?>
                                      </select>
                                  </div>
                                  <!-- <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Select Customer Name</label>
                                      <select name="customer_name" id="customer_name" class="form-control select2-lib-dropdown-customer_name "> <?php if(isset(request()->customer_name)) { echo  '
                                        <option value="'.request()->customer_name.'" Selected >'.request()->customer_name.'</option>'; } ?>
                                      </select>
                                  </div> -->
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Order No.</label>
                                      <input name="order_no" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_no }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Order Type</label>
                                      <input name="order_type" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->order_type }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Order Year</label>
                                      <select  name="year" class="form-control">
                                         <option value="">Select Year</option>
                                         @for($i=9; $i<=date("y", time()); $i++)
                                          @if($i == 9)
                                         <option value="09" @if(request()->year == '09') Selected @endif>09</option>
                                          @else
                                          <option value="{{ $i }}" @if(request()->year == $i) Selected @endif>{{ $i }}</option>
                                          @endif
                                         @endfor
                                      </select>
                                  </div>


                                </div>
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Expected Delivery Date - From</label>
                                      <input name="expected_order_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->expected_order_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Expected Delivery Date - To</label>
                                      <input name="expected_order_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->expected_order_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Enter Company Code</label>
                                      <input name="company_code" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->company_code }}">
                                  </div>
                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <table  class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                 <th>Action</th>
                                 <th>S No.</th>
                                 <th>Order No.</th>
                                 <th>Company Code</th>
                                 <th>Client Code</th>
                                 <th>Order Date</th>
                                 <th>Export Delivery Date</th>
                                 <th>Order Remaining Quantity</th>
                                 <th>Order Balance Quantity</th>
                              </tr>
                           </thead>
                           <tbody>
                              @if (count($orders_data) > 0)
                              @php $count = 1; @endphp
                              @foreach($orders_data as $key => $data)
                              <tr>
                                <td style="text-align: center;"><button class="btn btn-info" onclick="getOrderData({{ $data->OdOmIdNo}}, {{ $count }},  this)"> Info </button></td>
                                 <td  style="text-align: center;">{{ $orders_data->firstItem() +  $key }}</td>
                                 <td  style="text-align: center;" id="order-{{ $count++ }}"  >
                                   <a href="/emporer/orders/ordersDetails?OmTc={{ $data->OmTc}}&OmYy={{ $data->OmYy}}&OmChr={{ $data->OmChr}}&OmNo={{ $data->OmNo}}&company_code={{ $data->OmCoCd}}"  style="color: green;">
                                     {{ $data->OmTc }}/{{ $data->OmYy }}/{{ $data->OmChr }}/{{ $data->OmNo }}
                                   </a>
                                 </td>
                                 <td  style="text-align: center;" >{{ $data->OmCoCd }}</td>
                                 <td  style="text-align: center;" >{{ $data->OmCmCd }} ({{ $data->CmName }})</td>
                                 <td  style="text-align: center;" >{{ date("D, d-m-Y", strtotime($data->OmDt)) }}</td>
                                 <td  style="text-align: center;" >{{ date("D, d-m-Y",strtotime($data->OmExpDelDt)) }}</td>
                                 <td  style="text-align: center;" >{{ $data->order_qty }}</td>
                                 <td  style="text-align: center;" >{{ $data->bal_qty }}</td>
                              </tr>
                              @endforeach
                              @else
                              <tr>
                                 <td colspan="11" class="text-center text-danger">
                                    <h3><b>No Record Found</b></h3>
                                 </td>
                              </tr>
                              @endif
                           </tbody>
                        </table>
                        <div class="btn-group">
                           <button type="button" onclick="changenumber(20)" class="btn btn-default btn-sm btn-paging @if(request()->show == 20 || empty(request()->show )) btn-info @endif " data-value="20">20</button>
                           <button type="button" onclick="changenumber(50)" class="btn btn-default btn-sm btn-paging @if(request()->show == 50) btn-info @endif " data-value="50">50</button>
                           <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                         </div>
                         <div class="pagination pull-right">
                         {{ $orders_data->links('vendor.pagination.bootstrap-4') }}
                         </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- confirm Modal -->
<div class="modal fade bd-example-modal-lg" id="all_check_in_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="all_check_in_modal_label" style="font-weight: bold; color: black;">Order No . : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table id="table" class="table-bordered table-striped table " >
          <thead>
            <tr style="text-align: center;">
              <th>S.NO.</th>
              <th>Design Code</th>
              <th>Design Category</th>
              <th>Bag Location</th>
              <th>Bag Quantity</th>
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



@include('admin.emporer.emporer_script')

<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}




function customer_code_select2() {
    $(".select2-lib-dropdown-customer_code").select2({
      placeholder: "Customer Code",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-customer_code',
          }
          return query;
        },
        dataType: 'json',
        processResults: function (data) {
            return data;
        }
      }
    })
}


$(document).ready(function(){
  customer_code_select2();
});



function getOrderData(OmIdNo, order_id, this_var) {
  // $("#all_check_in_modal_label").html("Order No . - " + $("#order-"+order_id)[0].innerText)
  $("#all_check_in_modal_label").html("Order No . - " + $("#order-"+order_id)[0].innerHTML)
  $("#all_check_in_table_body").html("")


       $.ajax({
             url: '{{  url("/emporer/report/what-is-where-order-data") }}',
             cache: false,
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
             type: "get",
             data: { "OmIdNo": OmIdNo },
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


</script>

@endsection
