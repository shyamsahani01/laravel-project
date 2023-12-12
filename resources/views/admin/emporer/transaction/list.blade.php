@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&transaction_start_date='.request()->transaction_start_date;
$str .= '&transaction_end_date='.request()->transaction_end_date;
$str .= '&from_location='.request()->from_location;
$str .= '&to_location='.request()->to_location;
$str .= '&transaction_type='.request()->transaction_type;
$str .= '&voucher_no='.request()->voucher_no;
$showurl = url("/emporer/transaction/list?$str");
@endphp

@php
use App\Library\WebHelper;
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/transaction/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/transaction/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Transaction Date - From</label>
                                      <input name="transaction_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->transaction_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Transaction Date - To</label>
                                      <input name="transaction_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->transaction_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">From Location</label>
                                      <input name="from_location" type="text" autocomplete="off" placeholder="From Location" class="form-control" value="{{ request()->from_location }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">To Location</label>
                                      <input name="to_location" type="text" autocomplete="off" placeholder="To Location" class="form-control" value="{{ request()->to_location }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Transaction Type</label>
                                      <input name="transaction_type" type="text" autocomplete="off" placeholder="Transaction Type" class="form-control" value="{{ request()->transaction_type }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Voucher No.</label>
                                      <input name="voucher_no" type="text" autocomplete="off" placeholder="Voucher No." class="form-control" value="{{ request()->voucher_no }}">
                                  </div>
                                </div>
                            </div>
                          </form>
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <table class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                 <th>S No.</th>
                                 <th>Voucher No.</th>
                                 <th>Voucher Type</th>
                                 <th>Company Code</th>
                                 <th>Date</th>
                                 <th>From Location</th>
                                 <th>To Location</th>
                                 <th>User (Modified)</th>
                                 <th>Date (Modified)</th>
                              </tr>
                           </thead>
                           <tbody style="text-align:center;">
                              @if (count($bag_transaction_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($bag_transaction_data as $key => $data)
                              <tr>
                                 <td  style="text-align: center;">{{ $bag_transaction_data->firstItem() +  $key }}</td>
                                 <td>
                                   <!-- <a href="/emporer/transaction/transactionDetails?TTc={{ $data->TTc}}&TYy={{ $data->TYy}}&TChr={{ $data->TChr}}&TNo={{ $data->TNo}}&company_code={{ $data->TCoCd}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }} </a> -->
                                   <a href="/emporer/transaction/transactionDetails?TTc={{ $data->TTc}}&TIdNo={{ $data->TIdNo}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }} </a>
                                 </td>
                                 <td>{{ $data->type  }}</td>
                                 <td>{{ $data->TCoCd  }}</td>
                                 <td>{{ date("D, d-m-Y",strtotime($data->TDt)) }}</td>
                                 <td>{{ $data->TFrBLoc  }}</td>
                                 <td>{{ $data->TLsLoc  }}</td>
                                 <td>{{ $data->ModUsr  }}</td>
                                 <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
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
                         {{ $bag_transaction_data->links('vendor.pagination.bootstrap-4') }}
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


</script>

@endsection
