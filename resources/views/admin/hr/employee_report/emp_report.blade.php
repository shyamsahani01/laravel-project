@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
@php
$showurl = url('/hr/employee_report?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status);
@endphp
<style>
    table td,th {
    padding: 5px !important;
}
</style>

<div class="main-panel">
   <div class="content">
     <div class="container-fluid">
         <div class="row">
             <div class="col-md-12">
               <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">

                 <form method="GET" id="filter_form" action="{{ url('/hr/employee_report') }}">
                   <div class="x_title">
                       <h2 style="font-size: 1.25rem;">Employee's</h2>
                         <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                         <a href="{{ url('/hr/employee_report') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
                         <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                       <div class="clearfix"></div>
                     </div>
                    <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
                    <div class="x_content">
                       <div class="row">

                          <div class="col-md-6 col-sm-12  form-group">
                             <label class="diesign1-form1">Company</label>
                             <select   name="company"  class="form-control diesign1-form1-input">
                                <option></option>
                                <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura' ) Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                                <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                                <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                             </select>
                          </div>
                          <div class="col-md-6 col-sm-12  form-group">
                            <label class="diesign1-form1">Employee Status</label>
                             <select   name="status"  class="form-control diesign1-form1-input">
                                <option></option>
                                <option value="Active" @if(request()->status == 'Active' ) Selected @endif>Active</option>
                                <option value="Left" @if(request()->status == 'Left') Selected @endif>Left</option>
                            </select>
                          </div>
                          <div class="col-md-6 col-sm-12  form-group">
                            <label class="diesign1-form1">Search Employee</label>
                             <input name="employee_name" type="text" autocomplete="off" class="form-control diesign1-form1-input" value="{{ request()->employee_name }}">
                          </div>
                          <!-- <div class="col-md-2 col-sm-6">
                             <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                             <a href="{{ url('/hr/employee_report') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
                             <a href="{{ url('/hr/salary_register/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a>
                          </div> -->
                       </div>
                    </div>
                 </form>
               </div>
               <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                 <div class="card-body">
                     <div class="">
                       <table id="new-datatable" class="data" data-rtc-resizable-table="table.one" style="width:100%">
                          <thead>
                             <tr style="text-align: center;color: black;">
                               <th data-rtc-resizable="sno">S.No.</th>
                               <th data-rtc-resizable="emp">Employee</th>
                               <th data-rtc-resizable="adi">Attendance Device ID</th>
                               <th data-rtc-resizable="emp_name">Employee Name</th>
                               <th data-rtc-resizable="status">Status</th>
                               <th data-rtc-resizable="depart">Department</th>
                               <th data-rtc-resizable="des">Designation</th>
                               <th data-rtc-resizable="sno">Grade</th>
                               <th data-rtc-resizable="branch">Branch</th>
                               <th data-rtc-resizable="gms">Gross Monthly Salary</th>
                               <th data-rtc-resizable="export">Detail Export</th>
                             </tr>
                          </thead>
                          <tbody>
                            @if (count($emp_report_data) > 0)
                         @php $count = 1 @endphp
                          @foreach($emp_report_data as $key => $data)
                              <tr style="text-align: center;color: black;">
                                <!-- <td>{{ $count++  }}</td> -->
                                <td>{{ $emp_report_data->firstItem() +  $key  }}</td>
                                <td><a href="/hr/employee_report/emp_details?employee={{ $data->employee}}" target="_blank"  style="color: green;">{{ $data->employee}}</a></td>
                                <td>{{ $data->attendance_device_id}}</td>
                                <td>{{ $data->employee_name}}</td>
                                <td>{{ $data->status}}</td>
                                <td>{{ $data->department}}</td>
                                <td>{{ $data->designation}}</td>
                                <td>{{ $data->grade}}</td>
                                <td>{{ $data->branch}}</td>
                                <td>{{ round($data->gross_monthly_salary, 2)}}</td>
                                <td><a href="{{ url('/hr/employee_report/emp_details/export?employee='. $data->employee) }}" style="color: white;background: #2490ef;border-radius: 8px;" class="btn btn-info">Excel</a></td>
                                </tr>
                          @endforeach
                      @else
                        <tr>
                          <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                         </tr>
                      @endif
                          </tbody>
                       </table>
                       <div class="btn-group">
                        <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                        <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                        <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                     </div>
                          <div class="pagination pull-right" style="margin-bottom:10px;">
                          {{ $emp_report_data->links('vendor.pagination.bootstrap-4') }}
                      </div>
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
// $('#attendnceform').on('change', function() {
//     $("#show_hidden_input").attr("value", $('#attendnceform').val());
//     $("#filter_form").trigger("submit");
// });
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
