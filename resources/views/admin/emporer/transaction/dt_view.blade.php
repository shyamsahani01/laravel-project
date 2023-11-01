@extends('admin.layout.app')
@section('content')
<style>
    .table th, .table td {
    padding: 8px !important;
}
</style>


 <div class="main-panel">
     <div class="content">
         <div class="container-fluid">

           <div class="row">
               <div class="col-md-12">
                   <div class="shadow-lg p-3 mb-5 bg-white rounded">
                     <div class="x_title">
                         <h2>{{ $title }}</h2>
                         <div class="clearfix"></div>
                     </div>

                      <div class="form-group row order-form ">
                       <div class="col-md-12">
                         <div class="form-group row order-form col-md-12">

                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Voucher No.</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->voucher_no)){{ $bag_transaction_details->voucher_no }}@endif">
                               </div>
                           </div>

                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Voucher Lock (Y/N)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TLockYN)){{ $bag_transaction_details->TLockYN }}@endif"  >
                             </div>
                           </div>

                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Date</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TDt)){{ date('D, d-m-Y', strtotime($bag_transaction_details->TDt) ) }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Bag Location</label>
                             <div class="col-sm-6">
                               <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TFrBLoc)){{ $bag_transaction_details->TFrBLoc }}@endif"  >
                             </div>
                           </div>
                         </div>
                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Raw Material Location From</label>
                             <div class="col-sm-6">
                               <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TFrRmLoc)){{ $bag_transaction_details->TFrRmLoc }}@endif"  >
                             </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Raw Material Location To</label>
                             <div class="col-sm-6">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_transaction_details->TToRmLoc)){{ $bag_transaction_details->TToRmLoc }}@endif"  >
                             </div>
                           </div>
                         </div>


                         <div class="form-group row order-form col-md-12">

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Description</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TDesc)){{ $bag_transaction_details->TDesc  }}@endif">
                               </div>
                           </div>

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Company</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TCoCd)){{ $bag_transaction_details->TCoCd  }}@endif">
                               </div>
                           </div>

                         </div>


                         <div class="form-group row order-form col-md-12">

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">User (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_transaction_details->ModUsr)){{ $bag_transaction_details->ModUsr }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Date (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_transaction_details->ModDt)){{ date('D, d-m-Y', strtotime($bag_transaction_details->ModDt) ) . ' ' . $bag_transaction_details->ModTime }}@endif"  >
                             </div>
                           </div>

                         </div>




                       </div>


                      </div>

                   </div>
                </div>
              </div>


             <div class="row">
                 <div class="col-md-12">
                     <div class="panel-group" id="accordion">
                         <div class="panel panel-default shadow-lg p-3 mb-5 bg-white rounded">
                             <div class="x_panel">
                                 <div class="x_content">
                                     <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                                         <li class="nav-item">
                                             <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">Bag List</a>
                                         </li>
                                         <!-- <li class="nav-item">
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">BOM(Bill of Material)</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp3-tab" data-toggle="tab" href="#emp3" role="tab" aria-controls="emp3" aria-selected="false" style="font-weight: 550;color: black;">BOM Summary</a>
                                         </li> -->
                                     </ul>
                                     <div class="tab-content" id="myTabContent">
                                         <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                             <div class="x_title">
                                             </div>

                                             <div class="">
                                               <div class="table-responsive">

                                                 <table id="new-datatable-2" class="table table-striped table-bordered" style="">
                                                    <thead>
                                                       <tr style="text-align: center;">
                                                         <th>Action</th>
                                                         <th>S.NO.</th>
                                                         <th>Bag No.</th>
                                                         <th>Quantity</th>
                                                         <th>Parts Quantity</th>
                                                         <th>Gross Weight</th>
                                                         <th>From Location</th>
                                                         <th>Worker</th>
                                                         <th>Production Completed (Y/N)</th>
                                                         <th>PD Quantity</th>
                                                         <th>By Location</th>
                                                         <th>By Worker</th>
                                                         <th>Description</th>
                                                         <th>Customer Code</th>
                                                         <th>User (Modified)</th>
                                                         <th>Date (Modified)</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                      @php $temp_data_array = []; @endphp
                                                      @foreach($transaction_bag_list as $key => $data)
                                                        @if(isset($temp_data_array[$data->TdSr])) @php $temp_data_array[$data->TdSr] = $temp_data_array[$data->TdSr] + 1; @endphp
                                                        @else @php $temp_data_array[$data->TdSr] =  0; @endphp
                                                        @endif
                                                      @endforeach

                                                       @if (count($transaction_bag_list) > 0)
                                                       @php $count = 0; $count_check = 0; $temp_data =[]; @endphp
                                                       @foreach($transaction_bag_list as $key => $data)
                                                       @php $count++; @endphp
                                                       <?php
                                                       if(isset($temp_data[$data->TdSr])) { $temp_data[$data->TdSr] = $temp_data[$data->TdSr] + 1; }
                                                       else { $temp_data[$data->TdSr] =  0; }
                                                       ?>

                                                          @if($temp_data[$data->TdSr] == 0)
                                                            @php $count_check = 0; @endphp
                                                            <tr  style="text-align: center;">
                                                              <td><i class="fa fa-plus" style="color: green; font-weight:bold" onclick="toggleInnerTable({{ $data->TdSr  }}, this)"> ({{ $temp_data_array[$data->TdSr] }}) </i></td>
                                                              <td>{{ $data->TdSr  }}</td>
                                                              <td><a href="/emporer/bag/bagDetails?BIdNo={{ $data->TdBIdNo}}"  style="color: green; font-weight:bold">{{ $data->bag_no  }}</a></td>
                                                              <td>{{ round($data->TdBQty, 4)  }}</td>
                                                              <td>{{ round($data->TdPtQty, 4)  }}</td>
                                                              <td>{{ round($data->TdBGrWt, 4)  }}</td>
                                                              <td>{{ $data->TdFrBLoc  }}</td>
                                                              <!-- <td>{{ $data->TdToBLoc  }}</td> -->
                                                              <td>{{ $data->TdWrk  }}</td>
                                                              <td>{{ $data->TdPrdYN  }}</td>
                                                              <td>{{ round($data->TdPDQty, 4)  }}</td>
                                                              <td>{{ $data->TdByLoc  }}</td>
                                                              <td>{{ $data->TdByWrk  }}</td>
                                                              <td>{{ $data->TdDesc  }}</td>
                                                              <td></td>
                                                              <td>{{ $data->ModUsr  }}</td>
                                                              <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                            </tr>
                                                          @else
                                                            @php $count_check++; @endphp
                                                          @if($temp_data[$data->TdSr] == 1)
                                                          <tr  style="text-align: center; " class="hide-table" id ="innertable-{{ $data->TdSr  }}">
                                                            <td colspan="16">
                                                              <table  class="table table-bordered table-borderless " style="">
                                                                 <thead class="table-info">
                                                                    <tr style="text-align: center;">
                                                                      <th>S.NO.</th>
                                                                      <th>Raw Material From Location</th>
                                                                      <th>Issue / Receive</th>
                                                                      <th>Raw Material Category</th>
                                                                      <th style="min-width: 100px;">Raw Material Sub Category</th>
                                                                      <th>Raw Material Code</th>
                                                                      <th>Lottery No.</th>
                                                                      <th>Raw Material Size (Length / Sieve Size / Pointer )</th>
                                                                      <th>Stock Rate</th>
                                                                      <th>Quantity</th>
                                                                      <th>Raw Material Weight</th>
                                                                      <!-- <th>Broken / Missing</th> -->
                                                                      <th>Location Type</th>
                                                                      <th>To Location</th>
                                                                      <th>By Location</th>
                                                                      <th>By Worker</th>
                                                                      <th>Reason Code</th>
                                                                      <th>Dust Weight</th>
                                                                      <th>User (Modified)</th>
                                                                      <th>Date (Modified)</th>
                                                                    </tr>
                                                                 </thead>
                                                                 <tbody>
                                                            @endif
                                                                   <tr style="text-align: center;" class="table-secondary">
                                                                     <td>{{ $data->TdSrNo  }}</td>
                                                                     <td>{{ $data->TdFrRmLoc  }}</td>
                                                                     <!-- <td>{{ $data->TdFrBLoc  }}</td> -->
                                                                     <!-- <td>{{ $data->TdFrRmLocTyp  }}</td> -->
                                                                     <td>@if($data->TdFrRmDc == "C"){{ 'I' }}@elseif($data->TdFrRmDc == "D"){{ 'R' }}@endif</td>
                                                                     <td class="parameter-desc" onclick="getParameterDescription('{{ $data->TdRmCtg  }}', 'table', this, 'raw_material_category')">{{ $data->TdRmCtg  }}</td>
                                                                     <td class="parameter-desc" onclick="getParameterDescription('{{ $data->TdRmSCtg  }}', 'table', this, 'raw_material_sub_category', '{{ $data->TdRmCtg  }}')">{{ $data->TdRmSCtg  }}</td>
                                                                     <td>{{ $data->TdRmCd  }}</td>
                                                                     <td>{{ $data->TdLotNo  }}</td>
                                                                     <td>{{ round($data->TdRmSz, 4)  }}</td>
                                                                     <td>{{ round($data->TdRmStkRt, 4)  }}</td>
                                                                     <td>{{ round($data->TdRmQty, 4)  }}</td>
                                                                     <td>{{ round($data->TdRmWt, 4)  }}</td>
                                                                     <!-- <td></td> -->
                                                                     <td class="parameter-desc" onclick="getParameterDescription('{{ $data->TdToRmLocTyp  }}', 'table', this, 'location_type')">{{ $data->TdToRmLocTyp  }}</td>
                                                                     <td>{{ $data->TdToRmLoc  }}</td>
                                                                     <td>{{ $data->TdByLoc  }}</td>
                                                                     <td>{{ $data->TdByWrk  }}</td>
                                                                     <td>{{ $data->TdRjCd  }}</td>
                                                                     <td>{{ round($data->TdDustWt, 4)  }}</td>
                                                                     <td>{{ $data->ModUsr  }}</td>
                                                                     <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                                   </tr>

                                                          @if($temp_data_array[$data->TdSr]  == $count_check  )
                                                                  </tbody>
                                                              </table>
                                                            </td>
                                                          </tr>
                                                          @endif


                                                          @endif
                                                       @endforeach
                                                    @else
                                                      <tr>
                                                        <td colspan="17" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
 </div>




 <script>

function toggleInnerTable(id, this_var) {
  if($(this_var).hasClass("fa-plus")) {
    $(this_var).removeClass("fa-plus")
    $(this_var).addClass("fa-minus")
    $("#innertable-"+id).removeClass("hide-table")
  }
  else {
    $(this_var).removeClass("fa-minus")
    $(this_var).addClass("fa-plus")
    $("#innertable-"+id).addClass("hide-table")
  }
}
 </script>




@include('admin.emporer.emporer_script')

@endsection
