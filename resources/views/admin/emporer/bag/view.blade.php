@extends('admin.layout.app')
@section('content')
<style>
    .table th, .table td {
    padding: 8px !important;
}
</style>

@php
use App\Library\WebHelper;
@endphp

<?php
function checkDigits($value='')
{
  if($value == 0 || $value == "")  { return "";}
  else { return round($value, 4);}
}
 ?>

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
                       <div class="col-md-6">
                         <div class="form-group row order-form col-md-12">

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Bag No.</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_details->bag_no)){{ $bag_details->bag_no }}@endif">
                               </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Order No.</label>
                             <div class="col-sm-9">
                               <a href="/emporer/orders/ordersDetails?OmIdNo={{ $bag_details->BOmIdNo}}"  >
                                 <input type="text" readonly class="form-control from-custom-style"  style="color: green;"  value="@if(isset($bag_details->order_no)){{ $bag_details->order_no }}@endif"  >
                               </a>
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Company</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style"    value="@if(isset($bag_details->BCoCd)){{ $bag_details->BCoCd }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">User (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->ModUsr)){{ $bag_details->ModUsr }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Date (Modified)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->ModDt)){{ date('D, d-m-Y', strtotime($bag_details->ModDt) ) . ' ' . $bag_details->ModTime }}@endif"  >
                             </div>
                           </div>

                         </div>




                       </div>


                       <div class="col-md-6">
                         <div class="col-md-12 form-group order-form">
                           @if (WebHelper::get_emr_design_file_location($bag_details->DmCtg, $bag_details->DmTcTyp, $bag_details->DmCd, 'LD') != "")
                           <div class="col-sm-6">
                             <img id='design-LD-{{ $bag_details->DmCd  }}' style = "max-height: 200px;" class="col-sm-10" onclick="displayImage('{{ $bag_details->DmCd  }}', 'LD')" src="{{ WebHelper::get_emr_design_file_location($bag_details->DmCtg, $bag_details->DmTcTyp, $bag_details->DmCd, 'LD')  }}" >
                           </div>
                           @endif
                           @if (WebHelper::get_emr_design_file_location($bag_details->DmCtg, $bag_details->DmTcTyp, $bag_details->DmCd, '3D') != "")
                           <div class="col-sm-6">
                             <img id='design-3D-{{ $bag_details->DmCd  }}' style = "max-height: 200px;" class="col-sm-10" onclick="displayImage('{{ $bag_details->DmCd  }}', '3D')" src="{{ WebHelper::get_emr_design_file_location($bag_details->DmCtg, $bag_details->DmTcTyp, $bag_details->DmCd, '3D')  }}" >
                           </div>
                           @endif
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
                                             <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">General</a>
                                         </li>
                                         <!-- <li class="nav-item">
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">BOM(Bill of Material)</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp3-tab" data-toggle="tab" href="#emp3" role="tab" aria-controls="emp3" aria-selected="false" style="font-weight: 550;color: black;">BOM Summary</a>
                                         </li> -->
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">Bag History</a>
                                         </li>
                                     </ul>
                                     <div class="tab-content" id="myTabContent">
                                         <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                             <div class="x_title">
                                                 <div class="clearfix " style="font-weight: 550;color: black;">General</div>
                                             </div>

                                             <div class="">

                                               <?php
                                               $main_metal_code = "";
                                               $main_metal_weight = 0;
                                               $color_stone_weight = 0;
                                               $diamond_weight = 0;

                                               $bom_summary = []; $k=0;
                                               foreach($bag_orders_bom_details as $key => $data) {
                                                 $found =  0;
                                                 for ($i=0; $i < count($bom_summary) ; $i++) {
                                                   if($bom_summary[$i]['category'] == $data->OrRmCtg && $bom_summary[$i]['sub_category'] == $data->OrRmSCtg ) {
                                                     $found =  1;
                                                     $found_key = $i;
                                                     $bom_summary[$i]['quantity'] += $data->OrQty;
                                                     $bom_summary[$i]['weight'] += $data->OrWt;
                                                     $bom_summary[$i]['total_quantity'] += $bag_details->BQty * $data->OrQty;
                                                     $bom_summary[$i]['total_weight'] += $bag_details->BQty * $data->OrWt;
                                                     break;
                                                   }
                                                 }

                                                 if($found == 1) { continue; }

                                                 $bom_summary[$k]['category'] = $data->OrRmCtg;
                                                 $bom_summary[$k]['sub_category'] = $data->OrRmSCtg;
                                                 $bom_summary[$k]['quantity'] = $data->OrQty;
                                                 $bom_summary[$k]['weight'] = $data->OrWt;
                                                 $bom_summary[$k]['total_quantity'] = $bag_details->BQty * $data->OrQty;
                                                 $bom_summary[$k]['total_weight'] = $bag_details->BQty * $data->OrWt;
                                                 $bom_summary[$k]['main_metail'] = $data->OrMainMet;

                                                 if($data->OrMainMet == "Y") {$main_metal_code = $data->OrRmCd . " ( $data->RmDesc )";}
                                                 if($found == 0) { $k++; }

                                               }

                                               foreach($bom_summary as $key => $data) {
                                                 if($data['category'] == 'C') { $color_stone_weight += $data['total_weight']; }
                                                 if($data['category'] == 'D') { $diamond_weight += $data['total_weight']; }
                                                 if($data['main_metail'] == 'Y') { $main_metal_weight += $data['total_weight'];   }
                                               }
                                                ?>

                                               <div class="form-group row order-form ">

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Order No.</label>
                                                     <div class="col-sm-9">
                                                       <a href="/emporer/orders/ordersDetails?OmIdNo={{ $bag_details->BOmIdNo}}"  >
                                                         <input type="text" readonly class="form-control from-custom-style " style="color: green;" value="@if(isset($bag_details->order_no)){{ $bag_details->order_no }}@endif"  >
                                                       </a>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Suffix</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOdSfx)){{ $bag_details->BOdSfx }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Size</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOdDmSz)){{ $bag_details->BOdDmSz }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Customer</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style "  value="@if(isset($bag_orders_details->OmCmCd)){{ $bag_orders_details->OmCmCd .  ' (' . $bag_orders_details->CmName  .')' }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Design Category</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->DmCtg)){{ $bag_details->DmCtg }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Purchase Order No.</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_details->OmPoNo)){{ $bag_orders_details->OmPoNo }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Karat</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style "  value="@if(isset($bag_orders_design_details->OdKt)){{ $bag_orders_design_details->OdKt }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Color</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdDmCol)){{ $bag_orders_design_details->OdDmCol }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Product Delivery Date</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_orders_design_details->OdExpDelDt)){{ $bag_orders_design_details->OdExpDelDt }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Current Quantity</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($bag_details->BQty)){{ $bag_details->BQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Current Part Quantity</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BPtQty)){{ $bag_details->BPtQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Sub PO</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style"   value="**"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Open Bag Quantity</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BOpnQty)){{ $bag_details->BOpnQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Open Part Quantity</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BOpnPtQty)){{ $bag_details->BOpnPtQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Gross Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BGrWt)){{ round($bag_details->BGrWt, 4) }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Rejected Quantity</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BRjQty)){{ $bag_details->BRjQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Rejected Part Quantity</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_details->BRjPtQty)){{ $bag_details->BRjPtQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Main Metal Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($main_metal_weight)){{ $main_metal_weight }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Diamond Weight</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($diamond_weight)){{ $diamond_weight }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Color Stone Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($color_stone_weight)){{ $color_stone_weight }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Total Order Quantity</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdOrdQty)){{ $bag_orders_design_details->OdOrdQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Wax Weight</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="**"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Customer Design</label>
                                                     <div class="col-sm-7">
                                                       <a href="/emporer/design/designDetails?design_code={{ $bag_details->BOdDmCd}}"  >
                                                         <input type="text" readonly style="color: green;" class="form-control from-custom-style" value="@if(isset($bag_details->BOdDmCd)){{ $bag_details->BOdDmCd }}@endif"  >
                                                       </a>
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Stamp Instruction</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdCmStmpInst)){{ $bag_orders_design_details->OdCmStmpInst }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Design Instruction</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdDmPrdInst)){{ $bag_orders_design_details->OdDmPrdInst }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Size Instruction</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdSzInst)){{ $bag_orders_design_details->OdSzInst }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Customer Instruction</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdCmPrdInst)){{ $bag_orders_design_details->OdCmPrdInst }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>


                                               </div>


                                             </div>

                                             </br>
                                             </br>
                                             <div class="x_title">
                                                 <div class="clearfix"  style="font-weight: 550;color: black;">BOM(Bill of Material)</div>
                                             </div>
                                             <div class="table-responsive">
                                               <table id="new-datatable-2" class="table table-striped table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th>Raw Material Category</th>
                                                       <th style="min-width: 100px;">Raw Material Sub Category</th>
                                                       <th style="min-width: 250px;" >Raw Material Code</th>
                                                       <th style="min-width: 100px;">Length or Sieve Size</th>
                                                       <th>Breadth</th>
                                                       <th>Quantity</th>
                                                       <th>Pointer Weight</th>
                                                       <th>Weight</th>
                                                       <th>LME Rate</th>
                                                       <th>Sale Rate</th>
                                                       <th>Sale Value</th>
                                                       <th>Customer Rate</th>
                                                       <th>Customer Value</th>
                                                       <th>Quantity / Weight</th>
                                                       <th style="min-width: 180px;">Setting Code</th>
                                                       <th>Setting Rate</th>
                                                       <th>Setting Value</th>
                                                       <th>Setting Customer Rate</th>
                                                       <th>Setting Customer Value</th>
                                                       <th>Alloy Code</th>
                                                       <th>Alloy Sale Rate</th>
                                                       <th>Alloy Customer Rate</th>
                                                       <th>WAX Set Quantity</th>
                                                       <th>Hand Set Quantity</th>
                                                       <th>Sub Shape</th>
                                                       <th>Main Metal</th>
                                                       <th>User (Modified)</th>
                                                       <th>Date (Modified)</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     @if (count($bag_orders_bom_details) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($bag_orders_bom_details as $key => $data)
                                                          <tr  style="text-align: center;">
                                                            <td>{{ $data->OrSrNo  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->OrRmCtg  }}', 'table', this, 'raw_material_category')">{{ $data->OrRmCtg  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->OrRmSCtg  }}', 'table', this, 'raw_material_sub_category', '{{ $data->OrRmCtg  }}')">{{ $data->OrRmSCtg  }}</td>
                                                            <td>{{ $data->OrRmCd  }} @if(isset($data->RmDesc)) ({{ $data->RmDesc  }}) @endif</td>
                                                            <td>{{ round($data->OrLn1, 4)  }}</td>
                                                            <td>{{ round($data->OrLn2, 4)  }}</td>
                                                            <td>{{ $data->OrQty  }}</td>
                                                            <td>{{ round($data->OrRmPtr, 4)  }}</td>
                                                            <td>{{ round($data->OrWt, 4)  }}</td>
                                                            <td>{{ round($data->OrLmeSal, 4)  }}</td>
                                                            <td>{{ round($data->OrSalRt, 4)  }}</td>
                                                            <td>{{ round($data->OrSalVal, 4)  }}</td>
                                                            <td>{{ round($data->OrCstRt, 4)  }}</td>
                                                            <td>{{ round($data->OrCstVal, 4)  }}</td>
                                                            <td>**</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->OrSetScd  }}', 'table', this, 'setting_code')">{{ $data->OrSetScd  }}</td>
                                                            <td>{{ round($data->OrSetSalRt, 4)  }}</td>
                                                            <td>{{ round($data->OrSetSalVal, 4)  }}</td>
                                                            <td>{{ round($data->OrSetCstRt, 4)  }}</td>
                                                            <td>{{ round($data->OrSetCstVal, 4)  }}</td>
                                                            <td>{{ $data->OrAlyCd  }}</td>
                                                            <td>{{ round($data->OrAlySalRt, 4)  }}</td>
                                                            <td>{{ round($data->OrAlyCstRt, 4)  }}</td>
                                                            <td>{{ $data->OrWsQty  }}</td>
                                                            <td>{{ $data->OrHsQty  }}</td>
                                                            <td>{{ $data->OrSubShp  }}</td>
                                                            <td>{{ $data->OrMainMet  }}</td>
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

                                             </br>
                                             </br>
                                             <div class="x_title">
                                                 <div class="clearfix" style="font-weight: 550;color: black;"> BOM Summary</div>
                                             </div>
                                             <div class="table-responsive">
                                               <table id="new-datatable-3" class="table table-striped table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th>Raw Material Category</th>
                                                       <th>Raw Material Sub Category</th>
                                                       <th>Quantity</th>
                                                       <th>Weight</th>
                                                       <th>Total Quantity</th>
                                                       <th>Total Weight</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     @if (count($bom_summary) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($bom_summary as $key => $data)
                                                          <tr  style="text-align: center;">
                                                            <td>{{ $count++  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data['category']  }}', 'table', this, 'raw_material_category')">{{ $data['category']  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data['sub_category']  }}', 'table', this, 'raw_material_sub_category', '{{ $data['category']  }}')">{{ $data['sub_category']  }}</td>
                                                            <td>{{ round($data['quantity'], 4)  }}</td>
                                                            <td>{{ round($data['weight'], 4)  }}</td>
                                                            <td>{{ round($data['total_quantity'], 4)  }}</td>
                                                            <td>{{ round($data['total_weight'], 4)  }}</td>
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


                                         <div class="tab-pane fade" id="emp2" role="tabpanel" aria-labelledby="emp2-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>

                                             <div class="">



                                               <div class="form-group row order-form ">

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Order No.</label>
                                                     <div class="col-sm-9">
                                                       <a href="/emporer/orders/ordersDetails?OmTc={{ $bag_details->BOdTc}}&OmYy={{ $bag_details->BOdYy}}&OmChr={{ $bag_details->BOdChr}}&OmNo={{ $bag_details->BOdNo}}&company_code={{ $bag_details->BCoCd}}"  >
                                                         <input type="text" readonly class="form-control from-custom-style " style="color: green;" value="@if(isset($bag_details->order_no)){{ $bag_details->order_no }}@endif"  >
                                                       </a>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Suffix</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOdSfx)){{ $bag_details->BOdSfx }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Open Date</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOpnDt)){{ date('D, d-m-Y', strtotime($bag_details->BOpnDt) ) }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Design</label>
                                                     <div class="col-sm-9">
                                                       <a href="/emporer/design/designDetails?design_code={{ $bag_details->BOdDmCd}}"  >
                                                         <input type="text" readonly style="color: green;" class="form-control from-custom-style" value="@if(isset($bag_details->BOdDmCd)){{ $bag_details->BOdDmCd }}@endif"  >
                                                       </a>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Color</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_design_details->OdDmCol)){{ $bag_orders_design_details->OdDmCol }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Open Quantity</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOpnQty)){{ $bag_details->BOpnQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Size</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOdDmSz)){{ $bag_details->BOdDmSz }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Main Metal</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($main_metal_code)){{ $main_metal_code }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Open Part Quantity</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BOpnPtQty)){{ $bag_details->BOpnPtQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Current Quantity</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="@if(isset($bag_details->BQty)){{ $bag_details->BQty }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Customer</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($bag_orders_details->OmCmCd)){{ $bag_orders_details->OmCmCd .  ' (' . $bag_orders_details->CmName  .')' }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Invoice</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="**"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Sequence</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style "   value="**"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                               </div>
                                             </div>

                                             </br>
                                             <div class="table-responsive">
                                               <table id="new-datatable-2" class="table  table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th colspan="3"></th>
                                                       <th colspan="6">Issue Details</th>
                                                       <th colspan="2">Receipt Details</th>
                                                       <th colspan="9">Raw Material Details</th>
                                                       <th colspan="6">Style Details</th>
                                                       <th colspan="2"></th>
                                                       <!-- <th></th> -->
                                                     </tr>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th style="min-width: 130px;">Date</th>
                                                       <th>Voucher No.</th>
                                                       <th>Location / Sub Location</th>
                                                       <th>Worker</th>
                                                       <th>Quantity</th>
                                                       <th>Part Quantity</th>
                                                       <th>Gross Weight</th>
                                                       <th>Loss</th>
                                                       <th>Location / Sub Location</th>
                                                       <th>Worker</th>
                                                       <th style="min-width: 130px;">Raw Material Category</th>
                                                       <th style="min-width: 130px;">Raw Material Code</th>
                                                       <th style="min-width: 80px;">Lottery No.</th>
                                                       <th style="min-width: 80px;">Raw Material Size / Pointer</th>
                                                       <th style="min-width: 80px;">Location Type</th>
                                                       <th>Quantity In</th>
                                                       <th>Weight In</th>
                                                       <th>Quantity Out</th>
                                                       <th>Weight Out</th>
                                                       <th>Pcs In</th>
                                                       <th>Part In</th>
                                                       <th>Pcs Out</th>
                                                       <th>Part Out</th>
                                                       <th>Reject Pcs</th>
                                                       <th>Reject Part</th>
                                                       <th>User (Modified)</th>
                                                       <th style="min-width: 160px;">Date (Modified)</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $last_issue_location = '';

                                                    $bs_issue_location = '';
                                                    $bs_issue_worker = '';
                                                    $bs_style_qty = '';
                                                    $bs_style_parts_qty = '';
                                                    $bs_style_out_qty = '';
                                                    $bs_style_out_parts_qty = '';

                                                    $dt_issue_location = '';
                                                    $dt_issue_worker = '';

                                                    $mlt_issue_location = '';
                                                    $mlt_issue_worker = '';
                                                    $mlt_reject_qty = '';
                                                    $mlt_reject_part_qty = '';
                                                     ?>
                                                     @if (count($bag_transaction_details) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($bag_transaction_details as $key => $data)

                                                     <?php
                                                     // if( ($data->TdTc == "BS" || $data->TdTc == "DT" ) && $$data->TdSrNo == 0 ) {
                                                     //
                                                     // }
                                                     //
                                                     if( $data->TdTc == "BS"  ) {
                                                       if($data->TdSrNo == 0) {
                                                         $bs_issue_location = $data->TdFrBLoc;
                                                         $bs_issue_worker = $data->TdWrk;
                                                         if($data->TdBDc == "C") { $bs_style_out_qty = $data->TdBQty; $bs_style_out_parts_qty = $data->TdPtQty; }
                                                         if($data->TdBDc == "D") { $bs_style_qty = $data->TdBQty; $bs_style_parts_qty = $data->TdPtQty; }
                                                         // continue;
                                                       }
                                                       else {
                                                         // if($key > 0 && $bag_transaction_details[$key - 1] = "BS") {
                                                         if($key > 0 ) {
                                                           $data->TdFrBLoc = $bs_issue_location;
                                                           $data->TdWrk = $bs_issue_worker;
                                                           $data->style_qty = $bs_style_qty;
                                                           $data->style_parts_qty = $bs_style_parts_qty;
                                                           $data->style_out_qty = $bs_style_out_qty;
                                                           $data->style_out_parts_qty = $bs_style_out_parts_qty;
                                                         }
                                                       }
                                                     }

                                                     if( $data->TdTc == "DT"  ) {
                                                       if($data->TdSrNo == 0) {
                                                         $dt_issue_location = $data->TdFrBLoc;
                                                         $dt_issue_worker = $data->TdWrk;
                                                         // continue;
                                                       }
                                                       else {
                                                         if($key > 0 ) {
                                                           $data->TdFrBLoc = $dt_issue_location;
                                                           $data->TdWrk = $dt_issue_worker;
                                                         }
                                                       }
                                                     }

                                                     if( $data->TdTc == "MLT"  ) {
                                                       if($data->TdSrNo == 0) {
                                                         $mlt_issue_location = $data->TdFrBLoc;
                                                         $mlt_issue_worker = $data->TdWrk;
                                                         $mlt_reject_qty = $data->TdRjQty;
                                                         $mlt_reject_part_qty = $data->TdRjPtQty;
                                                         // continue;
                                                       }
                                                       else {
                                                         if($key > 0 ) {
                                                           $data->TdFrBLoc = $mlt_issue_location;
                                                           $data->TdWrk = $mlt_issue_worker;
                                                           $data->TdRjQty = $mlt_reject_qty;
                                                           $data->TdRjPtQty = $mlt_reject_part_qty;
                                                         }
                                                       }
                                                     }
                                                      ?>

                                                          <tr style="text-align: center;">
                                                            <td>{{ $count++  }}</td>
                                                            <td>{{ date('D, d-m-Y', strtotime($data->TdDt) )  }}</td>
                                                            <!-- <td><a  target="_blank" href="/emporer/transaction/transactionDetails?TTc={{ $data->TdTc}}&TYy={{ $data->TdYy}}&TChr={{ $data->TdChr}}&TNo={{ $data->TdNo}}&company_code={{ $data->TdCoCd}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }}</a>/{{ $data->TdSr}}</td> -->
                                                            <td><a  target="_blank" href="/emporer/transaction/transactionDetails?TTc={{ $data->TdTc}}&TIdNo={{ $data->TdTIdNo}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }}</a>/{{ $data->TdSr}}</td>
                                                            <td>{{ $data->TdFrBLoc  }} @php $last_issue_location = $data->TdFrBLoc  @endphp</td>
                                                            <td>{{ $data->TdWrk  }}</td>
                                                            <td>{{ checkDigits($data->TdBQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdPtQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdBGrWt)  }}</td>
                                                            <td>@if($data->TdToRmLocTyp == "L"){{ checkDigits($data->TdRmWt)  }}@endif</td>
                                                            <td>{{ $data->TdToBLoc  }}</td>
                                                            <td>{{ $data->TdByWrk  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->TdRmCtg  }}', 'table', this, 'raw_material_category')">{{ $data->TdRmCtg  }}</td>
                                                            <td>{{ $data->TdRmCd  }}</td>
                                                            <td>{{ $data->TdLotNo  }}</td>
                                                            <td>{{ $data->TdRmSz  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->TdToRmLocTyp  }}', 'table', this, 'location_type')">{{ $data->TdToRmLocTyp  }}</td>

                                                            @if($data->TdToRmLocTyp == "W")
                                                            <td>{{ checkDigits($data->TdRmQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdRmWt) }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            @elseif($data->TdToRmLocTyp == "B" || $data->TdToRmLocTyp == "S" || $data->TdToRmLocTyp == "M" || $data->TdToRmLocTyp == "XC")
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ checkDigits($data->TdRmQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdRmWt) }}</td>
                                                            @elseif($data->TdToRmLocTyp == "L")
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            @else
                                                            <td>{{ checkDigits($data->TdRmQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdRmWt) }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            @endif

                                                            <td>@if(isset($data->style_qty)){{ checkDigits($data->style_qty)  }}@endif</td>
                                                            <td>@if(isset($data->style_parts_qty)){{ checkDigits($data->style_parts_qty)  }}@endif</td>
                                                            <td>@if(isset($data->style_out_qty)){{ checkDigits($data->style_out_qty)  }}@endif</td>
                                                            <td>@if(isset($data->style_out_parts_qty)){{ checkDigits($data->style_out_parts_qty)  }}@endif</td>
                                                            <td>{{ checkDigits($data->TdRjQty)  }}</td>
                                                            <td>{{ checkDigits($data->TdRjPtQty)  }}</td>
                                                            <td>{{ $data->ModUsr  }}</td>
                                                            <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                           </tr>
                                                     @endforeach

                                                     @php $count_new = 0; @endphp
                                                     @foreach($fg_bag_list as $key => $data)
                                                        @php $count_new++; @endphp
                                                       <tr  style="text-align: center;">
                                                         <td>{{ $count++  }}</td>
                                                         <td>{{ date('D, d-m-Y', strtotime($data->FdDt) )  }}</td>
                                                         <td><a  target="_blank" href="/emporer/finish_good/finishGoodDetails?FgTc={{ $data->FdTc}}&FgIdNo={{ $data->FdFgIdNo}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }}</a>/{{ $data->FdSr}}</td>
                                                         <td>@if($count_new == 1){{ $last_issue_location  }}@endif</td>
                                                         <td></td>
                                                         <td>{{ checkDigits($data->FdQty)  }}</td>
                                                         <td></td>
                                                         <td>{{ checkDigits($data->FdGrWt)  }}</td>
                                                         <td></td>
                                                         <td>{{ $data->FgToBLoc  }}</td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>


                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>

                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td>{{ $data->ModUsr  }}</td>
                                                         <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                        </tr>
                                                      @endforeach

                                                     @foreach($fg_bm_bag_list as $key => $data)
                                                       <tr  style="text-align: center;">
                                                         <td>{{ $count++  }}</td>
                                                         <td>{{ date('D, d-m-Y', strtotime($data->ModDt) )  }}</td>
                                                         <td><a target="_blank" href="/emporer/finish_good/finishGoodDetails?FgTc={{ $data->FmdTc}}&FmdFmIdNo={{ $data->FmdIdNo}}"  style="color: green; font-weight:bold">{{ $data->voucher_no }}</a>/{{ $data->FmdSr}}</td>
                                                         <td>{{ $data->FmdFrFgSubLoc  }}</td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td>{{ $data->FmdToFgSubLoc  }}</td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>


                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>

                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
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




@include('admin.emporer.emporer_script')

@endsection
