@extends('admin.layout.app') @section('content')
<!-- @php $showurl = url('fg/unit2fgReport?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date); @endphp  -->
<div class="main-panel">
  <div class="content"> @includeif('admin.fgreports.filters') <div class="row" style="margin-top: 10px;">
      <div class="col-md-12">
        <div class="card">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_content">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box ">
                        <table id="datatable" class="table table-striped table-bordered table-responsive" style="width:100%" cellspacing="0" border="0">
                          <thead>
                            <tr style="text-align: center;">
                              <th colspan="2"></th>
                              <th colspan="8">Gold</th>
                              <th colspan="8">Silver</th>
                            </tr>
                            <tr style="text-align: center;">
                              <th colspan="2"></th>
                              <th colspan="4"></th>
                              <th colspan="2"> FG OF THE DAY </th>
                              <th colspan="2"> DIRECT PRODUCTION COST </th>
                              <th colspan="4"></th>
                              <th colspan="2"> FG OF THE DAY </th>
                              <th colspan="2"> DIRECT PRODUCTION COST </th>
                            </tr>
                            <tr style="text-align: center;">
                              <th>S.NO.</th>
                              <th style="padding: 10px 30px 10px 30px;">DATE</th>
                              <th>No. OF PROD. WORKERS PRESENT TODAY</th>
                              <th style="min-width: 100px;">TODAY'S SALARY OF PRESENT PROD. WORKERS</th>
                              <th style="min-width: 100px;">GW AMOUNT</th>
                              <th style="min-width: 100px;">TOTAL AMOUNT</th>
                              <th>QTY. PCS</th>
                              <th>WT. GMS.</th>
                              <th style="min-width: 80px;">Rs. PER PC</th>
                              <th style="min-width: 80px;">Rs. PER GM</th>
                              <th >No. OF PROD. WORKERS PRESENT TODAY</th>
                              <th style="min-width: 100px;">TODAY'S SALARY OF PRESENT PROD. WORKERS</th>
                              <th style="min-width: 100px;">GW AMOUNT</th>
                              <th style="min-width: 100px;">TOTAL AMOUNT</th>
                              <th>QTY. PCS</th>
                              <th>WT. GMS.</th>
                              <th style="min-width: 80px;">Rs. PER PC</th>
                              <th style="min-width: 80px;">Rs. PER GM</th>
                              <th>TOTAL FG GOLD + SILVER GMS</th>
                              <th style="min-width: 120px;">MANPOWER COST</th>
                              <th style="min-width: 120px;">GW COST</th>
                              <th style="min-width: 120px;">TOTAL MANPOWER AMOUNT</th>
                              <th style="min-width: 120px;">TOTAL MANPOWER PER GM</th>
                              <th style="min-width: 120px;">TOTAL EXPORT TILL TODAY USD</th>
                              <th style="min-width: 150px;">GOLD FG AMOUNT @ Rs. 7000 PER PC</th>
                              <th style="min-width: 120px;">SILVER FG AMOUNT @ Rs. 1200 PER PC</th>
                              <th style="min-width: 150px;">TOTAL FG AMOUNT</th>
                              <th style="min-width: 120px;">TOTAL EXPENSES ON MANPOWER</th>
                              <th>% OF MANPOWER EXPENSES AGAINST FG VALUE</th>
                              <th>TOTAL EXPENSES OF GOLD @35% OF TOTAL EXPENSES</th>
                              <th>% OF MANPOWER EXPENSES OF GOLD AGAINST FG VALUE</th>
                              <th>TOTAL EXPENSES OF SILVER @65% OF TOTAL EXPENSES</th>
                              <th>% OF MANPOWER EXPENSES OF SILVER AGAINST FG VALUE</th>
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
                              <td style="text-align: center;">{{ $fgData->firstItem() + $key }}</td>
                              <td style="text-align: center;">
                                <!-- <a href="javascript:void(0)" onclick="showDetails('{{ date('d-m-Y',strtotime($data->FdDt)) }}', {{ $key }} )" style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a> -->
                                <a href="/fg/unit2/details?fg_date={{ date('Y-m-d',strtotime($data->FdDt)) }}" target="_blank"  style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a>
                              </td>
                              <td > {{ round($no_of_prod_workers_gold, 0) }} </td>
                              <td > {{ "₹ ".number_format($today_salary_gold, 2)  }} </td>
                              <td > {{ "₹ ".number_format($gw_amount_gold, 2) }} </td>
                              <td > {{ "₹ ".number_format($total_amount_gold, 2) }} </td>
                              <td >{{ round($qty_pcs_gold, 0) }}</td>
                              <td >{{ round($wt_gms_gold, 2) }}</td>
                              <td > {{ "₹ ".number_format($rs_per_pc_gold, 2) }} </td>
                              <td > {{ "₹ ".number_format($rs_per_gm_gold, 2) }} </td>

                              <td > {{ round($no_of_prod_workers_silver, 0) }} </td>
                              <td > {{ "₹ ".number_format($today_salary_silver, 2) }} </td>
                              <td > {{ "₹ ".number_format($gw_amount_silver, 2) }} </td>
                              <td > {{ "₹ ".number_format($total_amount_silver, 2) }} </td>
                              <td > {{ round($qty_pcs_silver, 0) }} </td>
                              <td > {{ round($wt_gms_silver, 2) }}</td>
                              <td > {{ "₹ ".number_format($rs_per_pc_silver, 2) }} </td>
                              <td > {{ "₹ ".number_format($rs_per_gm_silver, 2) }} </td>

                              <td > {{ round($wt_gms_gold_silver, 2) }} </td>
                              <td > {{ "₹ ".number_format($manpower_cost, 2) }} </td>
                              <td > {{ "₹ ".number_format($gw_cost, 2) }} </td>
                              <td > {{ "₹ ".number_format($total_manpower_cost, 2) }} </td>
                              <td > {{ "₹ ".number_format($total_manpower_cost_per_gm, 2) }} </td>
                              <td > {{ round($total_export_till_today_usd, 2) }} </td>

                              <td > {{ "₹ ".number_format($fg_value_per_pc_gold, 2) }} </td>
                              <td > {{ "₹ ".number_format($fg_value_per_pc_silver, 2) }} </td>
                              <td > {{ "₹ ".number_format($fg_amount_total, 2) }} </td>
                              <td > {{ "₹ ".number_format($total_expenses_on_manpower, 2) }} </td>
                              <td > {{ "₹ ".number_format($manpower_expenses_against_fg_value, 2) }} </td>

                              <td > {{ round($total_expenses_gold, 4) }} </td>
                              <td > {{ round($manpower_expenses_gold, 4) }} </td>
                              <td > {{ round($total_expenses_silver, 4) }} </td>
                              <td > {{ round($manpower_expenses_silver, 4) }} </td>
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

                        <div class="btn-group">
                          <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                          <button type="button" onclick="changenumber(20)" class="btn btn-default btn-sm btn-paging @if(request()->show == 20) btn-info @endif " data-value="20">20</button>
                          <button type="button" onclick="changenumber(30)" class="btn btn-default btn-sm btn-paging @if(request()->show == 30) btn-info @endif " data-value="30">30</button>
                        </div>
                        <div class="pagination pull-right">
                          <div class="pagination pull-right">
                            {{ $fgData->links('vendor.pagination.bootstrap-4') }}
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
