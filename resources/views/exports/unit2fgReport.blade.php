<table id="datatable" class="table table-striped table-bordered table-responsive" style="width:100%" cellspacing="0" border="0">
  <thead>
    <tr style="text-align: center;">
      <th style="text-align: center;" colspan="2"></th>
      <th style="text-align: center;" colspan="8">Gold</th>
      <th style="text-align: center;" colspan="8">Silver</th>
    </tr>
    <tr style="text-align: center;">
      <th colspan="2"></th>
      <th colspan="4"></th>
      <th style="text-align: center;" colspan="2"> FG OF THE DAY </th>
      <th style="text-align: center;" colspan="2"> DIRECT PRODUCTION COST </th>
      <th colspan="4"></th>
      <th style="text-align: center;" colspan="2"> FG OF THE DAY </th>
      <th style="text-align: center;" colspan="2"> DIRECT PRODUCTION COST </th>
    </tr>
    <tr style="text-align: center;">
      <th style="text-align: center;height:55%;width:20%;">S.NO.</th>
      <th style="text-align: center;width:20%;">DATE</th>
      <th style="text-align: center;width:20%;">No. OF PROD. WORKERS<br> PRESENT TODAY</th>
      <th style="text-align: center;width:20%;">TODAY'S SALARY OF <br>PRESENT PROD. WORKERS</th>
      <th style="text-align: center;width:20%;">GW AMOUNT</th>
      <th style="text-align: center;width:20%;">TOTAL AMOUNT</th>
      <th style="text-align: center;width:20%;">QTY. PCS</th>
      <th style="text-align: center;width:20%;">WT. GMS.</th>
      <th style="text-align: center;width:20%;">Rs. PER PC</th>
      <th style="text-align: center;width:20%;">Rs. PER GM</th>
      <th style="text-align: center;width:20%;">No. OF PROD. WORKERS<br> PRESENT TODAY</th>
      <th style="text-align: center;width:20%;">TODAY'S SALARY OF <br>PRESENT PROD. WORKERS</th>
      <th style="text-align: center;width:20%;">GW AMOUNT</th>
      <th style="text-align: center;width:20%;">TOTAL AMOUNT</th>
      <th style="text-align: center;width:20%;">QTY. PCS</th>
      <th style="text-align: center;width:20%;">WT. GMS.</th>
      <th style="text-align: center;width:20%;">Rs. PER PC</th>
      <th style="text-align: center;width:20%;">Rs. PER GM</th>
      <th style="text-align: center;width:20%;">TOTAL FG GOLD<br> + SILVER GMS</th>
      <th style="text-align: center;width:20%;">MANPOWER COST</th>
      <th style="text-align: center;width:20%;">GW COST</th>
      <th style="text-align: center;width:20%;">TOTAL MANPOWER <br>AMOUNT</th>
      <th style="text-align: center;width:20%;">TOTAL MANPOWER <br>PER GM</th>
      <th style="text-align: center;width:20%;">TOTAL EXPORT <br>TILL TODAY USD</th>
      <th style="text-align: center;width:20%;">GOLD FG AMOUNT @ <br>Rs. 7000 PER PC</th>
      <th style="text-align: center;width:20%;">SILVER FG AMOUNT @ <br>Rs. 1200 PER PC</th>
      <th style="text-align: center;width:20%;">TOTAL FG AMOUNT</th>
      <th style="text-align: center;width:20%;">TOTAL EXPENSES <br>ON MANPOWER</th>
      <th style="text-align: center;width:20%;">% OF MANPOWER EXPENSES<br> AGAINST FG VALUE</th>
      <th style="text-align: center;width:20%;">TOTAL EXPENSES OF GOLD<br> @35% OF TOTAL EXPENSES</th>
      <th style="text-align: center;width:20%;">% OF MANPOWER EXPENSES <br>OF GOLD AGAINST FG VALUE</th>
      <th style="text-align: center;width:20%;">TOTAL EXPENSES OF SILVER <br>@65% OF TOTAL EXPENSES</th>
      <th style="text-align: center;width:20%;">% OF MANPOWER EXPENSES OF <br>SILVER AGAINST FG VALUE</th>
    </tr>
  </thead>
  <tbody>

    @if (count($fgData) > 0)
    @php
      $count = 1
    @endphp
    @foreach($fgData as $key => $data)
      @php
        $no_of_prod_workers_gold = ( $data->employee_data->total_employee_gold > 0 ) ?  $data->employee_data->total_employee_gold   : 0;
        $today_salary_gold = ( $data->employee_data->per_day_sallery_gold > 0 ) ?  $data->employee_data->per_day_sallery_gold   : 0;
        $gw_amount_gold = ( round($data->employee_data->actual_over_time_amount_gold) > 0 ) ?  round($data->employee_data->actual_over_time_amount_gold ) : 0;;
        $total_amount_gold = $gw_amount_gold + $today_salary_gold;
        $qty_pcs_gold = ( $data->fg_data->qty_gold > 0 ) ?  $data->fg_data->qty_gold   : 0;
        $wt_gms_gold = ( $data->fg_data->wt_gold > 0 ) ?  $data->fg_data->wt_gold   : 0;
        $rs_per_pc_gold = ( $qty_pcs_gold > 0 ) ?  ( $total_amount_gold / $qty_pcs_gold  )   : 0;
        $rs_per_gm_gold = ( $wt_gms_gold > 0 ) ?  ( $total_amount_gold / $wt_gms_gold  )   : 0;

        $no_of_prod_workers_silver = ( $data->employee_data->total_employee_silver > 0 ) ?  $data->employee_data->total_employee_silver   : 0;
        $today_salary_silver = ( $data->employee_data->per_day_sallery_silver > 0 ) ?  $data->employee_data->per_day_sallery_silver   : 0;
        $gw_amount_silver = ( round($data->employee_data->actual_over_time_amount_silver) > 0 ) ?  round($data->employee_data->actual_over_time_amount_silver ) : 0;;
        $total_amount_silver = $gw_amount_gold + $today_salary_gold;
        $qty_pcs_silver = ( $data->fg_data->qty_silver > 0 ) ?  $data->fg_data->qty_silver   : 0;
        $wt_gms_silver = ( $data->fg_data->wt_silver > 0 ) ?  $data->fg_data->wt_silver   : 0;
        $rs_per_pc_silver = ( $qty_pcs_silver > 0 ) ?  ( $total_amount_silver / $qty_pcs_silver  )   : 0;
        $rs_per_gm_silver = ( $wt_gms_silver > 0 ) ?  ( $total_amount_silver / $wt_gms_silver  )   : 0;

        $wt_gms_gold_silver = $wt_gms_gold  + $wt_gms_silver;
        $manpower_cost = $data->employee_data->manpower_cost ;
        $gw_cost = $data->employee_data->net_over_time_amount_gold +  $data->employee_data->net_over_time_amount_silver;
        $total_manpower_cost = $manpower_cost + $gw_cost;
        $total_manpower_cost_per_gm = ( $wt_gms_gold_silver > 0 ) ? ( round($total_manpower_cost / $wt_gms_gold_silver) ) : 0;
        $total_export_till_today_usd = 100;

        $fg_value_per_pc_gold = $qty_pcs_gold * 7000;
        $fg_value_per_pc_silver = $qty_pcs_silver * 1200;
        $fg_amount_total = $fg_value_per_pc_gold + $fg_value_per_pc_silver;
        $total_expenses_on_manpower = ($total_manpower_cost * 1.2);
        $manpower_expenses_against_fg_value = ( $fg_amount_total > 0 ) ?   ( $total_expenses_on_manpower / $fg_amount_total )   : 0;

        $total_expenses_gold = $total_expenses_on_manpower * 0.35;
        $manpower_expenses_gold = ( $fg_value_per_pc_gold > 0 ) ?   ( $total_expenses_gold / $fg_value_per_pc_gold )   : 0;
        $total_expenses_silver = $total_expenses_on_manpower * 0.65;
        $manpower_expenses_silver = ( $fg_value_per_pc_silver > 0 ) ?   ( $total_expenses_silver / $fg_value_per_pc_silver )   : 0;

      @endphp
    <tr style="text-align: center;">
      <td style="text-align: center;">{{ $count++ }}</td>
      <td style="text-align: center;">
        <!-- <a href="javascript:void(0)" onclick="showDetails('{{ date('d-m-Y',strtotime($data->FdDt)) }}', {{ $key }} )" style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a> -->
        <a href="/fg/unit2/details?fg_date={{ date('Y-m-d',strtotime($data->FdDt)) }}" target="_blank"  style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a>
      </td>
      <td style="text-align: center;"> {{ round($no_of_prod_workers_gold, 0) }} </td>
      <td style="text-align: center;"> {{ round($today_salary_gold, 2)  }} </td>
      <td style="text-align: center;"> {{ round($gw_amount_gold, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_amount_gold, 2) }} </td>
      <td style="text-align: center;">{{ round($qty_pcs_gold, 0) }}</td>
      <td style="text-align: center;">{{ round($wt_gms_gold, 2) }}</td>
      <td style="text-align: center;"> {{ round($rs_per_pc_gold, 2) }} </td>
      <td style="text-align: center;"> {{ round($rs_per_gm_gold, 2) }} </td>

      <td style="text-align: center;"> {{ round($no_of_prod_workers_silver, 0) }} </td>
      <td style="text-align: center;"> {{ round($today_salary_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($gw_amount_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_amount_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($qty_pcs_silver, 0) }} </td>
      <td style="text-align: center;"> {{ round($wt_gms_silver, 2) }}</td>
      <td style="text-align: center;"> {{ round($rs_per_pc_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($rs_per_gm_silver, 2) }} </td>

      <td style="text-align: center;"> {{ round($wt_gms_gold_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($manpower_cost, 2) }} </td>
      <td style="text-align: center;"> {{ round($gw_cost, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_manpower_cost, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_manpower_cost_per_gm, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_export_till_today_usd, 2) }} </td>

      <td style="text-align: center;"> {{ round($fg_value_per_pc_gold, 2) }} </td>
      <td style="text-align: center;"> {{ round($fg_value_per_pc_silver, 2) }} </td>
      <td style="text-align: center;"> {{ round($fg_amount_total, 2) }} </td>
      <td style="text-align: center;"> {{ round($total_expenses_on_manpower, 2) }} </td>
      <td style="text-align: center;"> {{ round($manpower_expenses_against_fg_value, 2) }} </td>

      <td style="text-align: center;"> {{ round($total_expenses_gold, 4) }} </td>
      <td style="text-align: center;"> {{ round($manpower_expenses_gold, 4) }} </td>
      <td style="text-align: center;"> {{ round($total_expenses_silver, 4) }} </td>
      <td style="text-align: center;"> {{ round($manpower_expenses_silver, 4) }} </td>
    </tr>
    <tr id="table-key-{{ $key }}" class="close-details"></tr>
    @endforeach
      @else <tr>
        <td colspan="17" class="text-center text-danger">
          <h3>
            <b>No Record Found</b>
          </h3>
        </td>
      </tr>
      @endif

  </tbody>
</table>
