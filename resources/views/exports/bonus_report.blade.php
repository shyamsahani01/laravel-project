<?php

function check_bonus($b_amount=0, $d_amount= 0)
{
  $bonus_amount = 0;
  // bonus calculation ------------------------------
  if($b_amount  <= 21000 && $b_amount > 0 && $d_amount <= 21000) {
    $basic_amount =  $b_amount;
    if($b_amount  >= 7000) {
      $basic_amount = 7000;
    }
    else {
      $basic_amount = $b_amount;
    }
    $bonus_amount = $basic_amount * 8.33 / 100;
  }
  return $bonus_amount;
}



function checkBasicAmount($amount=0)
{
  $check_amount = '';
  if($amount  >= 7000 ) {
    $check_amount = 7000;
  } elseif($amount > 0 && $amount < 7000 ) {
    $check_amount = round($amount, 2);
  }
  return $check_amount;
}


function round_bonus($bonus_round_amount=0)
{
  // bonus round calculation ------------------------------
  if($bonus_round_amount  > 10 ) {
    $get_amount = (int) ( $bonus_round_amount / 10 );
    $get_modulus = $bonus_round_amount % 10;

    if($get_modulus == 0 ) {
      // just be bonus amount
    }
    elseif($get_modulus > 0 && $get_modulus <= 5  ) {
      $bonus_round_amount = "$get_amount" . "5";
    }
    elseif($get_modulus > 5 && $get_modulus <= 9  ) {
      $bonus_round_amount = ( $get_amount + 1 ) . "0";
    }

  }
  return $bonus_round_amount;
}

 ?>


