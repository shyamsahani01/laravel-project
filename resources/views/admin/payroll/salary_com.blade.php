@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/css/resizable-table-columns.css">
<link rel="stylesheet" href="/admin/assets/newTheme/vendors/resizable/dist/samples/site.css">
<?php
use App\Library\AdminHelper;
 ?>
@php
$showurl = url('/payroll/salary_com?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status);
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

                 <form method="GET" id="filter_form" action="{{ url('/payroll/salary_com') }}">
                   <div class="x_title">
                       <h2 style="font-size: 1.25rem;">Salary Component Classification</h2>
                         <!-- <button type="button" title="Refresh" class="btn btn-danger design1-form1-btn"><i class="fa fa-refresh"><a href="{{ url('/hr/employee_report') }}" style="color: white;" ></a></i></button> -->
                         <a href="{{ url('/payroll/salary_com/export?company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&show='.request()->show) }}"  style="color: white;" class="btn btn-info design1-form1-btn">Excel</a>
                         <a href="{{ url('/payroll/salary_com') }}" style="color: white;" class="btn btn-danger design1-form1-btn">Refresh</a>
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
                     <div class="table-responsive">
                       <table id="new-datatable" class="data" data-rtc-resizable-table="table.one" style="width:100%">
                          <thead>
                             <tr style="text-align: center;color: black;">
                               <th data-rtc-resizable="sno">S.No.</th>
                               <th data-rtc-resizable="emp">Employee</th>
                               <th data-rtc-resizable="di"> Device ID</th>
                               <th data-rtc-resizable="emp_name">Employee Name</th>
                               <th data-rtc-resizable="gt">Gross Total <br>(₹)</th>
                               <th data-rtc-resizable="dt">Deduction Total<br>(₹)</th>
                               <th data-rtc-resizable="na">Net Amount<br>(₹)</th>
                               <th data-rtc-resizable="basic"><a href="javascript:void(0)" title="Basic" class="table-heading-a">Basic<br>(₹)</a></th>
                               <th data-rtc-resizable="hra"><a href="javascript:void(0)" title="House Rent Allowance" class="table-heading-a">HRA<br>(₹)</a></th>
                               <th data-rtc-resizable="cca"><a href="javascript:void(0)" title="City Compensatory Allowance" class="table-heading-a">CCA<br>(₹)</a></th>
                               <th data-rtc-resizable="ta"><a href="javascript:void(0)" title="Travelling Allowance" class="table-heading-a">TA<br>(₹)</a></th>
                               <th data-rtc-resizable="wa"><a href="javascript:void(0)" title="Washing Allowance" class="table-heading-a">WA<br>(₹)</a></th>
                            </tr>
                          </thead>
                          <tbody>

                            @if (count($salary_com_data) > 0)
                         @php $count = 1 @endphp
                          @foreach($salary_com_data as $key => $data)

                          <?php

                          $hra_amount = 0;
                          $b_amount = 0;
                          $cca_amount = 0;
                          $ta_amount = 0;
                          $wa_amount = 0;
                          $a_amount = 0;
                          $salary_slip_data = AdminHelper::getSalarySlipDetails($data->name);
                          foreach ($salary_slip_data as $key1 => $value2) {

                            if($value2->abbr == "TA") { $ta_amount = $value2->default_amount; }
                            if($value2->abbr == "HRA") { $hra_amount = $value2->default_amount;}
                            if($value2->abbr == "B") { $b_amount = $value2->default_amount; }
                            if($value2->abbr == "WA") { $wa_amount = $value2->default_amount; }
                            if($value2->abbr == "CCA") { $cca_amount = $value2->default_amount;}
                            if($value2->abbr == "A") { $a_amount = $value2->default_amount;}
                          }
                          ?>
                              <tr style="text-align: center;color: black;">
                                <td>{{ $count++  }}</td>
                                <td>{{ $data->employee }}</td>
                                <td>{{ $data->attendance_device_id }}</td>
                                <td>{{ $data->employee_name}}</td>
                                <td>{{ number_format($data->gross_monthly_salary, 2) }}</td>
                                <td>{{ number_format($data->base_total_deduction, 2)}}</td>
                                <td>{{ number_format($data->base_net_pay, 2) }}</td>
                                <td>{{ number_format($b_amount, 2) }}</td>
                                <td>{{ number_format($hra_amount, 2) }}</td>
                                <td>{{ number_format($cca_amount, 2) }}</td>
                                <td>{{ number_format($ta_amount, 2) }}</td>
                                <td>{{ number_format($wa_amount, 2) }}</td>
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
                          <div class="pagination pull-right">
                            {{ $salary_com_data->links('vendor.pagination.bootstrap-4') }}
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
