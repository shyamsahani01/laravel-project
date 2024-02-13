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
                <div class="col-md-4 form-group order-form">
                  <label for="" class="col-sm-6 col-form-label bold-label">Voucher No</label>
                    <div class="col-sm-6">
                      <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($invoice_details->invoice_no)){{ $invoice_details->invoice_no }}@endif">
                    </div>
                </div>
                <div class="col-md-4 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Date</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control from-custom-style" value="@if(isset($invoice_details->InDt)){{ date('D, d-m-Y', strtotime($invoice_details->InDt)) }}@endif"  >
                  </div>
                </div>
                <!-- <div class="col-md-4 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Currency</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control from-custom-style" value="@if(isset($orders_details->OmCmCurCd)){{ $orders_details->OmCmCurCd }}@endif"  >
                  </div>
                </div> -->
              </div>

              <div class="form-group row order-form">
                <div class="col-md-4 form-group order-form">
                  <label for="" class="col-sm-3 col-form-label bold-label">Customer</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control from-custom-style"  value="@if(isset($invoice_details->InCmCd)){{ $invoice_details->InCmCd . ' - ' . $invoice_details->CmName }}@endif">
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
                                                   <!-- <li class="nav-item">
                                                       <a class="nav-link" id="emp2-tab" data-toggle="tab" href="#emp2" role="tab" aria-controls="emp2" aria-selected="false" style="font-weight: 550;color: black;">Bag</a>
                                                   </li> -->
                                               </ul>
                                               <div class="tab-content" id="myTabContent">
                                                   <div class="tab-pane fade show active" id="emp1" role="tabpanel" aria-labelledby="emp1-tab">
                                                       <div class="x_title">
                                                           <div class="clearfix"></div>
                                                       </div>

                                                       <div class="table-responsive">
                                                         <table id="design-table"  class="table table-striped table-bordered" style="">
                                                            <thead>
                                                               <tr style="text-align: center;">
                                                                 <th>S.NO.</th>
                                                                 <th>JobNo</th>
                                                                 <th>PO No</th>
                                                                 <th>Design</th>
                                                                 <th>Item</th>
                                                                 <!-- <th>CR Code</th> -->
                                                                 @for($i=1; $i<=5; $i++)
                                                                   <th>Metal{{ $i }}</th>
                                                                 @endfor
                                                                 <th>Qty</th>
                                                                 <th>GrWt</th>
                                                                 <th>GoldWt</th>
                                                                 <th>SilWt</th>
                                                                 <th>OthWt</th>
                                                                 <th>Order</th>
                                                                   @for($i=1; $i<=15; $i++)
                                                                     <th>St{{ $i }}Name</th>
                                                                     <th>St{{ $i }}Code</th>
                                                                     <th>St{{ $i }}Qty</th>
                                                                     <th>St{{ $i }}Wt</th>
                                                                   @endfor
                                                                   @for($i=1; $i<=15; $i++)
                                                                     <th>Dia{{ $i }}Name</th>
                                                                     <th>Dia{{ $i }}Code</th>
                                                                     <th>Dia{{ $i }}Size</th>
                                                                     <th>Dia{{ $i }}Qty</th>
                                                                     <th>Dia{{ $i }}Wt</th>
                                                                   @endfor
                                                                  <th>Size</th>
                                                                  <th>InvPrice</th>
                                                                  <!-- <th>Gem Ival</th>
                                                                  <th>Invprice - GemIVal</th> -->
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               @if (isset($invoice_design_details) )
                                                               @php $count = 1 @endphp
                                                               @foreach($invoice_design_details as $key => $data)
                                                                    @php $count++; $bag_no = ''; $sum_gross = 0; $inv_price = 0; $gem_value = 0; @endphp

                                                                    @foreach($data->bag_details as $k2 => $d2)
                                                                         @php $bag_no .= $d2->BNo . ", "; $sum_gross += $d2->BGrWt;  @endphp
                                                                    @endforeach

                                                                    @foreach($data->invoice_design_rm_details as $k3 => $d3)
                                                                         @php $inv_price += $d3->IrSetIVal;  @endphp
                                                                         @if($d3->IrRmSCtg == "STV") @php $gem_value += $d3->IrSetIVal;  @endphp @endif
                                                                    @endforeach
                                                                    <tr  style="text-align: center;" class="">
                                                                      <td>{{ $data->IdSr  }}</td>
                                                                      <td>{{ $bag_no  }}</td>
                                                                      <td>{{ $data->OmPoNo  }}</td>
                                                                      <td>{{ $data->IdDmCd  }}</td>
                                                                      <!-- <td><a href="/emporer/design/designDetails?design_code={{ $data->IdDmCd}}"  style="color: green; font-weight:bold">{{ $data->IdDmCd  }}</a></td> -->
                                                                      <td>{{ $data->DmDesc  }}</td>
                                                                      <!-- <td></td> -->
                                                                      @for($i=1; $i<=5; $i++)
                                                                        <td>@if(isset($data->rm_data["metal_$i"]['name'])){{ $data->rm_data["metal_$i"]['name']  }}@endif</td>
                                                                      @endfor
                                                                      <!-- <td>{{ $data->OdOrdQty  }}</td> -->
                                                                      <td>{{ $data->IdQty  }}</td>
                                                                      <!-- <td>{{ round($sum_gross, 4)  }}</td> -->
                                                                      <td>{{ round($data->sum_gross_wt, 4)  }}</td>
                                                                      <td>{{ round($data->gold_wt, 4)  }}</td>
                                                                      <td>{{ round($data->silver_wt, 4)  }}</td>
                                                                      <td>{{ round($data->other_wt, 4)  }}</td>
                                                                      <td>{{ $data->OmChr . "-" . $data->OmNo }}</td>
                                                                      <!-- <td><a href="/emporer/orders/ordersDetails?OmIdNo={{ $data->OmIdNo}}"  style="color: green;">{{ $data->OmChr . "-" . $data->OmNo }}</a></td> -->
                                                                      @for($i=1; $i<=15; $i++)
                                                                        <td>@if(isset($data->rm_data["colostone_$i"]['name'])){{ $data->rm_data["colostone_$i"]['name']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["colostone_$i"]['code'])){{ $data->rm_data["colostone_$i"]['code']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["colostone_$i"]['qty'])){{ $data->rm_data["colostone_$i"]['qty']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["colostone_$i"]['gross_wt'])){{ round($data->rm_data["colostone_$i"]['gross_wt'], 4)  }}@endif</td>
                                                                      @endfor
                                                                      @for($i=1; $i<=15; $i++)
                                                                        <td>@if(isset($data->rm_data["diamond_$i"]['name'])){{ $data->rm_data["diamond_$i"]['name']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["diamond_$i"]['code'])){{ $data->rm_data["diamond_$i"]['code']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["diamond_$i"]['size'])){{ $data->rm_data["diamond_$i"]['size']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["diamond_$i"]['qty'])){{ $data->rm_data["diamond_$i"]['qty']  }}@endif</td>
                                                                        <td>@if(isset($data->rm_data["diamond_$i"]['gross_wt'])){{ round($data->rm_data["diamond_$i"]['gross_wt'], 4)  }}@endif</td>
                                                                      @endfor
                                                                      <td>{{ $data->OdDmSz  }}</td>
                                                                      <!-- <td>{{ round($inv_price, 4)  }}</td> -->
                                                                      <td>{{ round($data->IdIVal, 4)  }}</td>
                                                                      <!-- <td>{{ round($gem_value, 4)  }}</td>
                                                                      <td>{{ round( ($data->IdIVal - $gem_value), 4)  }}</td> -->
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

file_name  = '@if(isset($invoice_details->invoice_no)){{ str_replace("/", "-", $invoice_details->invoice_no) }}@endif'
$(function() {
  $('#design-table').DataTable( {
    ordering: true,
    dom: 'Bfrtip',
    "lengthMenu": [[-1, 25, 50], ["All", 25, 50]],     // page length options
    buttons: [
      {
        extend: 'excel',
        text: 'EXCEL',
        filename: function(){
                var d = new Date();
                var n = d.getTime();
                // return file_name +'_design_details_' + n;
                return file_name ;
            }
      },
      // {
      //   extend: 'csv',
      //   text: 'CSV',
      //   filename: function(){
      //           var d = new Date();
      //           var n = d.getTime();
      //           return file_name +'_design_details_' + n;
      //       }
      // },
      // {
      //   extend: 'pdf',
      //   text: 'PDF',
      //   filename: function(){
      //           var d = new Date();
      //           var n = d.getTime();
      //           return file_name +'_design_details_' + n;
      //       }
      // },
      'copy', 'pageLength']
  } );

});

</script>

<style>
.dt-buttons.btn-group {
  margin-bottom: -50px;
}
</style>





@endsection
