@extends('admin.layout.app') @section('content') @php $showurl = url('fg/unit1fgReport?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date); @endphp <div class="main-panel">
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
                        <table id="datatable" class="table table-striped table-bordered table-responsive" style="width:100%">
                          <thead>
                            <tr>
                              <th colspan="6"></th>
                              <th colspan="2"> FG OF THE DAY </th>
                              <th colspan="2"> DIRECT PRODUCTION COST </th>
                              <th colspan="8"></th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="text-align: center;">S.NO.</th>
                              <th style="text-align: center; min-width: 100px;">DATE</th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="Silver Department Employees" class="table-heading-a" >No. OF PROD. WORKERS PRESENT TODAY</a>
                              </th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="Silver Department Employees" class="table-heading-a" >TODAY'S SALARY OF PRESENT PROD. WORKERS</a>
                              </th>
                              <th style="text-align: center; min-width: 100px;">
                                <a href="javascript:void(0)" title="Silver Department Employees Actual Over Time Amount" class="table-heading-a" >DIRECT PRODUCTION GW AMOUNT <a>
                              </th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="TODAY'S  SALARY OF PRESENT PROD. WORKERS + DIRECT PRODUCTION GW AMOUNT" class="table-heading-a" >TOTAL DIRECT PRODUCTION COST AMOUNT </a>
                              </th>
                              <th style="text-align: center; min-width: 80px;">
                                <a href="javascript:void(0)" title="Total Quantity" class="table-heading-a" >QTY. PCS</a>
                              </th>
                              <th style="text-align: center; min-width: 80px;">
                                <a href="javascript:void(0)" title="Total Weight" class="table-heading-a" >WT. GMS.</a>
                              </th>
                              <th style="text-align: center; min-width: 100px;">
                                <a href="javascript:void(0)" title="TOTAL DIRECT PRODUCTION COST AMOUNT / QTY. PCS" class="table-heading-a" >Rs. PER PC </th>
                              <th style="text-align: center; min-width: 100px;">
                                <a href="javascript:void(0)" title="TOTAL DIRECT PRODUCTION COST AMOUNT / WT. GMS." class="table-heading-a" >Rs. PER GM </th>
                              <th style="text-align: center; min-width: 80px;">
                                <a href="javascript:void(0)" title="Total Sallery Of Unit 1 Employees " class="table-heading-a" >MANPOWER COST </th>
                              <th style="text-align: center; min-width: 80px;">
                                <a href="javascript:void(0)" title="Silver Department Employees Actual Over Time Amount" class="table-heading-a" >GW COST </th>
                              <th style="text-align: center; min-width: 80px;">
                                <a href="javascript:void(0)" title="MANPOWER COST + GW COST" class="table-heading-a" >TOTAL MANPOWER COST </a>
                              </th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="TOTAL MANPOWER COST / WT. GMS." class="table-heading-a" >TOTAL MANPOWER COST PER GM </a>
                              </th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="*** Currently static data ***" class="table-heading-a" >TOTAL EXPORT TILL TODAY USD * </a>
                              </th>
                              <th style="text-align: center; min-width: 100px;">
                                <a href="javascript:void(0)" title="QTY. PCS x 1200" class="table-heading-a" >FG VALUE @ Rs.1200 PER PC </a>
                              </th>
                              <th style="text-align: center; min-width: 150px;">
                                <a href="javascript:void(0)" title="TOTAL MANPOWER COST x 1.2" class="table-heading-a" >TOTAL EXPENSES ON MANPOWER </a>
                              </th>
                              <th style="text-align: center; min-width: 180px;">
                                <a href="javascript:void(0)" title="( TOTAL EXPENSES ON MANPOWER / FG VALUE @ Rs.1200 PER PC ) * 100  " class="table-heading-a" >% OF MANPOWER EXPENSES AGAINST FG VALUE </a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @if (count($fgData) > 0)
                            @php
                              $count = 1
                            @endphp
                            @foreach($fgData as $key => $data)
                              @php
                                $No_OF_PROD_WORKERS_PRESENT_TODAY = ( $data->employee_data->total_employee > 0 ) ? ( $data->employee_data->total_employee ) : 0;
                                $TODAY_SALARY_OF_PRESENT_PROD_WORKERS = ( round($data->employee_data->per_day_sallery) > 0 ) ? ( round($data->employee_data->per_day_sallery)  ) : 0;
                                $direct_production_gw_amount = ( round($data->employee_data->over_time_sallery) > 0 ) ?  round($data->employee_data->over_time_sallery ) : 0;;
                                $total_direct_production_cost_amount = $TODAY_SALARY_OF_PRESENT_PROD_WORKERS + $direct_production_gw_amount;
                                $rs_per_pc = ( round($data->quantity) > 0 ) ? ( round ( $total_direct_production_cost_amount/ round($data->quantity) ) ) : 0;
                                $rs_per_gm = ( round($data->weight) > 0 ) ? ( round ( $total_direct_production_cost_amount/ round($data->weight) ) ) : 0;
                                // $manpower_cost = ( round($data->employee_data->per_day_sallery) > 0 ) ? ( round($data->employee_data->per_day_sallery) ) : 0 ;
                                $manpower_cost = $data->employee_data->manpower_cost ;
                                $gw_cost =  $data->employee_data->net_over_time_amount ;
                                $total_manpower_cost = $manpower_cost + $gw_cost;
                                $total_manpower_cost_per_gm = ( $rs_per_gm > 0 ) ? ( round($total_manpower_cost / $rs_per_gm) ) : 0;
                                $total_export_till_today_usd = 100;
                                $fg_value_rs_1000_per_pc = round($data->quantity * 1200);
                                $total_expenses_on_manpower = round($total_manpower_cost * 1.2);
                                $per_of_manpower_expenses_against_fg_value = ( $fg_value_rs_1000_per_pc > 0 ) ? ( round ( ( $total_expenses_on_manpower / $fg_value_rs_1000_per_pc ) * 100 ) ) : 0;
                              @endphp
                            <tr>
                              <td style="text-align: center;">{{ $fgData->firstItem() + $key }}</td>
                              <td style="text-align: center;">
                                <!-- <a href="javascript:void(0)" onclick="showDetails('{{ date('d-m-Y',strtotime($data->FdDt)) }}', {{ $key }} )" style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a> -->
                                <a href="/fg/mahapura/details?fg_date={{ date('Y-m-d',strtotime($data->FdDt)) }}" target="_blank"  style="color: green;">{{ date('d-m-Y',strtotime($data->FdDt)) }} </a>
                              </td>
                              <td style="text-align: center;"> {{ $No_OF_PROD_WORKERS_PRESENT_TODAY }} </td>
                              <td style="text-align: center;"> {{ $TODAY_SALARY_OF_PRESENT_PROD_WORKERS  }} </td>
                              <td style="text-align: center;"> {{ $direct_production_gw_amount }} </td>
                              <td style="text-align: center;"> {{ $total_direct_production_cost_amount }} </td>
                              <td style="text-align: center;">{{ round($data->quantity) }}</td>
                              <td style="text-align: center;">{{ round($data->weight,0) }}</td>
                              <td style="text-align: center;"> {{ $rs_per_pc }} </td>
                              <td style="text-align: center;"> {{ $rs_per_gm }} </td>
                              <td style="text-align: center;"> {{ $manpower_cost }} </td>
                              <td style="text-align: center;"> {{ $gw_cost }} </td>
                              <td style="text-align: center;"> {{ $total_manpower_cost }} </td>
                              <td style="text-align: center;"> {{ $total_manpower_cost_per_gm }} </td>
                              <td style="text-align: center;"> {{ $total_export_till_today_usd }} </td>
                              <td style="text-align: center;"> {{ $fg_value_rs_1000_per_pc }}</td>
                              <td style="text-align: center;"> {{ $total_expenses_on_manpower }} </td>
                              <td style="text-align: center;"> {{ $per_of_manpower_expenses_against_fg_value }} </td>
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
