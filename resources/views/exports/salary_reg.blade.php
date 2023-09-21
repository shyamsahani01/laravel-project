@php
use App\Models\erp\Employee;
@endphp
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


 <table id="new-datatable" class="table table-responsive table-striped table-bordered" style="width:100%">
    <thead>
       <tr style="text-align:center;">
         <th style="height:50%;">S.No.</th>
         <th>Employee</th>
         <th>Employee Name</th>
         <th>Date of Joining</th>
         <th>Branch</th>
         <th>Department</th>
         <th>Designation</th>
         <th>Start Date</th>
         <th>End Date</th>
         <!-- <th>Month</th> -->
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
       // $month_year = "";
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
               $gross_monthly_salary = $check->gross_monthly_salary;


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
            <td style="text-align: center;">{{ $start_date }}</td>
            <td style="text-align: center;">{{ $end_date }}</td>

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
