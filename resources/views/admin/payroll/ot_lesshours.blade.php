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
                                <h2 style="font-size: 1.25rem;">OT & Less Hours Report</h2>
                                <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                                <a href=""  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a>
                                <a href="{{ url('/payroll/ot_lesshours') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}">
                            <div class="x_content">
                                <div class="row">

                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Start Date</label>
                                        <input name="date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="@if(isset (request()->date )){{request()->date }}@else{{date('Y-m-d')}}@endif">
                                    </div>
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">End Date</label>
                                        <input name="date" type="date" autocomplete="off" class="form-control diesign1-form1-input" value="@if(isset (request()->date )){{request()->date }}@else{{date('Y-m-d')}}@endif">
                                    </div>
                                    <div class="col-md-6 col-sm-12  form-group">
                                        <label class="diesign1-form1">Select Company</label>
                                        <select name="company" class="form-control diesign1-form1-input">
                                            <option value=""></option>
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
                    </div>
                    <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                      <div class="card-body">
                        <table id="new-datatable" class="data" data-rtc-resizable-table="table.one" style="width:100%">
                          <thead>
                             <tr style="text-align: center;color: black;">
                               <th data-rtc-resizable="sno">S.No.</th>
                               <th data-rtc-resizable="emp">Employee</th>
                               <th data-rtc-resizable="emp_name">Employee Name</th>
                               @for($i=1; $i<=$total_date; $i++)
                                 <th data-rtc-resizable="date">{{ $i . " " . date("D", strtotime( $year ."-" . $month . "-" . ( ($i<=9) ? "0".$i : $i ) ) ) }}</th>
                               @endfor
                            </tr>
                          </thead>
                          <tbody>
                            @if (count($empAttendance_data) > 0)
                            @php $count = 1 @endphp
                            @foreach($empAttendance_data as $key => $data)
                            <tr style="text-align: center;color: black;">
                              <td>{{ $empAttendance_data->firstItem() +  $key  }}</td>
                              <td> {{ $data->employee}}</td>
                              <td><a href="/hr/employee_attendance/empOtDetailsAndLessHour?employee={{ $data->employee }}&company={{ $data->company }}&month={{ $month }}&year={{ $year }}" target="_blank" style="color: green;">{{ $data->employee_name}}</a></td>
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
                        <div class="pagination pull-right" style="margin-top:10px;">
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
@section('footer-scripts')
<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
