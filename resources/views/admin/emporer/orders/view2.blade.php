@extends('admin.layout.app')
@section('content')

@php
use App\Library\WebHelper;
@endphp


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

              <div class="form-group row order-form">
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Order No.</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext"  value="@if(isset($orders_details->order_no)){{ $orders_details->order_no }}@endif">
                    </div>
                </div>

                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Client Code</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmCmCd)){{ $orders_details->OmCmCd }}@endif"  >
                  </div>
                </div>
              </div>

              <div class="form-group order-form row">
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Order Date</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext"  value="@if(isset($orders_details->OmDt)){{ date('D, d-m-Y', strtotime($orders_details->OmDt)) }}@endif">
                    </div>
                </div>
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Client Name</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->CmName)){{ $orders_details->CmName }}@endif"  >
                  </div>
                </div>
              </div>


              <div class="form-group order-form row">
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Expected Delivery Date</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmExpDelDt)){{ date('D, d-m-Y',strtotime($orders_details->OmExpDelDt)) }}@endif"  >
                  </div>
                </div>
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Purchase Order No.</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmPoNo)){{ $orders_details->OmPoNo }}@endif"  >
                  </div>
                </div>
              </div>

              <div class="form-group order-form row">
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">User ID</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->ModUsr)){{ $orders_details->ModUsr }}@endif"  >
                  </div>
                </div>
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Purchase Order Date</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmPoNo)){{ date('D, d-m-Y',strtotime($orders_details->OmPoDt)) }}@endif"  >
                  </div>
                </div>
              </div>

              <div class="form-group order-form row">
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Company</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmCoCd)){{ $orders_details->OmCoCd }}@endif"  >
                  </div>
                </div>
                <div class="col-md-6 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Company Currency</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="@if(isset($orders_details->OmCmCurCd)){{ $orders_details->OmCmCurCd }}@endif"  >
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
                                                       <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">Design</a>
                                                   </li>
                                                   <li class="nav-item">
                                                       <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">Bag</a>
                                                   </li>
                                               </ul>
                                               <div class="tab-content" id="myTabContent">
                                                   <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                                       <div class="x_title">
                                                           <div class="clearfix"></div>
                                                       </div>

                                                       <div class="table-responsive">
                                                         <table  class="table table-striped table-bordered" style="">
                                                            <thead>
                                                               <tr style="text-align: center;">
                                                                 <!-- <th>Button</th> -->
                                                                 <th>S.NO.</th>
                                                                 <th>Design Code</th>
                                                                 <th>Design Image</th>
                                                                 <th>Suffix</th>
                                                                 <th>Size</th>
                                                                 <th>Order Qunatity</th>
                                                                 <th>Product Qunatity</th>
                                                                 <th>Balance Qunatity</th>
                                                                 <th>Export Qunatity</th>
                                                                 <th>FG Qunatity</th>
                                                                 <th>Sale Price</th>
                                                                 <th>Customer Price</th>
                                                                 <th>Karat</th>
                                                                 <th style="min-width: 200px;">Production Instruction</th>
                                                                 <th style="min-width: 200px;">Customer Instruction</th>
                                                                 <th style="min-width: 200px;">Stamp Instruction</th>
                                                                 <th style="min-width: 200px;">Size Instruction</th>
                                                                 <th>Customer Code</th>
                                                                 <th style="min-width: 125px;">Delivery Date</th>
                                                                 <th>Product Sequence</th>
                                                                 <th>User (Modified)</th>
                                                                 <th style="min-width: 125px;">Date (Modified)</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               @if (count($orders_design_details) > 0)
                                                               @php $count = 1 @endphp
                                                               @foreach($orders_design_details as $key => $data)
                                                                    <tr  style="text-align: center;">
                                                                      <td>{{ $data->OdSr  }}</td>
                                                                      <td><a href="/emporer/design/designDetails?design_code={{ $data->OdDmCd}}"  style="color: green;">{{ $data->OdDmCd  }}</td>
                                                                      <td style="text-align: center;" >
                                                                        @if (WebHelper::get_emr_design_file_location($data->DmCtg, $data->DmTcTyp, $data->DmCd) != "")
                                                                        <img id='design-{{ $data->OdSr  }}' src='{{ WebHelper::get_emr_design_file_location($data->DmCtg, $data->DmTcTyp, $data->DmCd)  }}' onclick=displayImage({{ $data->OdSr  }})  width='150' height='150'>
                                                                        <!-- <img id='design-{{ $data->OdSr  }}' src='{{ WebHelper::get_emr_design_file_location($data->DmCtg, $data->DmTcTyp, $data->DmCd)  }}' class='zoom-images' width='150' height='150'> -->
                                                                        <!-- <button type='button' class='btn btn-primary btn_size_1' onclick=displayImage({{ $data->OdSr  }}) >
                                                                            <i class='fa fa-eye btn_icon'></i>
                                                                        </button> -->
                                                                        @endif
                                                                      </td>
                                                                      <td>{{ $data->OdSfx  }}</td>
                                                                      <td>{{ $data->OdDmSz  }}</td>
                                                                      <td>{{ $data->OdOrdQty  }}</td>
                                                                      <td>{{ $data->OdPrdQty  }}</td>
                                                                      <td></td>
                                                                      <td>{{ $data->OdExpQty  }}</td>
                                                                      <td>{{ $data->OdFgQty  }}</td>
                                                                      <td>{{ round($data->OdSalPrc, 4)  }}</td>
                                                                      <td>{{ round($data->OdCstPrc, 4)  }}</td>
                                                                      <td>{{ $data->OdKt  }}</td>
                                                                      <td>{{ $data->OdDmPrdInst  }}</td>
                                                                      <td>{{ $data->OdCmPrdInst  }}</td>
                                                                      <td>{{ $data->OdCmStmpInst  }}</td>
                                                                      <td>{{ $data->OdSzInst  }}</td>
                                                                      <td>{{ $data->OdOmCmCd  }}</td>
                                                                      <td>{{ date("D, d-m-Y",strtotime($data->OdDelDt)) }}</td>
                                                                      <td>{{ $data->OdPrdSeq  }}</td>
                                                                      <td>{{ $data->ModUsr  }}</td>
                                                                      <td>{{ date("D, d-m-Y",strtotime($data->ModDt)) . ' ' . $data->ModTime }}</td>
                                                                     </tr>
                                                               @endforeach
                                                            @else
                                                              <tr>
                                                                <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
                                                       <div class="table-responsive">
                                                         <table  class="table table-striped table-bordered" style="">
                                                            <thead>
                                                               <tr style="text-align: center;">
                                                                 <th>S.NO.</th>
                                                                 <th>Bag Year</th>
                                                                 <th>Bag Character</th>
                                                                 <th>Bag No.</th>
                                                                 <th>Order Serial No.</th>
                                                                 <th style="min-width: 125px;">Design Code</th>
                                                                 <th>Suffix</th>
                                                                 <th>Size</th>
                                                                 <th>Open Quantity</th>
                                                                 <th>Openning Part Quantity</th>
                                                                 <th style="min-width: 125px;">Open Date</th>
                                                                 <th>Open Location</th>
                                                                 <th>Bag Location</th>
                                                                 <th>Quantity</th>
                                                                 <th>Parts</th>
                                                                 <th>Gross Weight</th>
                                                                 <th style="min-width: 125px;" >Received Date</th>
                                                                 <th>Worker</th>
                                                                 <th>Rejected Bag(Y/N)</th>
                                                                 <th>Rejected Bag Quantity</th>
                                                                 <th>Rejected Bag Parts Quantity</th>
                                                                 <th>FG Sub Location</th>
                                                                 <th>User (Modified)</th>
                                                                 <th style="min-width: 125px;">Date (Modified)</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               @if (count($orders_bag_details) > 0)
                                                               @php $count = 1 @endphp
                                                               @foreach($orders_bag_details as $key => $data)
                                                                    <tr  style="text-align: center;">
                                                                      <td>{{ $count++  }}</td>
                                                                      <td>{{ $data->BYy  }}</td>
                                                                      <td>{{ $data->BChr  }}</td>
                                                                      <td>{{ $data->BNo  }}</td>
                                                                      <td>{{ $data->BOdSr  }}</td>
                                                                      <td><a href="/emporer/design/designDetails?design_code={{ $data->BOdDmCd}}"  style="color: green;">{{ $data->BOdDmCd  }}</td>
                                                                      <td>{{ $data->BOdSfx  }}</td>
                                                                      <td>{{ $data->BOdDmSz  }}</td>
                                                                      <td>{{ $data->BOpnQty  }}</td>
                                                                      <td>{{ $data->BOpnPtQty  }}</td>
                                                                      <td>{{ date("D, d-m-Y",strtotime($data->BOpnDt)) }}</td>
                                                                      <!-- <td class="parameter-desc" onclick="getParameterDescription('{{ $data->BOpnLoc  }}', 'table', this)">{{ $data->BOpnLoc  }}</td>
                                                                      <td class="parameter-desc" onclick="getParameterDescription('{{ $data->BLoc  }}', 'table', this)">{{ $data->BLoc  }}</td> -->
                                                                      <td>{{ $data->BOpnLoc  }}</td>
                                                                      <td>{{ $data->BLoc  }}</td>
                                                                      <td>{{ $data->BQty  }}</td>
                                                                      <td>{{ $data->BPtQty  }}</td>
                                                                      <td>{{ round($data->BGrWt, 4)  }}</td>
                                                                      <td>{{ date("D, d-m-Y",strtotime($data->BRecvDt)) }}</td>
                                                                      <td>{{ $data->BWrk  }}</td>
                                                                      <td></td>
                                                                      <td>{{ $data->BRjQty  }}</td>
                                                                      <td>{{ $data->BRjPtQty  }}</td>
                                                                      <td>{{ $data->BFgSubLoc  }}</td>
                                                                      <td>{{ $data->ModUsr  }}</td>
                                                                      <td>{{ date("D, d-m-Y",strtotime($data->ModDt)) . ' ' . $data->ModTime }}</td>
                                                                     </tr>
                                                               @endforeach
                                                            @else
                                                              <tr>
                                                                <td colspan="12" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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

<script>




</script>



@endsection
