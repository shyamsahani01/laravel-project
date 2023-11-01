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
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Voucher No.</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->voucher_no)){{ $fg_details->voucher_no }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Company</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgCoCd)){{ $fg_details->FgCoCd  }}@endif">
                               </div>
                           </div>
                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Date</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgDt)){{ date('D, d-m-Y', strtotime($fg_details->FgDt) ) }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Packing List</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style"  value="**"  >
                             </div>
                           </div>
                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Bag From Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgFrBLoc)){{ $fg_details->FgFrBLoc  }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Bag To Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgToBLoc)){{ $fg_details->FgToBLoc  }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Bag FG Sub Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgSubLoc)){{ $fg_details->FgSubLoc  }}@endif">
                               </div>
                           </div>
                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Raw Material From Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgFrRmLoc)){{ $fg_details->FgFrRmLoc  }}@endif">
                               </div>
                           </div>
                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Raw Material To Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FgToRmLoc)){{ $fg_details->FgToRmLoc  }}@endif">
                               </div>
                           </div>
                         </div>


                         <div class="form-group row order-form col-md-12">

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">User (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($fg_details->ModUsr)){{ $fg_details->ModUsr }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-4 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Date (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($fg_details->ModDt)){{ date('D, d-m-Y', strtotime($fg_details->ModDt) ) . ' ' . $fg_details->ModTime }}@endif"  >
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
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">Raw Material Wise</a>
                                         </li> -->
                                         <!-- <li class="nav-item">
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
                                                         <th>Design Code</th>
                                                         <th>Suffix</th>
                                                         <th>Size</th>
                                                         <th>Quantity</th>
                                                         <th>Gross Weight</th>
                                                         <th>Order No.</th>
                                                         <th>Bag Order Serial</th>
                                                         <th>Company</th>
                                                         <th>Sub Location</th>
                                                         <th>Packing List</th>
                                                         <!-- <th>Finish Good Date</th> -->
                                                         <th>User (Modified)</th>
                                                         <th>Date (Modified)</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       @if (count($fg_bag_list) > 0)
                                                       @php $count = 1; $total_gross_wt = 0; $total_qty = 0; @endphp
                                                       @foreach($fg_bag_list as $key => $data)
                                                            <tr  style="text-align: center;">
                                                              <td><button class="btn btn-info" onclick="getFGRaw('{{ $data->FdIdNo}}', '{{ $data->bag_no}}',  this)"> Info </button></td>
                                                              <td>{{ $data->FdSr  }}</td>
                                                              <td><a href="/emporer/bag/bagDetails?BYy={{ $data->FdBYy}}&BChr={{ $data->FdBChr}}&BNo={{ $data->FdBNo}}&company_code={{ $data->FdCoCd}}"  style="color: green; font-weight:bold">{{ $data->bag_no  }}</a></td>
                                                              <td><a href="/emporer/design/designDetails?design_code={{ $data->FdDmCd}}"  style="color: green;">{{ $data->FdDmCd  }}</td>
                                                              <td>{{ $data->FdSfx  }}</td>
                                                              <td>{{ $data->FdDmSz  }}</td>
                                                              <td>{{ round($data->FdQty, 4)  }} @php $total_qty += $data->FdQty; @endphp</td>
                                                              <td>{{ round($data->FdGrWt, 4)  }} @php $total_gross_wt += $data->FdGrWt; @endphp</td>
                                                              <td style="text-align: center;" ><a href="/emporer/orders/ordersDetails?OmTc={{ $data->FdPrdOdTc}}&OmYy={{ $data->FdPrdOdYy}}&OmChr={{ $data->FdPrdOdChr}}&OmNo={{ $data->FdPrdOdNo}}&company_code={{ $data->FdCoCd}}"  style="color: green;">{{ $data->order_no }}</a></td>
                                                              <td>{{ $data->FdPrdOdSr  }}</td>
                                                              <td>{{ $data->FdCoCd  }}</td>
                                                              <td>{{ $data->FdSubLoc  }}</td>
                                                              <td>**</td>
                                                              <!-- <td>{{ date('D, d-m-Y', strtotime($data->FdDt) ) }}</td> -->
                                                              <td>{{ $data->ModUsr  }}</td>
                                                              <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                             </tr>
                                                       @endforeach
                                                       <tr  style="text-align: center;">
                                                         <td style="font-weight: bold; color: black;"> Total </td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td style="font-weight: bold; color: black;">{{ round($total_qty, 4)  }}</td>
                                                         <td style="font-weight: bold; color: black;">{{ round($total_gross_wt, 4) }}</td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <!-- <td></td> -->
                                                         <td></td>
                                                         <td></td>
                                                        </tr>
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


                                        <div class="tab-pane fade" id="emp2" role="tabpanel" aria-labelledby="emp2tab">
                                            <div class="x_title">
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="table-responsive">
                                              <table id="new-datatable-5" class="table table-striped table-bordered" style="">
                                                 <thead>
                                                   <tr style="text-align: center;">
                                                     <th>S.NO.</th>
                                                     <th>Bag No.</th>
                                                     <th>Raw Material From Location</th>
                                                     <th>Issue / Receive</th>
                                                     <th>Raw Material Category</th>
                                                     <th style="min-width: 100px;">Raw Material Sub Category</th>
                                                     <th>Raw Material Code</th>
                                                     <th>Lottery No.</th>
                                                     <th>Size </th>
                                                     <th>Breadth</th>
                                                     <th>Depth</th>
                                                     <th>Stock Rate</th>
                                                     <th>Quantity</th>
                                                     <th>Raw Material Weight</th>
                                                     <th>Location Type</th>
                                                     <th>Raw Material To Location</th>
                                                     <th>User (Modified)</th>
                                                     <th>Date (Modified)</th>
                                                   </tr>
                                                 </thead>
                                                 </thead>
                                                 <tbody>
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


 <!-- confirm Modal -->
 <div class="modal fade bd-example-modal-xl" id="all_check_in_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl large-modal" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="all_check_in_modal_label" style="font-weight: bold; color: black;">Bag No . : </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">

         <table id="table" class="table-bordered table-striped table table-responsive" >
           <thead>
             <tr style="text-align: center;">
               <th>S.NO.</th>
               <th>Raw Material From Location</th>
               <th>Issue / Receive</th>
               <th>Raw Material Category</th>
               <th style="min-width: 100px;">Raw Material Sub Category</th>
               <th>Raw Material Code</th>
               <th>Lottery No.</th>
               <th>Size </th>
               <th>Breadth</th>
               <th>Depth</th>
               <th>Stock Rate</th>
               <th>Quantity</th>
               <th>Raw Material Weight</th>
               <th>Location Type</th>
               <th>Raw Material To Location</th>
               <th>User (Modified)</th>
               <th>Date (Modified)</th>
             </tr>
           </thead>
           <tbody id="all_check_in_table_body">
             <tr>
               <td class="text-center"></td>
               <td class="text-center"></td>
               <td class="text-center"></td>
             </tr>
         </table>

       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>




 <script>

 function getFGRaw(FdIdNo, bag_no, this_var) {
   $("#all_check_in_modal_label").html("Bag No . - " + bag_no)
   $("#all_check_in_table_body").html("")


        $.ajax({
              url: '{{  url("/emporer/get-fg-raw-material") }}',
              cache: false,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
              type: "get",
              data: { "FdIdNo": FdIdNo },
              dataType: "json",
              beforeSend: function (obj) {
                $('#loader').removeClass('hidden')
              },
              success: function(obj){
                $('#loader').addClass('hidden')
                 if(obj.status) {
                    $("#all_check_in_table_body").html(obj.html_data)
                    $("#all_check_in_modal").modal("show")

                 }else {
                    alert(obj.msg)
                 }


              },
              error: function(obj){
                $('#loader').addClass('hidden')
                 var error_msg = ""
                 $.each(obj.responseJSON.errors, function (key, val) {
                     error_msg +=  val[0] + "\n";
                 });
                 alert(error_msg)

              },
          });

 }


 </script>




@include('admin.emporer.emporer_script')

@endsection
