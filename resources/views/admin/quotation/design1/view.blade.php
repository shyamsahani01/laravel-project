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
            <form id="quotation-form" method="POST" onsubmit="event.preventDefault();">

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
                  <a href="{{url('quotation/quotation_design/export?quotation_id='.$quotation_data->name.'&quoation_form_type='.$quotation_data->quoation_form_type.'&page=excel')}}" title="Export" class="" style="color: white;">
                    <button type="button" title="Excel" onclick="downloadFile()" class="btn btn-info design1-form1-btn">Excel</button>
                  </a>
                  <a href="{{url('quotation/quotation_design/edit?quotation_id='.$quotation_data->name.'&quoation_form_type='.$quotation_data->quoation_form_type.'&page=edit')}}" title="Edit" class="" style="color: white;">
                    <button type="button" title="Edit" class="btn btn-success design1-form1-btn">Edit</button>
                  </a>
                </div>

              </div>
              <input type="hidden" name="quoation_form_type" value="Anna-EFB Network">
              <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($quotation_data->name)){{ $quotation_data->name }}@else{{0}}@endif">
              <div class="x_content">
                <div class="row">

                  <div class="col-md-1 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Date</label>
                    <input type="text" name="transaction_date" class="form-control-plaintext" value="@if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@endif">
                  </div>

                  <div class="col-md-1 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Status</label>
                    <input type="text" name="status" class="form-control-plaintext" value="@if(isset($quotation_data->status)){{ $quotation_data->status }}@endif">
                  </div>
                  <div class="col-md-2 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Title</label>
                    <input type="text" name="title" class="form-control-plaintext" value="@if(isset($quotation_data->title)){{ $quotation_data->title }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Conversion Rate ($1 in INR)</label>
                    <input type="number" step=any id="conversion_rate_inr" onchange="performAllCalculation()" name="conversion_rate_inr" class="form-control-plaintext" value="@if(isset($design_header_data->conversion_rate_inr)){{ $design_header_data->conversion_rate_inr }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-4 col-form-label" style="color: black;font-weight: bold;">Company</label>
                    <input type="text" name="company" class="form-control-plaintext" value="@if(isset($quotation_data->company)){{ $quotation_data->company }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Customer Name</label>
                      <input type="text" name="customer_name" class="form-control-plaintext" value="@if(isset($quotation_data->customer_name)){{ $quotation_data->customer_name }}@endif">
                  </div>

                  <input type="hidden" name="quoation_header_id" id="quoation_header-id" value="@if(isset($design_header_data->id)){{ $design_header_data->id }}@else{{0}}@endif">

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Gold Rate - oz <span id="gold_rate_toolTip">
                      <i class="fa fa-question-circle"></i>
                    </span></label>
                    <input type="number" step=any id="gold_rate" onchange="performAllCalculation()" name="gold_rate" class="form-control-plaintext" value="@if(isset($design_header_data->gold_rate)){{ $design_header_data->gold_rate }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Silver Rate - oz <span id="silver_rate_toolTip">
                      <i class="fa fa-question-circle"></i>
                    </span></label>
                    <input type="number" step=any id="silver_rate" onchange="performAllCalculation()" name="silver_rate" class="form-control-plaintext" value="@if(isset($design_header_data->silver_rate)){{ $design_header_data->silver_rate }}@endif">
                  </div>


                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Value Add % For Gold</label>
                    <input type="number" step=any id="value_additionl_per_for_cost_1_gold" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_gold" class="form-control-plaintext" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_gold)){{ $design_header_data->value_additionl_per_for_cost_1_gold }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Value Add% For Silver</label>
                    <input type="number" step=any id="value_additionl_per_for_cost_1_silver" onchange="performAllCalculation()" name="value_additionl_per_for_cost_1_silver" class="form-control-plaintext" value="@if(isset($design_header_data->value_additionl_per_for_cost_1_silver)){{ $design_header_data->value_additionl_per_for_cost_1_silver }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Gold Loss(%)</label>
                    <input type="number" step=any id="loss_gold" onchange="performAllCalculation()" name="loss_gold" class="form-control-plaintext" value="@if(isset($design_header_data->loss_gold)){{ $design_header_data->loss_gold }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">Silver Loss(%)</label> -->
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">Silver Loss(%)</label>
                      <input type="number" step=any id="loss_silver" onchange="performAllCalculation()" name="loss_silver" class="form-control-plaintext" value="@if(isset($design_header_data->loss_silver)){{ $design_header_data->loss_silver }}@endif">
                  </div>

                  <div class="col-md-2 form-group">
                    <!-- <label for="exampleFormControlInput1" class="form-label col-form-label">White Gold Loss(%)</label> -->
                      <label class="col-sm-12 col-form-label" style="color: black;font-weight: bold;">White Gold Loss(%)</label>
                      <input type="number" step=any id="loss_white_gold" onchange="performAllCalculation()" name="loss_white_gold" class="form-control-plaintext" value="@if(isset($design_header_data->loss_white_gold)){{ $design_header_data->loss_white_gold }}@endif">

                  </div>


                </div>
              </div>
            </form>



          <!-- <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;"> -->
            <!-- <div class="x_title">
              <h2 style="font-size: 1.25rem;">Design Table</h2>
              <div class="clearfix"></div>
            </div> -->
            <div class=" div_for_table ">
              <div class=" table_wrapper  top-border">

            <!-- <div class="table-responsive"> -->
              <table id="designtable" class="table tableFixHead table-responsive " style="width:100%;">
                <thead id="designpost-thead-1">
                  <tr>
                    <th class="design1-form1-table1-thead fixed_header_th sticky-col first-col ">S.No</th>
                  <th class="design1-form1-table1-thead fixed_header_th sticky-col second-col">Image</th>
                    <th class="design1-form1-table1-thead fixed_header_th sticky-col third-col" style="color:#1A73E8;" id="design_code_html">Design Code/Product Code</th>
                    <th class="design1-form1-table1-thead">Their Code</th>
                    <th class="design1-form1-table1-thead">Product Type</th>
                    <th class="design1-form1-table1-thead">Metal Group</th>
                    <th class="design1-form1-table1-thead">Metal Varients</th>
                    <th class="design1-form1-table1-thead">Metal Weight Casting</th>
                    <th class="design1-form1-table1-thead">Metal Weight Chain</th>
                    <th class="design1-form1-table1-thead" style="color:#1A73E8;" id="value_Of_Metal_html">Value Of Metal ($)</th>
                    <th class="design1-form1-table1-thead">
                      <table style="margin-top: -13px; margin-bottom: -13px">
                        <thead>
                          <tr>
                            <th class="design1-form1-table1-thead" style="padding-top: 74px; width: 53px; border-left-color: white !important;">Row </th>
                            <th colspan=2 class="design1-form1-table1-thead" style="width: 157px;color:#1A73E8;" id="labour_html" >Labour ($)</th>
                            </tr>
                        </thead>
                      </table>
                    </th>
                    <th class="design1-form1-table1-thead">
                      <table style="margin-top: -13px; margin-bottom: -13px">
                        <thead>
                          <tr>
                            <th class="design1-form1-table1-thead" style="width: 94px; padding-top: 74px; border-left-color: white !important;">Row</th>
                            <th class="design1-form1-table1-thead" style="width: 106px">Stone Name</th>
                            <th class="design1-form1-table1-thead" style="width: 107px">Stone Shape</th>
                            <th class="design1-form1-table1-thead" style="width: 108px">Stone Cut</th>
                            <th class="design1-form1-table1-thead" style="width: 106px">Setting Type</th>
                            <th class="design1-form1-table1-thead" style="width: 107px">Stone Size (Length)</th>
                            <th class="design1-form1-table1-thead" style="width: 107px">Stone Size (Width)</th>
                            <th class="design1-form1-table1-thead" style="width: 87px">Stone Qty</th>
                            <th class="design1-form1-table1-thead" style="width: 87px;color:#1A73E8;" id="stone_weight_html" >Stone Weight</th>
                            <th class="design1-form1-table1-thead" style="width: 107px">Stone / Diamond Quality</th>
                            <!-- <th class="design1-form1-table1-thead" style="width: 107px">Setting Type</th> -->
                            <th class="design1-form1-table1-thead" style="width: 87px">Price Unit</th>
                            <th class="design1-form1-table1-thead" style="width: 87px;">Stone Purchase Price (₹)</th>
                            <th class="design1-form1-table1-thead" style="width: 87px;">Stone Value Added %</th>
                            <th class="design1-form1-table1-thead" style="width: 87px; color:#1A73E8; " id="sale_price_html"> Stone Sale Price (₹)</th>
                            <th class="design1-form1-table1-thead" style="width: 74px; color:#1A73E8;  border-right: 1px solid white !important;" id="stone_value_added_per_html">Stone Value  ($)</th>
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
                    <!-- <th class="design1-form1-table1-thead" style="color:#1A73E8;" id="stone_quotation_price_html" >Stone Quotation Price ($)</th> -->
                  </tr>
                </thead>
                <?php
                $new_raw = '';
                $count = 0;
                if(!empty($design_data)) {
				foreach($design_data as $data) {
          $count++;
          $labour_type = json_decode($data->labour_type);
          $setting_charge = json_decode($data->setting_charge);
          $plating_type = json_decode($data->plating_type);
          $square_value = json_decode($data->square_value);
          $labour_value = json_decode($data->labour_value);

          $stone_name = json_decode($data->stone_name);
          $setting_type = json_decode($data->setting_type);
          $stone_cut = json_decode($data->stone_cut);
          $stone_shape = json_decode($data->stone_shape);
          $stone_size_l = json_decode($data->stone_size_l);
          $stone_size_w = json_decode($data->stone_size_w);
          $stone_diamond_quality = json_decode($data->stone_diamond_quality);
          $setting_type = json_decode($data->setting_type);
          $price_unit = json_decode($data->price_unit);
          $stone_qty = json_decode($data->stone_qty);
          $stone_weight = json_decode($data->stone_weight);
          $stone_value = json_decode($data->stone_value);
          $value_added_per = json_decode($data->value_added_per);
          $stone_value_added = json_decode($data->stone_value_added);
          $sale_price = json_decode($data->sale_price);


					 $id = 0;
           $k = 0; $l = 0; $m = 0;

					$row_id = $count;
					$id = $data->id;


					 $new_raw .='                 <tbody id="designpost-tbody-'.$row_id.'" class="designpost-tbody" > ';



											$new_raw .='
																									<tr>

																											<td class="design1-form1-table1   first-col sticky-col " >'.$row_id.'</td>

																											<td class="design1-form1-table1  second-col sticky-col  " >

																													<span > ';
																													if($data->image == "" || $data->image == NULL ) {}
																													else {
																														$new_raw .= '  <img id="designpost-img_src-'.$row_id.'" src="'.env('APP_URL').'/storage/design_img/'.$data->image.'" class="table-design_img zoom-images element-image">';
																												}
                                                        $new_raw .= '               		</span>';

																												if($data->image == "" || $data->image == NULL ) {}
																												else {
																													$new_raw .= '	<button type="button" class="btn btn-primary btn_size_1" onclick="displayImageModal('.$row_id.')" >
								                                                        		<i class="fa fa-eye btn_icon"></i>
								                                                        </button> ';
																											}



																									$new_raw .= '		</td>
																											<td class="design1-form1-table1 third-col sticky-col  " >'.$data->product_code.'</td>
																											<td class="design1-form1-table1 " >'.$data->their_code.'</td>
																											<td class="design1-form1-table1 " >'.$data->product_type.'</td>
																											<td class="design1-form1-table1 " >'.$data->metal_type.'</td>
																											<td class="design1-form1-table1 " >'.$data->metal.'</td>
																											<td class="design1-form1-table1 " >'.$data->metal_weight_casting.'</td>
																											<td class="design1-form1-table1 " >'.$data->metal_weight_chain.'</td>
																											<td class="design1-form1-table1 " >'.$data->value_of_metal.'</td>

																											<td class="design1-form1-table1">
																											  <table style="margin: -4px">
																													<tbody id="designpost-labor-table-tbody-'.$row_id.'">';
                                          $new_raw .= '
    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-1" value="1" >
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															CFP
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text" readonly  name="labour_value_cfp" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_cfp" value="'.$data->labour_value_cfp.'" >
    																													</td>
    																												</tr>

    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-2" value="2" >
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															Chain Labour
                                                                  <span class="chain_labour_toolTip">
    																				                        <i class="fa fa-question-circle"></i>
    																				                      </span>
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text"  name="labour_value_chain_labour"   class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_chain_labour" value="'.$data->labour_value_chain_labour.'" >
    																													</td>
    																												</tr>

    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-3" value="3" >
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															Total Setting Charge
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text" readonly  name="labour_value_total_setting" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_total_setting" value="'.$data->labour_value_total_setting.'" >
    																													</td>
    																												</tr>

    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-4" value="4" >
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															Finding
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text"  name="labour_value_finding" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_finding" value="'.$data->labour_value_finding.'" >
    																													</td>
    																												</tr>

    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-5" value="5" >
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															Packing, PD and other Miss.
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text"  name="labour_value_packing"   class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_packing" value="'.$data->labour_value_packing.'" >
    																													</td>
    																												</tr>';

                                                  if(stripos("gold", $data->metal_type) !== false) {
                                                    $new_raw .='<tr>
      																													<td class="design1-form1-table1">
      																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-6" value="6" >
      																													</td>
      																													<td  class="design1-form1-table1" >';
                                                                $new_raw .= '	 <input name="gold_text_chains" style="width: 100px;" class="form-control-plaintext" id="designpost-plating_chains-gold_plating_text-'.$row_id.'" value="Pen Plating">';
      																													$new_raw .= '	</td>
      																													<td  class="design1-form1-table1 ">
      																															<input type="text" readonly   name="labour_value_plating_casting" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_plating_casting" value="'.$data->labour_value_plating_casting.'" >
      																													</td>
      																												</tr>';
                                                  }

                                                  elseif(stripos("silver", $data->metal_type) !== false) {
    																							$new_raw .='<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-6" value="6" >
    																													</td>
    																													<td  class="design1-form1-table1';
    																														if(isset($data->plating_casting)) { if( stripos($data->plating_casting, "square") !== false) { 	$new_raw .=' square_value '; } }
    																												$new_raw .='
    																													">
    																															Plating Casting Products ';
                                                                  $normal_string = '';
                                                                  if(isset($data->plating_casting)){
                                                                    $str_arr = explode(",", $data->plating_casting);
                                                                    if(is_array($str_arr)) {
                                                                      if(count($str_arr) > 0) {
                                                                        unset($str_arr[count($str_arr) - 1]);
                                                                      }
                                                                      $normal_string = implode(",",$str_arr);
                                                                    }
                                                                  }
    																										$new_raw .='<input style="width: 100px;text-align: center;" type="text" id="designpost-plating_casting-'.$row_id.'" name="plating_casting" value="'.( $normal_string ).'" class="form-control-plaintext">';
    																																if(isset($data->plating_casting)) { if( stripos($data->plating_casting, "square") !== false) {
    																																	$new_raw .= '	 <input name="square_value" id="designpost-plating_casting-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_casting-square_value\', 0)"   class="form-control-plaintext" style="width: 100px;"  ';
    																																		if(isset($data->plating_casting_square_value)) { 	$new_raw .=' value="'.$data->plating_casting_square_value.'" ';  }
    																																	$new_raw .=' >';
    																																 } }
    																														$new_raw .='
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text" readonly   name="labour_value_plating_casting" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_plating_casting" value="'.$data->labour_value_plating_casting.'" >
    																													</td>
    																												</tr>

    																												<tr>
    																													<td class="design1-form1-table1">
    																																<input type="text" readonly  name="row_1" class="form-control-plaintext" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-7" value="7" >
    																													</td>
    																													<td  class="design1-form1-table1 ';
    																														if(isset($data->plating_chains)) { if( stripos($data->plating_chains, "square") !== false) { 	$new_raw .=' square_value '; } }
    																												$new_raw .='
    																													">
    																															Plating - Chains';
                                                                  $normal_string = '';
                                                                  if(isset($data->plating_chains)){
                                                                    $str_arr = explode(",", $data->plating_chains);
                                                                    if(is_array($str_arr)) {
                                                                      if(count($str_arr) > 0) {
                                                                        unset($str_arr[count($str_arr) - 1]);
                                                                      }
                                                                      $normal_string = implode(",",$str_arr);
                                                                    }
                                                                  }

                                                          $new_raw .=' <input style="width: 100px;text-align: center;" type="text" id="designpost-plating_chains-'.$row_id.'" name="plating_chains" value="'.( $normal_string ).'" class="form-control-plaintext">';
    																																if(isset($data->plating_chains)) { if( stripos($data->plating_chains, "square") !== false) {
    																																	$new_raw .= '	 <input name="square_value" id="designpost-plating_chains-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_chains-square_value\', 0)"   class="form-control " style="width: 100px;"  ';
    																																		if(isset($data->plating_chains_square_value)) { 	$new_raw .=' value="'.$data->plating_chains_square_value.'" ';  }
    																																	$new_raw .=' >';
    																																 } }
    																														$new_raw .='
    																													</td>
    																													<td  class="design1-form1-table1 ">
    																															<input type="text" readonly  name="labour_value_plating_chains" class="form-control-plaintext" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_plating_chains" value="'.$data->labour_value_plating_chains.'" >
    																													</td>
    																												</tr>';
                                                          }
																											$new_raw .='	</tbody>
																										</table>
																										</td>

																										<td class="design1-form1-table1">
																										<table style="margin: -4px;">

																											<tbody id="designpost-stone-table-tbody-'.$row_id.'">';

																											for ($i=0; $i <count($stone_name) ; $i++) {

																												$new_raw .= '<tr>

																										<td class="design1-form1-table1">
																													<input type="text" readonly name="row_2" class="form-control-plaintext" id="designpost-'.$row_id.'-row-row_2-'.$i.'"  value="'.($i+1).'"  style="width: 100px;text-align: center;">
																										</td>

																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_name-'.$row_id.'" name="stone_name" value="'.( isset($stone_name[$i]) ? $stone_name[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_shape-'.$row_id.'" name="stone_shape" value="'.( isset($stone_shape[$i]) ? $stone_shape[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_cut-'.$row_id.'" name="stone_cut" value="'.( isset($stone_cut[$i]) ? $stone_cut[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-setting_type-'.$row_id.'" name="setting_type" value="'.( isset($setting_type[$i]) ? $setting_type[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_size_l-'.$row_id.'" name="stone_size_l" value="'.( isset($stone_size_l[$i]) ? $stone_size_l[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_size_w-'.$row_id.'" name="stone_size_w" value="'.( isset($stone_size_w[$i]) ? $stone_size_w[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
                                                    <td  class="design1-form1-table1" ><input type="number" style="width: 80px;text-align: center;" onchange="performCalculation('.$row_id.')" id="designpost-stone_qty-'.$row_id.'" name="stone_qty"  value="'.( isset($stone_qty[$i]) ? $stone_qty[$i] : 0 ).'" class="form-control-plaintext"></td>
																										<td  class="design1-form1-table1 stone_weight" ><input type="number" style="width: 80px;text-align: center;" name="stone_weight" class="form-control-plaintext" id="designpost-'.$row_id.'-row-stone_weight-'.$i.'"  value="'.( isset($stone_weight[$i]) ? $stone_weight[$i] : 0 ).'" >
																										<td  class="design1-form1-table1 ">
																												<input style="width: 100px;text-align: center;" type="text" id="designpost-stone_diamond_quality-'.$row_id.'" name="stone_diamond_quality" value="'.( isset($stone_diamond_quality[$i]) ? $stone_diamond_quality[$i] : 0 ).'" class="form-control-plaintext">
	                                                  </td>
																										<td  class="design1-form1-table1 ">
																												<input style="width: 80px;text-align: center;" type="text" id="designpost-price_unit-'.$row_id.'" name="price_unit" value="'.( isset($price_unit[$i]) ? $price_unit[$i] : 0 ).'" class="form-control-plaintext">
																										</td>
																										</td>
																										<td  class="design1-form1-table1 stone_value" ><input type="number" style="width: 80px;text-align: center;"  name="stone_value" class="form-control-plaintext" id="designpost-'.$row_id.'-row-stone_value-'.$i.'"  value="'.( isset($stone_value[$i]) ? $stone_value[$i] : 0 ).'"  ></td>

																 										<td  class="design1-form1-table1 value_added_per "><input type="text" style="width: 80px;text-align: center;"  onchange="performCalculation('.$row_id.')" name="value_added_per" class="form-control-plaintext" id="designpost-'.$row_id.'-row-value_added_per-'.$i.'"  value="'.( isset($value_added_per[$i]) ? $value_added_per[$i] : 0 ).'"  ></td>
                                                    <td  class="design1-form1-table1 sale_price "><input type="text" style="width: 80px; text-align: center;"  name="sale_price" class="form-control-plaintext" id="designpost-'.$row_id.'-row-sale_price-'.$i.'"  value="'.( isset($sale_price[$i]) ? $sale_price[$i] : 0 ).'"  ></td>
																 										<td  class="design1-form1-table1 stone_value_added "><input type="text" style="width: 80px; text-align: center;"  name="stone_value_added" class="form-control-plaintext" id="designpost-'.$row_id.'-row-stone_value_added-'.$i.'"  value="'.( isset($stone_value_added[$i]) ? $stone_value_added[$i] : 0 ).'"  ></td>


																										</tr>
																												';
																											}
																											$new_raw .= '

																											</tbody>
																										</table>
																									</td>

                                                  <td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="cost_1" class="form-control-plaintext" style="width: 80px;" id="designpost-cost_1-'.$row_id.'" value="'.$data->cost_1.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="cost_2" class="form-control-plaintext" style="width: 80px;" id="designpost-cost_2-'.$row_id.'" value="'.$data->cost_2.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="value_addition_cost_1" class="form-control-plaintext" style="width: 100px;" id="designpost-value_addition_cost_1-'.$row_id.'"  value="'.$data->value_addition_cost_1.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="ex_factory_price" class="form-control-plaintext" style="width: 100px;" id="designpost-ex_factory_price-'.$row_id.'" value="'.$data->ex_factory_price.'" ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" name="discount_per" onchange="performCalculation('.$row_id.')"  class="form-control-plaintext" style="width: 80px;" id="designpost-discount_per-'.$row_id.'"  value="'.$data->discount_per.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="price_after_discount" class="form-control-plaintext" style="width: 100px;" id="designpost-price_after_discount-'.$row_id.'" value="'.$data->price_after_discount.'" ></td>

																									</tr> ';



						 $new_raw .= '
											</tbody>';

					 }


				} echo $new_raw;
                ?>
              </table>
            </div>
          </div>
        <!-- </div> -->
      </div>
    </div>
  </div>
</div>



@include('admin.quotation.quotation_script')



@endsection
