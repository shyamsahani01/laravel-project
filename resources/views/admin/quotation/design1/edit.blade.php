@extends('admin.layout.app')
@section('content')

<?php
use App\Library\AdminHelper;
 ?>
<style>
table {
    border-collapse: unset !important;
}
</style>
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

              <div class="row bottom-border">

                <div class="col-md-3 col-sm-12  form-group">
                  <h2 style="font-size: 1.25rem;">Quotation </h2>
                </div>


                <div class="col-md-3 col-sm-12  form-group left-border">
                  <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;"></label>
                  <div class="col-sm-8">
                    <input type="text" readonly name="name" id="quotation-form-name" class="form-control-plaintext" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@endif">
                  </div>
                </div>

                <div class="col-md-3 col-sm-12  form-group right-border">
                  <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Created By</label>
                  <div class="col-sm-8">
                    <input type="text" readonly name="owner" class="form-control-plaintext" value="@if(isset($quotation_data->owner)){{ $quotation_data->owner }}@else{{ auth()->user()->email }}@endif">
                  </div>
                </div>

                <div class="col-md-3 col-sm-12  form-group">
                  <button type="button" title="Excel" onclick="downloadFile()" class="btn btn-info design1-form1-btn">Excel</button>
                  <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Save</button>
                </div>

              </div>
              <input type="hidden" name="quoation_form_type" value="Anna-EFB Network">
              <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@else{{0}}@endif">
              <div class="x_content">
                <div class="row">

                  <div class="col-md-1 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Date</label>
                    <input type="date" name="transaction_date" class="form-control" value="@if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@else{{ date('Y-m-d')}}@endif">
                  </div>

                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Date</label>
                    <input type="date" name="transaction_date" class="form-control" value="@if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@else{{ date('Y-m-d')}}@endif">
                  </div> -->

                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="date" name="valid_till" class="form-control" value="@if(isset($quotation_data->valid_till)){{ $quotation_data->valid_till }}@endif">
                    <label for="floatingPassword col-form-label">Valid Till</label>
                  </div> -->
                  <div class="col-md-1 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Status</label>
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">Status</label> -->
                    <select name="status" class="form-control select2-lib-dropdown">
                      <option></option>
                      <!-- <option value="Draft" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Draft') {{ " Selected " }} @endif @endif>Draft</option> -->
                      <option value="Open" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Open') {{ " Selected " }} @endif @endif >Open</option>
                      <!-- <option value="Replied" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Replied') {{ " Selected " }} @endif @endif >Replied</option> -->
                      <option value="Quotation Sent" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Quotation Sent') {{ " Selected " }} @endif @endif >Quotation Sent</option>
                      <option value="Converted Order" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Converted Order') {{ " Selected " }} @endif @endif >Converted Order</option>
                      <option value="Not Converted Order" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Not Converted Order') {{ " Selected " }} @endif @endif >Not Converted Order</option>
                      <!-- <option value="Ordered" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Ordered') {{ " Selected " }} @endif @endif >Ordered</option> -->
                      <!-- <option value="Lost" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Lost') {{ " Selected " }} @endif @endif >Lost</option> -->
                      <!-- <option value="Cancelled" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Cancelled') {{ " Selected " }} @endif @endif >Cancelled</option>
                      <option value="Expired" @if(isset($quotation_data->status)) @if($quotation_data->status == 'Expired') {{ " Selected " }} @endif @endif >Expired</option> -->
                    </select>
                  </div>
                  <div class="col-md-2 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Title</label>
                    <input type="text" name="title" class="form-control" value="@if(isset($quotation_data->title)){{ $quotation_data->title }}@endif">
                  </div>
                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="text" name="title" class="form-control" value="@if(isset($quotation_data->title)){{ $quotation_data->title }}@endif">
                    <label for="floatingPassword col-form-label">Title</label>
                  </div> -->

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Conversion Rate ($1 in INR)</label>
                    <input type="number" step=any id="conversion_rate_inr" onchange="performAllCalculation()" name="conversion_rate_inr" class="form-control" value="@if(isset($design_header_data->conversion_rate_inr)){{ $design_header_data->conversion_rate_inr }}@else{{ 70 }}@endif">
                  </div>
                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="number" step=any id="conversion_rate_inr" onchange="performAllCalculation()" name="conversion_rate_inr" class="form-control" value="@if(isset($design_header_data->conversion_rate_inr)){{ $design_header_data->conversion_rate_inr }}@else{{ 70 }}@endif" placeholder="">
                    <label for="floatingPassword col-form-label">Conversion Rate ($1 in INR)</label>
                  </div> -->

                  <!-- <div class="col-md-3 col-sm-12 mb-3">
                    <label for="exampleFormControlInput1" class="form-label col-form-label">Order Type</label>
                    <select name="order_type" class="form-control select2-lib-dropdown">
                      <option></option>
                      <option value="Sales" @if(isset($quotation_data->order_type)) @if($quotation_data->order_type == 'Sales') {{ " Selected " }} @endif @endif>Sales</option>
                      <option value="Maintenance" @if(isset($quotation_data->order_type)) @if($quotation_data->order_type == 'Maintenance') {{ " Selected " }} @endif @endif >Maintenance</option>
                      <option value="Shopping Cart" @if(isset($quotation_data->order_type)) @if($quotation_data->order_type == 'Shopping Cart') {{ " Selected " }} @endif @endif >Shopping Cart</option>
                    </select>
                  </div> -->

                  <div class="col-md-2 form-group">
                      <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Company</label>
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">Company</label> -->
                    <select name="company" class="form-control select2-lib-dropdown">
                      <option></option>
                      <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(isset($quotation_data->company)) @if($quotation_data->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') {{ " Selected " }} @endif @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                      <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(isset($quotation_data->company)) @if($quotation_data->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') {{ " Selected " }} @endif @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                      <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(isset($quotation_data->company)) @if($quotation_data->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') {{ " Selected " }} @endif @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                    </select>
                  </div>

                  <div class="col-md-2 form-group">
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Customer Name</label>
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">Customer Name</label> -->
                    <select name="customer_name" class="form-control select2-lib-dropdown-customer_name "> <?php if(isset($quotation_data->customer_name)) { echo  '
                      <option value="'.$quotation_data->customer_name.'" Selected >'.$quotation_data->customer_name.'</option>'; } ?>
                    </select>
                  </div>

                  <input type="hidden" name="quoation_header_id" id="quoation_header-id" value="@if(isset($design_header_data->id)){{ $design_header_data->id }}@else{{0}}@endif">


                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="number" step=any id="gold_rate" onchange="performAllCalculation()" name="gold_rate" class="form-control" value="@if(isset($design_header_data->gold_rate)){{ $design_header_data->gold_rate }}@else{{ 1760 }}@endif" placeholder="">
                    <label for="floatingPassword col-form-label">Gold Rate - oz</label>
                  </div> -->
                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Gold Rate - oz
                      <span id="gold_rate_toolTip">
                        <i class="fa fa-question-circle"></i>
                      </span>
                  </label>
                    <input type="number" step=any id="gold_rate" onchange="performAllCalculation()" name="gold_rate" class="form-control" value="@if(isset($design_header_data->gold_rate)){{ $design_header_data->gold_rate }}@else{{ 1760 }}@endif">
                  </div>
                  <!-- <div class="col-sm-2">
                      <span id="gold_rate_toolTip">
                        <i class="fa fa-question-circle"></i>
                      </span>
                  </div> -->

                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                      <input type="number" step=any id="silver_rate" onchange="performAllCalculation()" name="silver_rate" class="form-control" value="@if(isset($design_header_data->silver_rate)){{ $design_header_data->silver_rate }}@else{{ 28 }}@endif"  placeholder="">
                      <label for="floatingPassword col-form-label">Silver Rate - oz</label>
                  </div> -->
                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Silver Rate - oz <span id="silver_rate_toolTip">
                      <i class="fa fa-question-circle"></i>
                    </span></label>
                    <input type="number" step=any id="silver_rate" onchange="performAllCalculation()" name="silver_rate" class="form-control" value="@if(isset($design_header_data->silver_rate)){{ $design_header_data->silver_rate }}@else{{ 28 }}@endif">
                  </div>
                  <!-- <div class="col-sm-2">
                    <span id="silver_rate_toolTip">
                      <i class="fa fa-question-circle"></i>
                    </span>
                  </div> -->

                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="number" step=any id="value_additionl_per_for_cost_1_gold" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_gold" class="form-control" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_gold)){{ $design_header_data->value_additionl_per_for_cost_1_gold }}@else{{ 10 }}@endif" placeholder="">
                    <label for="floatingPassword col-form-label">Value Additionl % For Gold</label>
                  </div> -->
                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Value Add % For Gold</label>
                    <input type="number" step=any id="value_additionl_per_for_cost_1_gold" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_gold" class="form-control" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_gold)){{ $design_header_data->value_additionl_per_for_cost_1_gold }}@else{{ 10 }}@endif">
                  </div>

                  <!-- <div class="col-md-3 col-sm-12 form-floating">
                    <input type="number" step=any id="value_additionl_per_for_cost_1_silver" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_silver" class="form-control" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_silver)){{ $design_header_data->value_additionl_per_for_cost_1_silver }}@else{{ 15 }}@endif" placeholder="">
                    <label for="floatingPassword col-form-label">Value Additionl % For Silver</label>
                  </div> -->
                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Value Add% For Silver</label>
                    <input type="number" step=any id="value_additionl_per_for_cost_1_silver" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_silver" class="form-control" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_silver)){{ $design_header_data->value_additionl_per_for_cost_1_silver }}@else{{ 15 }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Gold Loss(%)</label>
                    <select name="loss_gold" id="loss_gold" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                      <option value="10" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '10') {{ " Selected " }} @endif @endif>10</option>
                      <option value="11" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '11') {{ " Selected " }} @endif @endif>11</option>
                      <option value="12.5" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                      <option value="15" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '15') {{ " Selected " }} @endif @endif>15</option>
                      <option value="17" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '17') {{ " Selected " }} @endif @endif>17</option>
                      <option value="20" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '20') {{ " Selected " }} @endif @endif>20</option>
                    </select>
                  </div>

                  <div class="col-md-2 form-group">
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">Silver Loss(%)</label> -->
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Silver Loss(%)</label>
                      <select name="loss_silver" id="loss_silver" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                        <option value="10" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '10') {{ " Selected " }} @endif @endif>10</option>
                        <option value="11" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '11') {{ " Selected " }} @endif @endif>11</option>
                        <option value="12.5" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                        <option value="15" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '15') {{ " Selected " }} @endif @endif>15</option>
                        <option value="17" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '17') {{ " Selected " }} @endif @endif>17</option>
                        <option value="20" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '20') {{ " Selected " }} @endif @endif>20</option>
                      </select>
                  </div>

                  <div class="col-md-2 form-group">
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">White Gold Loss(%)</label> -->
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">White Gold Loss(%)</label>
                    <select name="loss_white_gold" id="loss_white_gold" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                      @for($j=11; $j<=20; $j++)
                        <option value="{{ $j }}" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == $j) {{ " Selected " }} @endif @endif>{{ $j }}</option>
                      @endfor
                      <!-- <option value="10" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '10') {{ " Selected " }} @endif @endif>10</option> -->

                      <!-- <option value="12.5" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                      <option value="15" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '15') {{ " Selected " }} @endif @endif>15</option>
                      <option value="17" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '17') {{ " Selected " }} @endif @endif>17</option>
                      <option value="20" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '20') {{ " Selected " }} @endif @endif>20</option> -->
                    </select>
                  </div>


                </div>
              </div>
            </form>

          <div class=" div_for_table ">
            <div class=" table_wrapper  top-border">
              <table id="designtable" class="table tableFixHead table-responsive " style="width:100%;">
                <thead id="designpost-thead-1">
                  <tr>
                    <!-- <th class="design1-form1-table1-thead">S.No</th> -->
                    <th class="design1-form1-table1-thead fixed_header_th sticky-col first-col">
                      <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;">
                        <i class="fa fa-plus"></i> Add Design </a>
                      Action</th>
                    <th class="design1-form1-table1-thead  fixed_header_th sticky-col second-col">Image</th>
                    <th class="design1-form1-table1-thead fixed_header_th sticky-col third-col" id="design_code_html">Design Code/Product Code</th>
                    <th class="design1-form1-table1-thead">Their Code</th>
                    <th class="design1-form1-table1-thead">Product Type</th>
                    <th class="design1-form1-table1-thead">Metal Group</th>
                    <th class="design1-form1-table1-thead">Metal Varients</th>
                    <th class="design1-form1-table1-thead">Metal Weight Casting</th>
                    <th class="design1-form1-table1-thead">Metal Weight Chain</th>
                    <th class="design1-form1-table1-thead" id="value_Of_Metal_html">
                      Value Of Metal ($)
                    </th>
                    <th class="design1-form1-table1-thead">
                      <table style="margin-top: -13px; margin-bottom: -7px">
                        <thead>
                          <tr>
                            <th class="" style="width: 50px; border-left-color: transparent !important;">Row </th>
                            <th colspan=2 class="" style="width: 215px; border-right-color: transparent !important;" id="labour_html">Labour ($)</th>
                            <!-- <th class="design1-form1-table1-thead" style="width: 40px; border-right-color: white !important;"></th> -->
                          </tr>
                        </thead>
                      </table>
                    </th>
                    <th class="design1-form1-table1-thead">

                      @php $count = 0;
                      @endphp
                      @if(!empty($design_data))
                      @foreach($design_data as $data)
                      @php $count++;
                      @endphp
                      <script>
                        last_form_id = {{ $count }};
                      </script>
                      @endforeach
                      @endif

                      <table style="margin-top: -13px; margin-bottom: -7px">
                        <thead>
                          <tr>
                            <th class="" style="width: 55px;  border-left-color: transparent !important;">Row</th>
                            <th class="" style="width: 135px">Stone Name</th>
                            <th class="" style="width: 107px">Stone Shape</th>
                            <th class="" style="width: 108px">Stone Cut</th>
                            <th class="" style="width: 106px">Setting Type</th>
                            <th class="" style="width: 87px">Stone Size (Length)</th>
                            <th class="" style="width: 87px">Stone Size (Width)</th>
                            <th class="" style="width: 87px">Stone Qty</th>
                            <th class="" style="width: 87px;" id="stone_weight_html">Stone Weight</th>
                            <th class="" style="width: 107px">Stone / Diamond Quality</th>
                            <!-- <th class="design1-form1-table1-thead" style="width: 107px">Setting Type</th> -->
                            <th class="" style="width: 87px">Price Unit</th>
                            <th class="" style="width: 87px;" id="stone_purchase_price_html">Stone Purchase Price (₹)</th>
                            <th class="" style="width: 87px;">Stone Value Added %</th>
                            <th class="" style="width: 87px;" id="sale_price_html" >Stone Sale Price (₹)</th>
                            <th class="" style="width: 87px;" id="stone_value_added_per_html" >Stone Value  ($)</th>
                            <!-- <th class="" style="width: 39px; border-right-color: transparent !important;"></th> -->
                            <th class="" style="width: 125px; border-right-color: transparent !important;"></th>
                          </tr>
                        </thead>
                      </table>
                    </th>

                    <th class="design1-form1-table1-thead" id="cost_1_html" >Cost 1 ($)</th>
                    <th class="design1-form1-table1-thead" id="cost_2_html" >Cost 2 ($)</th>
                    <th class="design1-form1-table1-thead" id="value_additionl_Cost1_html">Value Additionl (Cost 1) ($)</th>
                    <th class="design1-form1-table1-thead" id="ex_factory_price_html" >Ex-Factory Price ($)</th>
                    <th class="design1-form1-table1-thead" id="discount_per_html" >Discount %</th>
                    <th class="design1-form1-table1-thead" id="price_after_discount_html" >Price After Discount($)</th>
                    <!-- <th class="design1-form1-table1-thead" id="stone_quotation_price_html" >Stone Quotation Price ($)</th> -->

                    <!-- <th class="design1-form1-table1-thead" id="sale_price_html">Sale Price</th> -->
                  </tr>
                </thead>
                <!-- <tbody id="design-table-body" class=""></tbody> -->

                <?php echo AdminHelper::design1RowFrom(Config::get('constants.edit_design'), request()->quotation_id, 0, 0); ?>
              </table>
              <!-- <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;">
                <i class="fa fa-plus"></i> Add Design </a> -->
            </div>
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
