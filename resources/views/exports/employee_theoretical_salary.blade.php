<?php
use App\Library\AdminHelper;
?>
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
         $all_net_pay = 0; ?>

         @if(count($emp_salary_data) > 0)
         @php
         $count = 1;
         $total_emp_salary_data = count($emp_salary_data);
         @endphp
         @foreach($emp_salary_data as $key => $data)

        <?php
         $yearly_payment_days = $yearly_payment_days + $data->total_working_days;
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

        @if(date("n", strtotime($data->start_date) ) == 3 || $count == $total_emp_salary_data + 1 )
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
         $yearly_net_pay = 0; ?>
         @endif
         @if($count == $total_emp_salary_data + 1 )
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
        @endif
        @endforeach
        @else
        <tr>
            <td colspan="12" class="text-center text-danger">
                <h3><b>No Record Found</b></h3>
            </td>
        </tr>
        @endif
    </tbody>
</table>
