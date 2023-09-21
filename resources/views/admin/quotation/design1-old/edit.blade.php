@extends('admin.layout.app')
@section('content')

<?php
use App\Library\AdminHelper;
 ?>
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

                        <a href="{{url('quotation/quotation_design/export?quotation_id='. request()->quotation_id .'&quoation_form_type='.$quotation_data->quoation_form_type )}}" title="Export" class="btn btn-primary btn_space design1-form1-btn" style="color: white;">Excel Export</a>
                        <a href="{{url('quotation/quotation_design/view?quotation_id='.request()->quotation_id .'&quoation_form_type='.$quotation_data->quoation_form_type )}}" title="View" class="btn btn-info btn_space design1-form1-btn " style="color: white;" >View</a>
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

                  <form id="designpost-thead-1" method="POST" onsubmit="event.preventDefault(); add_quotation();">
                      <div class="x_title">
                        <h2 style="font-size: 1.25rem;">Quotation Description</h2>
                          <button type="button" onclick="editdesignhead()" class="btn btn-success design1-form1-btn">Save</button>
                        <div class="clearfix"></div>
                      </div>
                       <input type="hidden" name="id" id="designpost-designheaderid-1" value="@if(isset($design_header_data->id)){{ $design_header_data->id }}@else{{ 0 }}@endif">
                     <div class="x_content">
                        <div class="row">
                           <div class="col-md-6 col-sm-12  form-group">
                              <label class="diesign1-form1">Metal Kitco Gold $</label>
                              <input type="text" class="form-control diesign1-form1-input" id="designpost-metal_kittco_gold-1" onchange="performAllCalculation()"  name="metal_kittco_gold" value="@if(isset($design_header_data->metal_kittco_gold)){{ $design_header_data->metal_kittco_gold }}@endif">
                           </div>
                           <div class="col-md-6 col-sm-12  form-group">
                             <label class="diesign1-form1">USD Conversion $</label>
                              <input type="text"  class="form-control diesign1-form1-input" id="designpost-usd_conversion-1"  onchange="performAllCalculation()" name="usd_conversion" value="@if(isset($design_header_data->usd_conversion)){{ $design_header_data->usd_conversion }}@endif">
                           </div>
                           <div class="col-md-6 col-sm-12  form-group">
                              <label class="diesign1-form1">Metal Kitco Silver $</label>
                              <input type="text"  class="form-control diesign1-form1-input" id="designpost-metal_kittco_silver-1"  onchange="performAllCalculation()"  name="metal_kittco_silver" value="@if(isset($design_header_data->metal_kittco_silver)){{ $design_header_data->metal_kittco_silver }}@endif">
                           </div>
                        </div>
                     </div>
                  </form>

              </div>
              <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                <div class="x_title">
                  <h2 style="font-size: 1.25rem;">Design Table</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                      <table id="designtable" class="table table-striped table-bordered" style="width:100%;">
                        <thead id="designpost-thead-1">
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
                             <th class="design1-form1-table1-thead" style="padding: 0px 110px 0px 0px;"></th>
                             <th class="design1-form1-table1-thead">Action</th>
                         </tr>
                         </thead>
                         <tbody id="design-table-body">
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

                        <?php echo AdminHelper::design1RowFrom(Config::get('constants.edit_design'), request()->quotation_id, 0, 0); ?>

                      </table>
                      <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;"><i class="fa fa-plus"></i> Add Design</a>
                   </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>


@include('admin.quotation.quotation_script')

@include('admin.quotation.design1.script')

@endsection
