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
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->voucher_no)){{ $fg_details->voucher_no }}@endif">
                               </div>
                           </div>
                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Company</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FmCoCd)){{ $fg_details->FmCoCd  }}@endif">
                               </div>
                           </div>
                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-3 col-form-label bold-label">Date</label>
                               <div class="col-sm-9">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FmDt)){{ date('D, d-m-Y', strtotime($fg_details->FmDt) ) }}@endif">
                               </div>
                           </div>
                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">To FG Sub Location</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="**">
                               </div>
                           </div>
                         </div>

                         <div class="form-group row order-form col-md-12">
                           <div class="col-md-6 form-group order-form">
                             <label for="" class="col-sm-6 col-form-label bold-label">Description</label>
                               <div class="col-sm-6">
                                 <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($fg_details->FmDesc)){{ $fg_details->FmDesc  }}@endif">
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
                                                         <th>Design Code</th>
                                                         <th>Suffix</th>
                                                         <th>Size</th>
                                                         <th>Company</th>
                                                         <th>FROM FG Sub Location</th>
                                                         <th>To FG Sub Location</th>
                                                         <th>User (Modified)</th>
                                                         <th>Date (Modified)</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       @if (count($fg_bag_list) > 0)
                                                       @php $count = 1;  @endphp
                                                       @foreach($fg_bag_list as $key => $data)
                                                            <tr  style="text-align: center;">
                                                              <td>{{ $data->FmdSr  }}</td>
                                                              <td><a href="javascript:void(0)" >{{ $data->bag_no  }}</a></td>
                                                              <!-- <td><a href="/emporer/bag/bagDetails?BYy={{ $data->FmdBYy}}&BChr={{ $data->FmdBChr}}&BNo={{ $data->FmdBNo}}&company_code={{ $data->FmdCoCd}}"  style="color: green; font-weight:bold">{{ $data->bag_no  }}</a></td> -->
                                                              <td><a href="/emporer/design/designDetails?design_code={{ $data->BOdDmCd}}"  style="color: green;">{{ $data->BOdDmCd  }}</td>
                                                              <td>{{ $data->BOdSfx  }}</td>
                                                              <td>{{ $data->BOdDmSz  }}</td>
                                                              <td>{{ $data->FmdCoCd  }}</td>
                                                              <td>{{ $data->FmdFrFgSubLoc  }}</td>
                                                              <td>{{ $data->FmdToFgSubLoc  }}</td>
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






@include('admin.emporer.emporer_script')

@endsection
