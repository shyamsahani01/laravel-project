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
                <button type="submit" title="Submit" class="btn btn-success design1-form1-btn">Submit</button>
                <div class="clearfix"></div>
              </div>
              <input type="hidden" name="quoation_form_type" value="Anna-EFB Network">
              <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@else{{0}}@endif">
              <div class="x_content">
                <div class="row">
                  <div class="col-md-6 col-sm-12  form-group">
                    <div class="col-md-6 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Date</label>
                      <div class="col-sm-8">
                        <input type="date" name="transaction_date" class="form-control" value="@if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@endif">
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Valid Till</label>
                      <div class="col-sm-8">
                        <input type="date" name="valid_till" class="form-control" value="@if(isset($quotation_data->valid_till)){{ $quotation_data->valid_till }}@endif">
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Order Type</label>
                      <div class="col-sm-8">
                        <select name="order_type" class="form-control select2-lib-dropdown" value="@if(isset($quotation_data->order_type)){{ $quotation_data->order_type }}@endif">
                          <option></option>
                          <option value="Sales" @if(request()->order_type == 'Sales' ) Selected @endif>Sales</option>
                          <option value="Maintenance" @if(request()->order_type == 'Maintenance') Selected @endif>Maintenance</option>
                          <option value="Shopping Cart" @if(request()->order_type == 'Shopping Cart') Selected @endif>Shopping Cart</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Company</label>
                      <div class="col-sm-8">
                        <select name="company" class="form-control select2-lib-dropdown" value="@if(isset($quotation_data->company)){{ $quotation_data->company }}@endif">
                          <option></option>
                          <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura' ) Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                          <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                          <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Customer Name</label>
                      <div class="col-sm-8">
                        <select name="customer_name" class="form-control select2-lib-dropdown-customer_name "></select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12  form-group" style="border-left: 1px solid;">
                    <input type="hidden" name="quoation_header_id" id="quoation_header-id" value="@if(isset($design_header_data->id)){{ $design_header_data->id }}@else{{0}}@endif">
                    <!-- <div class="col-md-12 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Customer Name</label>
                      <div class="col-sm-4">
                        <select name="customer_name_header" class="form-control select2-lib-dropdown-customer_name "> <?php if(isset($design_header_data->customer_name)) { echo  '
																		<option value="'.$design_header_data->customer_name.'" Selected >'.$design_header_data->customer_name.'</option>'; } ?> </select>
                      </div>
                    </div> -->
                    <div class="col-md-12 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Conversion Rate ($1 in INR)</label>
                      <div class="col-sm-4">
                        <input type="text" name="conversion_rate_inr" onchange="performAllCalculation()" class="form-control" value="@if(isset($design_header_data->conversion_rate_inr)){{ $design_header_data->conversion_rate_inr }}@else {{ 70 }} @endif" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Gold Rate - oz</label>
                      <div class="col-sm-4">
                        <input type="text" name="gold_rate" class="form-control" onchange="performAllCalculation()" value="@if(isset($design_header_data->gold_rate)){{ $design_header_data->gold_rate }}@else {{ 1760 }} @endif" placeholder="">
                      </div>
                      <div class="col-sm-4">
                        <span>
                          <i class="fa fa-question-circle"></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Silver Rate - oz</label>
                      <div class="col-sm-4">
                        <select class="form-control select2-lib-dropdown" onchange="performAllCalculation()" name="silver_rate"> @for($i=15; $i<=40; $i++) <option value="{{ $i }}" @if(isset($design_header_data->silver_rate)) @if($design_header_data->silver_rate == $i) {{ " Selected " }} @endif @endif>{{ "$ ". $i   }}</option> @endfor </select>
                      </div>
                      <div class="col-sm-4">
                        <span>
                          <i class="fa fa-question-circle"></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Loss: </label>
                    </div>
                    <div class="col-md-5 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Gold (%)</label>
                      <div class="col-sm-8">
                        <select name="loss_gold" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                          <option value="10" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '10') {{ " Selected " }} @endif @endif>10</option>
                          <option value="11" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '11') {{ " Selected " }} @endif @endif>11</option>
                          <option value="12.5" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                          <option value="15" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '15') {{ " Selected " }} @endif @endif>15</option>
                          <option value="17" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '17') {{ " Selected " }} @endif @endif>17</option>
                          <option value="20" @if(isset($design_header_data->loss_gold)) @if($design_header_data->loss_gold == '20') {{ " Selected " }} @endif @endif>20</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Silver (%)</label>
                      <div class="col-sm-8">
                        <select name="loss_silver" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                          <option value="10" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '10') {{ " Selected " }} @endif @endif>10</option>
                          <option value="11" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '11') {{ " Selected " }} @endif @endif>11</option>
                          <option value="12.5" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                          <option value="15" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '15') {{ " Selected " }} @endif @endif>15</option>
                          <option value="17" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '17') {{ " Selected " }} @endif @endif>17</option>
                          <option value="20" @if(isset($design_header_data->loss_silver)) @if($design_header_data->loss_silver == '20') {{ " Selected " }} @endif @endif>20</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-12  form-group"></div>
                    <div class="col-md-5 col-sm-12  form-group">
                      <label for="staticEmail" class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">White Gold (%)</label>
                      <div class="col-sm-8">
                        <select name="loss_white_gold" onchange="performAllCalculation()" class="form-control select2-lib-dropdown">
                          <option value="10" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '10') {{ " Selected " }} @endif @endif>10</option>
                          <option value="11" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '11') {{ " Selected " }} @endif @endif>11</option>
                          <option value="12.5" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '12.5') {{ " Selected " }} @endif @endif>12.5</option>
                          <option value="15" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '15') {{ " Selected " }} @endif @endif>15</option>
                          <option value="17" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '17') {{ " Selected " }} @endif @endif>17</option>
                          <option value="20" @if(isset($design_header_data->loss_white_gold)) @if($design_header_data->loss_white_gold == '20') {{ " Selected " }} @endif @endif>20</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- new -->
          <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
            <div class="x_title">
              <h2 style="font-size: 1.25rem;">Design Table</h2>
              <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table id="designtable" class="table table-striped table-responsive table-bordered" style="width:100%;">
                <thead id="designpost-thead-1">
                  <tr>
                    <th class="design1-form1-table1-thead">S.No</th>
                    <th class="design1-form1-table1-thead">Action</th>
                    <th class="design1-form1-table1-thead">Image</th>
                    <th class="design1-form1-table1-thead">Design Code/Product Code</th>
                    <th class="design1-form1-table1-thead">Their Code</th>
                    <th class="design1-form1-table1-thead">Product Type</th>
                    <th class="design1-form1-table1-thead">Metal Group</th>
                    <th class="design1-form1-table1-thead">Metal Varients</th>
                    <th class="design1-form1-table1-thead">Metal Weight Casting</th>
                    <th class="design1-form1-table1-thead">Metal Weight Chain</th>
                    <th class="design1-form1-table1-thead">Value Of Metal</th>
                    <th class="design1-form1-table1-thead">
                      <table style="margin-top: -13px; margin-bottom: -13px">
                        <thead>
                          <tr>
                            <th class="design1-form1-table1-thead" style="padding-top: 50px; width: 105px; border-left-color: white !important;">Row </th>
                            <th colspan=2 class="design1-form1-table1-thead" style="width: 215px">Labour </th>
                            <th class="design1-form1-table1-thead" style="width: 40px; border-right-color: white !important;"></th>
                          </tr>
                        </thead>
                      </table>
                    </th>
                    <th class="design1-form1-table1-thead">
                      <table style="margin-top: -13px; margin-bottom: -13px">
                        <thead>
                          <tr>
                            <th class="design1-form1-table1-thead" style="width: 94px; border-left-color: white !important;">Row</th>
                            <th class="design1-form1-table1-thead" style="width: 106px">Stone Name</th>
                            <th class="design1-form1-table1-thead" style="width: 108px">Stone Cut</th>
                            <th class="design1-form1-table1-thead" style="width: 109px">Stone Shape</th>
                            <th class="design1-form1-table1-thead" style="width: 105px">Stone Size (Length)</th>
                            <th class="design1-form1-table1-thead" style="width: 105px">Stone Size (Width)</th>
                            <th class="design1-form1-table1-thead" style="width: 107px">Stone / Diamond Quality</th>
                            <!-- <th class="design1-form1-table1-thead2" style="width: 107px">Setting Type</th> -->
                            <th class="design1-form1-table1-thead2" style="width: 107px">Price Unit</th>
                            <th class="design1-form1-table1-thead" style="width: 87px">Stone Qty</th>
                            <th class="design1-form1-table1-thead" style="width: 87px">Stone Weight</th>
                            <th class="design1-form1-table1-thead" style="width: 86px">Stone Value</th>
                            <th class="design1-form1-table1-thead" style="width: 39px; border-right-color: white !important;"></th>
                          </tr>
                        </thead>
                      </table>
                    </th>
                    <th class="design1-form1-table1-thead">Cost 1</th>
                    <th class="design1-form1-table1-thead">Value Addition (Cost1)</th>
                    <th class="design1-form1-table1-thead">Ex-Factory Price</th>
                    <th class="design1-form1-table1-thead"></th>
                    <th class="design1-form1-table1-thead">Stone Quoatrion Price</th>
                    <th class="design1-form1-table1-thead">Sale Price</th>
                  </tr>
                </thead>
                <tbody id="design-table-body"></tbody>
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
                <?php echo AdminHelper::design1RowFrom(Config::get('constants.edit_design'), request()->quotation_id, 0, 0); ?>
              </table>
              <a href="javascript:void(0)" onclick="addDesignForm(last_form_id+1)" class="btn btn-success btn-sm pull-right" style="margin-top: -16px; float: left;">
                <i class="fa fa-plus"></i> Add Design </a>
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
