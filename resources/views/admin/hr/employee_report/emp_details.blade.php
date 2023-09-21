@extends('admin.layout.app')
@section('content')
<style>
    .table th, .table td {
    padding: 8px !important;
}
</style>
<?php
use App\Library\AdminHelper;
?>
 <div class="main-panel">
     <div class="content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="panel-group" id="accordion">
                         <div class="panel panel-default shadow-lg p-3 mb-5 bg-white rounded">
                             <div class="x_panel">
                                 <div class="x_content">
                                     <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                                         <li class="nav-item">
                                             <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">Employee Detail</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">Salary Detail Monthly</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp3-tab" data-toggle="tab" href="#emp3" role="tab" aria-controls="emp3" aria-selected="false" style="font-weight: 550;color: black;">Salary Detail Yearly</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp4-tab" data-toggle="tab" href="#emp4" role="tab" aria-controls="emp4" aria-selected="false" style="font-weight: 550;color: black;">Theoretical Salary Info.</a>
                                         </li>
                                     </ul>
                                     <div class="tab-content" id="myTabContent">
                                         <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>

                                             <div class="">
                                                 <div class=row>
                                                     <div class="col-lg-7">
                                                         <div>
                                                             <ul style="list-style: none;font-size: 14px;color: black;margin-top: 20px;">
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Employee </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->employee)){{ $emp_details_data->employee }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Employee Name </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->employee_name)){{ $emp_details_data->employee_name }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Date Of Birth </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->date_of_birth)){{ $emp_details_data->date_of_birth }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Date Of Joining </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->date_of_joining)){{ $emp_details_data->date_of_joining }}@endif</span>
                                                                 </li>

                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Phone Number </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->cell_number)){{ $emp_details_data->cell_number }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Marital Status </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->marital_status)){{ $emp_details_data->marital_status }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Aadhar Card Number </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->aadhar_card_no)){{ $emp_details_data->aadhar_card_no }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">PAN Number </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->pan_number)){{ $emp_details_data->pan_number }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Permanent Address </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->permanent_address)){{ $emp_details_data->permanent_address }}@endif</span>
                                                                     <!-- <label class="form-group">@if(isset($emp_details_data->permanent_address)){{ $emp_details_data->permanent_address }}@endif</label> -->
                                                                     <!-- <input class="form-control-plaintext" disabled value="@if(isset($emp_details_data->permanent_address)){{ $emp_details_data->permanent_address }}@endif"> -->
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Father Name </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->father_name)){{ $emp_details_data->father_name }}@endif</span>
                                                                 </li>
                                                             </ul>
                                                         </div>
                                                     </div>
                                                     <div class="col-lg-5">
                                                         <div style="border-left: 1px solid black;">
                                                             <ul style="list-style: none;font-size: 14px;color: black;margin-top: 20px;">
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Attendance Device ID </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->attendance_device_id)){{ $emp_details_data->attendance_device_id }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Designation </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->designation)){{ $emp_details_data->designation }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Occupation</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->occupation)){{ $emp_details_data->occupation }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Department</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->department)){{ $emp_details_data->department }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Grade </span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->grade)){{ $emp_details_data->grade }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Branch</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->branch)){{ $emp_details_data->branch }}@endif</span>
                                                                 </li>
                                                                 <!-- <li style="margin-bottom: 4px;">
                                                     <span style="min-width: 139px;display: inline-block;">Salary Structure ID</span>
                                                     <span style="display: inline-block;">:</span>
                                                     <span>@if(isset($emp_details_data->salary_structure_id)){{ $emp_details_data->salary_structure_id }}@endif</span>
                                                   </li> -->
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Bank Name</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->bank_name_new)){{ $emp_details_data->bank_name_new }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">Bank Account Number</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->bank_ac_no)){{ $emp_details_data->bank_ac_no }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">IFSC Code</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->ifsc_code)){{ $emp_details_data->ifsc_code }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">UAN Number</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->provident_fund_account)){{ $emp_details_data->provident_fund_account }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">ESIC Number</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->esic_no)){{ $emp_details_data->esic_no }}@endif</span>
                                                                 </li>
                                                                 <li style="margin-bottom: 4px;">
                                                                     <span style="min-width: 139px;display: inline-block;">ESIC Exit Date</span>
                                                                     <span style="display: inline-block;">:</span>
                                                                     <span>@if(isset($emp_details_data->esic_exit_date)){{ $emp_details_data->esic_exit_date }}@endif</span>
                                                                 </li>
                                                             </ul>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>

                                        </div>

                                         <div class="tab-pane fade" id="emp2" role="tabpanel" aria-labelledby="emp2-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                                 <table id="designtable" class="table table-bordered design1-form1-table" style="width:100%;">
                                                     <thead>
                                                         <tr style="text-align: center;">
                                                             <th style="border: 1px solid black;">S.No.</th>
                                                             <th style="border: 1px solid black;min-width: 95px;">Month Year</th>
                                                             <th style="border: 1px solid black;min-width: 83px;"><a href="javascript:void(0)" title="Pay Days" class="table-heading-a">Pay Days</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 112px;"><a href="javascript:void(0)" title="Working Days" class="table-heading-a">Working Days</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 102px;"><a href="javascript:void(0)" title="Gross Pay" class="table-heading-a">Gross Pay<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Basic" class="table-heading-a">Basic<br> (₹)</a>
                                                             <!-- <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Basic" class="table-heading-a">Bonus<br> (₹)</a> -->
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="House Rent Allowance" class="table-heading-a">HRA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="City Compensatory Allowance" class="table-heading-a">CCA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Travelling Allowance" class="table-heading-a">TA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Washing Allowance" class="table-heading-a">WA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Incentive Pay" class="table-heading-a">IP<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Over Time" class="table-heading-a">OT<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 76px;"><a href="javascript:void(0)" title="Arrear" class="table-heading-a">Arrear<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 66px;"><a href="javascript:void(0)" title="Income Tax" class="table-heading-a">I Tax<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 62px;"><a href="javascript:void(0)" title="GMI" class="table-heading-a">GMI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution ESI" class="table-heading-a">ESI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution PF" class="table-heading-a">PF<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="ABRY Scheme" class="table-heading-a">ABRY<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 78px;"><a href="javascript:void(0)" title="Advance Deduction" class="table-heading-a">Adv. D<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 88px;"><a href="javascript:void(0)" title="Less Hours Deduction" class="table-heading-a">Less.Hr.<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Net Pay" class="table-heading-a">Net Pay<br> (₹)</a>
                                                             </th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                         <?php
                                                              $yearly_data = [];
                                                              $yearly_payment_days = 0;
                                                              $yearly_total_present = 0;
                                                              $yearly_gross_pay = 0;
                                                              $yearly_hra_amount = 0;
                                                              $yearly_b_amount = 0;
                                                              // $yearly_bonus_amount = 0;
                                                              $yearly_cca_amount = 0;
                                                              $yearly_ta_amount = 0;
                                                              $yearly_wa_amount = 0;
                                                              $yearly_esi_amount = 0;
                                                              $yearly_pf_amount = 0;
                                                              $yearly_abry_amount = 0;
                                                              $yearly_ip_amount = 0;
                                                              $yearly_ot_amount = 0;
                                                              $yearly_ad_amount = 0;
                                                              $yearly_lhd_amount = 0;
                                                              $yearly_gmi_amount = 0;
                                                              $yearly_it_amount = 0;
                                                              $yearly_a_amount = 0;
                                                              $yearly_net_pay = 0;
                                                              $all_payment_days = 0;
                                                              $all_total_present = 0;
                                                              $all_gross_pay = 0;
                                                              $all_hra_amount = 0;
                                                              $all_b_amount = 0;
                                                              // $all_bonus_amount = 0;
                                                              $all_cca_amount = 0;
                                                              $all_ta_amount = 0;
                                                              $all_wa_amount = 0;
                                                              $all_esi_amount = 0;
                                                              $all_pf_amount = 0;
                                                              $all_abry_amount = 0;
                                                              $all_ip_amount = 0;
                                                              $all_ot_amount = 0;
                                                              $all_ad_amount = 0;
                                                              $all_lhd_amount = 0;
                                                              $all_gmi_amount = 0;
                                                              $all_it_amount = 0;
                                                              $all_a_amount = 0;
                                                              $all_net_pay = 0; ?>
                                                         @if(count($emp_salary_data) > 0)
                                                         @php
                                                         $count = 1;
                                                         $total_emp_salary_data = count($emp_salary_data);
                                                         @endphp
                                                         @foreach($emp_salary_data as $key => $data)


                                                         <?php
                                                            $yearly_payment_days = $yearly_payment_days + $data->payment_days;
                                                            $yearly_total_present = $yearly_total_present + $data->total_present;
                                                            $yearly_gross_pay = $yearly_gross_pay + $data->gross_pay;
                                                            $yearly_net_pay = $yearly_net_pay + $data->net_pay;
                                                            $all_payment_days = $all_payment_days + $data->payment_days;
                                                            $all_total_present = $all_total_present + $data->total_present;
                                                            $all_gross_pay = $all_gross_pay + $data->gross_pay;
                                                            $all_net_pay = $all_net_pay + $data->net_pay;
                                                            $hra_amount = 0;
                                                            $b_amount = 0;
                                                            // $bonus_amount = 0;
                                                            $cca_amount = 0;
                                                            $ta_amount = 0;
                                                            $wa_amount = 0;
                                                            $esi_amount = 0;
                                                            $pf_amount = 0;
                                                            $abry_amount = 0;
                                                            $ip_amount = 0;
                                                            $ot_amount = 0;
                                                            $ad_amount = 0;
                                                            $lhd_amount = 0;
                                                            $gmi_amount = 0;
                                                            $it_amount = 0;
                                                            $a_amount = 0;
                                                            $salary_slip_data = AdminHelper::getSalarySlipDetails($data->name);
                                                            foreach ($salary_slip_data as $key2 => $value2)
                                                            {
                                                                if ($value2->abbr == "TA")
                                                                {
                                                                    $ta_amount = $value2->amount;
                                                                    $yearly_ta_amount = $yearly_ta_amount + $ta_amount;
                                                                    $all_ta_amount = $all_ta_amount + $ta_amount;
                                                                }
                                                                if ($value2->abbr == "HRA")
                                                                {
                                                                    $hra_amount = $value2->amount;
                                                                    $yearly_hra_amount = $yearly_hra_amount + $hra_amount;
                                                                    $all_hra_amount = $all_hra_amount + $hra_amount;
                                                                }
                                                                if ($value2->abbr == "B")
                                                                {
                                                                    $b_amount = $value2->amount;

                                                                    // bonus calculation ------------------------------
                                                                    // if($b_amount  <= 21000) {
                                                                    //   $basic_amount =  $b_amount;
                                                                    //   if($b_amount  >= 7000) {
                                                                    //     $basic_amount = 7000;
                                                                    //   }
                                                                    //   else {
                                                                    //     $basic_amount = $b_amount;
                                                                    //   }
                                                                    //   $bonus_amount = $basic_amount * 8.33 / 100;
                                                                    //
                                                                    //   $yearly_bonus_amount = $yearly_bonus_amount + $bonus_amount;
                                                                    //   $all_bonus_amount = $all_bonus_amount + $bonus_amount;
                                                                    // }
                                                                    //
                                                                    //
                                                                    // $yearly_b_amount = $yearly_b_amount + $b_amount;
                                                                    // $all_b_amount = $all_b_amount + $b_amount;
                                                                }
                                                                if ($value2->abbr == "CCA")
                                                                {
                                                                    $cca_amount = $value2->amount;
                                                                    $yearly_cca_amount = $yearly_cca_amount + $cca_amount;
                                                                    $all_cca_amount = $all_cca_amount + $cca_amount;
                                                                }
                                                                if ($value2->abbr == "PF")
                                                                {
                                                                    $pf_amount = $value2->amount;
                                                                    $yearly_pf_amount = $yearly_pf_amount + $pf_amount;
                                                                    $all_pf_amount = $all_pf_amount + $pf_amount;
                                                                }
                                                                if ($value2->abbr == "AD")
                                                                {
                                                                    $ad_amount = $value2->amount;
                                                                    $yearly_ad_amount = $yearly_ad_amount + $ad_amount;
                                                                    $all_ad_amount = $all_ad_amount + $ad_amount;
                                                                }
                                                                if ($value2->abbr == "WA")
                                                                {
                                                                    $wa_amount = $value2->amount;
                                                                    $yearly_wa_amount = $yearly_wa_amount + $wa_amount;
                                                                    $all_wa_amount = $all_wa_amount + $wa_amount;
                                                                }
                                                                if ($value2->abbr == "IP")
                                                                {
                                                                    $ip_amount = $value2->amount;
                                                                    $yearly_ip_amount = $yearly_ip_amount + $ip_amount;
                                                                    $all_ip_amount = $all_ip_amount + $ip_amount;
                                                                }
                                                                if ($value2->abbr == "ESI")
                                                                {
                                                                    $esi_amount = $value2->amount;
                                                                    $yearly_esi_amount = $yearly_esi_amount + $esi_amount;
                                                                    $all_esi_amount = $all_esi_amount + $esi_amount;
                                                                }
                                                                if ($value2->abbr == "OT")
                                                                {
                                                                    $ot_amount = $value2->amount;
                                                                    $yearly_ot_amount = $yearly_ot_amount + $ot_amount;
                                                                    $all_ot_amount = $all_ot_amount + $ot_amount;
                                                                }
                                                                if ($value2->abbr == "ABRY")
                                                                {
                                                                    $abry_amount = $value2->amount;
                                                                    $yearly_abry_amount = $yearly_abry_amount + $abry_amount;
                                                                    $all_abry_amount = $all_abry_amount + $abry_amount;
                                                                }
                                                                if ($value2->abbr == "LHD")
                                                                {
                                                                    $lhd_amount = $value2->amount;
                                                                    $yearly_lhd_amount = $yearly_lhd_amount + $lhd_amount;
                                                                    $all_lhd_amount = $all_lhd_amount + $lhd_amount;
                                                                }
                                                                if ($value2->abbr == "GMI")
                                                                {
                                                                    $gmi_amount = $value2->amount;
                                                                    $yearly_gmi_amount = $yearly_gmi_amount + $gmi_amount;
                                                                    $all_gmi_amount = $all_gmi_amount + $gmi_amount;
                                                                }
                                                                if ($value2->abbr == "IT")
                                                                {
                                                                    $it_amount = $value2->amount;
                                                                    $yearly_it_amount = $yearly_it_amount + $it_amount;
                                                                    $all_it_amount = $all_it_amount + $it_amount;
                                                                }
                                                                if ($value2->abbr == "A")
                                                                {
                                                                    $a_amount = $value2->amount;
                                                                    $yearly_a_amount = $yearly_a_amount + $a_amount;
                                                                    $all_a_amount = $all_a_amount + $a_amount;
                                                                }
                                                            }
                                                            ?>




                                                         <tr style="text-align:center;">
                                                             <td style="border: 1px solid black;">{{ $count++ }}</td>
                                                             <td style="border: 1px solid black;">{{ date("m-Y", strtotime($data->start_date)) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($data->payment_days, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($data->total_present, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data->gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($b_amount, 2)}}</td>
                                                             <!-- <td style="border: 1px solid black;"></td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data->net_pay, 2) }}</td>
                                                         </tr>

                                                         @if (date("n", strtotime($data->start_date) ) == 3 || $count == $total_emp_salary_data + 1 )
                                                         <tr style="text-align:center; font-weight: bold;">
                                                             <td colspan="2" style="border: 1px solid black;">Sub Total : </td>
                                                             <td style="border: 1px solid black;">{{ round($yearly_payment_days, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($yearly_total_present, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_b_amount, 2)}}</td>
                                                             <!-- <td style="border: 1px solid black;"></td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_net_pay, 2) }}</td>
                                                         </tr>

                                                         <?php $temp_data = [];
                                                                $current_finesiacl_year = "";
                                                                if (date("n", strtotime($data->start_date)) == 3)
                                                                {
                                                                    $current_year = date("Y", strtotime($data->start_date));
                                                                    $last_year = $current_year - 1;
                                                                    $current_finesiacl_year = $last_year . "/" . $current_year;
                                                                }
                                                                elseif ($count == $total_emp_salary_data + 1)
                                                                {
                                                                    $current_year = date("Y", strtotime($data->start_date));
                                                                    $next_year = $current_year + 1;
                                                                    $current_finesiacl_year = $current_year . "/" . $next_year;
                                                                }
                                                                $temp_data = ["year" => $current_finesiacl_year, "yearly_payment_days" => $yearly_payment_days, "yearly_total_present" => $yearly_total_present, "yearly_gross_pay" => $yearly_gross_pay, "yearly_hra_amount" => $yearly_hra_amount, "yearly_b_amount" => $yearly_b_amount, "yearly_cca_amount" => $yearly_cca_amount, "yearly_ta_amount" => $yearly_ta_amount, "yearly_wa_amount" => $yearly_wa_amount, "yearly_esi_amount" => $yearly_esi_amount, "yearly_pf_amount" => $yearly_pf_amount, "yearly_abry_amount" => $yearly_abry_amount, "yearly_ip_amount" => $yearly_ip_amount, "yearly_ot_amount" => $yearly_ot_amount, "yearly_ad_amount" => $yearly_ad_amount, "yearly_lhd_amount" => $yearly_lhd_amount, "yearly_gmi_amount" => $yearly_gmi_amount, "yearly_it_amount" => $yearly_it_amount, "yearly_a_amount" => $yearly_a_amount, "yearly_net_pay" => $yearly_net_pay, ];
                                                                $yearly_data[] = $temp_data;
                                                                $yearly_payment_days = 0;
                                                                $yearly_total_present = 0;
                                                                $yearly_gross_pay = 0;
                                                                $yearly_hra_amount = 0;
                                                                $yearly_b_amount = 0;
                                                                // $yearly_bonus_amount= 0;
                                                                $yearly_cca_amount = 0;
                                                                $yearly_ta_amount = 0;
                                                                $yearly_wa_amount = 0;
                                                                $yearly_esi_amount = 0;
                                                                $yearly_pf_amount = 0;
                                                                $yearly_abry_amount = 0;
                                                                $yearly_ip_amount = 0;
                                                                $yearly_ot_amount = 0;
                                                                $yearly_ad_amount = 0;
                                                                $yearly_lhd_amount = 0;
                                                                $yearly_gmi_amount = 0;
                                                                $yearly_it_amount = 0;
                                                                $yearly_a_amount = 0;
                                                                $yearly_net_pay = 0; ?> @endif @if ($count == $total_emp_salary_data + 1 )
                                                         <tr style="text-align:center; font-weight: bold;">
                                                             <td colspan="2" style="border: 1px solid black;">Grand Total : </td>
                                                             <td style="border: 1px solid black;">{{ round($all_payment_days, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($all_total_present, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_b_amount, 2)}}</td>
                                                             <!-- <td style="border: 1px solid black;"></td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($all_hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_net_pay, 2) }}</td>
                                                         </tr>
                                                         @endif @endforeach @else
                                                         <tr>
                                                             <td colspan="12" class="text-center text-danger">
                                                                 <h3><b>No Record Found</b></h3>
                                                             </td>
                                                         </tr>
                                                         @endif
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>

                                         <div class="tab-pane fade" id="emp3" role="tabpanel" aria-labelledby="emp3-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                                 <table id="designtable" class="table table-bordered design1-form1-table" style="width:100%;">
                                                     <thead>
                                                         <tr style="text-align: center;">
                                                             <th style="border: 1px solid black;">Year</th>
                                                             <th style="border: 1px solid black;min-width: 75px;"><a href="javascript:void(0)" title="Pay Days" class="table-heading-a">Pay Days</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Working Days" class="table-heading-a">Working Days</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Gross Pay" class="table-heading-a">Gross Pay<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Basic" class="table-heading-a">Basic<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="House Rent Allowance" class="table-heading-a">HRA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="City Compensatory Allowance" class="table-heading-a">CCA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Travelling Allowance" class="table-heading-a">TA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Washing Allowance" class="table-heading-a">WA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Incentive Pay" class="table-heading-a">IP<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Over Time" class="table-heading-a">OT<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Arrear" class="table-heading-a">Arrear<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 46px;"><a href="javascript:void(0)" title="Income Tax" class="table-heading-a">I Tax<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="GMI" class="table-heading-a">GMI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution ESI" class="table-heading-a">ESI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution PF" class="table-heading-a">PF<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="ABRY Scheme" class="table-heading-a">ABRY<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 58px;"><a href="javascript:void(0)" title="Advance Deduction" class="table-heading-a">Adv. D<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Less Hours Deduction" class="table-heading-a">Less.Hr.<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Net Pay" class="table-heading-a">Net Pay<br> (₹)</a>
                                                             </th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>



                                                         @if (count($yearly_data) > 0) @php $count = 1; $total_yearly_data = count($yearly_data); @endphp @foreach($yearly_data as $key => $data) @php $count++; @endphp

                                                         <tr style="text-align:center;">
                                                             <td style="border: 1px solid black;">{{ $data['year'] }} </td>
                                                             <td style="border: 1px solid black;">{{ round($data['yearly_payment_days'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($data['yearly_total_present'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_gross_pay'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_b_amount'], 2)}}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_hra_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_cca_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_ta_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_wa_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_ip_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_ot_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_a_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_it_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_gmi_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_esi_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_pf_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_abry_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_ad_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_lhd_amount'], 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data['yearly_net_pay'], 2) }}</td>
                                                         </tr>


                                                         @if ($count == $total_yearly_data + 1 )
                                                         <tr style="text-align:center; font-weight: bold;">
                                                             <td style="border: 1px solid black;">Grand Total : </td>
                                                             <td style="border: 1px solid black;">{{ round($all_payment_days, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($all_total_present, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_b_amount, 2)}}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_net_pay, 2) }}</td>
                                                         </tr>
                                                         @endif @endforeach @else
                                                         <tr>
                                                             <td colspan="12" class="text-center text-danger">
                                                                 <h3><b>No Record Found</b></h3>
                                                             </td>
                                                         </tr>
                                                         @endif


                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>

                                         <div class="tab-pane fade" id="emp4" role="tabpanel" aria-labelledby="emp4tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                                 <table id="designtable" class="table table-bordered design1-form1-table" style="width:100%;">
                                                     <thead>
                                                         <tr style="text-align: center;">
                                                             <th style="border: 1px solid black;">S.No.</th>
                                                             <th style="border: 1px solid black;min-width: 87px;">Month Year</th>
                                                             <th style="border: 1px solid black;min-width: 75px;"><a href="javascript:void(0)" title="Pay Days" class="table-heading-a">Pay Days</a>
                                                             </th>
                                                             <!-- <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Working Days" class="table-heading-a">Working Days</a></th> -->
                                                             <th style="border: 1px solid black;min-width: 87px;"><a href="javascript:void(0)" title="Gross Pay" class="table-heading-a">Gross Pay<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Basic" class="table-heading-a">Basic<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="House Rent Allowance" class="table-heading-a">HRA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="City Compensatory Allowance" class="table-heading-a">CCA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Travelling Allowance" class="table-heading-a">TA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Washing Allowance" class="table-heading-a">WA<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Incentive Pay" class="table-heading-a">IP<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Over Time" class="table-heading-a">OT<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Arrear" class="table-heading-a">Arrear<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 46px;"><a href="javascript:void(0)" title="Income Tax" class="table-heading-a">I Tax<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="GMI" class="table-heading-a">GMI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution ESI" class="table-heading-a">ESI<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Employee Contribution PF" class="table-heading-a">PF<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="ABRY Scheme" class="table-heading-a">ABRY<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;min-width: 58px;"><a href="javascript:void(0)" title="Advance Deduction" class="table-heading-a">Adv. D<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Less Hours Deduction" class="table-heading-a">Less.Hr.<br> (₹)</a>
                                                             </th>
                                                             <th style="border: 1px solid black;"><a href="javascript:void(0)" title="Net Pay" class="table-heading-a">Net Pay<br> (₹)</a>
                                                             </th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                       <?php $yearly_data = [];
                                                          $yearly_payment_days = 0;
                                                          $yearly_total_present = 0;
                                                          $yearly_gross_pay = 0;
                                                          $yearly_hra_amount = 0;
                                                          $yearly_b_amount = 0;
                                                          $yearly_cca_amount = 0;
                                                          $yearly_ta_amount = 0;
                                                          $yearly_wa_amount = 0;
                                                          $yearly_esi_amount = 0;
                                                          $yearly_pf_amount = 0;
                                                          $yearly_abry_amount = 0;
                                                          $yearly_ip_amount = 0;
                                                          $yearly_ot_amount = 0;
                                                          $yearly_ad_amount = 0;
                                                          $yearly_lhd_amount = 0;
                                                          $yearly_gmi_amount = 0;
                                                          $yearly_it_amount = 0;
                                                          $yearly_a_amount = 0;
                                                          $yearly_net_pay = 0;
                                                          $all_payment_days = 0;
                                                          $all_total_present = 0;
                                                          $all_gross_pay = 0;
                                                          $all_hra_amount = 0;
                                                          $all_b_amount = 0;
                                                          $all_cca_amount = 0;
                                                          $all_ta_amount = 0;
                                                          $all_wa_amount = 0;
                                                          $all_esi_amount = 0;
                                                          $all_pf_amount = 0;
                                                          $all_abry_amount = 0;
                                                          $all_ip_amount = 0;
                                                          $all_ot_amount = 0;
                                                          $all_ad_amount = 0;
                                                          $all_lhd_amount = 0;
                                                          $all_gmi_amount = 0;
                                                          $all_it_amount = 0;
                                                          $all_a_amount = 0;
                                                          $all_net_pay = 0; ?> @if (count($emp_salary_data) > 0) @php $count = 1; $total_emp_salary_data = count($emp_salary_data); @endphp @foreach($emp_salary_data as $key => $data)

                                                                                                                                                                             <?php $yearly_payment_days = $yearly_payment_days + $data->total_working_days;
                                                          $yearly_total_present = $yearly_total_present + $data->total_present;
                                                          $yearly_gross_pay = $yearly_gross_pay + $data->gross_monthly_salary;
                                                          $yearly_net_pay = $yearly_net_pay + $data->base_net_pay;
                                                          $all_payment_days = $all_payment_days + $data->total_working_days;
                                                          $all_total_present = $all_total_present + $data->total_present;
                                                          $all_gross_pay = $all_gross_pay + $data->gross_monthly_salary;
                                                          $all_net_pay = $all_net_pay + $data->base_net_pay;
                                                          $hra_amount = 0;
                                                          $b_amount = 0;
                                                          $cca_amount = 0;
                                                          $ta_amount = 0;
                                                          $wa_amount = 0;
                                                          $esi_amount = 0;
                                                          $pf_amount = 0;
                                                          $abry_amount = 0;
                                                          $ip_amount = 0;
                                                          $ot_amount = 0;
                                                          $ad_amount = 0;
                                                          $lhd_amount = 0;
                                                          $gmi_amount = 0;
                                                          $it_amount = 0;
                                                          $a_amount = 0;
                                                          $salary_slip_data = AdminHelper::getSalarySlipDetails($data->name);
                                                          foreach ($salary_slip_data as $key2 => $value2)
                                                          {
                                                              if ($value2->abbr == "TA")
                                                              {
                                                                  $ta_amount = $value2->default_amount;
                                                                  $yearly_ta_amount = $yearly_ta_amount + $ta_amount;
                                                                  $all_ta_amount = $all_ta_amount + $ta_amount;
                                                              }
                                                              if ($value2->abbr == "HRA")
                                                              {
                                                                  $hra_amount = $value2->default_amount;
                                                                  $yearly_hra_amount = $yearly_hra_amount + $hra_amount;
                                                                  $all_hra_amount = $all_hra_amount + $hra_amount;
                                                              }
                                                              if ($value2->abbr == "B")
                                                              {
                                                                  $b_amount = $value2->default_amount;
                                                                  $yearly_b_amount = $yearly_b_amount + $b_amount;
                                                                  $all_b_amount = $all_b_amount + $b_amount;
                                                              }
                                                              if ($value2->abbr == "CCA")
                                                              {
                                                                  $cca_amount = $value2->default_amount;
                                                                  $yearly_cca_amount = $yearly_cca_amount + $cca_amount;
                                                                  $all_cca_amount = $all_cca_amount + $cca_amount;
                                                              }
                                                              if ($value2->abbr == "PF")
                                                              {
                                                                  $pf_amount = $value2->default_amount;
                                                                  $yearly_pf_amount = $yearly_pf_amount + $pf_amount;
                                                                  $all_pf_amount = $all_pf_amount + $pf_amount;
                                                              }
                                                              if ($value2->abbr == "AD")
                                                              {
                                                                  $ad_amount = $value2->default_amount;
                                                                  $yearly_ad_amount = $yearly_ad_amount + $ad_amount;
                                                                  $all_ad_amount = $all_ad_amount + $ad_amount;
                                                              }
                                                              if ($value2->abbr == "WA")
                                                              {
                                                                  $wa_amount = $value2->default_amount;
                                                                  $yearly_wa_amount = $yearly_wa_amount + $wa_amount;
                                                                  $all_wa_amount = $all_wa_amount + $wa_amount;
                                                              }
                                                              if ($value2->abbr == "IP")
                                                              {
                                                                  $ip_amount = $value2->default_amount;
                                                                  $yearly_ip_amount = $yearly_ip_amount + $ip_amount;
                                                                  $all_ip_amount = $all_ip_amount + $ip_amount;
                                                              }
                                                              if ($value2->abbr == "ESI")
                                                              {
                                                                  $esi_amount = $value2->default_amount;
                                                                  $yearly_esi_amount = $yearly_esi_amount + $esi_amount;
                                                                  $all_esi_amount = $all_esi_amount + $esi_amount;
                                                              }
                                                              if ($value2->abbr == "OT")
                                                              {
                                                                  $ot_amount = $value2->default_amount;
                                                                  $yearly_ot_amount = $yearly_ot_amount + $ot_amount;
                                                                  $all_ot_amount = $all_ot_amount + $ot_amount;
                                                              }
                                                              if ($value2->abbr == "ABRY")
                                                              {
                                                                  $abry_amount = $value2->default_amount;
                                                                  $yearly_abry_amount = $yearly_abry_amount + $abry_amount;
                                                                  $all_abry_amount = $all_abry_amount + $abry_amount;
                                                              }
                                                              if ($value2->abbr == "LHD")
                                                              {
                                                                  $lhd_amount = $value2->default_amount;
                                                                  $yearly_lhd_amount = $yearly_lhd_amount + $lhd_amount;
                                                                  $all_lhd_amount = $all_lhd_amount + $lhd_amount;
                                                              }
                                                              if ($value2->abbr == "GMI")
                                                              {
                                                                  $gmi_amount = $value2->default_amount;
                                                                  $yearly_gmi_amount = $yearly_gmi_amount + $gmi_amount;
                                                                  $all_gmi_amount = $all_gmi_amount + $gmi_amount;
                                                              }
                                                              if ($value2->abbr == "IT")
                                                              {
                                                                  $it_amount = $value2->default_amount;
                                                                  $yearly_it_amount = $yearly_it_amount + $it_amount;
                                                                  $all_it_amount = $all_it_amount + $it_amount;
                                                              }
                                                              if ($value2->abbr == "A")
                                                              {
                                                                  $a_amount = $value2->default_amount;
                                                                  $yearly_a_amount = $yearly_a_amount + $a_amount;
                                                                  $all_a_amount = $all_a_amount + $a_amount;
                                                              }
                                                          }
                                                          ?>



                                                         <tr style="text-align:center;">
                                                             <td style="border: 1px solid black;">{{ $count++ }}</td>
                                                             <td style="border: 1px solid black;">{{ date("m-Y", strtotime($data->start_date)) }}</td>
                                                             <td style="border: 1px solid black;">{{ round($data->total_working_days, 2) }}</td>
                                                             <!-- <td style="border: 1px solid black;">{{ round($data->total_present, 2) }}</td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($data->gross_monthly_salary, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($b_amount, 2)}}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($data->base_net_pay, 2) }}</td>
                                                         </tr>

                                                         @if (date("n", strtotime($data->start_date) ) == 3 || $count == $total_emp_salary_data + 1 )
                                                         <tr style="text-align:center; font-weight: bold;">
                                                             <td colspan="2" style="border: 1px solid black;">Sub Total : </td>
                                                             <td style="border: 1px solid black;">{{ round($yearly_payment_days, 2) }}</td>
                                                             <!-- <td style="border: 1px solid black;">{{ round($yearly_total_present, 2) }}</td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_b_amount, 2)}}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($yearly_net_pay, 2) }}</td>
                                                         </tr>

                                                         <?php $yearly_payment_days = 0;
                                                          $yearly_total_present = 0;
                                                          $yearly_gross_pay = 0;
                                                          $yearly_hra_amount = 0;
                                                          $yearly_b_amount = 0;
                                                          $yearly_cca_amount = 0;
                                                          $yearly_ta_amount = 0;
                                                          $yearly_wa_amount = 0;
                                                          $yearly_esi_amount = 0;
                                                          $yearly_pf_amount = 0;
                                                          $yearly_abry_amount = 0;
                                                          $yearly_ip_amount = 0;
                                                          $yearly_ot_amount = 0;
                                                          $yearly_ad_amount = 0;
                                                          $yearly_lhd_amount = 0;
                                                          $yearly_gmi_amount = 0;
                                                          $yearly_it_amount = 0;
                                                          $yearly_a_amount = 0;
                                                          $yearly_net_pay = 0; ?> @endif @if ($count == $total_emp_salary_data + 1 )
                                                         <tr style="text-align:center; font-weight: bold;">
                                                             <td colspan="2" style="border: 1px solid black;">Grand Total : </td>
                                                             <td style="border: 1px solid black;">{{ round($all_payment_days, 2) }}</td>
                                                             <!-- <td style="border: 1px solid black;">{{ round($all_total_present, 2) }}</td> -->
                                                             <td style="border: 1px solid black;">{{ number_format($all_gross_pay, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_b_amount, 2)}}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_hra_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_cca_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ta_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_wa_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ip_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ot_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_a_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_it_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_gmi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_esi_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_pf_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_abry_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_ad_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_lhd_amount, 2) }}</td>
                                                             <td style="border: 1px solid black;">{{ number_format($all_net_pay, 2) }}</td>
                                                         </tr>
                                                         @endif @endforeach @else
                                                         <tr>
                                                             <td colspan="12" class="text-center text-danger">
                                                                 <h3><b>No Record Found</b></h3>
                                                             </td>
                                                         </tr>
                                                         @endif
                                                     </tbody>
                                                 </table>
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
@endsection
@section('footer-scripts')
<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
