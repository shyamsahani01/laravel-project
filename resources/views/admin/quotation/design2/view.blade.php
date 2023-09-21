@extends('admin.layout.app')
@section('content')
<script>
   last_form_id = 0;
</script>
<style>
    .table th {
    padding: 0px !important;
}
</style>
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
            <div class="x_title">
                <h2>Qoutation Description</h2>
                <div class="clearfix"></div>
              </div>
            <form id="designpost-thead-1" method="POST">
                 <input type="hidden" name="id" id="designpost-designheaderid-1">
               <div class="x_content">
                  <div class="row">

                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Sliver</label>
                        <input type="text" disabled id="designpost-sliver_us_rate-1" name="sliver_us_rate" value="@if(isset($design_header_data->sliver_us_rate)){{ $design_header_data->sliver_us_rate }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">1 US$ (INR)</label>
                        <input type="text" disabled id="designpost-currency_exchange_rate-1" name="currency_exchange_rate" value="@if(isset($design_header_data->currency_exchange_rate)){{ $design_header_data->currency_exchange_rate }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Sliver INR (Per gram)</label>
                        <input type="text" disabled id="designpost-sliver_inr_rate-1" name="sliver_inr_rate" value="@if(isset($design_header_data->sliver_inr_rate)){{ $design_header_data->sliver_inr_rate }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Gold US$ (Per ounce for GP)</label>
                        <input type="text" disabled id="designpost-gold_us_rate-1" name="gold_us_rate" value="@if(isset($design_header_data->gold_us_rate)){{ $design_header_data->gold_us_rate }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Inc. Silver Loss (At 15% Silver loss)</label>
                        <input type="text" disabled id="designpost-silver_loss-1" name="silver_loss" value="@if(isset($design_header_data->silver_loss)){{ $design_header_data->silver_loss }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">18K Gold For Chains</label>
                        <input type="text" disabled id="designpost-gold_18k-1" name="gold_18k" value="@if(isset($design_header_data->gold_18k)){{ $design_header_data->gold_18k }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">24K Gold Plating For Non chain Products</label>
                        <input type="text" disabled id="designpost-gold_24k-1" name="gold_24k" value="@if(isset($design_header_data->gold_24k)){{ $design_header_data->gold_24k }}@endif"  class="form-control diesign1-form1-input" value="">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                      </div>
                     <!-- <div class="col-md-6 col-sm-12  form-group">
                        <button type="button" onclick="editdesignhead()" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                        {{-- <button type="button" class="btn btn-success">Send Quotation to ERP</button> --}}
                     </div> -->
                  </div>
               </div>
            </form>
          </div>
          <div class="shadow-lg p-3 mb-5 bg-white rounded">
            <div class="x_title">
                <h2>Design Table</h2>
                <div class="clearfix"></div>
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered" style="width:100%;">

                      <tbody id="design-table-body">
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="54" align="center" valign=middle><b><font color="#000000">Image</font></b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#BFBFBF"><b><font color="#000000">Design</font></b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Silver</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Stone</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=8 align="center" valign=middle bgcolor="#FAC090"><b>Stone/Diamond</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0.00"><b>Silver</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle>
                              <a href="javascript:void(0)" title=" ( Labour Charge x  Silver Wt. ) / 1 USD in INR " class="table-auto_calculated"><b>Labour ($)</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle>
                              <a href="javascript:void(0)" title=" ( 20 x  Stone/Diamond Qty ) / 1 USD in INR " class="table-auto_calculated"><b>Setting ($)</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#93CDDD"><b>Misc. ($)</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B3A2C7"><b>Plating ($)</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#C3D69B" sdnum="1033;0;0.00"><b>Total Cost ($)</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#D99694"><b><font color="#000000">Value Addition ($)</font></b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#95B3D7"><b><font color="#000000">Sale Price ($)</font></b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#7030A0"><b><font color="#FFFFFF">$ cost change /$1</font></b></td>
                            </tr>
                        <tr>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>
                              <a href="javascript:void(0)" title=" Silver Actual Wt. x Silver Additional Wt." class="table-auto_calculated"><b>Wt.</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Wt.</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Name</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Shape</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Size</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Qty</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Weight</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090"><b>Price (₹)</b></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090">
                              <a href="javascript:void(0)" title=" Stone/Diamond Price x 2 " class="table-auto_calculated"><b>Inc Margin (₹)</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FAC090">
                              <a href="javascript:void(0)" title=" ( Inc Margin x  Stone/Diamond Weight ) / 1 USD in INR " class="table-auto_calculated"><b>Amt ($)</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0.00">
                              <a href="javascript:void(0)" title=" Silver Wt. x Inc. Silver Loss " class="table-auto_calculated"><b>Amt ($)</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#93CDDD">
                              <b>Item</b>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#93CDDD">
                              <a href="javascript:void(0)" title=" ( 10 / 1 USD in INR ) + 0.05 " class="table-auto_calculated"><b>Cost</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#B3A2C7">
                              <a href="javascript:void(0)" title=" 1.97 x Silver Wt. " class="table-auto_calculated"> <b>GP</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#B3A2C7">
                              <a href="javascript:void(0)" title=" 1.97 x Silver Wt. " class="table-auto_calculated"> <b>RP</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C3D69B" sdnum="1033;0;0.00">
                              <a href="javascript:void(0)" title=" Silver Amt. + Labour + Setting + Misc. Cost " class="table-auto_calculated"> <b>SS</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C3D69B">
                              <a href="javascript:void(0)" title=" Silver Amt. + Labour + Setting + Misc. Cost " class="table-auto_calculated"> <b>GP</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C3D69B">
                              <a href="javascript:void(0)" title=" Silver Amt. + Labour + Setting + Misc. Cost " class="table-auto_calculated"> <b>RP</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D99694" sdnum="1033;0;0.00">
                              <a href="javascript:void(0)" title=" ( Total Cost SS x Value Additional % ) + Stone/Diamond Amt + Finding Charge " class="table-auto_calculated"> <b>SS</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D99694">
                              <a href="javascript:void(0)" title=" ( Total Cost GP x Value Additional % ) + Stone/Diamond Amt + Plating GP + Finding Charge" class="table-auto_calculated"> <b> GP </b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D99694">
                              <a href="javascript:void(0)" title=" ( Total Cost RP x Value Additional % ) + Stone/Diamond Amt + Plating RP + Finding Charge " class="table-auto_calculated"> <b> RP </b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#95B3D7" sdnum="1033;0;0.00">
                              <a href="javascript:void(0)" title=" Total Cost SS  + Value Addition SS " class="table-auto_calculated">  <b>SS</b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#95B3D7">
                              <a href="javascript:void(0)" title=" Total Cost GP  + Value Addition GP " class="table-auto_calculated"> <b> GP </b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#95B3D7">
                              <a href="javascript:void(0)" title=" Total Cost RP  + Value Addition RP " class="table-auto_calculated"> <b> RP </b> </a>
                            </td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#7030A0">
                              <a href="javascript:void(0)" title="(), ( Cost Change 1  - Sale Price RP), ( Cost Change 2 / 10)" class="table-auto_calculated"> <b> For MV Costing Only </b> </a>
                            </td>
                        </tr>
                         @php
                         $count = 0;
                         @endphp
                         @if(!empty($design_data))
                         @foreach($design_data as $data)
                         @php $count++;  @endphp
                         @php
                         $image_url = 'https://erp.pinkcityindia.com'. $data->image;
                         $current_row = $data->current_row;
                         $silver_wt = json_decode($data->silver_wt);
                         $stone_wt = json_decode($data->stone_wt);
                         $stone_diamond_name = json_decode($data->stone_diamond_name);
                         $stone_diamond_shape = json_decode($data->stone_diamond_shape);
                         $stone_diamond_size = json_decode($data->stone_diamond_size);
                         $stone_diamond_qty = json_decode($data->stone_diamond_qty);
                         $stone_diamond_weight = json_decode($data->stone_diamond_weight);
                         $stone_diamond_price = json_decode($data->stone_diamond_price);
                         $stone_diamond_inc_margin = json_decode($data->stone_diamond_inc_margin);
                         $stone_diamond_amt = json_decode($data->stone_diamond_amt);
                         $silver_amt = json_decode($data->silver_amt);
                         $labour = json_decode($data->labour);
                         $setting = json_decode($data->setting);
                         $misc_item = json_decode($data->misc_item);
                         $misc_cost = json_decode($data->misc_cost);
                         $plating_gp = json_decode($data->plating_gp);
                         $plating_rp = json_decode($data->plating_rp);
                         $total_cost_ss = json_decode($data->total_cost_ss);
                         $total_cost_rp = json_decode($data->total_cost_rp);
                         $total_cost_gp = json_decode($data->total_cost_gp);
                         $value_addition_ss = json_decode($data->value_addition_ss);
                         $value_addition_rp = json_decode($data->value_addition_rp);
                         $value_addition_gp = json_decode($data->value_addition_gp);
                         $sale_price_ss = json_decode($data->sale_price_ss);
                         $sale_price_rp = json_decode($data->sale_price_rp);
                         $sale_price_gp = json_decode($data->sale_price_gp);
                         $cost_change_1 = json_decode($data->cost_change_1);
                         $cost_change_2 = json_decode($data->cost_change_2);
                         $cost_change_3 = json_decode($data->cost_change_3);

                        @endphp
                        <script>
                           last_form_id = {{ $count }};
                        </script>
                         <tbody id="editdata-{{ $count }}" style="border-top: 1px solid black;">

                         @if($current_row >0)
                            @for($i=0; $i<$current_row; $i++)
                           @if($i==0)

                          <tr>
                              <input type="hidden" id="designpost-current_row-{{ $count }}" name="current_row" value="@if(isset($data->current_row)){{ $data->current_row }}@endif" class="form-control">
                              <input type="hidden" id="designpost-id-{{ $count }}" name="id" value="@if(isset($data->id)){{ $data->id }}@endif" class="form-control">
                              <td rowspan="{{ $data->current_row }}" class="design1-form1-table2 designpost-tbody-class-{{ $count }}"><b>
                              @if($data->image == "" || $data->image == NULL )
                              @else
                              <img src="{{ env('APP_URL'); }}/storage/design_img/{{ $data->image }}" class="table-design_img zoom-images">
                              @endif
                              </b></td>
                              <td rowspan="{{ $data->current_row }}" class="design1-form1-table2 designpost-tbody-class-{{ $count }}" bgcolor="#BFBFBF"><b>
                                @if(isset($data->design)){{ $data->design }}@endif
                              </b></td>
                              <input type="hidden" id="designpost-{{ $count }}-row-table_id-{{ $i }}"  name="row_id" value="0" class="form-control">
                              <td class="design1-form1-table2"> @if(isset($silver_wt[$i])){{ $silver_wt[$i] }}@endif</td>
                              <td class="design1-form1-table2" sdval="0" sdnum="1033;0;0.00">  @if(isset($stone_wt[$i])){{ $stone_wt[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_name[$i])){{ $stone_diamond_name[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_shape[$i])){{ $stone_diamond_shape[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_size[$i])){{ $stone_diamond_size[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090"><font color="#FF0000">  @if(isset($stone_diamond_qty[$i])){{ $stone_diamond_qty[$i] }}@endif</font></td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_weight[$i])){{ $stone_diamond_weight[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_price[$i])){{ $stone_diamond_price[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" >  @if(isset($stone_diamond_inc_margin[$i])){{ $stone_diamond_inc_margin[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090">  @if(isset($stone_diamond_amt[$i])){{ $stone_diamond_amt[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($silver_amt[$i])){{ $silver_amt[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($labour[$i])){{ $labour[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($setting[$i])){{ $setting[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#93CDDD">  @if(isset($misc_item[$i])){{ $misc_item[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#93CDDD"> @if(isset($misc_cost[$i])) {{ $misc_cost[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#B3A2C7"> @if(isset($plating_gp[$i])) {{ $plating_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#B3A2C7"> @if(isset($plating_rp[$i])) {{ $plating_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B"> @if(isset($total_cost_ss[$i])) {{ $total_cost_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B"> @if(isset($total_cost_gp[$i])) {{ $total_cost_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B"> @if(isset($total_cost_rp[$i])) {{ $total_cost_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694"> @if(isset($value_addition_ss[$i])) {{ $value_addition_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694"> @if(isset($value_addition_gp[$i])) {{ $value_addition_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694"> @if(isset($value_addition_rp[$i])) {{ $value_addition_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7"> $  @if(isset($sale_price_ss[$i])){{ $sale_price_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7"> $  @if(isset($sale_price_gp[$i] )){{ $sale_price_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7"> $  @if(isset($sale_price_rp[$i])){{ $sale_price_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" ><font color="#000000">  @if(isset($cost_change_1[$i])) {{ $cost_change_1[$i] }}@endif </font></td>
                              <td class="design1-form1-table2"> @if(isset($cost_change_2[$i])){{ $cost_change_2[$i] }}@endif  </td>
                              <td class="design1-form1-table2">  @if(isset($cost_change_3[$i])){{ $cost_change_3[$i] }}@endif</td>
                          </tr>
                          @elseif($i == $current_row - 1)
                          @else
                          <tr id="designpost-{{ $count }}-row-id-{{ $i }}" >
                              <input type="hidden" id="designpost-{{ $count }}-row-table_id-{{ $i }}"  name="row_id" value="0" class="form-control">
                              <td class="design1-form1-table2" > @if(isset($silver_wt[$i])) {{ $silver_wt[$i] }}@endif</td>
                              <td class="design1-form1-table2" > @if(isset($stone_wt[$i]))  {{ $stone_wt[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090"> @if(isset($stone_diamond_name[$i]))  {{ $stone_diamond_name[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090"> @if(isset($stone_diamond_shape[$i]))  {{ $stone_diamond_shape[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090"> @if(isset($stone_diamond_size[$i]))  {{ $stone_diamond_size[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" ><font color="#FF0000"> @if(isset($stone_diamond_qty[$i]))  {{ $stone_diamond_qty[$i] }}@endif</font></td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" >  @if(isset($stone_diamond_weight[$i])) {{ $stone_diamond_weight[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" > @if(isset($stone_diamond_price[$i]))  {{ $stone_diamond_price[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" > @if(isset($stone_diamond_inc_margin[$i]))  {{ $stone_diamond_inc_margin[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#FAC090" > @if(isset($stone_diamond_amt[$i])) {{ $stone_diamond_amt[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($silver_amt[$i])) {{ $silver_amt[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($labour[$i])) {{ $labour[$i] }}@endif</td>
                              <td class="design1-form1-table2" >@if(isset($setting[$i])) {{ $setting[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#93CDDD">@if(isset($misc_item[$i])){{ $misc_item[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#93CDDD" >  @if(isset($misc_cost[$i])) {{ $misc_cost[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#B3A2C7" > @if(isset($plating_gp[$i]))  {{ $plating_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#B3A2C7" > @if(isset($plating_rp[$i]))  {{ $plating_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B" > @if(isset($total_cost_ss[$i]))  {{ $total_cost_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B" > @if(isset($total_cost_gp[$i]))  {{ $total_cost_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#C3D69B" > @if(isset($total_cost_rp[$i]))  {{ $total_cost_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694" > @if(isset($value_addition_ss[$i]))  {{ $value_addition_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694" > @if(isset($value_addition_gp[$i]))  {{ $value_addition_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#D99694" > @if(isset($value_addition_rp[$i]))  {{ $value_addition_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7" > $ @if(isset($sale_price_ss[$i])) {{ $sale_price_ss[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7" > $ @if(isset($sale_price_gp[$i])) {{ $sale_price_gp[$i] }}@endif</td>
                              <td class="design1-form1-table2" bgcolor="#95B3D7" > $ @if(isset($sale_price_rp[$i])) {{ $sale_price_rp[$i] }}@endif</td>
                              <td class="design1-form1-table2" ><font color="#000000">  @if(isset($cost_change_1[$i]))  {{ $cost_change_1[$i] }}@endif </font></td>
                              <td class="design1-form1-table2">@if(isset($cost_change_2[$i]))  {{ $cost_change_2[$i] }}@endif  </td>
                              <td class="design1-form1-table2"> @if(isset($cost_change_3[$i]))  {{ $cost_change_3[$i] }}@endif</td>
                          </tr>
                          @endif
                          @endfor
                        @endif
                        </tbody>
                       @endforeach
                       @endif
                       </tbody>
                      </table>
                  </div>
              </div>
          </div>


        </div>
    </div>
</div>
@endsection
