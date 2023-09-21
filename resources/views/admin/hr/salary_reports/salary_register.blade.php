@extends('admin.layout.app')
@section('content')
@php
use App\Models\erp\Employee;
@endphp
<style>
    .table th, .table td {
    padding: 8px !important;
}
</style>
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@php
$showurl = url('/hr/salary_register?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name);
@endphp
<div class="main-panel">
   <div class="content">
      @includeif('admin.hr.salary_reports.filters')
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
                                 <div class="card-box">

                                   <?php
                                   $check = 0;

                                   if (isset($attendance_summery_data->message->result)) {
                                     if(is_array($attendance_summery_data->message->result) ) {
                                       if(count($attendance_summery_data->message->result) > 0) {
                                         $check = 1;
                                       }
                                     }
                                   }
                                  ?>

                                  @if ($check == 1)


                                    <table id="new-datatable" class="table table-responsive table-bordered" style="width:100%">
                                       <thead>
                                          <tr style="text-align:center;">
                                            <th>S.No.</th>
                                            <th>Employee</th>
                                            <th>Employee Name</th>
                                            <th>Date of Joining</th>
                                            <th>Branch</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <!-- <th>Start Date</th>
                                            <th>End Date</th> -->
                                            <th>Month</th>
                                            <th>Leave Without Pay</th>
                                            <th>Payment Days</th>
                                            <th>Total Present</th>
                                            <th>City Compensatory Allowance<br>(₹)</th>
                                            <th>Travelling Allowance<br>(₹)</th>
                                            <th>OT<br>(₹)</th>
                                            <th>Basic<br>(₹)</th>
                                            <th>House Rent Allowance<br>(₹)</th>
                                            <th>Washing Allowance<br>(₹)</th>
                                            <th>Incentive Pay<br>(₹)</th>
                                            <th>Gross Pay<br>(₹)</th>
                                            <th>Gross Monthly Salary<br>(₹)</th>
                                            <th>Employee Contribution PF<br>(₹)</th>
                                            <th>Late Hours Deduction<br>(₹)</th>
                                            <th>Employee Contribution ESI<br>(₹)</th>
                                            <th>Advance Deduction<br>(₹)</th>
                                            <th>ABRY Scheme<br>(₹)</th>
                                            <th>Loan Repayment<br>(₹)</th>
                                            <th>Total Deduction<br>(₹)</th>
                                            <th>Net Pay<br>(₹)</th>
                                          </tr>
                                       </thead>
                                       <tbody>

                                       <?php
                                           $total_leave_without_pay = 0;
                                           $total_payment_days = 0;
                                           $gross_monthly_salary = 0;
                                           $total_city_compensatory_allowance = 0;
                                           $total_travelling_allowance = 0;
                                           $total_OT = 0;
                                           $total_basic = 0;
                                           $total_house_rent_allowance = 0;
                                           $total_washing_allowance = 0;
                                           $total_incentive_pay = 0;
                                           $total_gross_pay = 0;
                                           $total_employee_contribution_PF = 0;
                                           $total_late_hours_deduction = 0;
                                           $total_employee_contribution_ESI = 0;
                                           $total_advance_deduction = 0;
                                           $total_ABRY_scheme = 0;
                                           $total_loan_repayment = 0;
                                           $total_total_deduction = 0;
                                           $total_net_pay = 0;
                                           $total_gross_monthly_salary = 0;
                                           $total_total_present = 0;
                                       ?>


                                         @if (isset($attendance_summery_data->message->result))
                                         @php
                                            $result = $salary_register_data->message->result;
                                            $result2 = $attendance_summery_data->message->result;
                                          @endphp
                                         @for($i=0; $i<count($result2) ; $i++)
                                          @php
                                            $data2 = $result2[$i];
                                          @endphp

                                          <?php
                                          $date_of_joining = "";
                                          $branch = "";
                                          $department = "";
                                          $designation = "";
                                          $company = "";
                                          $start_date = "";
                                          $end_date = "";
                                          $month_year = "";
                                          $leave_without_pay = "";
                                          $payment_days = "";
                                          $city_compensatory_allowance = "";
                                          $travelling_allowance = "";
                                          $ot = "";
                                          $basic = "";
                                          $house_rent_allowance = "";
                                          $washing_allowance = "";
                                          $incentive_pay = "";
                                          $gross_pay = "";
                                          $employee_contribution_pf = "";
                                          $late_hours_deduction = "";
                                          $employee_contribution_esi = "";
                                          $advance_deduction = "";
                                          $abry_scheme = "";
                                          $loan_repayment = "";
                                          $total_deduction = "";
                                          $net_pay = "";

                                          if(isset($salary_register_data->message->result)) {
                                            $salary_result = $salary_register_data->message->result;
                                            foreach ($salary_result as $key2 => $value2) {
                                              if(is_array($value2)) {

                                              }else {
                                                if($value2->employee == $data2->employee) {
                                                  $date_of_joining = isset($value2->date_of_joining) ? $value2->date_of_joining : "";
                                                  $branch = isset($value2->branch) ? $value2->branch : "";
                                                  $department = isset($value2->department) ? $value2->department : "";
                                                  $designation = isset($value2->designation) ? $value2->designation : "";
                                                  $company = isset($value2->company) ? $value2->company : "";
                                                  $start_date = isset($value2->start_date) ? $value2->start_date : "";
                                                  $end_date = isset($value2->end_date) ? $value2->end_date : "";
                                                  $month_year = date("F-Y", strtotime($value2->end_date));
                                                  $leave_without_pay = isset($value2->leave_without_pay) ? $value2->leave_without_pay : "";
                                                  $payment_days = isset($value2->payment_days) ? $value2->payment_days : "";
                                                  $city_compensatory_allowance = isset($value2->city_compensatory_allowance) ? $value2->city_compensatory_allowance : "";
                                                  $travelling_allowance = isset($value2->travelling_allowance) ? $value2->travelling_allowance : "";
                                                  $ot = isset($value2->ot) ? $value2->ot : "";
                                                  $basic = isset($value2->basic) ? $value2->basic : "";
                                                  $house_rent_allowance = isset($value2->house_rent_allowance) ? $value2->house_rent_allowance : "";
                                                  $washing_allowance = isset($value2->washing_allowance) ? $value2->washing_allowance : "";
                                                  $incentive_pay = isset($value2->incentive_pay) ? $value2->incentive_pay : "";
                                                  $gross_pay = isset($value2->gross_pay) ? $value2->gross_pay : "";
                                                  $employee_contribution_pf = isset($value2->employee_contribution_pf) ? $value2->employee_contribution_pf : "";
                                                  $late_hours_deduction = isset($value2->late_hours_deduction) ? $value2->late_hours_deduction : "";
                                                  $employee_contribution_esi = isset($value2->employee_contribution_esi) ? $value2->employee_contribution_esi : "";
                                                  $advance_deduction = isset($value2->advance_deduction) ? $value2->advance_deduction : "";
                                                  $abry_scheme = isset($value2->abry_scheme) ? $value2->abry_scheme : "";
                                                  $loan_repayment = isset($value2->loan_repayment) ? $value2->loan_repayment : "";
                                                  $total_deduction = isset($value2->total_deduction) ? $value2->total_deduction : "";
                                                  $net_pay = isset($value2->net_pay) ? $value2->net_pay : "";

                                                  $check = Employee::select('gross_monthly_salary')->where('employee',$data2->employee)->first();
                                                  $gross_monthly_salary = (isset( $check->gross_monthly_salary) ? $check->gross_monthly_salary : 0);


                                                  // for total calculation ---------------------------------
                                                  $total_leave_without_pay = $total_leave_without_pay + (isset($value2->leave_without_pay) ? $value2->leave_without_pay : 0);
                                                  $total_payment_days = $total_payment_days + (isset($value2->payment_days) ? $value2->payment_days : 0);
                                                  $total_city_compensatory_allowance = $total_city_compensatory_allowance + (isset($value2->city_compensatory_allowance) ? $value2->city_compensatory_allowance : 0);
                                                  $total_travelling_allowance = $total_travelling_allowance + (isset($value2->travelling_allowance) ? $value2->travelling_allowance : 0);
                                                  $total_OT = $total_OT + (isset($value2->ot) ? $value2->ot : 0);
                                                  $total_basic = $total_basic + (isset($value2->basic) ? $value2->basic : 0);
                                                  $total_house_rent_allowance = $total_house_rent_allowance + (isset($value2->house_rent_allowance) ? $value2->house_rent_allowance : 0);
                                                  $total_washing_allowance = $total_washing_allowance + (isset($value2->washing_allowance) ? $value2->washing_allowance : 0);
                                                  $total_incentive_pay = $total_incentive_pay + (isset($value2->incentive_pay) ? $value2->incentive_pay : 0);
                                                  $total_gross_pay = $total_gross_pay + (isset($value2->gross_pay) ? $value2->gross_pay : 0);
                                                  $total_gross_monthly_salary = $total_gross_monthly_salary + $gross_monthly_salary;
                                                  $total_employee_contribution_PF = $total_employee_contribution_PF + (isset($value2->employee_contribution_pf) ? $value2->employee_contribution_pf : 0);
                                                  $total_late_hours_deduction = $total_late_hours_deduction + (isset($value2->late_hours_deduction) ? $value2->late_hours_deduction : 0);
                                                  $total_employee_contribution_ESI = $total_employee_contribution_ESI + (isset($value2->employee_contribution_esi) ? $value2->employee_contribution_esi : 0);
                                                  $total_advance_deduction = $total_advance_deduction + (isset($value2->advance_deduction) ? $value2->advance_deduction : 0);
                                                  $total_ABRY_scheme = $total_ABRY_scheme + (isset($value2->abry_scheme) ? $value2->abry_scheme : 0);
                                                  $total_loan_repayment = $total_loan_repayment + (isset($value2->loan_repayment) ? $value2->loan_repayment : 0);
                                                  $total_total_deduction = $total_total_deduction + (isset($value2->total_deduction) ? $value2->total_deduction : 0);
                                                  $total_net_pay = $total_net_pay + (isset($value2->net_pay) ? $value2->net_pay : 0);
                                                  $total_total_present = $total_total_present + (isset($data2->total_present) ? $data2->total_present : 0);

                                                }
                                              }

                                            }
                                          }
                                          ?>


                                            <tr>
                                               <td style="text-align: center;">{{ $i+1 }}</td>
                                               <td style="text-align: center;">{{ isset($data2->employee) ? $data2->employee : ""; }}</td>
                                               <td style="text-align: center;">{{ isset($data2->employee_name) ? $data2->employee_name : ""; }}</td>
                                               <td style="text-align: center;">{{ $date_of_joining }}</td>
                                               <td style="text-align: center;">{{ $branch }}</td>
                                               <td style="text-align: center;">{{ $department }}</td>
                                               <td style="text-align: center;">{{ $designation }}</td>
                                               <!-- <td style="text-align: center;">{{ $company }}</td> -->
                                               <!-- <td style="text-align: center;">{{ $start_date }}</td>
                                               <td style="text-align: center;">{{ $end_date }}</td> -->
                                               <td style="text-align: center;">{{ $month_year }}</td>
                                               <td style="text-align: center;">{{ $leave_without_pay }}</td>
                                               <td style="text-align: center;">{{ $payment_days }}</td>
                                               <td style="text-align: center;">{{ isset($data2->total_present) ? $data2->total_present : ""; }}</td>
                                               <td style="text-align: center;">{{ $city_compensatory_allowance }}</td>
                                               <td style="text-align: center;">{{ $travelling_allowance }}</td>
                                               <td style="text-align: center;">{{ $ot }}</td>
                                               <td style="text-align: center;">{{ $basic }}</td>
                                               <td style="text-align: center;">{{ $house_rent_allowance }}</td>
                                               <td style="text-align: center;">{{ $washing_allowance }}</td>
                                               <td style="text-align: center;">{{ $incentive_pay }}</td>
                                               <td style="text-align: center;">{{ $gross_pay }}</td>
                                               <td style="text-align: center;">{{ round($gross_monthly_salary, 2) }}</td>
                                               <td style="text-align: center;">{{ $employee_contribution_pf }}</td>
                                               <td style="text-align: center;">{{ $late_hours_deduction }}</td>
                                               <td style="text-align: center;">{{ $employee_contribution_esi }}</td>
                                               <td style="text-align: center;">{{ $advance_deduction }}</td>
                                               <td style="text-align: center;">{{ $abry_scheme }}</td>
                                               <td style="text-align: center;">{{ $loan_repayment }}</td>
                                               <td style="text-align: center;">{{ $total_deduction }}</td>
                                               <td style="text-align: center;">{{ $net_pay }}</td>
                                           </tr>
                                         @endfor

                                         @if(count($result) > 0)
                                        <tfoot >
                                         <tr  style="text-align:center;font-weight: bold;" >
                                            <td style="text-align: center;">Total </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;"> </td>
                                            <td style="text-align: center;">{{ $total_leave_without_pay }} </td>
                                            <td style="text-align: center;">{{ $total_payment_days }} </td>
                                            <td style="text-align: center;">{{ $total_total_present }} </td>
                                            <td style="text-align: center;">{{ $total_city_compensatory_allowance }} </td>
                                            <td style="text-align: center;">{{ $total_travelling_allowance }} </td>
                                            <td style="text-align: center;">{{ $total_OT }} </td>
                                            <td style="text-align: center;">{{ $total_basic }} </td>
                                            <td style="text-align: center;">{{ $total_house_rent_allowance }} </td>
                                            <td style="text-align: center;">{{ $total_washing_allowance }} </td>
                                            <td style="text-align: center;">{{ $total_incentive_pay }} </td>
                                            <td style="text-align: center;">{{ $total_gross_pay }} </td>
                                            <td style="text-align: center;">{{ $total_gross_monthly_salary }}</td>
                                            <td style="text-align: center;">{{ $total_employee_contribution_PF }} </td>
                                            <td style="text-align: center;">{{ $total_late_hours_deduction }} </td>
                                            <td style="text-align: center;">{{ $total_employee_contribution_ESI }} </td>
                                            <td style="text-align: center;">{{ $total_advance_deduction }} </td>
                                            <td style="text-align: center;">{{ $total_ABRY_scheme }} </td>
                                            <td style="text-align: center;">{{ $total_loan_repayment }} </td>
                                            <td style="text-align: center;">{{ $total_total_deduction }} </td>
                                            <td style="text-align: center;">{{ $total_net_pay }} </td>
                                         </tr>
                                       </tfoot>
                                         @endif

                                         @else
                                         <tr>
                                            <td colspan="11" class="text-center text-danger">
                                               <h3><b>No Record Found</b></h3>
                                            </td>
                                         </tr>
                                         @endif

                                       </tbody>
                                    </table>

                                    @else
                                    <h3>No Record, Please set filter.</h3>
                                    @endif

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
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script>
$(document).ready( function() {
  $('#new-datatable').DataTable( {
      ordering: false,
      searching: false,
      "sDom": 'Rfrtlip',
  } );
} );
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
