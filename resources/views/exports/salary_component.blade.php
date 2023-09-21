<?php
use App\Library\AdminHelper;
 ?>
<table id="new-datatable" class="table table-bordered" style="width:100%">
   <thead>
      <tr style="text-align:center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
        <th>S.No.</th>
        <th>Employee</th>
        <th> Device ID</th>
        <th>Employee Name</th>
        <th>Gross Total</th>
        <th>Deduction Total</th>
        <th>Net Amount</th>
        <th><a href="javascript:void(0)" title="Basic" class="table-heading-a">Basic</a></th>
        <th><a href="javascript:void(0)" title="House Rent Allowance" class="table-heading-a">HRA</a></th>
        <th><a href="javascript:void(0)" title="City Compensatory Allowance" class="table-heading-a">CCA</a></th>
        <th><a href="javascript:void(0)" title="Travelling Allowance" class="table-heading-a">TA</a></th>
        <th><a href="javascript:void(0)" title="Washing Allowance" class="table-heading-a">WA</a></th>
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
       <tr  style="text-align:center;">
         <td>{{ $count++  }}</td>
         <td>{{ $data->employee}}</td>
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
