<table id="datatable" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th colspan="6"></th>
                              <th colspan="2" style="height: 30%;"> FG OF THE DAY </th>
                              <th colspan="2"> DIRECT PRODUCTION COST </th>
                              <th colspan="8"></th>
                            </tr>
                            <tr style="text-align: center;">
                              <th style="text-align: center;">S.NO.</th>
                              <th style="text-align: center; width: 15%; height: 45%;">DATE</th>
                              <th style="text-align: center; width: 25%;">No. OF PROD. WORKERS <br> PRESENT TODAY</th>
                              <th style="text-align: center; width: 25%;">TODAY'S SALARY OF <br>PRESENT PROD. WORKERS</th>
                              <th style="text-align: center; width: 25%;">DIRECT PRODUCTION <br> GW AMOUNT *</th>
                              <th style="text-align: center; width: 25%;">TOTAL DIRECT PRODUCTION <br> COST AMOUNT **</th>
                              <th style="text-align: center; width: 18%;">QTY. PCS</th>
                              <th style="text-align: center; width: 18%;">WT. GMS.</th>
                              <th style="text-align: center; width: 18%;">Rs. PER PC **</th>
                              <th style="text-align: center; width: 18%;">Rs. PER GM **</th>
                              <th style="text-align: center; width: 20%;">MANPOWER COST *</th>
                              <th style="text-align: center; width: 18%;">GW COST *</th>
                              <th style="text-align: center; width: 25%;">TOTAL MANPOWER <br> COST *</th>
                              <th style="text-align: center; width: 25%;">TOTAL MANPOWER <br> COST PER GM **</th>
                              <th style="text-align: center; width: 25%;">TOTAL EXPORT <br> TILL TODAY USD *</th>
                              <th style="text-align: center; width: 25%;">FG VALUE @ <br>Rs.1000 PER PC </th>
                              <th style="text-align: center; width: 25%;">TOTAL EXPENSES <br> ON MANPOWER **</th>
                              <th style="text-align: center; width: 25%;">% OF MANPOWER EXPENSES <br> AGAINST FG VALUE **</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if (count($fgData) > 0)
                            @php
                              $count = 1
                            @endphp
                            @foreach($fgData as $key => $data)
                              @php
                                $No_OF_PROD_WORKERS_PRESENT_TODAY = ( $data->employee_data->total_employee > 0 ) ? ( $data->employee_data->total_employee  ) : 0;
                                $TODAY_SALARY_OF_PRESENT_PROD_WORKERS = ( round($data->employee_data->per_day_sallery) > 0 ) ? ( round($data->employee_data->per_day_sallery)  ) : 0;
                                $direct_production_gw_amount = ( round($data->employee_data->over_time_sallery) > 0 ) ?  round($data->employee_data->over_time_sallery ) : 0;;
                                $total_direct_production_cost_amount = $TODAY_SALARY_OF_PRESENT_PROD_WORKERS + $direct_production_gw_amount;
                                $rs_per_pc = ( round($data->quantity) > 0 ) ? ( round ( $total_direct_production_cost_amount/ round($data->quantity) ) ) : 0;
                                $rs_per_gm = ( round($data->weight) > 0 ) ? ( round ( $total_direct_production_cost_amount/ round($data->weight) ) ) : 0;
                                // $manpower_cost = ( round($data->employee_data->per_day_sallery) > 0 ) ? ( round($data->employee_data->per_day_sallery)  ) : 0 ;
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
                              <td style="text-align: center;">{{ $count++ }}</td>
                              <td style="text-align: center;">{{ date('d-m-Y',strtotime($data->FdDt)) }}</td>
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
                            <tr id="table-key-{{ $key }}" class="close-details"></tr> @endforeach @else <tr>
                              <td colspan="17" class="text-center text-danger">
                                <h3>
                                  <b>No Record Found</b>
                                </h3>
                              </td>
                            </tr> @endif
                          </tbody>
                        </table>
