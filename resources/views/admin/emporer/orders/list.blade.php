@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$showurl = url('/emporer/orders/list?show='.request()->show.'&order_start_date='.request()->order_start_date.'&order_end_date='.request()->order_end_date.'&customer_code='.request()->customer_code.'&customer_name='.request()->customer_name.'&order_no='.request()->order_no.'&expected_order_start_date='.request()->expected_order_start_date.'&purchase_order_no='.request()->purchase_order_no);
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/orders/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/orders/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
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
                                      <label class="design1-form1">Enter Purshase Order No.</label>
                                      <input name="purchase_order_no" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->purchase_order_no }}">
                                  </div>
                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                 <th>S No.</th>
                                 <th>Order No.</th>
                                 <th>Company Code</th>
                                 <th>Client Code</th>
                                 <th>Client Name</th>
                                 <th>Purchase Order No.</th>
                                 <th>Order Date</th>
                                 <th>Export Delivery Date</th>
                              </tr>
                           </thead>
                           <tbody>
                              @if (count($orders_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($orders_data as $key => $data)
                              <tr>
                                 <td  style="text-align: center;">{{ $orders_data->firstItem() +  $key }}</td>
                                 <!-- <td  style="text-align: center;" ><a href="/emporer/orders/ordersDetails?order_no={{ $data->order_no}}&company_code={{ $data->OmCoCd}}"  style="color: green;">{{ $data->order_no }}</a></td> -->
                                 <td  style="text-align: center;" ><a href="/emporer/orders/ordersDetails?OmTc={{ $data->OmTc}}&OmYy={{ $data->OmYy}}&OmChr={{ $data->OmChr}}&OmNo={{ $data->OmNo}}&company_code={{ $data->OmCoCd}}"  style="color: green;">{{ $data->order_no }}</a></td>
                                 <td  style="text-align: center;" >{{ $data->OmCoCd }}</td>
                                 <td  style="text-align: center;" >{{ $data->OmCmCd }}</td>
                                 <td  style="text-align: center;" >{{ $data->CmName }}</td>
                                 <td  style="text-align: center;" >{{ $data->OmPoNo }}</td>
                                 <td  style="text-align: center;" >{{ date("D, d-m-Y", strtotime($data->OmDt)) }}</td>
                                 <td  style="text-align: center;" >{{ date("D, d-m-Y",strtotime($data->OmExpDelDt)) }}</td>
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

function customer_name_select2() {
    $(".select2-lib-dropdown-customer_name").select2({
      placeholder: "Customer Name",
      allowClear: true,
      ajax: {
        url: '/get-emr-parmeters',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'emr-customer_name',
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
  customer_name_select2();
});







</script>

@endsection
