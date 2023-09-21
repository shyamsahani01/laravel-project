@extends('admin.layout.app')
@section('content')
@php
$showurl = url('/hr/bonus_report?show='.request()->show.'&company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&year='.request()->year);
@endphp

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
    <div class="main-panel">
        <div class="content">
            @includeif('admin.hr.bonus.filters')
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
                                    <div class="card-box table-responsive">

                                       <table id="datatable" class="table table-bordered" style="width:100%">
                                          <thead>
                                             <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                               <th>S.NO.</th>
                                               <th>Employee ID</th>
                                               <th>Employee Name</th>
                                               <th>Department</th>
                                               <th>Status</th>
                                               <th style="width:350px">April {{ $year }}</th>
                                               <th style="width:200px">May {{ $year }}</th>
                                               <th style="width:200px">June {{ $year }}</th>
                                               <th style="width:200px">July {{ $year }}</th>
                                               <th style="width:200px">August {{ $year }}</th>
                                               <th style="width:200px">September {{ $year }}</th>
                                               <th style="width:200px">Octomber {{ $year }}</th>
                                               <th style="width:200px">November {{ $year }}</th>
                                               <th style="width:200px">December {{ $year }}</th>
                                               <th style="width:200px">January {{ $year + 1 }}</th>
                                               <th style="width:200px">February {{ $year + 1 }}</th>
                                               <th style="width:200px">March {{ $year + 1 }}</th>
                                               <th style="width:200px">Total Bonus</th>
                                               <th style="width:200px">Total Bonus Round</th>
                                               <th style="width:200px">Total Pay Days</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                        @if (count($bonus_data) > 0)
                                           @php $count = 1; $total_bonus = 0; $total_pay_days = 0; @endphp
                                            @foreach($bonus_data as $key => $data)
                                                <tr  style="text-align: center;">
                                                <td>{{ $bonus_data->firstItem() +  $key  }}</td>
                                                <td><a href="/hr/employee_report/emp_details?employee={{ $data->name }}" target="_blank"  style="color: green;">{{ $data->name}}</a></td>
                                                <td>{{ $data->employee_name}}</td>
                                                <td>{{ $data->department}}</td>
                                                <td>{{ $data->status}}</td>
                                                <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->april_basic > 0 ? round($data->april_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->april_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->april_pay_days > 0 ?  round($data->april_pay_days, 2) : '' }}  </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->april_basic, $data->april_basic_default); $total_bonus += $bonus; echo round($bonus, 2);  $total_pay_days += $data->april_pay_days;  ?> </td></tr>
                                                  </table>
                                              </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->may_basic > 0 ? round($data->may_basic, 2) : ''  }}  </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->may_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->may_pay_days > 0 ?  round($data->may_pay_days, 2) : '' }}  </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->may_basic, $data->may_basic_default);  $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->may_pay_days; ?> </td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->june_basic > 0 ? round($data->june_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->june_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->june_pay_days > 0 ?  round($data->june_pay_days, 2) : '' }}  </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->june_basic, $data->june_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->june_pay_days; ?> </td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->july_basic > 0 ? round($data->july_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->july_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->july_pay_days > 0 ?  round($data->july_pay_days, 2) : '' }} </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->july_basic, $data->july_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->july_pay_days; ?> </td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->aug_basic > 0 ? round($data->aug_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->aug_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->aug_pay_days > 0 ?  round($data->aug_pay_days, 2) : '' }} </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->aug_basic, $data->aug_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->aug_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->sept_basic > 0 ? round($data->sept_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->sept_basic) }} </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->sept_pay_days > 0 ?  round($data->sept_pay_days, 2) : '' }} </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->sept_basic, $data->sept_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->sept_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->oct_basic > 0 ? round($data->oct_basic, 2) : ''  }}</td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->oct_basic) }}  </td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->oct_pay_days > 0 ?  round($data->oct_pay_days, 2) : '' }} </td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->oct_basic, $data->oct_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->oct_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->nov_basic > 0 ? round($data->nov_basic, 2) : ''  }}</td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->nov_basic) }}</td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->nov_pay_days > 0 ?  round($data->nov_pay_days, 2) : '' }}</td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->nov_basic, $data->nov_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->nov_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->dec_basic > 0 ? round($data->dec_basic, 2) : ''  }}</td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->dec_basic) }}</td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->dec_pay_days > 0 ?  round($data->dec_pay_days, 2) : '' }}</td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->dec_basic, $data->dec_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->dec_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->jan_basic > 0 ? round($data->jan_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->jan_basic) }}</td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->jan_pay_days > 0 ?  round($data->jan_pay_days, 2) : '' }}</td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->jan_basic, $data->jan_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->jan_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->feb_basic > 0 ? round($data->dec_basic, 2) : ''  }}  </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->feb_basic) }}</td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->feb_pay_days > 0 ?  round($data->feb_pay_days, 2) : '' }}</td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->feb_basic, $data->feb_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->feb_pay_days; ?></td></tr>
                                                  </table>
                                                </td>
                                              <td>
                                                  <table class="table table-borderless" style="width: max-content;">
                                                      <tr> <td style="padding:0px">Basic : {{ $data->mar_basic > 0 ? round($data->mar_basic, 2) : ''  }} </td></tr>
                                                      <tr> <td style="padding:0px">Basic Amount : {{ checkBasicAmount($data->mar_basic) }}</td> </tr>
                                                      <tr> <td style="padding:0px">Pay Days : {{ $data->mar_pay_days > 0 ?  round($data->mar_pay_days, 2) : '' }}</td></tr>
                                                      <tr> <td style="padding:0px">Bonus : <?php $bonus = check_bonus($data->mar_basic, $data->mar_basic_default); $total_bonus += $bonus; echo round($bonus, 2); $total_pay_days += $data->mar_pay_days; ?></td></tr>
                                                  </table>
                                                </td>

                                                <td> <p> {{ round($total_bonus) }}  </p> </td>
                                                <td> <p> {{ round_bonus(round($total_bonus)) }}  </p> </td>
                                                <td> <p> {{ $total_pay_days }}  </p> </td>
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
                                 <div class="btn-group">
            						            <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
            						            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
            						            <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                                  </div>
                                    <div class="pagination pull-right">
                                    {{ $bonus_data->links('vendor.pagination.bootstrap-4') }}
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
    </div>
@endsection
@section('footer-scripts')
<script>

</script>
<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
