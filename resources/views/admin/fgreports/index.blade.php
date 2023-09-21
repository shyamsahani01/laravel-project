
@extends('admin.layout.app')
@section('content')
@php
$showurl = url('fg/fgreports?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date);
@endphp
    <div class="main-panel">
        <div class="content">
            @includeif('admin.fgreports.filters')
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
                                    
                                       <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                          <thead>
                                            <tr>
                                                <th colspan="6" ></th>
                                                <th colspan="2"> FG OF THE DAY </th>
                                                <th colspan="2" > DIRECT PRODUCTION COST </th>
                                                <th colspan="8" ></th>
                                            </tr>
                                             <tr style="text-align: center;">
                                               <th style="text-align: center;"  >S.NO.</th>
                                               <th style="text-align: center; min-width: 100px;">DATE</th>
                                               <th style="text-align: center; min-width: 150px;" >No. OF PROD. WORKERS PRESENT  TODAY</th>
                                               <th style="text-align: center; min-width: 150px;" >TODAY'S  SALARY OF PRESENT PROD. WORKERS</th>
                                               <th style="text-align: center; min-width: 100px;" >DIRECT PRODUCTION GW AMOUNT *</th>
                                               <th style="text-align: center; min-width: 150px;" >TOTAL DIRECT PRODUCTION COST AMOUNT **</th>
                                               <th style="text-align: center; min-width: 80px;" >QTY. PCS</th>
                                               <th style="text-align: center; min-width: 80px;" >WT. GMS.</th>
                                               <th style="text-align: center; min-width: 100px;" >Rs. PER PC **</th>
                                               <th style="text-align: center; min-width: 100px;" >Rs. PER GM **</th>
                                               <th style="text-align: center; min-width: 80px;" >MANPOWER COST *</th>
                                               <th style="text-align: center; min-width: 80px;" >GW COST *</th>
                                               <th style="text-align: center; min-width: 80px;" >TOTAL MANPOWER COST *</th>
                                               <th style="text-align: center; min-width: 150px;" >TOTAL MANPOWER COST PER GM **</th>
                                               <th style="text-align: center; min-width: 150px;" >TOTAL EXPORT TILL TODAY USD *</th>
                                               <th style="text-align: center; min-width: 100px;" >FG VALUE @ Rs.1000 PER PC </th>
                                               <th style="text-align: center; min-width: 150px;" >TOTAL EXPENSES ON MANPOWER **</th>
                                               <th style="text-align: center; min-width: 180px;" >% OF MANPOWER EXPENSES AGAINST FG VALUE **</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                            @if (count($fgData) > 0)
                                               @php $count = 1 @endphp
                                                @foreach($fgData as $key => $data)
                                                    @php
                                                          $direct_production_gw_amount = 100;
                                                          $total_direct_production_cost_amount = round($data->employee_data->per_day_salary) + $direct_production_gw_amount;
                                                          $rs_per_pc = ( round($data->quantity) > 0 ) ? ( round ( $total_direct_production_cost_amount/  round($data->quantity) ) ) : 0;
                                                          $rs_per_gm =  ( round($data->weight) > 0 ) ? ( round ( $total_direct_production_cost_amount/  round($data->weight) ) ) : 0;

                                                          $manpower_cost = 100;
                                                          $gw_cost = 100;
                                                          $total_manpower_cost = $manpower_cost + $gw_cost;
                                                          $total_manpower_cost_per_gm = ( $rs_per_gm > 0 ) ?  ( round($total_manpower_cost / $rs_per_gm) ) : 0;
                                                          $total_export_till_today_usd = 100;
                                                          $fg_value_rs_1000_per_pc =  round($data->quantity  * 1000);
                                                          $total_expenses_on_manpower = round($total_manpower_cost  * 1.2);
                                                          $per_of_manpower_expenses_against_fg_value = ( $fg_value_rs_1000_per_pc > 0 ) ?  ( round ( ( $total_expenses_on_manpower / $fg_value_rs_1000_per_pc ) * 100 ) ) : 0;
                                                     @endphp
                                                    <tr>
                                                        <td style="text-align: center;" >{{ $fgData->firstItem() +  $key }}</td>

                                                        <!-- <td style="text-align: center;"><a href="javascript:void(0)" onclick="showDetails('{{ date('d-m-Y',strtotime($data->FdDt)) }}')"  >{{ date('d-m-Y',strtotime($data->FdDt)) }} </a></td> -->

                                                        <td style="text-align: center;"><a href="javascript:void(0)" onclick="showDetails('{{ date('d-m-Y',strtotime($data->FdDt)) }}', {{ $key }} )" style="color: green;"  >{{ date('d-m-Y',strtotime($data->FdDt)) }} </a></td>
                                                        <td style="text-align: center;" > {{ $data->employee_data->total_employee }} </td>
                                                        <td style="text-align: center;" > {{ round($data->employee_data->per_day_salary) }} </td>
                                                        <td style="text-align: center;" > {{ $direct_production_gw_amount }} </td>
                                                        <td style="text-align: center;" > {{ $total_direct_production_cost_amount }} </td>

                                                        <td style="text-align: center;" >{{ round($data->quantity) }}</td>
                                                        <td style="text-align: center;" >{{ round($data->weight,0) }}</td>

                                                        <td style="text-align: center;" > {{ $rs_per_pc }} </td>
                                                        <td style="text-align: center;" > {{ $rs_per_gm }}  </td>


                                                        <td style="text-align: center;" > {{ $manpower_cost }} </td>
                                                        <td style="text-align: center;" > {{ $gw_cost }}  </td>

                                                        <td style="text-align: center;" > {{ $total_manpower_cost }}  </td>
                                                        <td style="text-align: center;" > {{ $total_manpower_cost_per_gm }}  </td>
                                                        <td style="text-align: center;" > {{ $total_export_till_today_usd }} </td>
                                                        <td style="text-align: center;" > {{ $fg_value_rs_1000_per_pc }}</td>
                                                        <td style="text-align: center;" > {{ $total_expenses_on_manpower }} </td>
                                                        <td style="text-align: center;" > {{ $per_of_manpower_expenses_against_fg_value }} </td>
                                                    </tr>

                                                    <tr id="table-key-{{ $key }}" class = "close-details">
                                                    </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="17" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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




    <!-- Modal -->
    <div class="modal fade" id="FGDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Finish Goods Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="" class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;"  >S.NO.</th>
                        <th style="text-align: center; min-width: 100px; font-weight: bold;">B Id No.</th>
                        <th style="text-align: center; min-width: 80px; font-weight: bold;" >Quantity</th>
                        <th style="text-align: center; min-width: 80px; font-weight: bold;" >Weight</th>
                    </tr>
                </thead>
                <tbody id="FGDetails-table_body">
                 </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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


    function showDetails(date_value, key) {
        // $.ajax({
        //         url: '{{  url("get-fg-details") }}',
        //         cache: false,
        //         type: "get",
        //         data: {'date' : date_value},
        //         dataType: "json",
        //         success: function(obj){
        //             var str = "";
        //             if(obj.status == 1) {
        //                 for(let i=0; i<obj.data.length; i++) {
        //                     str += '<tr>';
        //                     str += '    <td style="text-align: center;" >'+(i+1)+'</td>';
        //                     str += '    <td style="text-align: center;" >'+obj.data[i].FdBIdNo+'</td>';
        //                     str += '    <td style="text-align: center;" >'+Math.round(obj.data[i].FdQty)+'</td>';
        //                     str += '    <td style="text-align: center;" >'+ ( Math.round(obj.data[i].FdGrWt * 100) / 100 )  +'</td>';
        //                     str += '</tr>';
        //                 }
        //             } else {
        //                 str += '<tr>';
        //                 str += '    <td colspan="4" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>';
        //                 str += '<tr>';
        //             }
        //             $("#FGDetails-table_body").html(str)
        //             $("#FGDetails").modal("show")
        //         },
        //         error: function(obj){
        //             $("#alert").append("unable to fetch data");
        //         },
        //     });


            if($("#table-key-"+key).attr('class') == 'close-details') {

                $.ajax({
                    url: '{{  url("get-fg-details") }}',
                    cache: false,
                    type: "get",
                    data: {'date' : date_value},
                    dataType: "json",
                    success: function(obj){
                        var str = "";

                        str += "<td></td>";
                        str += "<td colspan=4>";
                        str += '    <table id="" class="table table-striped table-bordered" >';
                        str += '        <thead>';
                        str += '            <tr>';
                        str += '                <th style="text-align: center; font-weight: bold;"  >S.NO.</th>';
                        str += '                <th style="text-align: center; min-width: 100px; font-weight: bold;">B Id No.</th>';
                        str += '                <th style="text-align: center; min-width: 80px; font-weight: bold;" >Quantity</th>';
                        str += '                <th style="text-align: center; min-width: 80px; font-weight: bold;" >Weight</th>';
                        str += '            </tr>';
                        str += '        </thead>';
                        str += '    <tbody id="FGDetails-table_body">';

                        if(obj.status == 1) {
                            for(let i=0; i<obj.data.length; i++) {
                                str += '<tr>';
                                str += '    <td style="text-align: center;" >'+(i+1)+'</td>';
                                str += '    <td style="text-align: center;" >'+obj.data[i].FdBIdNo+'</td>';
                                str += '    <td style="text-align: center;" >'+Math.round(obj.data[i].FdQty)+'</td>';
                                str += '    <td style="text-align: center;" >'+ ( Math.round(obj.data[i].FdGrWt * 100) / 100 )  +'</td>';
                                str += '</tr>';
                            }

                        } else {
                            str += '<tr>';
                            str += '    <td colspan="4" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>';
                            str += '<tr>';
                        }

                        str += '    </tbody>';
                        str += '  </table>';
                        str += '</td>';
                        str += "<td colspan=13></td>";

                        $("#table-key-"+key).html(str)
                        $("#table-key-"+key).attr('class', 'open-details');
                        $("#table-key-"+key).show();

                    },
                    error: function(obj){
                        $("#alert").append("unable to fetch data");
                    },
                });


            } else {
                $("#table-key-"+key).attr('class', 'close-details');
                $("#table-key-"+key).hide();
            }


    }


</script>
@endsection
