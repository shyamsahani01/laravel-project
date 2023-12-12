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
                             <label for="" class="col-sm-3 col-form-label bold-label">Date</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TDt)){{ date('D, d-m-Y', strtotime($bag_transaction_details->TDt) ) }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Bag Location</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_transaction_details->TFrBLoc)){{ $bag_transaction_details->TFrBLoc }}@endif"  >
                             </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">To Bag Location</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_transaction_details->TLsLoc)){{ $bag_transaction_details->TLsLoc }}@endif"  >
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
                                                         <th>S.NO.</th>
                                                         <th>Bag No.</th>
                                                         <th>Quantity</th>
                                                         <th>Parts Quantity</th>
                                                         <th>Gross Weight</th>
                                                         <th>From Location</th>
                                                         <th>To Location</th>
                                                         <th>Worker</th>
                                                         <th>Acknowledgement (Y/N)</th>
                                                         <th>Wax Weight</th>
                                                         <th>Description</th>
                                                         <th>Client Code</th>
                                                         <th>User (Modified)</th>
                                                         <th>Date (Modified)</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       @if (count($transaction_bag_list) > 0)
                                                       @php $count = 1 @endphp
                                                       @foreach($transaction_bag_list as $key => $data)
                                                            <tr  style="text-align: center;">
                                                              <!-- <td>{{ $data->TdSr  }}</td> -->
                                                              <td>{{ $data->TdSr  }}</td>
                                                              <!-- <td><a href="/emporer/bag/bagDetails?bag_no={{ $data->bag_no}}&company_code={{ $data->TdCoCd}}"  style="color: green; font-weight:bold">{{ $data->bag_no  }}</a></td> -->
                                                              <td><a href="/emporer/bag/bagDetails?BIdNo={{ $data->TdBIdNo}}"  style="color: green; font-weight:bold">{{ $data->bag_no  }}</a></td>
                                                              <td>{{ round($data->TdBQty, 4)  }}</td>
                                                              <td>{{ round($data->TdPtQty, 4)  }}</td>
                                                              <td>{{ round($data->TdBGrWt, 4)  }}</td>
                                                              <td>{{ $data->TdFrBLoc  }}</td>
                                                              <td>{{ $data->TdToBLoc  }}</td>
                                                              <td>{{ $data->TdWrk  }} ({{ $data->worker_name  }})</td>
                                                              <td>{{ $data->TdAck  }}</td>
                                                              <td>{{ round($data->TdWaxWt, 4)  }}</td>
                                                              <td>{{ $data->TdDesc  }}</td>
                                                              <td></td>
                                                              <td>{{ $data->ModUsr  }}</td>
                                                              <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                             </tr>
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
