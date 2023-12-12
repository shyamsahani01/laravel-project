@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&bag_open_start_date='.request()->bag_open_start_date;
$str .= '&bag_open_end_date='.request()->bag_open_end_date;
$str .= '&design_code='.request()->design_code;
$str .= '&order_no='.request()->order_no;
$str .= '&bag_no='.request()->bag_no;
$showurl = url("/emporer/bag/list?$str");
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
                        <form method="GET" id="filter_form" action="{{ url('/emporer/bag/list') }}">
                            <div class="x_title">
                                <h2 style="font-size: 1.25rem;">{{ $title }}</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <!-- <a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name. '&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a> -->
                                <a href="{{ url('/emporer/bag/list') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Bag Open Date - From</label>
                                      <input name="bag_open_start_date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->bag_open_start_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Bag Open  Date - To</label>
                                      <input name="bag_open_end_date"  type="date" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->bag_open_end_date }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Design Code</label>
                                      <input name="design_code" type="text" autocomplete="off" placeholder="Design Code" class="form-control" value="{{ request()->design_code }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Order No.</label>
                                      <input name="order_no" type="text" autocomplete="off" placeholder="Order No." class="form-control" value="{{ request()->order_no }}">
                                  </div>
                                  <div class="col-md-2 col-sm-12  form-group">
                                      <label class="design1-form1">Bag No.</label>
                                      <input name="bag_no" type="text" autocomplete="off" placeholder="Bag No." class="form-control" value="{{ request()->bag_no }}">
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
                                 <th>S No.</th>
                                 <th>Bag No.</th>
                                 <th>Company Code</th>
                                 <th>Order No.</th>
                                 <th style="min-width: 125px;">Design Code</th>
                                 <th>Size</th>
                                 <th style="min-width: 125px;">Open Date</th>
                                 <th>Open Location</th>
                                 <th>Bag Location</th>
                                 <th>Quantity</th>
                                 <th>Gross Weight</th>
                                 <th style="min-width: 125px;" >Received Date</th>
                                 <th>FG Sub Location</th>
                              </tr>
                           </thead>
                           <tbody style="text-align:center;">
                              @if (count($bag_data) > 0)
                              @php $count = 1 @endphp
                              @foreach($bag_data as $key => $data)
                              <tr>
                                 <td  style="text-align: center;">{{ $bag_data->firstItem() +  $key }}</td>
                                 <!-- <td><a href="/emporer/bag/bagDetails?bag_no={{ $data->bag_no}}&company_code={{ $data->BCoCd}}"  style="color: green; font-weight:bold">{{ $data->bag_no }} </a></td> -->
                                 <td><a href="/emporer/bag/bagDetails?BIdNo={{ $data->BIdNo}}"  style="color: green; font-weight:bold">{{ $data->bag_no }} </a></td>
                                 <td>{{ $data->BCoCd  }}</td>
                                 <td><a href="/emporer/orders/ordersDetails?OmIdNo={{ $data->BOmIdNo}}"  style="color: green;">{{ $data->order_no  }} </a></td>
                                 <td><a href="/emporer/design/designDetails?design_code={{ $data->BOdDmCd}}"  style="color: green;">{{ $data->BOdDmCd  }} </a></td>
                                 <td>{{ $data->BOdDmSz  }}</td>
                                 <td>{{ date("D, d-m-Y",strtotime($data->BOpnDt)) }}</td>
                                 <td>{{ $data->BOpnLoc  }}</td>
                                 <td>{{ $data->BLoc  }}</td>
                                 <td>{{ $data->BQty  }}</td>
                                 <td>{{ round($data->BGrWt, 4)  }}</td>
                                 <td>{{ date("D, d-m-Y",strtotime($data->BRecvDt)) }}</td>
                                 <td>{{ $data->BFgSubLoc  }}</td>
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
                         {{ $bag_data->links('vendor.pagination.bootstrap-4') }}
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
