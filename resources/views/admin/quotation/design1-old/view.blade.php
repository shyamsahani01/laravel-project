@extends('admin.layout.app')
@section('content')
<script>
   last_form_id = 0;
</script>
<div class="main-panel">
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
              <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">

                <form id="quotation-form" method="POST" onsubmit="event.preventDefault(); add_quotation();">
                  <div class="x_title">
                      <h2 style="font-size: 1.25rem;">Quotation Details</h2>
                        <!-- <button type="submit" class="btn btn-success design1-form1-btn"><i class="fa fa-paper-plane"></i></button> -->
                        <a href="{{url('quotation/quotation_design/edit?quotation_id='. request()->quotation_id .'&quoation_form_type='.$quotation_data->quoation_form_type )}}" title="Edit" class="btn btn-primary btn_space design1-form1-btn" style="color: white;">Edit</a>
                        <a href="{{url('quotation/quotation_design/export?quotation_id='. request()->quotation_id .'&quoation_form_type='.$quotation_data->quoation_form_type )}}" title="Export" class="btn btn-primary btn_space design1-form1-btn" style="color: white;">Excel Export</a>
                      <div class="clearfix"></div>
                    </div>
                   <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@else{{0}}@endif">
                    <input type="hidden" name="quotation_design_type_id" id="quotation-form-quotation_design_type_id" value="2">
                   <div class="x_content">
                      <div class="row">
                         <div class="col-md-6 col-sm-12  form-group">
                           <label class="diesign1-form1">Name</label>
                            <input type="text" disabled placeholder="Quotation Name" name="name" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                           <label class="diesign1-form1">Title</label>
                            <input type="text" disabled placeholder="Title" name="owner" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->title)){{ $quotation_data->title }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                           <label class="diesign1-form1">Sales Person Name</label>
                            <input type="text" disabled placeholder="Sales Person Name" name="owner" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->owner)){{ $quotation_data->owner }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                           <label class="diesign1-form1">Customer Name</label>
                            <input type="text" disabled placeholder="Customer Name" name="customer_name" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->customer_name)){{ $quotation_data->customer_name }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                           <label class="diesign1-form1">Date</label>
                            <input type="date" disabled name="transaction_date" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                            <label class="diesign1-form1">Status</label>
                            <input type="text" disabled name="status" autocomplete="off"  class="form-control diesign1-form1-input" value="@if(isset($quotation_data->status)){{ $quotation_data->status }}@endif">
                         </div>
                      </div>
                   </div>
                </form>

              </div>
              <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                <form id="quotation-form" method="POST" onsubmit="event.preventDefault(); add_quotation();">
                  <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($quotation_data->id)){{ $quotation_data->id }}@endif">
                <div class="x_title">
                     <h2 style="font-size: 1.25rem;">Quotation Description</h2>
                     <div class="clearfix"></div>
                   </div>
                   <div class="x_content">
                      <div class="row">
                         <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Quotation Name</label>
                            <input type="text" disabled name="metal_kittco_gold" autocomplete="off"  class="form-control" value="@if(isset($design_header_data->metal_kittco_gold)){{ '$'.$design_header_data->metal_kittco_gold }}@endif">
                         </div>
                         <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">USD Conversion</label>
                         <input type="text" disabled name="usd_conversion" autocomplete="off"  class="form-control" value="@if(isset($design_header_data->usd_conversion)){{ '$'.$design_header_data->usd_conversion }}@endif">
                        </div>
                         <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Metal Kitco Silver</label>
                            <input type="text" disabled name="metal_kittco_silver" autocomplete="off"  class="form-control" value="@if(isset($design_header_data->metal_kittco_silver)){{ '$'.$design_header_data->metal_kittco_silver }}@endif">
                         </div>
                      </div>
                   </div>
                </form>
              </div>
              <div class="shadow-lg p-3 mb-5 bg-white rounded">
                <div class="x_title">
                     <h2 style="font-size: 1.25rem;">Design Table</h2>
                     <div class="clearfix"></div>
                   </div>
                   <div class="table-responsive">
                      <table id="designtable" class="table table-striped table-bordered" style="width:100%;">
                         <thead>

                           <tr>
                              <th class="design1-form1-table1-thead">S.No</th>
                              <th class="design1-form1-table1-thead">Image</th>
                              <th class="design1-form1-table1-thead">Description</th>
                              <th class="design1-form1-table1-thead">Product Type</th>
                              <th class="design1-form1-table1-thead">Size</th>
                              <th class="design1-form1-table1-thead">Model No.</th>
                              <th class="design1-form1-table1-thead">Their Code</th>
                              <th class="design1-form1-table1-thead">Order Qty</th>
                              <th class="design1-form1-table1-thead">Metal</th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Metal Kitco Silver / 31.1" class="table-auto_calculated">Metal Per Gms</a></th>
                              <th class="design1-form1-table1-thead">Metal Weight</th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Metal Per Gms*Metal Weight * 1.1" class="table-auto_calculated">Metal Value Including Wastage 10 %</a></th>
                              <th class="design1-form1-table1-thead">Labour</th>
                              <th colspan="2" class="design1-form1-table1-thead">Labour</th>
                              <th class="design1-form1-table1-thead">Total Labour</th>
                              <th class="design1-form1-table1-thead1"><a href="javascript:void(0)" title="Metal Value Including Wastage 10 % + Total Labour" class="table-auto_calculated">Metal & Labour Cost</a></th>
                              <th class="design1-form1-table1-thead1"><a href="javascript:void(0)" title="Metal & Labour Cost * 15%" class="table-auto_calculated">Value Addition- ( Silver 15% )</a></th>
                              <th class="design1-form1-table1-thead1">Rhodium</th>
                              <th class="design1-form1-table1-thead1">Gold Plating</th>
                              <th class="design1-form1-table1-thead1">PD</th>
                              <th class="design1-form1-table1-thead1"><a href="javascript:void(0)" title="Sum Of Stone Value" class="table-auto_calculated">Total Stone Value</a></th>
                              <th class="design1-form1-table1-thead2"><a href="javascript:void(0)" title="Sum(Metal & Labour Cost + Value Addition( Silver 15% ) + Rhodium + Gold Plating + PD + Total Stone Value)" class="table-auto_calculated">Price in USD</a></th>
                              <th class="design1-form1-table1-thead2"><a href="javascript:void(0)" title="Price in USD * 0.96" class="table-auto_calculated">Price in Euro</a></th>
                              <th class="design1-form1-table1-thead">Gem Variation</th>
                              <th class="design1-form1-table1-thead">Stone</th>
                              <th class="design1-form1-table1-thead">Shape</th>
                              <th class="design1-form1-table1-thead">Cut</th>
                              <th class="design1-form1-table1-thead">Setting</th>
                              <th class="design1-form1-table1-thead2">Setting Rate</th>
                              <th class="design1-form1-table1-thead">L</th>
                              <th class="design1-form1-table1-thead">W</th>
                              <th class="design1-form1-table1-thead">Qty</th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Qty * 1.88" class="table-auto_calculated">Weight</a></th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Sale Price / Labour" class="table-auto_calculated">Price</a></th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Price * Weight" class="table-auto_calculated">Stone Value</a></th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Total Sum Of Qty" class="table-auto_calculated">Total Stone</a></th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Total Sum Of Weight" class="table-auto_calculated">TCW</a></th>
                              <th class="design1-form1-table1-thead">Purchase Price</th>
                              <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Purchase Price * 1.5" class="table-auto_calculated">Sale Price</a></th>
                              <th class="design1-form1-table1-thead2"></th>
                              <th class="design1-form1-table1-thead2"></th>
                          </tr>
                         </thead>
                         <tbody id="design-table-body">

                            @php
                               $count = 0;
                            @endphp
                            @if(!empty($design_data))
                            @foreach($design_data as $data)
                            @php $count++;  @endphp
                            @php
                            $image_url = 'https://erp.pinkcityindia.com'. $data->image;
                             $current_row = $data->current_row;
                             $labour_type = json_decode($data->labour_type);
                             $labour_rate = json_decode($data->labour_rate);
                             $labour_value = json_decode($data->labour_value);
                             $gem_variation = json_decode($data->gem_variation);
                             $stone = json_decode($data->stone);
                             $shape = json_decode($data->shape);
                             $cut = json_decode($data->cut);
                             $setting = json_decode($data->setting);
                             $setting_rate = json_decode($data->setting_rate);
                             $l = json_decode($data->l);
                             $w = json_decode($data->w);
                             $qty = json_decode($data->qty);
                             $weight = json_decode($data->weight);
                             $price = json_decode($data->price);
                             $stone_value = json_decode($data->stone_value);
                             $purchase_price = json_decode($data->purchase_price);
                             $sale_price = json_decode($data->sale_price);

                             $labour_type_array=["CPW", "Setting", "Finding", "Rhodium", "Gold Plating", "PD"];
                             $labour_value_array=["$1.00Per Grm", "Stone Setting", "$0.00Per Unit", "$0.50Per Grm", "$0.00Per Grm", "$1.25Per Grm"];
                            @endphp

                            <script>
                               last_form_id = {{ $count }};
                            </script>
                         <tbody id="editdata-{{ $count }}">

                         @if($current_row >0)
                            @for($i=0; $i<$current_row; $i++)
                               @if($i==0)

                            <tr>
                               <input type="hidden" id="designpost-current_row-{{ $count }}" name="current_row" value="{{ $data->current_row }}" class="form-control">
                               <input type="hidden" id="designpost-id-{{ $count }}" name="id" value="{{ $data->id }}" class="form-control">
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}"> {{ $count }} </td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">
                                  @if($data->image == "" || $data->image == NULL )
                                  @else
                                  <img src="{{ env('APP_URL'); }}/storage/design_img/{{ $data->image }}" class="table-design_img zoom-images">
                                  @endif
                               </td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->description )){{ $data->description }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->product_type )){{ $data->product_type }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->size)){{ $data->size }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->model_number)){{ $data->model_number }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" >@if(isset($data->their_code)){{ $data->their_code }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->order_qty)){{ $data->order_qty }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->metal)){{ $data->metal }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->metal_per_gms)){{'$'. $data->metal_per_gms }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->metal_weight)){{ $data->metal_weight }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" >$@if(isset($data->metal_value_including_wastage)){{ $data->metal_value_including_wastage }}@endif</td>

                               <input type="hidden" id="designpost-{{ $count }}-row-table_id-{{ $i }}"  name="row_id" value="0" class="form-control">

                               <td class="design1-form1-table1">@if(isset($labour_type[$i])){{ $labour_type[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($labour_value[$i])){{ $labour_value[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($labour_rate[$i])){{'$'. $labour_rate[$i] }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->total_labour)){{'$'. $data->total_labour }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->metal_labour_cost)){{'$'. $data->metal_labour_cost }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->value_addition_silver)){{'$'. $data->value_addition_silver }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->rhodium)){{'$'. $data->rhodium }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->gold_plating)){{'$'. $data->gold_plating }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->pd)){{'$'. $data->pd }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->total_stone_value)){{'$'. $data->total_stone_value }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" style="background: #92d04f;">@if(isset($data->price_in_usd)){{'$'. $data->price_in_usd }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" style="background: #92d04f;">@if(isset($data->price_in_euro)){{'€'. $data->price_in_euro }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($gem_variation[$i])){{ $gem_variation[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($stone[$i])){{ $stone[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($shape[$i])){{ $shape[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($cut[$i])){{ $cut[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($setting[$i])){{ $setting[$i] }}@endif</td>
                               <td style="background: #92d04f;" class="design1-form1-table1">@if(isset($setting_rate[$i])){{'$'. $setting_rate[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($l[$i])){{ $l[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($w[$i])){{ $w[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($qty[$i])){{ $qty[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($weight[$i])){{ $weight[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($price[$i])){{'$'. $price[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($stone_value[$i])){{'$'. $stone_value[$i] }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->total_stone)){{ $data->total_stone }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}">@if(isset($data->tcw)){{ $data->tcw }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($purchase_price[$i])){{'$'. $purchase_price[$i] }}@endif</td>
                               <td class="design1-form1-table1">@if(isset($sale_price[$i])){{'$'. $sale_price[$i] }}@endif</td>
                              <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" style="background: #92d04f;">@if(isset($data->extra_column_1)){{'$'. $data->extra_column_1 }}@endif</td>
                               <td rowspan="{{ $data->current_row }}" class="design1-form1-table1 designpost-tbody-class-{{ $count }}" style="background: #92d04f;">@if(isset($data->extra_column_1)){{'$'. $data->extra_column_1 }}@endif</td>
                              </tr>

                            @elseif($i == $current_row - 1)

                            @else
                                  <tr id="designpost-{{ $count }}-row-id-{{ $i }}" >
                                     <input type="hidden" id="designpost-{{ $count }}-row-table_id-{{ $i }}"  name="row_id" value="0" class="form-control">
                                        <td class="design1-form1-table1">@if(isset($labour_type[$i])){{ $labour_type[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($labour_value[$i])){{ $labour_value[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($labour_rate[$i])){{'$'. $labour_rate[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($gem_variation[$i])){{ $gem_variation[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($stone[$i])){{ $stone[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($shape[$i])){{ $shape[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($cut[$i])){{ $cut[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($setting[$i])){{ $setting[$i] }}@endif</td>
                                        <td style="background: #92d04f;" class="design1-form1-table1">@if(isset($setting_rate[$i])){{'$'. $setting_rate[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($l[$i])){{ $l[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($w[$i])){{ $w[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($qty[$i])){{ $qty[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($weight[$i])){{ $weight[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($price[$i])){{'$'. $price[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($stone_value[$i])){{ $stone_value[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($purchase_price[$i])){{'$'. $purchase_price[$i] }}@endif</td>
                                        <td class="design1-form1-table1">@if(isset($sale_price[$i])){{'$'. $sale_price[$i] }}@endif</td>
                                     </tr>




                            @endif
                         @endfor
                      @endif




                         </tbody>
                         @endforeach
                         @endif
                         </tbody>
                      </table>
                      {{-- <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;"><i class="fa fa-plus"></i> Add Design</a> --}}
                   </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function add_quotation() {
            $.ajax({
                  url: '{{  url("quotation/add") }}',
                  cache: false,
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                  type: "post",
                  data: $('#quotation-form').serialize(),
                  dataType: "json",
                  success: function(obj){
                     if(obj.status) {
                        $("#quotation-form-id").attr("value", obj.data)
                        alert(obj.msg)
                     }else {
                        alert(obj.msg)
                     }
                  },
                  error: function(obj){
                     var error_msg = ""
                     $.each(obj.responseJSON.errors, function (key, val) {
                         error_msg +=  val[0] + "\n";
                     });
                     alert(error_msg)

                  },
              });
   }


   function addMoreData(id) {
     var current_row = $("#designpost-current_row-"+id).val();
     current_row = parseInt(current_row);
     $.ajax({
               url: '{{  url("quotation/quotation_design_1/addMoreData") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"row_id":id, "current_row":current_row+1},
               dataType: "json",
               success: function(obj){
                  if(obj.status) {

                     $("#designpost-last-row-"+id).before(obj.data)
                     $(".designpost-tbody-class-"+id).attr("rowspan", current_row+1)
                     $("#designpost-current_row-"+id).attr("value", current_row+1)
                  }else {
                     alert(obj.msg)
                  }
               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
      });
  }


  function addDesignForm(last_id)
   {
     $.ajax({
               url: '{{  url("quotation/quotation_design_1/addNewDesignFormRow") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"id":last_id},
               dataType: "json",
               success: function(obj){
                  if(obj.status) {
                     $("#designtable").append(obj.data);
                  }else {
                     alert(obj.msg)
                  }

               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });
           last_form_id++;
   }



   function editform(id)
   {

      var formData = new FormData();
       formData.append('id', $("#designpost-id-"+id).val());
       formData.append('quotation_table_id', $("#quotation-form-id").val());
       if($('#designpost-image-'+id)[0].files.length > 0) {
         formData.append('image', $('#designpost-image-'+id)[0].files[0]);
       }
       formData.append('description', $('#designpost-description-'+id).val());
       formData.append('product_type', $('#designpost-product_type-'+id).val());
       formData.append('size', $('#designpost-size-'+id).val());
       formData.append('model_number', $('#designpost-model_number-'+id).val());
       formData.append('their_code', $('#designpost-their_code-'+id).val());
       formData.append('order_qty', $('#designpost-order_qty-'+id).val());
       formData.append('metal', $('#designpost-metal-'+id).val());
       formData.append('metal_per_gms', $('#designpost-metal_per_gms-'+id).val());
       formData.append('metal_weight', $('#designpost-metal_weight-'+id).val());
       formData.append('metal_value_including_wastage', $('#designpost-metal_value_including_wastage-'+id).val());

       formData.append('total_labour', $('#designpost-total_labour-'+id).val());
       formData.append('metal_labour_cost', $('#designpost-metal_labour_cost-'+id).val());
       formData.append('value_addition_silver', $('#designpost-value_addition_silver-'+id).val());
       formData.append('rhodium', $('#designpost-rhodium-'+id).val());
       formData.append('gold_plating', $('#designpost-gold_plating-'+id).val());
       formData.append('pd', $('#designpost-pd-'+id).val());
       formData.append('total_stone_value', $('#designpost-total_stone_value-'+id).val());
       formData.append('price_in_usd', $('#designpost-price_in_usd-'+id).val());
       formData.append('price_in_euro', $('#designpost-price_in_euro-'+id).val());

       formData.append('current_row', $("#designpost-current_row-"+id).val());

       var current_row_of_id = parseInt($("#designpost-current_row-"+id).val())


       for(let i=0; i<=current_row_of_id; i++) {
          if($('#designpost-'+id+'-row-labour_type-'+i+'').val() == undefined ) {
             continue;
          }
          else {

            formData.append('table_id[]', $('#designpost-'+id+'-row-table_id-'+i+'').val());
            formData.append('labour_type[]', $('#designpost-'+id+'-row-labour_type-'+i+'').val());
            formData.append('labour_value[]', $('#designpost-'+id+'-row-labour_value-'+i+'').val());
            formData.append('labour_rate[]', $('#designpost-'+id+'-row-labour_rate-'+i+'').val());
            formData.append('gem_variation[]', $('#designpost-'+id+'-row-gem_variation-'+i+'').val());
            formData.append('stone[]', $('#designpost-'+id+'-row-stone-'+i+'').val());
            formData.append('shape[]', $('#designpost-'+id+'-row-shape-'+i+'').val());
            formData.append('cut[]', $('#designpost-'+id+'-row-cut-'+i+'').val());
            formData.append('setting[]', $('#designpost-'+id+'-row-setting-'+i+'').val());
            formData.append('setting_rate[]', $('#designpost-'+id+'-row-setting_rate-'+i+'').val());
            formData.append('l[]', $('#designpost-'+id+'-row-l-'+i+'').val());
            formData.append('w[]', $('#designpost-'+id+'-row-w-'+i+'').val());
            formData.append('qty[]', $('#designpost-'+id+'-row-qty-'+i+'').val());
            formData.append('weight[]', $('#designpost-'+id+'-row-weight-'+i+'').val());
            formData.append('price[]', $('#designpost-'+id+'-row-price-'+i+'').val());
            formData.append('stone_value[]', $('#designpost-'+id+'-row-stone_value-'+i+'').val());
            formData.append('purchase_price[]', $('#designpost-'+id+'-row-purchase_price-'+i+'').val());
            formData.append('sale_price[]', $('#designpost-'+id+'-row-sale_price-'+i+'').val());

          }
       }



           $.ajax({
               url: '{{  url("quotation/quotation_design_1/update") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: formData,
               dataType: "json",
               processData: false,
               contentType: false,
               success: function(obj){
                  if(obj.status) {
                     $("#designpost-id-"+id).attr("value", obj.data)
                     alert(obj.msg)
                  }else {
                     alert(obj.msg)
                  }

               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });
   }


</script>
@endsection
