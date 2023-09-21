@extends('admin.layout.app')
@section('content')

<?php
use App\Library\AdminHelper;
 ?>

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
                    <a href="{{url('quotation/quotation_design/view?quotation_id='.request()->quotation_id .'&quoation_form_type='.$quotation_data->quoation_form_type )}}" title="View" class="btn btn-info btn_space design1-form1-btn " style="color: white;" >View</a>
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
            <form id="designpost-thead-1">
              <div class="x_title">
                  <h2 style="font-size: 1.25rem;">Quotation Description</h2>
                    <a href="javascript:void(0)" title="Save" >
                      <button type="button" onclick="editdesignhead()" class="btn btn-success design1-form1-btn">Save</button>
                    </a>
                  <div class="clearfix"></div>
                </div>
                 <input type="hidden" name="id" id="designpost-designheaderid-1" value="@if(isset($design_header_data->id)){{ $design_header_data->id }}@else{{0}}@endif">

               <div class="x_content">
                  <div class="row">

                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Sliver</label>
                        <input type="number" id="designpost-sliver_us_rate-1" onchange="performHeaderCalculation()"  name="sliver_us_rate" value="@if(isset($design_header_data->sliver_us_rate)){{ $design_header_data->sliver_us_rate }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">1 US$ (INR)</label>
                        <input type="number" id="designpost-currency_exchange_rate-1"  onchange="performAllCalculation()"  name="currency_exchange_rate" value="@if(isset($design_header_data->currency_exchange_rate)){{ $design_header_data->currency_exchange_rate }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Sliver (INR per gram)</label>
                        <input type="number" id="designpost-sliver_inr_rate-1" onchange="performAllCalculation()" name="sliver_inr_rate" value="@if(isset($design_header_data->sliver_inr_rate)){{ $design_header_data->sliver_inr_rate }}@endif" class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Gold US$ (Per ounce for GP)</label>
                        <input type="number" id="designpost-gold_us_rate-1" onchange="performAllCalculation()"  name="gold_us_rate" value="@if(isset($design_header_data->gold_us_rate)){{ $design_header_data->gold_us_rate }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">Inc. Silver Loss (At 15% Silver loss)</label>
                        <input type="number" id="designpost-silver_loss-1" onchange="performAllCalculation()"  name="silver_loss" value="@if(isset($design_header_data->silver_loss)){{ $design_header_data->silver_loss }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">18K Gold For Chains</label>
                        <input type="number" id="designpost-gold_18k-1" onchange="performAllCalculation()"   name="gold_18k" value="@if(isset($design_header_data->gold_18k)){{ $design_header_data->gold_18k }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                       <label class="diesign1-form1">24K Gold Plating For Non chain Products</label>
                        <input type="number" id="designpost-gold_24k-1" onchange="performAllCalculation()"  name="gold_24k" value="@if(isset($design_header_data->gold_24k)){{ $design_header_data->gold_24k }}@endif"  class="form-control diesign1-form1-input">
                     </div>
                     <div class="col-md-6 col-sm-12  form-group">
                      </div>
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
                    <table id="designtable" class="table table-striped table-bordered" style="width:100%;">

                    <tbody>
                        <tr>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="54" align="center" valign=middle><b><font color="#000000">Image</font></b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#BFBFBF"><b><font color="#000000">Design</font></b></td>
                          <!-- <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Silver Actual</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Silver Addition</b></td> -->
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" colspan=3 valign=middle><b>Silver</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Stone</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=8 align="center" valign=middle bgcolor="#FAC090"><b>Stone/Diamond</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0.00"><b>Silver</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle>
                            <b>Labour Charge</b>
                          </td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle>
                            <a href="javascript:void(0)" title=" ( Labour Charge x  Silver Wt. ) / 1 USD in INR " class="table-auto_calculated"><b>Labour ($)</b> </a>
                          </td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle>
                            <a href="javascript:void(0)" title=" ( 20 x  Stone/Diamond Qty ) / 1 USD in INR " class="table-auto_calculated"><b>Setting ($)</b> </a>
                          </td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#93CDDD"><b>Misc. ($)</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#B3A2C7"><b>Plating ($)</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#C3D69B" sdnum="1033;0;0.00"><b>Total Cost ($)</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="center" valign=middle bgcolor="#D99694"><b><font color="#000000">Value Addition ($)</font></b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#95B3D7"><b><font color="#000000">Sale Price ($)</font></b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#7030A0"><b><font color="#FFFFFF">$ cost change /$1</font></b></td>
                            <td style="border-left: 1px solid #000000;     padding: 0px 110px 0px 0px;"align="center" valign=middle bgcolor="#7030A0" ></td>
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#BFBFBF"><b><font color="#000000">Action</font></b></td>
                            </tr>
                        <tr>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Actual Wt.</b></td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b>Additional Wt.</b></td>
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
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D99694">
                            <b>Finding Charge</b>
                          </td>
                          <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D99694">
                             <b>Value Additional % </b>
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
                            <td style="border-left: 1px solid #000000"align="center" valign=middle bgcolor="#7030A0"></td>
                          </tr>

                        </tbody>

                            @php
                            $count = 0;
                            @endphp
                            @if(!empty($design_data))
                            @foreach($design_data as $data)
                            @php $count++;  @endphp

                           <script>
                              last_form_id = {{ $count }};
                           </script>


                          @endforeach
                          @endif

                          <?php echo AdminHelper::design2RowFrom(Config::get('constants.edit_design'), request()->quotation_id, 0, 0); ?>

                      </table>
                    <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;"><i class="fa fa-plus"></i> Add Design</a>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>


@include('admin.quotation.quotation_script')

@include('admin.quotation.design2.script')

@endsection
