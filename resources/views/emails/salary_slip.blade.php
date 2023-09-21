
@php
use App\Library\AdminHelper;
$salary_slip_data = AdminHelper::getSalarySlipDetails($salary_slip->name);
@endphp

<div style="text-align: center;max-width: max-content;">

<p class="western" style="line-height: 115%; margin-bottom: 0.14in">


  <img src="https://erp.pinkcityindia.com/files/Pinkcity_logo.png" style="width: 10%;">
  <br></br>

  <font style="padding-top: 0.28in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in" color="black">
    <font style="font-size: 25pt">
      <b>SALARY SLIP</b>
    </font>
  </font>
  <br></br>

  <font color="black">
    <font style="font-size: 13pt">
      <b>{{ $salary_slip->name }}</b>
    </font>
  </font>
</p>


<table width="100%"  cellpadding="4" cellspacing="0">

  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Start Date:</p>
    </td>
    <td width="200" style="color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ date("d-m-Y", strtotime($salary_slip->start_date) ) }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black;  height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">End Date:</p>
    </td>
    <td width="200" style=" height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ date("d-m-Y", strtotime($salary_slip->end_date)) }}</p>
    </td>
  </tr>


  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Employee Number:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->employee }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Company:</p>
    </td>
    <td width="400" style=" height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->company }}</p>
    </td>
  </tr>




  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Employee Name:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->father_name }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Department:</p>
    </td>
    <td width="200" style=" height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->department }}</p>
    </td>
  </tr>


  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Father Name:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->employee_name }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Designation:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->designation }}</p>
    </td>
  </tr>


  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Mother Name:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->mother_name }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">UAN Number:</p>
    </td>
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->uan_number }}</p>
    </td>
  </tr>


  <tr valign="top" style="text-align: left;">
    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Date of Joining:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->date_of_joining }}</p>
    </td>

    <td width="200" style="font-weight: bold; color: black; height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">Bank Account No.:</p>
    </td>
    <td width="200" style="height: max-content; padding-top: 0in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western" style="margin-bottom: 0in">{{ $salary_slip->bank_account_no }}</p>
    </td>
  </tr>

</table>





<table width="100%" cellpadding="7" cellspacing="0">
    <td width="181" style="text-align: center; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #000001; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <font color="black">
          <font color="black">
            <b>Earnings</b>
          </font>
        </font>
      </p>
    </td>
    <td width="82" style="text-align: center; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <font color="black">
          <b>Amount</b>
        </font>
      </p>
    </td>
    <td width="194" style="text-align: center; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <font color="black">
          <b>Deductions</b>
        </font>
      </p>
    </td>
    <td width="132" style="text-align: center; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <font color="black">
          <b>Amount</b>
        </font>
      </p>
    </td>
  </tr>




  <tr valign="top">
    <td width="181" height="169" style="text-align: left; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #000001; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      @foreach ($salary_slip_data as $key => $value)
        @if($value->parentfield == 'earnings')
        <p class="western" style="margin-bottom: 0in; color: black;">{{ $value->salary_component }}</p>
        @endif
      @endforeach
    </td>
    <td width="82" style="border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      @foreach ($salary_slip_data as $key => $value)
        @if($value->parentfield == 'earnings')
        <p class="western" style="margin-bottom: 0in; color: black;">{{ round($value->amount) }}</p>
        @endif
      @endforeach
    </td>
    <td width="194" style="text-align: left; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #00000a; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      @foreach ($salary_slip_data as $key => $value)
        @if($value->parentfield == 'deductions')
        <p class="western" style="margin-bottom: 0in; color: black;">{{ $value->salary_component }}</p>
        @endif
      @endforeach
    </td>
    <td width="132" style="border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
      @foreach ($salary_slip_data as $key => $value)
        @if($value->parentfield == 'deductions')
        <p class="western" style="margin-bottom: 0in; color: black;">{{ round($value->amount) }}</p>
        @endif
      @endforeach
    </td>
  </tr>
  <tr>
    <td colspan="2" width="277" height="20" style="color: black; border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #000001; border-right: 1px solid #00000a; padding-top: 0.08in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <b>Gross Earnings : </b> {{ round($salary_slip->gross_pay) }}
      </p>
    </td>
    <td colspan="2" width="341" style="border-top: 1px solid #000001; border-bottom: 1px solid #000001; border-left: 1px solid #00000a; border-right: 1px solid #000001; padding-top: 0.08in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <font color="black">
          <b>Gross Deductions : </b> {{ round($salary_slip->total_deduction) }}
        </font>
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="4" width="632" height="20" style=" text-align: left; border: 1px solid #000001; padding-top: 0.08in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <b>Gross Monthly Salary: </b> {{ round($salary_slip->gross_monthly_salary) }}
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="4" width="632" height="20" style=" text-align: left; border: 1px solid #000001; padding-top: 0.08in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <b>Net Pay: </b> {{ round($salary_slip->net_pay) }}
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="4" width="632" height="19" style="text-align: left; border: 1px solid #000001; padding-top: 0.08in; padding-bottom: 0.08in; padding-left: 0.08in; padding-right: 0.08in">
      <p class="western">
        <b>Total in words : </b> {{ $salary_slip->total_in_words }}
      </p>
    </td>
  </tr>
</table>
<p class="western" style="line-height: 115%; margin-bottom: 0.14in"> </p>


</div>
