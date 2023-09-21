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
                         <div class="form-group row order-form col-md-4">

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Design Code</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control-plaintext"  value="@if(isset($design_details->DmCd)){{ $design_details->DmCd }}@endif">
                               </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Design Category</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext parameter-desc"  onclick="getParameterDescription('{{ $design_details->DmCtg  }}', 'input', this)"  value="@if(isset($design_details->DmCtg)){{ $design_details->DmCtg }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Description</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmDesc)){{ $design_details->DmDesc }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-4 col-form-label bold-label">Design Lock (Y/N)</label>
                             <div class="col-sm-8">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmLockYN)){{ $design_details->DmLockYN }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Valid Co Cd</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmValidCoCd)){{ $design_details->DmValidCoCd }}@endif"  >
                             </div>
                           </div>


                         </div>



                         <div class="form-group row order-form col-md-4">

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Size</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmSz)){{ $design_details->DmSz }}@endif"  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">UOM</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmUom)){{ $design_details->DmUom }}@endif"  >
                             </div>
                           </div>
                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">-</label>
                             <div class="col-sm-9">
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Password</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value=""  >
                             </div>
                           </div>

                           <div class="col-md-12 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Valid (Y/N)</label>
                             <div class="col-sm-9">
                               <input type="text" readonly class="form-control-plaintext" value="@if(isset($design_details->DmValidYN)){{ $design_details->DmValidYN }}@endif"  >
                             </div>
                           </div>

                         </div>

                         <div class="form-group row order-form col-md-4">
                           <div class="col-md-12 form-group order-form">
                             @if (WebHelper::get_emr_design_file_location($design_details->DmCtg, $design_details->DmTcTyp, $design_details->DmCd, 'LD') != "")
                             <div class="col-sm-6">
                               <img id='design-LD-{{ $design_details->DmCd  }}' style = "max-height: 200px;" class="col-sm-10" onclick="displayImage('{{ $design_details->DmCd  }}', 'LD')" src="{{ WebHelper::get_emr_design_file_location($design_details->DmCtg, $design_details->DmTcTyp, $design_details->DmCd, 'LD')  }}" >
                             </div>
                             @endif
                             @if (WebHelper::get_emr_design_file_location($design_details->DmCtg, $design_details->DmTcTyp, $design_details->DmCd, '3D') != "")
                             <div class="col-sm-6">
                               <img id='design-3D-{{ $design_details->DmCd  }}' style = "max-height: 200px;" class="col-sm-10" onclick="displayImage('{{ $design_details->DmCd  }}', '3D')" src="{{ WebHelper::get_emr_design_file_location($design_details->DmCtg, $design_details->DmTcTyp, $design_details->DmCd, '3D')  }}" >
                             </div>
                             @endif
                           </div>
                         </div>


                       </div>

                         <div class="form-group row order-form ">
                           <div class="form-group row order-form col-md-4">
                             <div class="col-md-12 form-group order-form">
                               <label for="" class="col-sm-3 col-form-label bold-label">User (Modified)</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->ModUsr)){{ $design_details->ModUsr }}@endif"  >
                               </div>
                             </div>
                           </div>
                           <div class="form-group row order-form col-md-4">
                             <div class="col-md-12 form-group order-form">
                               <label for="" class="col-sm-3 col-form-label bold-label">Date (Modified)</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->ModDt)){{ date('D, d-m-Y', strtotime($design_details->ModDt) ) . ' ' . $design_details->ModTime }}@endif"  >
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
                                         <!-- <li class="nav-item">
                                             <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">Design Detail</a>
                                         </li> -->
                                         <li class="nav-item">
                                             <a class="nav-link active" id="emp1-tab" data-toggle="tab" href="#emp1" role="tab" aria-controls="emp1" aria-selected="true" style="font-weight: 550;color: black;">General</a>
                                         </li>
                                         <!-- <li class="nav-item">
                                             <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">General</a>
                                         </li> -->
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp3-tab" data-toggle="tab" href="#emp3" role="tab" aria-controls="emp3" aria-selected="false" style="font-weight: 550;color: black;">BOM(Bill of Material)</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp4-tab" data-toggle="tab" href="#emp4" role="tab" aria-controls="emp4" aria-selected="false" style="font-weight: 550;color: black;">Lab Details</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="emp5-tab" data-toggle="tab" href="#emp5" role="tab" aria-controls="emp4" aria-selected="false" style="font-weight: 550;color: black;">Analysis</a>
                                         </li>
                                     </ul>
                                     <div class="tab-content" id="myTabContent">
                                         <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>

                                             <div class="">

                                               <div class="form-group row order-form ">

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Production Category</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmPrdCtg  }}', 'input', this)" value="@if(isset($design_details->DmPrdCtg)){{ $design_details->DmPrdCtg }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Sales Category</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmSalCtg  }}', 'input', this)"  value="@if(isset($design_details->DmSalCtg)){{ $design_details->DmSalCtg }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Value Addition Category</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmVaCtg  }}', 'input', this)"  value="@if(isset($design_details->DmVaCtg)){{ $design_details->DmVaCtg }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Loss Category</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmLsCtg  }}', 'input', this)" value="@if(isset($design_details->DmLsCtg)){{ $design_details->DmLsCtg }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Karat</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmKt)){{ $design_details->DmKt }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Bag Pcs</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmBagPcs)){{ $design_details->DmBagPcs }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Set Family Code</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmSetCd  }}', 'input', this)"  value="@if(isset($design_details->DmSetCd)){{ $design_details->DmSetCd }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Old Code</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmOldCd)){{ $design_details->DmOldCd }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Color</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmCol  }}', 'input', this)"  value="@if(isset($design_details->DmCol)){{ $design_details->DmCol }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Customer Code</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmCmCd)){{ $design_details->DmCmCd }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label"> Design for Customer Group (Y/N)</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmCmGrp)){{ $design_details->DmCmGrp }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Parts</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmParts)){{ $design_details->DmParts }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Part Description</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmPartDesc)){{ $design_details->DmPartDesc }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Design On Hold</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmHld)){{ $design_details->DmHld }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Design Hold Description</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmHldDesc)){{ $design_details->DmHldDesc }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Default Size</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmDefSz)){{ $design_details->DmDefSz }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Process Sequence</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc"  onclick="getParameterDescription('{{ $design_details->DmPrcsSeq  }}', 'input', this)"  value="@if(isset($design_details->DmPrcsSeq)){{ $design_details->DmPrcsSeq }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Production Sequence</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style parameter-desc" onclick="getParameterDescription('{{ $design_details->DmPrdSeq  }}', 'input', this)"   value="@if(isset($design_details->DmPrdSeq)){{ $design_details->DmPrdSeq }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-4 col-form-label bold-label">Production Instruction</label>
                                                     <div class="col-sm-8">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmPrdInst)){{ $design_details->DmPrdInst }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Design Date </label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmDsgDt)){{ date('D, d-m-Y', strtotime($design_details->DmDsgDt) ) }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Design By</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmDsgBy)){{ $design_details->DmDsgBy }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Created Date</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmCreatedDt)){{ date('D, d-m-Y', strtotime($design_details->DmCreatedDt) ) }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Model Maker</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmModMkr)){{ $design_details->DmModMkr }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Last Modified</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmLstMdf)){{ $design_details->DmLstMdf }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-3 col-form-label bold-label">Wax Weight</label>
                                                     <div class="col-sm-9">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmWaxWt)){{ $design_details->DmWaxWt }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Model Weight with Runner</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmModRunWt)){{ $design_details->DmModRunWt }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Casting Piece Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmCasPcWt)){{ $design_details->DmCasPcWt }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-6 col-form-label bold-label">Source Sketch / Design Code</label>
                                                     <div class="col-sm-6">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmSrcDsgCd)){{ $design_details->DmSrcDsgCd }}@endif"  >
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Silver Model Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmSilModWt)){{ round($design_details->DmSilModWt, 4) }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>

                                                 <div class="form-group row order-form col-md-12">
                                                   <div class="col-md-4 form-group order-form">
                                                     <label for="" class="col-sm-5 col-form-label bold-label">Total Diamond Weight</label>
                                                     <div class="col-sm-7">
                                                       <input type="text" readonly class="form-control from-custom-style" value="@if(isset($design_details->DmTotDiaWt)){{ $design_details->DmTotDiaWt }}@endif"  >
                                                     </div>
                                                   </div>
                                                 </div>



                                               </div>


                                             </div>

                                        </div>

                                         <div class="tab-pane fade" id="emp2" role="tabpanel" aria-labelledby="emp2-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">



                                             </div>

                                         </div>

                                         <div class="tab-pane fade" id="emp3" role="tabpanel" aria-labelledby="emp3-tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                               <table id="new-datatable-2" class="table table-striped table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th>Raw Material Category</th>
                                                       <th>Raw Material Sub Category</th>
                                                       <th>Raw Material Code</th>
                                                       <th>Length or Sieve Size</th>
                                                       <th>Breadth</th>
                                                       <th>Product Quantity</th>
                                                       <th>Pointer Weight</th>
                                                       <th>Product Weight</th>
                                                       <!-- <th>Production Quantity</th>
                                                       <th>Production Weight</th> -->
                                                       <th>Setting Code</th>
                                                       <th>WAX Set Quantity</th>
                                                       <th>Hand Set Quantity</th>
                                                       <th>Sub Shape</th>
                                                       <th>Alloy Code</th>
                                                       <th>Main Metal</th>
                                                       <th>User (Modified)</th>
                                                       <th>Date (Modified)</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     @if (count($design_bom_details) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($design_bom_details as $key => $data)
                                                          <tr  style="text-align: center;">
                                                            <td>{{ $data->DrSr  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DrRmCtg  }}', 'table', this,  'raw_material_category')">{{ $data->DrRmCtg  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DrRmSCtg  }}', 'table', this, 'raw_material_sub_category', '{{ $data->DrRmCtg  }}' )">{{ $data->DrRmSCtg  }}</td>
                                                            <td>{{ $data->DrRmCd  }} @if(isset($data->RmDesc)) ({{ $data->RmDesc  }}) @endif</td>
                                                            <td>{{ round($data->DrLn1, 4)  }}</td>
                                                            <td>{{ round($data->DrLn2, 4)  }}</td>
                                                            <!-- <td>{{ $data->DrQty  }}</td> -->
                                                            <td>{{ $data->DrPrdQty  }}</td>
                                                            <td>{{ round($data->DrRmPtr, 4)  }}</td>
                                                            <!-- <td>{{ round($data->DrWt, 4)  }}</td> -->
                                                            <!-- <td>{{ $data->DrPrdQty  }}</td> -->
                                                            <td>{{ round($data->DrPrdWt, 4)  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DrSetSCd  }}', 'table', this, 'setting_code')">{{ $data->DrSetSCd  }}</td>
                                                            <td>{{ $data->DrWsQty  }}</td>
                                                            <td>{{ $data->DrHsQty  }}</td>
                                                            <td>{{ $data->DrSubShp  }}</td>
                                                            <td>{{ $data->DrAlyCd  }}</td>
                                                            <td>{{ $data->DrMainMet  }}</td>
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

                                         <div class="tab-pane fade" id="emp4" role="tabpanel" aria-labelledby="emp4tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                               <table id="new-datatable-3" class="table table-striped table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th>Labour Main Code</th>
                                                       <th>Labour Sub Code</th>
                                                       <th>By Quantity / Weight</th>
                                                       <th>Quantity</th>
                                                       <th>User (Modified)</th>
                                                       <th>Date (Modified)</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     @if (count($design_lab_details) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($design_lab_details as $key => $data)
                                                          <tr  style="text-align: center;">
                                                            <td>{{ $data->DlSr  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DlMCd  }}', 'table', this, 'labour_main_code')">{{ $data->DlMCd  }}</td>
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DlSCd  }}', 'table', this, 'labour_sub_code', '{{ $data->DlMCd  }}')">{{ $data->DlSCd }}</td>
                                                            <td>@if($data->DlSr == 1) {{ 'Q' }}@endif</td>
                                                            <td>{{ $data->DlQty  }}</td>
                                                            <td>{{ $data->ModUsr  }}</td>
                                                            <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                           </tr>
                                                     @endforeach
                                                  @else
                                                    <tr>
                                                      <td colspan="7" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                                     </tr>
                                                  @endif
                                                  </tbody>
                                               </table>
                                             </div>
                                         </div>

                                         <div class="tab-pane fade" id="emp5" role="tabpanel" aria-labelledby="emp5tab">
                                             <div class="x_title">
                                                 <div class="clearfix"></div>
                                             </div>
                                             <div class="table-responsive">
                                               <table id="new-datatable-4" class="table table-striped table-bordered" style="">
                                                  <thead>
                                                     <tr style="text-align: center;">
                                                       <th>S.NO.</th>
                                                       <th>Analysis Name</th>
                                                       <th>Analysis Code </th>
                                                       <th>Analysis Description</th>
                                                       <th>User (Modified)</th>
                                                       <th>Date (Modified)</th>
                                                     </tr>
                                                  </thead>
                                                  <tbody>
                                                     @if (count($design_analysis_details) > 0)
                                                     @php $count = 1 @endphp
                                                     @foreach($design_analysis_details as $key => $data)
                                                          <tr  style="text-align: center;">
                                                            <td>{{ $data->DaAnaSr  }}</td>
                                                            <td>@if($data->DaAnaSr == 1) {{ 'Collection' }}@elseif($data->DaAnaSr == 2) {{ 'CAD' }}@elseif($data->DaAnaSr == 3) {{ 'CR App' }}@endif</td>
                                                            <!-- <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DaAnaCd  }}', 'table', this,
                                                              '@if($data->DaAnaSr == 1) {{ 'analysis_collection' }}@elseif($data->DaAnaSr == 2) {{ 'analysis_cad' }}@elseif($data->DaAnaSr == 3) {{ 'analysis_cr_app' }}@endif')">
                                                              {{ $data->DaAnaCd  }} @if(isset($data->description))  ({{ $data->description  }})@endif</td> -->
                                                            <td class="parameter-desc" onclick="getParameterDescription('{{ $data->DaAnaCd  }}', 'table', this,
                                                              '@if($data->DaAnaSr == 1){{ 'analysis_collection' }}@elseif($data->DaAnaSr == 2){{ 'analysis_cad' }}@elseif($data->DaAnaSr == 3){{ 'analysis_cr_app' }}@endif')">
                                                              {{ $data->DaAnaCd  }} </td>
                                                            <td>{{ $data->DaAnaDesc  }}</td>
                                                            <td>{{ $data->ModUsr  }}</td>
                                                            <td>{{ date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime }}</td>
                                                           </tr>
                                                     @endforeach
                                                  @else
                                                    <tr>
                                                      <td colspan="6" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
