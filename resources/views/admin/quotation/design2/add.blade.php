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
          <!-- <div class="x_title">
              <h2>{{$title}}</h2>
              <div class="clearfix"></div>
            </div> -->
            <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
              <form id="quotation-form" method="POST" onsubmit="event.preventDefault(); add_quotation();">
                <div class="x_title">
                    <h2 style="font-size: 1.25rem;">Quotation Details</h2>
                      <button type="submit" class="btn btn-success design1-form1-btn"><i class="fa fa-paper-plane"></i></button>
                    <div class="clearfix"></div>
                  </div>
                  <input type="hidden" name="id" id="quotation-form-id" value="0">
                  <input type="hidden" name="quotation_design_type_id" id="quotation-form-quotation_design_type_id" value="2">
                 <div class="x_content">
                    <div class="row">

                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Quotation Name</label>
                          <input type="text" name="quo_name" autocomplete="off"  class="form-control diesign1-form1-input" value="">
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
                             <option value="Draft">Draft</option>
                             <option value="Open">Open</option>
                             <option value="Replied">Replied</option>
                             <option value="Ordered">Ordered</option>
                             <option value="Lost">Lost</option>
                             <option value="Cancelled">Cancelled</option>
                             <option value="Expired">Expired</option>
                          </select>
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Document Status</label>
                          <select name="doc_status" class="form-control diesign1-form1-input">
                             <option></option>
                             <option value="Draft" >Draft</option>
                             <option value="Submit" >Submit</option>
                             <option value="Cancel" >Cancel</option>
                          </select>
                       </div>
                       <!-- <div class="col-md-6 col-sm-12  form-group">
                          <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                          {{-- <button type="button" class="btn btn-success">Send Quotation to ERP</button> --}}
                       </div> -->
                    </div>
                 </div>
              </form>
            </div>
            <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
              <form id="designpost-thead-1" method="POST" onsubmit="event.preventDefault(); add_quotation();">
                <div class="x_title">
                    <h2 style="font-size: 1.25rem;">Qoutation Description</h2>
                    <button type="button" onclick="editdesignhead()" class="btn btn-success design1-form1-btn"><i class="fa fa-paper-plane"></i></button>
                    <div class="clearfix"></div>
                  </div>
                   <input type="hidden" name="id" id="designpost-designheaderid-1" value="0">
                 <div class="x_content">
                    <div class="row">

                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Sliver</label>
                          <input type="text" onchange="performHeaderCalculation()" id="designpost-sliver_us_rate-1" name="sliver_us_rate" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">1 US$ INR</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-currency_exchange_rate-1" name="currency_exchange_rate" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Sliver INR per gram</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-sliver_inr_rate-1" name="sliver_inr_rate" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Gold US$ per ounce for GP</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-gold_us_rate-1" name="gold_us_rate" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">Inc. Silver Loss at 15% Silver loss</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-silver_loss-1" name="silver_loss" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">18K Gold For Chains</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-gold_18k-1" name="gold_18k" autocomplete="off"  class="form-control diesign1-form1-input" value="">
                       </div>
                       <div class="col-md-6 col-sm-12  form-group">
                         <label class="diesign1-form1">24K Gold Plating For Non chain Products</label>
                          <input type="text" onchange="performAllCalculation()" id="designpost-gold_24k-1" name="gold_24k" autocomplete="off"  class="form-control diesign1-form1-input" value="">
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
                  <h2 style="font-size: 1.25rem;">Design Table</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="designtable" class="table table-striped table-bordered design1-form1-table" style="width:100%;">
                           <input type="hidden" name="id">

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