<table style="width:100%">
   <thead>
      <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
        <th style="text-align: center; width: 10%;border: 1px solid black; font-weight: bold;">S.NO.</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Employee ID</th>
        <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Employee Name</th>
        <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Department</th>
        <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Status</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">April {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">May {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">June {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">July {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">August {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">September {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Octomber {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">November {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">December {{ $year }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">January {{ $year + 1 }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">February {{ $year + 1 }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">March {{ $year + 1 }}</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Total Bonus</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Total Bonus Round</th>
        <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Total Pay Days</th>
      </tr>
   </thead>
   <tbody>
 @if (count($bonus_data) > 0)
    @php $count = 1; $total_bonus = 0; $total_pay_days = 0; @endphp
     @foreach($bonus_data as $key => $data)
         <tr style="text-align: center;">
             <td style="height: 60%;text-align: center;border: 1px solid black;">{{ $count++  }}</td>
             <td style="text-align: center;border: 1px solid black;">{{ $data->name}}</td>
             <td style="text-align: center;border: 1px solid black;">{{ $data->employee_name}}</td>
             <td style="text-align: center;border: 1px solid black;">{{ $data->department}}</td>
             <td style="text-align: center;border: 1px solid black;">{{ $data->status}}</td>
             <td style="text-align: center;border: 1px solid black;"> Basic : {{ $data->april_basic > 0 ? round($data->april_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->april_basic) }}   <br> Pay Days : {{ $data->april_pay_days > 0 ?  round($data->april_pay_days, 2) : '' }}  <br>   Bonus : <?php $bonus = check_bonus($data->april_basic, $data->april_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->april_pay_days; ?> </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->may_basic > 0 ? round($data->may_basic, 2) : ''  }}  <br> Basic Amount : {{ checkBasicAmount($data->may_basic) }}   <br> Pay Days : {{ $data->may_pay_days > 0 ?  round($data->may_pay_days, 2) : '' }}  <br>  Bonus : <?php $bonus = check_bonus($data->may_basic, $data->may_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->may_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->june_basic > 0 ? round($data->june_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->june_basic) }}  <br>  Pay Days : {{ $data->june_pay_days > 0 ?  round($data->june_pay_days, 2) : '' }}  <br> Bonus : <?php $bonus = check_bonus($data->june_basic, $data->june_basic_default); $total_bonus += $bonus; echo $bonus;  $total_pay_days += $data->june_pay_days; ?> </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->july_basic > 0 ? round($data->july_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->july_basic) }}   <br>  Pay Days : {{ $data->july_pay_days > 0 ?  round($data->july_pay_days, 2) : '' }} <br>   Bonus : <?php $bonus = check_bonus($data->july_basic, $data->july_basic_default); $total_bonus += $bonus; echo $bonus;  $total_pay_days += $data->july_pay_days; ?> </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->aug_basic > 0 ? round($data->aug_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->aug_basic) }}   <br> Pay Days : {{ $data->aug_pay_days > 0 ?  round($data->aug_pay_days, 2) : '' }} <br>  Bonus : <?php $bonus = check_bonus($data->aug_basic, $data->aug_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->aug_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->sept_basic > 0 ? round($data->sept_basic, 2) : ''  }} <br>  Basic Amount : {{ checkBasicAmount($data->sept_basic) }}  <br>  Pay Days : {{ $data->sept_pay_days > 0 ?  round($data->sept_pay_days, 2) : '' }}  <br> Bonus : <?php $bonus = check_bonus($data->sept_basic, $data->sept_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->sept_pay_days; ?> </td>
             <td style="text-align: center;border: 1px solid black;"> Basic : {{ $data->oct_basic > 0 ? round($data->oct_basic, 2) : ''  }} <br>  Basic Amount : {{ checkBasicAmount($data->oct_basic) }} <br>   Pay Days : {{ $data->oct_pay_days > 0 ?  round($data->oct_pay_days, 2) : '' }} <br>  Bonus : <?php $bonus = check_bonus($data->oct_basic, $data->oct_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->oct_pay_days;  ?> </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->nov_basic > 0 ? round($data->nov_basic, 2) : ''  }}  <br>  Basic Amount : {{ checkBasicAmount($data->nov_basic) }}  <br>   Pay Days : {{ $data->nov_pay_days > 0 ?  round($data->nov_pay_days, 2) : '' }}  <br>  Bonus : <?php $bonus = check_bonus($data->nov_basic, $data->nov_basic_default); $total_bonus += $bonus; echo $bonus;  $total_pay_days += $data->nov_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;"> Basic : {{ $data->dec_basic > 0 ? round($data->dec_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->dec_basic) }}   <br>  Pay Days : {{ $data->dec_pay_days > 0 ?  round($data->dec_pay_days, 2) : '' }}   <br> Bonus : <?php $bonus = check_bonus($data->dec_basic, $data->dec_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->dec_pay_days; ?> </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->jan_basic > 0 ? round($data->jan_basic, 2) : ''  }}  <br> Basic Amount : {{ checkBasicAmount($data->jan_basic) }}   <br> Pay Days : {{ $data->jan_pay_days > 0 ?  round($data->jan_pay_days, 2) : '' }}  <br>  Bonus : <?php $bonus = check_bonus($data->jan_basic, $data->jan_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->jan_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->feb_basic > 0 ? round($data->feb_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->feb_basic) }}  <br>  Pay Days : {{ $data->feb_pay_days > 0 ?  round($data->feb_pay_days, 2) : '' }}  <br>  Bonus : <?php $bonus = check_bonus($data->feb_basic, $data->feb_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->feb_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;">  Basic : {{ $data->mar_basic > 0 ? round($data->mar_basic, 2) : ''  }} <br> Basic Amount : {{ checkBasicAmount($data->mar_basic) }}  <br>  Pay Days : {{ $data->mar_pay_days > 0 ?  round($data->mar_pay_days, 2) : '' }} <br>  Bonus : <?php $bonus = check_bonus($data->mar_basic, $data->mar_basic_default); $total_bonus += $bonus; echo $bonus; $total_pay_days += $data->mar_pay_days; ?>  </td>
             <td style="text-align: center;border: 1px solid black;">  {{ round($total_bonus) }}   </td>
             <td style="text-align: center;border: 1px solid black;">  {{ round_bonus(round($total_bonus)) }}  </td>
             <td style="text-align: center;border: 1px solid black;">  {{ $total_pay_days }}   </td>
             <?php $total_bonus = 0; $total_pay_days = 0; ?>
         </tr>
     @endforeach
 @else
  <tr>
     <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
  </tr>
 @endif
</tbody>
</table>
