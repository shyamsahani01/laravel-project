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
                    <button type="submit" class="btn btn-success design1-form1-btn"><i class="fa fa-paper-plane"></i></button>
                    <div class="clearfix"></div>
                  </div>
                  <input type="hidden" name="id" id="quotation-form-id" value="0">
                     <input type="hidden" name="quotation_design_type_id" id="quotation-form-quotation_design_type_id" value="1">
                  <div class="x_content">
                     <div class="row">
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Quotation Name</label>
                           <input type="text" name="quo_name" autocomplete="off"  class="diesign1-form1-input form-control" value="">
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Sales Person Name</label>
                            <select name="sales_person_name" class=" diesign1-form1-input  form-control select2-lib-dropdown"  >
                                <option value="" ></option>
                                @foreach($sales_person_data as $key => $value)
                                <option value="{{ $value->sales_person_name }}">{{ $value->sales_person_name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Client Name</label>
                           <select name="client_name" class=" diesign1-form1-input  form-control select2-lib-dropdown"  >
                               <option value="" ></option>
                               @foreach($customer_data as $key => $value)
                               <option value="{{ $value->customer_name }}">{{ $value->customer_name }} </option>
                               @endforeach
                           </select>
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Date</label>
                           <input type="date" name="date" autocomplete="off"  class="form-control diesign1-form1-input" value="<?php echo date('Y-m-d', time());?>">
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Status</label>
                           <select name="status" class="form-control diesign1-form1-input">
                              <option></option>
                              <option value="Draft" >Draft</option>
                              <option value="Open" >Open</option>
                              <option value="Replied" >Replied</option>
                              <option value="Ordered" >Ordered</option>
                              <option value="Lost" >Lost</option>
                              <option value="Cancelled" >Cancelled</option>
                              <option value="Expired" >Expired</option>
                           </select>
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Document Status</label>
                           <select name="doc_status" class="form-control diesign1-form1-input">
                              <option></option>
                              <option  value="Draft" >Draft</option>
                              <option  value="Submit" >Submit</option>
                              <option  value="Cancel" >Cancel</option>
                           </select>
                        </div>
                        <!-- <div class="col-md-2 col-sm-12  form-group">
                           <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                        </div> -->
                     </div>
                  </div>
               </form>
            </div>
            <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
               <form id="designpost-thead-1">
               <div class="x_title">
                    <h2 style="font-size: 1.25rem;">Quotation Description</h2>
                    <button type="button" onclick="editdesignhead()" class="btn btn-success design1-form1-btn"><i class="fa fa-paper-plane"></i></button>
                    <div class="clearfix"></div>
                  </div>
                  <input type="hidden" name="id" id="designpost-designheaderid-1" value="0">
                  <div class="x_content">
                     <div class="row">
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Metal Kitco Gold $</label>
                           <input type="text" onchange="performAllCalculation()" id="designpost-metal_kittco_gold-1" name="metal_kittco_gold"  class="diesign1-form1-input form-control" value="">
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">USD Conversion $</label>
                           <input type="text" onchange="performAllCalculation()" id="designpost-usd_conversion-1" name="usd_conversion"  class="diesign1-form1-input form-control" value="">
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                        <label class="diesign1-form1">Metal Kitco Silver $</label>
                           <input type="text" onchange="performAllCalculation()" id="designpost-metal_kittco_silver-1" name="metal_kittco_silver"  class="diesign1-form1-input form-control" value="">
                        </div>
                        <!-- <div class="col-md-2 col-sm-12  form-group">
                           <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                        </div> -->
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
                          <input type="hidden" name="id">
                          <thead id="designpost-thead-1">
                          <input type="hidden" name="id" id="designpost-designheaderid-1">
                          <tr>
                             <th class="design1-form1-table1-thead">Sr no</th>
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
                             <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Price / Weight" class="table-auto_calculated">Stone Value</a></th>
                             <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Total Sum Of Qty" class="table-auto_calculated">Total Stone</a></th>
                             <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Total Sum Of Weight" class="table-auto_calculated">TCW</a></th>
                             <th class="design1-form1-table1-thead">Purchase Price</th>
                             <th class="design1-form1-table1-thead"><a href="javascript:void(0)" title="Purchase Price * 1.5" class="table-auto_calculated">Sale Price</a></th>
                             <th class="design1-form1-table1-thead2"></th>
                             <th class="design1-form1-table1-thead2"></th>
                             <th class="design1-form1-table1-thead"></th>
                             <th class="design1-form1-table1-thead">Action</th>
                         </tr>
                           </thead>
                           <tbody id="design-table-body">


                           </tbody>
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
