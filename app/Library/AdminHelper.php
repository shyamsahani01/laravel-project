<?php
namespace App\Library;
use Auth;
use DB;
use Config;
class AdminHelper {

	public static function design1RowFrom($action_type = 'add', $quotation_id = '', $last_insert_id = 0, $row_id = 0)
	{
			$localdesignDB = DB::connection("localdesign");

			$count = 0;

			$new_raw = '';

			$labour_type_array = ["CFP", "Chain Labour", "Total Setting Charge", "Finding", "Packing, PD and other Miss", "Plating - Casting", "Plating - Chain"];

			$design_data = [];

			if($action_type == Config::get('constants.duplicate_design')) {
				$query2 = $localdesignDB
								 ->table("quotation_design_1")
								 ->where("id", $last_insert_id);
				$design_data = $query2->get();
			}
			elseif($action_type == Config::get('constants.edit_design')) {
				$query2 = $localdesignDB
								 ->table("quotation_design_1")
								 ->where("quotation_table_id", $quotation_id);
				$design_data = $query2->get();
			}
			elseif($action_type == Config::get('constants.add_design')) {
				$temp_data = [
					"row_no" => "",
					"image" => "",
					"image_type" => "",
					"product_type" => "",
					"product_code" => "",
					"their_code" => "",
					"metal_type" => "",
					"metal" => "",
					"metal_weight_casting" => "",
					"metal_weight_chain" => "",
					"value_of_metal" => "",

					"cost_1" => "",
					"cost_2" => "",
					"value_addition_cost_1" => "",
					"ex_factory_price" => "",
					"discount_per" => "",
					"discount_per" => "",
					"price_after_discount" => "",
					// "sale_price" => "",

					"labour_type" => '[""]',
					"labour_type" => '[""]',
					"setting_charge" => '[""]',
					"plating_type" => '[""]',
					"square_value" => '[""]',
					"labour_value" => '[""]',

					"labour_value_cfp" => '0',
					"labour_value_chain_labour" => '0',
					"labour_value_total_setting" => '0',
					"labour_value_finding" => '0',
					"labour_value_packing" => '0',
					"labour_value_plating_casting" => '0',
					"labour_value_plating_chains" => '0',

					"stone_name" => '[""]',
					"setting_type" => '[""]',
					"stone_cut" => '[""]',
					"stone_shape" => '[""]',
					"stone_size_l" => '[""]',
					"stone_size_w" => '[""]',
					"stone_diamond_quality" => '[""]',
					"setting_type" => '[""]',
					"price_unit" => '[""]',
					"stone_qty" => '[""]',
					"stone_weight" => '[""]',
					"stone_value" => '[""]',
					"value_added_per" => '[""]',
					"stone_value_added" => '[""]',
					"sale_price" => '[""]',
				];

				$design_data[0] = (object) $temp_data;

			}

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
					 if($action_type == Config::get('constants.edit_design')) {
						$row_id = $count;
						$id = $data->id;
					 }


					 $new_raw .='                 <tbody id="designpost-tbody-'.$row_id.'" class="designpost-tbody" > ';


											$new_raw .='
																									<tr>
																											<input type="hidden" id="designpost-section_id-'.$row_id.'" class="section_id-class"  name="section_id" value="'.$row_id.'" class="form-control">
																											<input type="hidden" id="designpost-id-'.$row_id.'" name="id" value="'.$id.'" class="form-control">
																											<input type="hidden" id="designpost-row_no-'.$row_id.'" name="row_no" value="'.$data->row_no.'" class="form-control">
																											<input type="hidden" id="designpost-image-'.$row_id.'" name="image" value="'.$data->image.'" class="form-control">
																											<input type="hidden" id="designpost-image_type-'.$row_id.'" name="image_type" value="'.$data->image_type.'" class="form-control">
																											<!-- <td class="design1-form1-table1 designpost-tbody-class-'.$row_id.' header_column " >'.$row_id.'</td> -->

																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.' header_column first-col sticky-col " >
																												<input type="number" id="designpost-current_row_no-'.$row_id.'" name="current_row_no" value="'.$row_id.'" class="form-control-plaintext center-text">
																												<p style="display: inherit">
																													<a href="javascript:void(0)"  title="Save" onclick="editform(this, '.$row_id.')" class="btn btn-success btn_size_1"><i class="fa fa-flash btn_icon"></i></a>
																													<a href="javascript:void(0)"  title="Duplicate" onclick="editform(this, '.$row_id.', \'duplicate\')" class="btn btn-info btn_size_1"><i class="fa fa-clone btn_icon"></i></a>
																													<a href="javascript:void(0)" title="Delete"  onclick="showConfirmDialog('.$row_id.')" class="btn btn-danger btn_space btn_size_1"><span><i class="fa fa-trash btn_icon"></i></span></a>
																												</p>
																											</td>

																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.' header_column second-col sticky-col  " >

																													<button type="button" onclick="updateDesignRawID('.$row_id.')" class="btn btn-primary" data-toggle="modal" data-target="#selectDesignModal">
																															Select Image Type
																													</button>
																													<span id="designpost-image_src-'.$row_id.'" > ';
																													if($data->image == "" || $data->image == NULL ) {}
																													else {
																														$new_raw .= '  <img id="designpost-img_src-'.$row_id.'"  src="'.env('APP_URL').'/storage/design_img/'.$data->image.'" class="table-design_img zoom-images element-image">';
																												}
																												$new_raw .= '               		</span>';

																											// 	if($data->image == "" || $data->image == NULL ) {}
																											// 	else {
																											// 		$new_raw .= '	<button type="button" class="btn btn-primary btn_size_1" onclick="displayImageModal('.$row_id.')" >
								                                      //                   		<i class="fa fa-eye btn_icon"></i>
								                                      //                   </button> ';
																											// }

																									$new_raw .= '
																															<button type="button" class="btn btn-primary btn_size_1" onclick="displayImageModal('.$row_id.')" >
																																	<i class="fa fa-eye btn_icon"></i>
																															</button>
																											</td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.' third-col sticky-col  "  ><input type="text" id="designpost-product_code-'.$row_id.'" name="product_code" value="'.$data->product_code.'" class="form-control"></td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" ><input style="width: 80px;" type="text" id="designpost-their_code-'.$row_id.'" name="their_code" value="'.$data->their_code.'" class="form-control"></td>

																											<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" >
																													<select name="product_type" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-product_type" style="width: 130px;" id="designpost-product_type-'.$row_id.'"   >';
																													if(isset($data->product_type)) { 	$new_raw .='  <option value="'.$data->product_type.'" Selected >'.$data->product_type.'</option>'; }
																												$new_raw .='</select>
																											</td>

																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.' metal_type " >
																												<select name="metal_type" class="form-control select2-lib-dropdown-metal_type"  onchange="perforMetalTypeCalculation('.$row_id.', this)"  style="width: 130px;" id="designpost-metal_type-'.$row_id.'"   >';
																												if(isset($data->metal_type)) { 	$new_raw .='  <option value="'.$data->metal_type.'" Selected >'.$data->metal_type.'</option>'; }
																											$new_raw .='</select>
																											</td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" >
																												<select name="metal" onchange="performCalculation('.$row_id.', this)" class="form-control select2-lib-dropdown-metal_name" style="width: 130px;"  id="designpost-metal-'.$row_id.'"   >';
																												if(isset($data->metal)) { 	$new_raw .='  <option value="'.$data->metal.'" Selected >'.$data->metal.'</option>'; }
																											$new_raw .='</select>
																											</td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" ><input style="width: 80px;" type="number" onchange="performCalculation('.$row_id.')" id="designpost-metal_weight_casting-'.$row_id.'" name="metal_weight_casting" value="'.$data->metal_weight_casting.'" class="form-control"></td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" ><input style="width: 80px;" type="number" onchange="performCalculation('.$row_id.')" id="designpost-metal_weight_chain-'.$row_id.'" name="metal_weight_chain" value="'.$data->metal_weight_chain.'" class="form-control"></td>
																											<td class="design1-form1-table1 designpost-tbody-class-'.$row_id.'" ><input style="width: 80px;" type="number" id="designpost-value_of_metal-'.$row_id.'" name="value_of_metal" value="'.$data->value_of_metal.'" class="form-control"></td>

																											<td class="design1-form1-table1">
																											  <table style="margin: -4px">

																													<tbody id="designpost-labor-table-tbody-'.$row_id.'">';

																			$new_raw .= '
																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-1" value="1" >
																													</td>
																													<td  class="design1-form1-table1 ">
																															CFP
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number" readonly  name="labour_value_cfp" class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_cfp" value="'.$data->labour_value_cfp.'" >
																													</td>
																												</tr>

																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-2" value="2" >
																													</td>
																													<td  class="design1-form1-table1 ">
																															Chain Labour
																															<span class="chain_labour_toolTip">
																				                        <i class="fa fa-question-circle"></i>
																				                      </span>
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number"  name="labour_value_chain_labour"  onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_chain_labour" value="'.$data->labour_value_chain_labour.'" >
																													</td>
																												</tr>

																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-3" value="3" >
																													</td>
																													<td  class="design1-form1-table1 ">
																															Total Setting Charge
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number" readonly  name="labour_value_total_setting" class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_total_setting" value="'.$data->labour_value_total_setting.'" >
																													</td>
																												</tr>

																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-4" value="4" >
																													</td>
																													<td  class="design1-form1-table1 ">
																															Finding
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number"  name="labour_value_finding"  onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_finding" value="'.$data->labour_value_finding.'" >
																													</td>
																												</tr>

																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-5" value="5" >
																													</td>
																													<td  class="design1-form1-table1 ">
																															Packing, PD and other Miss.
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number"  name="labour_value_packing"  onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_packing" value="'.$data->labour_value_packing.'" >
																													</td>
																												</tr>

																												<tr>
																													<td class="design1-form1-table1">
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-6" value="6" >
																													</td>
																													<td  id="designpost-'.$row_id.'-row-plating_casting_td"    class="design1-form1-table1';
																														if(isset($data->plating_casting)) { if( stripos($data->plating_casting, "square") !== false) { 	$new_raw .=' square_value '; } }
																												$new_raw .='
																													">
																														';

																														// $check_gold_0 = 0;
																														// $check_silver_0 = 0;

																															if(stripos("gold", $data->metal_type) !== false) {
																																// $check_gold_0 = 1;
																																$new_raw .= '	 <input name="gold_text_casting" style="width: 100px;" class="form-control-plaintext" id="designpost-plating_casting-gold_plating_text-'.$row_id.'" value="Pen Plating">';
																															}
																															elseif(stripos("silver", $data->metal_type) !== false ) {
																																// $check_silver_0 = 1;
																																$new_raw .='
																																	Plating Casting Products
																																<select name="plating_casting" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-plating_casting" style="width: 100px;" id="designpost-'.$row_id.'-row-plating_casting"  >';
																																if(isset($data->plating_casting)) { 	$new_raw .='  <option value="'.$data->plating_casting.'" Selected >'.$data->plating_casting.'</option>'; }
																																$new_raw .='</select>';
																																	if(isset($data->plating_casting)) { if( stripos($data->plating_casting, "square") !== false) {
																																		$square_value_uom = 0;
																																		$plating_casting_array = explode(",", $data->plating_casting);
																																		if(isset($plating_casting_array[2])) {
																																			$square_value_uom = $plating_casting_array[count($plating_casting_array) - 1];
																																		}
																																		$new_raw .= '	 <input name="square_value" id="designpost-plating_casting-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_casting-square_value\', '.$square_value_uom.')"   class="form-control " style="width: 100px;"  ';
																																			if(isset($data->plating_casting_square_value)) { 	$new_raw .=' value="'.$data->plating_casting_square_value.'" ';  }
																																		$new_raw .=' >';
																																	 } }
																															}

																															if($action_type == 'add')  { $new_raw .=' Plating Casting Products	';}


																																// if($check_gold_0 == 0) {
																																// 	$new_raw .= '	 <input name="gold_text_casting" style="display: none;width: 100px;" class="form-control-plaintext" id="designpost-plating_casting-gold_plating_text-'.$row_id.'" value="Pen Plating">';
																																// }

																																// if($check_silver_0 == 0) {
																																// // hide the dropdown by default
																																// $new_raw .='<select name="plating_casting" style="display: none;width: 100px;" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-plating_casting"  id="designpost-'.$row_id.'-row-plating_casting"  >';
																																// if(isset($data->plating_casting)) { 	$new_raw .='  <option value="'.$data->plating_casting.'" Selected >'.$data->plating_casting.'</option>'; }
																																// $new_raw .='</select>';
																																// 	if(isset($data->plating_casting)) { if( stripos($data->plating_casting, "square") !== false) {
																																// 		$square_value_uom = 0;
																																// 		$plating_casting_array = explode(",", $data->plating_casting);
																																// 		if(isset($plating_casting_array[2])) {
																																// 			$square_value_uom = $plating_casting_array[count($plating_casting_array) - 1];
																																// 		}
																																// 		$new_raw .= '	 <input name="square_value" id="designpost-plating_casting-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_casting-square_value\', '.$square_value_uom.')"   class="form-control " style="display: none;width: 100px;" ';
																																// 			if(isset($data->plating_casting_square_value)) { 	$new_raw .=' value="'.$data->plating_casting_square_value.'" ';  }
																																// 		$new_raw .=' >';
																																// 	 } }
																																//
																																//  }



																														$new_raw .='
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number"  ';
																															if(stripos("gold", $data->metal_type) !== false) {
																																// $new_raw .= '	readonly ';
																															} else {
																																$new_raw .= '	readonly ';
																															}
																															$new_raw .= '  name="labour_value_plating_casting" onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_plating_casting" value="'.$data->labour_value_plating_casting.'" >
																													</td>
																												</tr>

																												<tr  ';
																												if(stripos("gold", $data->metal_type) !== false) {
																													// $check_gold_0 = 1;
																													$new_raw .= ' style="display:none;"	 ';
																												}
																											$new_raw .='	>
																													<td class="design1-form1-table1 " >
																																<input type="text" readonly  name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-7" value="7" >
																													</td>
																													<td id="designpost-'.$row_id.'-row-plating_chains_td"     class="design1-form1-table1 ';
																														if(isset($data->plating_chains)) { if( stripos($data->plating_chains, "square") !== false) { 	$new_raw .=' square_value '; } }
																												$new_raw .='
																													">
																														';

																															// $check_gold_1 = 0;
																															// $check_silver_1 = 0;

																												if(stripos("gold", $data->metal_type) !== false) {
																													// $check_gold_1 = 1;
																													$new_raw .= '	 <input name="gold_text_chains" style="width: 100px;" class="form-control-plaintext" id="designpost-plating_chains-gold_plating_text-'.$row_id.'" value="Pen Plating">';
																												}
																												elseif(stripos("silver", $data->metal_type) !== false) {

																													// $check_silver_1 = 1;

																													$new_raw .=' 	Plating - Chains	<select name="plating_chains" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-plating_chains" style="width: 100px;" id="designpost-'.$row_id.'-row-plating_chains"  >';
																														if(isset($data->plating_chains)) { 	$new_raw .='  <option value="'.$data->plating_chains.'" Selected >'.$data->plating_chains.'</option>'; }
																														$new_raw .='</select>';
																															if(isset($data->plating_chains)) { if( stripos($data->plating_chains, "square") !== false) {
																																$square_value_uom = 0;
																																$plating_chains_array = explode(",", $data->plating_chains);
																																if(isset($plating_chains_array[2])) {
																																	$square_value_uom = $plating_chains_array[count($plating_chains_array) - 1];
																																}
																																$new_raw .= '	 <input name="square_value" id="designpost-plating_chains-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_chains-square_value\', '.$square_value_uom.')"   class="form-control " style="width: 100px;"  ';
																																	if(isset($data->plating_chains_square_value)) { 	$new_raw .=' value="'.$data->plating_chains_square_value.'" ';  }
																																$new_raw .=' >';
																															 } }
																												}

																												if($action_type == 'add')  { $new_raw .=' 	Plating - Chains	';}


																													// if($check_gold_1 == 0 ) {
																													// 	$new_raw .= '	 <input name="gold_text_chains" style="display: none;width: 100px;" class="form-control-plaintext" id="designpost-plating_chains-gold_plating_text-'.$row_id.'" value="Pen Plating">';
																													// }

																													// if($check_silver_1 == 0) {
																													//
																													// $new_raw .='	<select name="plating_chains" style="display: none;width: 100px;" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-plating_chains"  id="designpost-'.$row_id.'-row-plating_chains"  >';
																													// 	if(isset($data->plating_chains)) { 	$new_raw .='  <option value="'.$data->plating_chains.'" Selected >'.$data->plating_chains.'</option>'; }
																													// 	$new_raw .='</select>';
																													// 		if(isset($data->plating_chains)) { if( stripos($data->plating_chains, "square") !== false) {
																													// 			$square_value_uom = 0;
																													// 			$plating_chains_array = explode(",", $data->plating_chains);
																													// 			if(isset($plating_chains_array[2])) {
																													// 				$square_value_uom = $plating_chains_array[count($plating_chains_array) - 1];
																													// 			}
																													// 			$new_raw .= '	 <input name="square_value" id="designpost-plating_chains-square_value'.$row_id.'" type="number" onchange="performLabourSettingCalculation('.$row_id.', '.$row_id.', this, \'plating_chains-square_value\', '.$square_value_uom.')"   class="form-control " style="display: none;width: 100px;"  ';
																													// 				if(isset($data->plating_chains_square_value)) { 	$new_raw .=' value="'.$data->plating_chains_square_value.'" ';  }
																													// 			$new_raw .=' >';
																													// 		 } }
																													//
																													//  }

																														$new_raw .='
																													</td>
																													<td  class="design1-form1-table1 ">
																															<input type="number"	name="labour_value_plating_chains" onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value_plating_chains" value="'.$data->labour_value_plating_chains.'" >
																													</td>
																												</tr>

																												</tbody>
																										</table>
																										</td>

																										<td class="design1-form1-table1">
																										<table style="margin: -4px;">

																											<tbody id="designpost-stone-table-tbody-'.$row_id.'">';

																											for ($i=0; $i <count($stone_name) ; $i++) {

																												$new_raw .= '<tr>

																										<td class="design1-form1-table1">
																													<input type="text" readonly name="row_2" class="form-control" id="designpost-'.$row_id.'-row-row_2-'.$i.'"  value="'.($i+1).'"  style="width: 61px;">
																										</td>

																										<td  class="design1-form1-table1 ">
																												<select name="stone_name" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_name" style="width: 130px;" id="designpost-'.$row_id.'-row-stone_name-'.$i.'"  >';
																												if(isset($stone_name[$i])) { 	$new_raw .='  <option value="'.$stone_name[$i].'" Selected >'.$stone_name[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="stone_shape" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_shape" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_shape-'.$i.'"  >';
																												if(isset($stone_shape[$i])) { 	$new_raw .='  <option value="'.$stone_shape[$i].'" Selected >'.$stone_shape[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="stone_cut" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_cut" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_cut-'.$i.'"  >';
																												if(isset($stone_cut[$i])) { 	$new_raw .='  <option value="'.$stone_cut[$i].'" Selected >'.$stone_cut[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="setting_type" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-setting_type" style="width: 100px;" id="designpost-'.$row_id.'-row-setting_type-'.$i.'"  >';
																												if(isset($setting_type[$i])) { 	$new_raw .='  <option value="'.$setting_type[$i].'" Selected >'.$setting_type[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="stone_size_l" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_size_l" style="width: 80px;" id="designpost-'.$row_id.'-row-stone_size_l-'.$i.'"  >';
																												if(isset($stone_size_l[$i])) { 	$new_raw .='  <option value="'.$stone_size_l[$i].'" Selected >'.$stone_size_l[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="stone_size_w" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_size_w" style="width: 80px;" id="designpost-'.$row_id.'-row-stone_size_w-'.$i.'"  >';
																												if(isset($stone_size_w[$i])) { 	$new_raw .='  <option value="'.$stone_size_w[$i].'" Selected >'.$stone_size_w[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1" ><input type="number" style="width: 80px;" onchange="performCalculation('.$row_id.')" id="designpost-stone_qty-'.$row_id.'" min="1" name="stone_qty"  value="'.$stone_qty[$i].'"  class="form-control"></td>
																										<td  class="design1-form1-table1 stone_weight"  >
																												<input type="number" style="width: 80px;" name="stone_weight" class="form-control" id="designpost-'.$row_id.'-row-stone_weight-'.$i.'" readonly value="'.$stone_weight[$i].'"  >
																											<!--	<a href="javascript:void(0)" title="" ><span style="padding-top: 5px;padding-left: 5px;">
																                          <i class="fa fa-question-circle"></i>
																                        </span> </a> -->
																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="stone_diamond_quality" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_diamond_quality" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_diamond_quality-'.$i.'"  >';
																												if(isset($stone_diamond_quality[$i])) { 	$new_raw .='  <option value="'.$stone_diamond_quality[$i].'" Selected >'.$stone_diamond_quality[$i].'</option>'; }
																												$new_raw .='</select>

																										</td>
																										<td  class="design1-form1-table1 ">
																												<select name="price_unit" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-price_unit" style="width: 80px;" id="designpost-'.$row_id.'-row-price_unit-'.$i.'"  >';
																												if(isset($price_unit[$i])) { 	$new_raw .='  <option value="'.$price_unit[$i].'" Selected >'.$price_unit[$i].'</option>'; }
																												$new_raw .='</select>
																										</td>
																										<td  class="design1-form1-table1 stone_value"  >
																												<input type="number" style="width: 80px;"  name="stone_value" class="form-control" id="designpost-'.$row_id.'-row-stone_value-'.$i.'" readonly  value="'.( isset($stone_value[$i]) ? $stone_value[$i] : 0 ).'"  >
																												<!-- <a href="javascript:void(0)" title="" ><span style="padding-top: 5px;padding-left: 5px;">
																                          <i class="fa fa-question-circle"></i>
																                        </span> </a> -->
																										</td>

																 										<td  class="design1-form1-table1 value_added_per " >
																												<input type="number" style="width: 80px;"  onchange="performCalculation('.$row_id.')" name="value_added_per" class="form-control" id="designpost-'.$row_id.'-row-value_added_per-'.$i.'"  value="'.( isset($value_added_per[$i]) ? $value_added_per[$i] : 0 ).'"  >
																										</td>
																 										<td  class="design1-form1-table1 sale_price "><input type="text" style="width: 80px;" readonly  name="sale_price" class="form-control" id="designpost-'.$row_id.'-row-sale_price-'.$i.'"  value="'.( isset($sale_price[$i]) ? $sale_price[$i] : 0 ).'"  ></td>
																 										<td  class="design1-form1-table1 stone_value_added "><input type="text" style="width: 80px;" readonly  name="stone_value_added" class="form-control" id="designpost-'.$row_id.'-row-stone_value_added-'.$i.'"  value="'.( isset($stone_value_added[$i]) ? $stone_value_added[$i] : 0 ).'"  ></td>

																										<td class="design1-form1-table1"> ';
																													if($i>=1) {
																													$new_raw .=' <p style="display: inline-flex; margin:0px;" >
																								 													<a href="javascript:void(0)" title="Add" onclick="addMoreData2(this,'.$row_id.',  \'add\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-plus btn_icon"></i></span></a>
																																					<a href="javascript:void(0)" title="Duplicate" onclick="addMoreData2(this,'.$row_id.', \'duplicate\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-clone btn_icon"></i></span></a>
																																					<a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData2(this, '.$row_id.', \'delete\')" class="btn btn-danger btn_space" style="height: 28px;"><span><i class="fa fa-trash" style="vertical-align: top;"></i></span></a>
																																				</p> ';
																													}
																													else {
																													$new_raw .=' <p style="display: inline-flex;margin:0px;" >
																																					<a href="javascript:void(0)" title="Add" onclick="addMoreData2(this,'.$row_id.',  \'add\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-plus btn_icon"></i></span></a>
																																					<a href="javascript:void(0)" title="Duplicate" onclick="addMoreData2(this,'.$row_id.', \'duplicate\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-clone btn_icon"></i></span></a>
																																				  <a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData2(this, '.$row_id.', \'delete_first\')" class="btn btn-danger btn_space" style="height: 28px;"><span><i class="fa fa-trash" style="vertical-align: top;"></i></span></a>
																																			</p>';
																													}
																												$new_raw .='
																										</td>

																										 			</tr>
																												';
																											}
																											$new_raw .= '

																											</tbody>
																										</table>
																									</td>

																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="cost_1" class="form-control" style="width: 80px;" id="designpost-cost_1-'.$row_id.'" value="'.$data->cost_1.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="cost_2" class="form-control" style="width: 80px;" id="designpost-cost_2-'.$row_id.'" value="'.$data->cost_2.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="value_addition_cost_1" class="form-control" style="width: 100px;" id="designpost-value_addition_cost_1-'.$row_id.'"  value="'.$data->value_addition_cost_1.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="ex_factory_price" class="form-control" style="width: 100px;" id="designpost-ex_factory_price-'.$row_id.'" value="'.$data->ex_factory_price.'" ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" name="discount_per" onchange="performCalculation('.$row_id.')"  class="form-control" style="width: 80px;" id="designpost-discount_per-'.$row_id.'"  value="'.$data->discount_per.'"  ></td>
																									<td  class="design1-form1-table1 designpost-tbody-class-'.$row_id.'"><input type="number" readonly name="price_after_discount" class="form-control" style="width: 100px;" id="designpost-price_after_discount-'.$row_id.'" value="'.$data->price_after_discount.'" ></td>

																									</tr> ';

						 $new_raw .= '
											</tbody>';
					 }

				}
		return $new_raw;
	}

	public static function design1AddMoreData($action_type = 'add',$row_id = 0, $current_section = 0, $getData = [])
	{
		$erpnextDB = DB::connection("erpnext");

			$i = $current_section;
			$new_raw = '';

			$temp_data = [];

			if($action_type == Config::get('constants.duplicate_design')) {
				$temp_data = [
					"labour_type" => json_encode($getData['labour_type']),
				];

				$data = (object) $temp_data;

			}
			elseif($action_type == Config::get('constants.add_design')) {
				$temp_data = [
					"labour_type" => '[""]',
				];

			}

			$data = (object) $temp_data;

				$labour_type = json_decode($data->labour_type);


					 $new_raw .='<tr id="designpost-'.$row_id.'-row-id-'.$i.'" >

										 <td class="design1-form1-table1">
												 <input type="number" readonly onchange="performCalculation('.$row_id.')" name="row_1" class="form-control" style="width: 59px;" id="designpost-'.$row_id.'-row-row_1-'.$i.'"  value="1" >
										 </td>

										<td class="design1-form1-table1" >
												<select name="labour_type" onchange="performCalculation('.$row_id.')" id="designpost-'.$row_id.'-row-labour_type-'.$i.'" class="form-control  select2-lib-dropdown-labour_type " style="width: 100px;">';
										$new_raw .='
												</select>
										</td>
										<td class="design1-form1-table1 labour_value">
												<input type="text"  name="labour_value" class="form-control" style="width: 100px;" id="designpost-'.$row_id.'-row-labour_value-'.$i.'"  value=""  >
										</td>
										<td class="design1-form1-table1">
											<p style="display: flex; margin:0px;" >
												<a href="javascript:void(0)" title="Duplicate" onclick="addMoreData(this,'.$row_id.')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-plus btn_icon"></i></span></a>
												<a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData(this,'.$row_id.')" class="btn btn-danger btn_space" style="height: 28px;"><span><i class="fa fa-trash" style="vertical-align: top;"></i></span></a>
											</p>
										</td>

								</tr>';

		return $new_raw;
	}

	public static function design1AddMoreData2($action_type = 'add',$row_id = 0, $current_section = 0, $getData = [])
	{
		$erpnextDB = DB::connection("erpnext");


			$i = $current_section;

			$new_raw = '';

			$temp_data = [];


			if($action_type == 'duplicate' ) {
				// $temp_data = [
					$stone_name[0] = isset($getData['stone_name']) ? $getData['stone_name']  : ''  ;
					$setting_type[0] = isset($getData['setting_type']) ? $getData['setting_type'] : '' ;
					$stone_cut[0] = isset($getData['stone_cut']) ? $getData['stone_cut'] : '' ;
					$stone_shape[0] = isset($getData['stone_shape']) ? $getData['stone_shape'] : '' ;
					$stone_size_l[0] = isset($getData['stone_size_l']) ? $getData['stone_size_l'] : '' ;
					$stone_size_w[0] = isset($getData['stone_size_w']) ? $getData['stone_size_w'] : '' ;
					$stone_diamond_quality[0] = isset($getData['stone_diamond_quality']) ? $getData['stone_diamond_quality'] : '' ;
					$setting_type[0] = isset($getData['setting_type']) ? $getData['setting_type'] : '' ;
					$price_unit[0] = isset($getData['price_unit']) ? $getData['price_unit'] : '' ;
					$stone_qty[0] = isset($getData['stone_qty']) ? $getData['stone_qty'] : 0 ;
					$stone_weight[0] = isset($getData['stone_weight']) ? $getData['stone_weight'] : 0 ;
					$stone_value[0] = isset($getData['stone_value']) ? $getData['stone_value'] : 0 ;
					$value_added_per[0] = isset($getData['value_added_per']) ? $getData['value_added_per'] : 0 ;
					$stone_value_added[0] = isset($getData['stone_value_added']) ? $getData['stone_value_added'] : 0 ;
					$sale_price[0] = isset($getData['sale_price']) ? $getData['sale_price'] : 0 ;
				// ];

				$data = (object) $temp_data;

			}
			elseif($action_type == 'add' ) {
				// $temp_data = [
						$stone_name[0] = '';
						$setting_type[0] = '';
						$stone_cut[0] = '';
						$stone_shape[0] = '';
						$stone_size_l[0] = '';
						$stone_size_w[0] = '';
						$stone_diamond_quality[0] = '';
						$setting_type[0] = '';
						$price_unit[0] = '';
						$stone_qty[0] = 0;
						$stone_weight[0] = 0;
						$stone_value[0] = 0;
						$value_added_per[0] = 0;
						$stone_value_added[0] = 0;
						$sale_price[0] = 0;
				// ];

			}

			$data = (object) $temp_data;


					 $new_raw .='<tr id="designpost-'.$row_id.'-row-id-'.$i.'" >

													 <td class="design1-form1-table1">
								 								<input type="text" readonly name="row_2" class="form-control" id="designpost-'.$row_id.'-row-row_2-'.$i.'"  value="1"  style="width: 61px;">
								 					</td>

								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_name" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_name" style="width: 130px;" id="designpost-'.$row_id.'-row-stone_name-'.$i.'"  >';
								 							if(isset($stone_name[0])) { 	$new_raw .='  <option value="'.$stone_name[0].'" Selected >'.$stone_name[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_shape" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_shape" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_shape-'.$i.'"  >';
								 							if(isset($stone_shape[0])) { 	$new_raw .='  <option value="'.$stone_shape[0].'" Selected >'.$stone_shape[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_cut" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_cut" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_cut-'.$i.'"  >';
								 							if(isset($stone_cut[0])) { 	$new_raw .='  <option value="'.$stone_cut[0].'" Selected >'.$stone_cut[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="setting_type" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-setting_type" style="width: 100px;" id="designpost-'.$row_id.'-row-setting_type-'.$i.'"  >';
								 							if(isset($setting_type[0])) { 	$new_raw .='  <option value="'.$setting_type[0].'" Selected >'.$setting_type[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_size_l" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_size_l" style="width: 80px;" id="designpost-'.$row_id.'-row-stone_size_l-'.$i.'"  >';
								 							if(isset($stone_size_l[0])) { 	$new_raw .='  <option value="'.$stone_size_l[0].'" Selected >'.$stone_size_l[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_size_w" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_size_w" style="width: 80px;" id="designpost-'.$row_id.'-row-stone_size_w-'.$i.'"  >';
								 							if(isset($stone_size_w[0])) { 	$new_raw .='  <option value="'.$stone_size_w[0].'" Selected >'.$stone_size_w[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>
													<td  class="design1-form1-table1" ><input type="number" style="width: 80px;" onchange="performCalculation('.$row_id.')" id="designpost-stone_qty-'.$row_id.'" min="1" name="stone_qty"  value="'.$stone_qty[0].'"  class="form-control"></td>
								 					<td  class="design1-form1-table1 stone_weight"  >
								 							<input type="number" style="width: 80px;" name="stone_weight" class="form-control" id="designpost-'.$row_id.'-row-stone_weight-'.$i.'" readonly value="'.$stone_weight[0].'"  >
								 						<!--	<a href="javascript:void(0)" title="" ><span style="padding-top: 5px;padding-left: 5px;">
								 								<i class="fa fa-question-circle"></i>
								 							</span> </a> -->
								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="stone_diamond_quality" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-stone_diamond_quality" style="width: 100px;" id="designpost-'.$row_id.'-row-stone_diamond_quality-'.$i.'"  >';
								 							if(isset($stone_diamond_quality[0])) { 	$new_raw .='  <option value="'.$stone_diamond_quality[0].'" Selected >'.$stone_diamond_quality[0].'</option>'; }
								 							$new_raw .='</select>

								 					</td>
								 					<td  class="design1-form1-table1 ">
								 							<select name="price_unit" onchange="performCalculation('.$row_id.')" class="form-control select2-lib-dropdown-price_unit" style="width: 80px;" id="designpost-'.$row_id.'-row-price_unit-'.$i.'"  >';
								 							if(isset($price_unit[0])) { 	$new_raw .='  <option value="'.$price_unit[0].'" Selected >'.$price_unit[0].'</option>'; }
								 							$new_raw .='</select>
								 					</td>

								 					<td  class="design1-form1-table1 stone_value"  >
								 							<input type="number" style="width: 80px;"  name="stone_value" class="form-control" id="designpost-'.$row_id.'-row-stone_value-'.$i.'" readonly value="'.( isset($stone_value[0]) ? $stone_value[0] : 0 ).'"  >
								 							<!-- <a href="javascript:void(0)" title="" ><span style="padding-top: 5px;padding-left: 5px;">
								 								<i class="fa fa-question-circle"></i>
								 							</span> </a> -->
								 					</td>

								 					<td  class="design1-form1-table1 value_added_per " >
								 							<input type="number" style="width: 80px;"  onchange="performCalculation('.$row_id.')" name="value_added_per" class="form-control" id="designpost-'.$row_id.'-row-value_added_per-'.$i.'"  value="'.( isset($value_added_per[0]) ? $value_added_per[0] : 0 ).'"  >
								 					</td>
								 					<td  class="design1-form1-table1 sale_price "><input type="number" style="width: 80px;" readonly  name="sale_price" class="form-control" id="designpost-'.$row_id.'-row-sale_price-'.$i.'"  value="'.( isset($sale_price[0]) ? $sale_price[0] : 0 ).'"  ></td>
								 					<td  class="design1-form1-table1 stone_value_added "><input type="number" style="width: 80px;" readonly  name="stone_value_added" class="form-control" id="designpost-'.$row_id.'-row-stone_value_added-'.$i.'"  value="'.( isset($stone_value_added[0]) ? $stone_value_added[0] : 0 ).'"  ></td>

								 					<td class="design1-form1-table1"> ';

								 								$new_raw .=' <p style="margin:0px; display: inline-flex;" >
																									<a href="javascript:void(0)" title="Add" onclick="addMoreData2(this,'.$row_id.', \'add\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-plus btn_icon"></i></span></a>
																									<a href="javascript:void(0)" title="Duplicate" onclick="addMoreData2(this,'.$row_id.', \'duplicate\')" class="btn btn-info btn_space btn_size_1"><span><i class="fa fa-clone btn_icon"></i></span></a>
																									<a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData2(this, '.$row_id.')" class="btn btn-danger btn_space" style="height: 28px;"><span><i class="fa fa-trash" style="vertical-align: top;"></i></span></a>
								 														</p>';

								 							$new_raw .='
								 					</td>


								</tr>';

		return $new_raw;
	}

	public static function design2RowFrom($action_type = 'add', $quotation_id = '', $last_insert_id = 0, $row_id = 0)
	{
		$erpnextDB = DB::connection("erpnext");
		$localdesignDB = DB::connection("localdesign");
		$query2 = $erpnextDB
						 ->table("tabGemstone")
						 ->select("stone_name");
		$stone_data = $query2->get();

		$query2 = $erpnextDB
						 ->table("tabStone Shape")
						 ->select("shape_name");
		$stoneshape_data = $query2->get();

		$design_data = [];

		if($action_type == Config::get('constants.duplicate_design') ) {
			$query2 = $localdesignDB
							 ->table("quotation_design_2")
							 ->where("id", $last_insert_id);
			$design_data = $query2->get();
		}
		elseif($action_type == Config::get('constants.edit_design') ) {
			$query2 = $localdesignDB
							 ->table("quotation_design_2")
							 ->where("quotation_table_id", $quotation_id);
			$design_data = $query2->get();
		}
		elseif($action_type == Config::get('constants.add_design') ) {
			$temp_data = [
				"current_row" => 2,
				"image" => '',
				"image_type" => '',
				"design" => '',

				"silver_act_wt" => '[""]',
				"silver_add_wt" => '[""]',
				"silver_wt" => '[""]',
				"stone_wt" => '[""]',
				"stone_diamond_name" => '[""]',
				"stone_diamond_shape" => '[""]',
				"stone_diamond_size" => '[""]',
				"stone_diamond_qty" => '[""]',
				"stone_diamond_weight" => '[""]',
				"stone_diamond_price" => '[""]',
				"stone_diamond_inc_margin" => '[""]',
				"stone_diamond_amt" => '[""]',
				"silver_amt" => '[""]',
				"labour_charge" => '[""]',
				"labour" => '[""]',
				"setting" => '[""]',
				"misc_item" => '[""]',
				"misc_cost" => '[""]',
				"plating_gp" => '[""]',
				"plating_rp" => '[""]',
				"total_cost_ss" => '[""]',
				"total_cost_gp" => '[""]',
				"total_cost_rp" => '[""]',
				"finding_charge" => '[""]',
				"value_add_per" => '[""]',
				"value_addition_ss" => '[""]',
				"value_addition_gp" => '[""]',
				"value_addition_rp" => '[""]',
				"sale_price_ss" => '[""]',
				"sale_price_gp" => '[""]',
				"sale_price_rp" => '[""]',
				"cost_change_1" => '[""]',
				"cost_change_2"=> '[""]',
				"cost_change_3" => '[""]',
			];

			$design_data[0] = (object) $temp_data;

		}



		$count = 0;

		$new_raw ='';

		if(!empty($design_data)) {
			foreach($design_data as $data) {
				$count++;

				$current_row = $data->current_row;
				$silver_act_wt = json_decode($data->silver_act_wt);
				$silver_add_wt = json_decode($data->silver_add_wt);
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
				$labour_charge = json_decode($data->labour_charge);
				$labour = json_decode($data->labour);
				$setting = json_decode($data->setting);
				$misc_item = json_decode($data->misc_item);
				$misc_cost = json_decode($data->misc_cost);
				$plating_gp = json_decode($data->plating_gp);
				$plating_rp = json_decode($data->plating_rp);
				$total_cost_ss = json_decode($data->total_cost_ss);
				$total_cost_gp = json_decode($data->total_cost_gp);
				$total_cost_rp = json_decode($data->total_cost_rp);
				$finding_charge = json_decode($data->finding_charge);
				$value_add_per = json_decode($data->value_add_per);
				$value_addition_ss = json_decode($data->value_addition_ss);
				$value_addition_gp = json_decode($data->value_addition_gp);
				$value_addition_rp = json_decode($data->value_addition_rp);
				$sale_price_ss = json_decode($data->sale_price_ss);
				$sale_price_gp = json_decode($data->sale_price_gp);
				$sale_price_rp = json_decode($data->sale_price_rp);
				$cost_change_1 = json_decode($data->cost_change_1);
				$cost_change_2 = json_decode($data->cost_change_2);
				$cost_change_3 = json_decode($data->cost_change_3);

				$id = 0;
				if($action_type == Config::get('constants.edit_design')) {
				 $row_id = $count;
				 $id = $data->id;
				}

				$new_raw .='
										<tbody style="border-top: 1px;" id="designpost-tbody-'.$row_id.'">';

				if($current_row >0) {

					for($i=0; $i<$current_row; $i++) {



						if($i==0) {

							$new_raw .= '
															<tr id="designpost-'.$row_id.'-row-id-'.$i.'">

															<input type="hidden" id="designpost-section_id-'.$row_id.'" class="section_id-class"  name="section_id" value="'.$row_id.'" class="form-control">
															<input type="hidden" id="designpost-current_row-'.$row_id.'" name="current_row" value="'.$data->current_row.'" class="form-control">
															<input type="hidden" id="designpost-id-'.$row_id.'" name="id" value="'.$id.'" class="form-control">
															<input type="hidden" id="designpost-image-'.$row_id.'" name="image" value="'.$data->image.'" class="form-control">
															<input type="hidden" id="designpost-image_type-'.$row_id.'" name="image_type" value="'.$data->image_type.'" class="form-control">

																	<td rowspan='.$data->current_row.' class="design1-form1-table2 designpost-tbody-class-'.$row_id.'"><b>
																	<button type="button" onclick="updateDesignRawID('.$row_id.')" class="btn btn-primary" data-toggle="modal" data-target="#selectDesignModal">
																										Select Image Type
																								</button>
																								<span id="designpost-image_src-'.$row_id.'" > ';
																								if($data->image == "" || $data->image == NULL ) {}
																								else {
																									$new_raw .= '  <img src="'.env('APP_URL').'/storage/design_img/'.$data->image.'" class="table-design_img zoom-images">';
																							}
								$new_raw .= '               </span>
																	</td>
																	<td rowspan='.$data->current_row.' class="design1-form1-table2 designpost-tbody-class-'.$row_id.'" bgcolor="#BFBFBF"><b>
																		<textarea type="text" id="designpost-design-'.$row_id.'" name="design" value="" class="form-control" style="width: 100px; height:110px">'.$data->design.'</textarea></b>
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_act_wt-'.$i.'" name="silver_act_wt" value="'.$silver_act_wt[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="1" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_add_wt-'.$i.'" name="silver_add_wt" value="'.$silver_add_wt[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-silver_wt-'.$i.'" name="silver_wt" value="'.$silver_wt[$i].'" class="form-control" style="width: 80px;">
																	</td>
																	<td  class="design1-form1-table2">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_wt-'.$i.'" name="stone_wt" value="'.$stone_wt[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2" bgcolor="#FAC090">
																			<select name="stone_diamond_name[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_name-'.$i.'">
																						<option value="" ></option>';
																						$stone_diamond_name_array[0] = $stone_diamond_name[$i];
																							foreach($stone_data as $key => $value){
																									$new_raw .='<option value="'.$value->stone_name.'" '. ( in_array($value->stone_name, $stone_diamond_name_array) ? ' Selected ' : ' ' )  .'  >'.$value->stone_name.' </option>';
																							}
																							$new_raw .='
																						</select>
																	</td>
																	<td class="design1-form1-table2" bgcolor="#FAC090">
																	<select name="stone_diamond_shape[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_shape-'.$i.'">
																				<option value="" ></option>';
																				$stone_diamond_shape_array[0] =  $stone_diamond_shape[$i];
																					foreach($stoneshape_data as $key => $value){
																							$new_raw .='<option value="'.$value->shape_name.'"  '. ( in_array($value->shape_name, $stone_diamond_shape_array) ? ' Selected ' : ' ' )  .'  >'.$value->shape_name.' </option>';
																					}
																					$new_raw .='
																				</select>
																	</td>
																	<td class="design1-form1-table2" bgcolor="#FAC090">
																		<input type="text" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_size-'.$i.'" name="stone_diamond_size" value="'.$stone_diamond_size[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2" bgcolor="#FAC090"><font color="#FF0000">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_qty-'.$i.'" name="stone_diamond_qty" value="'.$stone_diamond_qty[$i].'" class="form-control number-inputs" style="width: 80px;"></font>
																	</td>
																	<td bgcolor="#FAC090" class="design1-form1-table2">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_weight-'.$i.'" name="stone_diamond_weight" value="'.$stone_diamond_weight[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#FAC090" class="design1-form1-table2">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_price-'.$i.'" name="stone_diamond_price" value="'.$stone_diamond_price[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#FAC090" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_inc_margin-'.$i.'" name="stone_diamond_inc_margin" value="'.$stone_diamond_inc_margin[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#FAC090" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_amt-'.$i.'" name="stone_diamond_amt" value="'.$stone_diamond_amt[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-silver_amt-'.$i.'"  name="silver_amt" value="'.$silver_amt[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')"   id="designpost-'.$row_id.'-row-labour_charge-'.$i.'" name="labour_charge" value="'.$labour_charge[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0"  id="designpost-'.$row_id.'-row-labour-'.$i.'" name="labour" value="'.$labour[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-setting-'.$i.'" name="setting" value="'.$setting[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#93CDDD" class="design1-form1-table2">
																		<input type="text" id="designpost-'.$row_id.'-row-misc_item-'.$i.'" name="misc_item" value="'.$misc_item[$i].'" class="form-control" style="width: 80px;">
																	</td>
																	<td bgcolor="#93CDDD" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-misc_cost-'.$i.'" name="misc_cost" value="'.$misc_cost[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#B3A2C7" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_gp-'.$i.'" name="plating_gp" value="'.$plating_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#B3A2C7" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_rp-'.$i.'" name="plating_rp" value="'.$plating_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_ss-'.$i.'" name="total_cost_ss" value="'.$total_cost_ss[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_gp-'.$i.'" name="total_cost_gp" value="'.$total_cost_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_rp-'.$i.'" name="total_cost_rp" value="'.$total_cost_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#D99694" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-finding_charge-'.$i.'" name="finding_charge" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$finding_charge[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#D99694" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-value_add_per-'.$i.'" name="value_add_per" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$value_add_per[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#D99694" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_ss-'.$i.'" name="value_addition_ss"   value="'.$value_addition_ss[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#D99694" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_gp-'.$i.'" name="value_addition_gp"   value="'.$value_addition_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#D99694" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_rp-'.$i.'" name="value_addition_rp"  value="'.$value_addition_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_ss-'.$i.'" name="sale_price_ss" value="'.$sale_price_ss[$i].'" class="form-control number-inputs" style="width:80px;">
																	</td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_gp-'.$i.'" name="sale_price_gp" value="'.$sale_price_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_rp-'.$i.'" name="sale_price_rp" value="'.$sale_price_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td align="right" class="design1-form1-table2"><font color="#000000">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_1-'.$i.'" name="cost_change_1" value="'.$cost_change_1[$i].'" class="form-control number-inputs" style="width: 80px;"></font>
																	</td>
																	<td sdval="0" class="design1-form1-table2">
																	<font color="#000000">
																		<input type="number" id="designpost-'.$row_id.'-row-cost_change_2-'.$i.'" name="cost_change_2" value="'.$cost_change_2[$i].'" class="form-control number-inputs" style="width: 80px;"></font>
																	 </td>
																	<td sdval="0" class="design1-form1-table2">
																		<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_3-'.$i.'" name="cost_change_3" value="'.$cost_change_3[$i].'" class="form-control number-inputs" style="width: 80px;">
																	</td>
																	<td style="border-left: 1px solid #000000;     padding: 3px;"align="center" valign=middle >
																			<a href="javascript:void(0)" title="Duplicate" onclick="duplicateData('.$row_id.', '.$i.')" class="btn btn-info btn_space" style="height: 28px;"><span><i class="fa fa-plus" style="vertical-align: top;"></i></span></a>
																	</td>
																	<td rowspan='.$data->current_row.' class="design1-form1-table2 designpost-tbody-class-'.$row_id.'" height="129"><b>
																			 <a href="javascript:void(0)"  title="Save" onclick="editform('.$row_id.')" class="btn btn-success btn_size_1"><i class="fa fa-flash btn_icon"></i></a>
																			 <a href="javascript:void(0)"  title="Duplicate" onclick="editform('.$row_id.', \'duplicate\')" class="btn btn-info btn_size_1"><i class="fa fa-plus btn_icon"></i></a>
																			<a href="javascript:void(0)" title="Delete"  onclick="showConfirmDialog('.$row_id.')" class="btn btn-danger btn_space btn_size_1"><span><i class="fa fa-trash btn_icon"></i></span></a>
																	</b></td>
															</tr> ';
						}
						elseif($i == $current_row - 1) {

								$new_raw .= '
															<tr id="designpost-last-row-'.$row_id.'">
																	<td class="design1-form1-table2" colspan="2">
																	<a href="javascript:void(0)" onclick="addMoreData('.$row_id.')" class="btn btn-success btn-sm " ><i class="fa fa-plus"></i> Add More</a>
																	</td>
																	<td  class="design1-form1-table2"></td>
																	<td  class="design1-form1-table2"></td>
																	<td class="design1-form1-table2" bgcolor="#FAC090"></td>
																	<td class="design1-form1-table2" bgcolor="#FAC090"></td>
																	<td class="design1-form1-table2" bgcolor="#FAC090"></td>
																	<td class="design1-form1-table2" bgcolor="#FAC090"><font color="#FF0000"></td>
																	<td bgcolor="#FAC090" class="design1-form1-table2"></td>
																	<td bgcolor="#FAC090" class="design1-form1-table2"></td>
																	<td bgcolor="#FAC090" class="design1-form1-table2"></td>
																	<td bgcolor="#FAC090" class="design1-form1-table2"></td>
																	<td class="design1-form1-table2"></td>
																	<td class="design1-form1-table2"></td>
																	<td class="design1-form1-table2"></td>
																	<td class="design1-form1-table2"></td>
																	<td bgcolor="#93CDDD" class="design1-form1-table2"></td>
																	<td bgcolor="#93CDDD" class="design1-form1-table2"></td>
																	<td bgcolor="#B3A2C7" class="design1-form1-table2"></td>
																	<td bgcolor="#B3A2C7" class="design1-form1-table2"></td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2"></td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2"></td>
																	<td bgcolor="#C3D69B" class="design1-form1-table2"></td>
																	<td bgcolor="#D99694" class="design1-form1-table2"></td>
																	<td bgcolor="#D99694" class="design1-form1-table2"></td>
																	<td bgcolor="#D99694" class="design1-form1-table2"></td>
																	<td bgcolor="#D99694" class="design1-form1-table2"></td>
																	<td bgcolor="#D99694" class="design1-form1-table2"></td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2"></td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2"></td>
																	<td bgcolor="#95B3D7" class="design1-form1-table2"></td>
																	<td align="right" class="design1-form1-table2"><font color="#000000"></td>
																	<td sdval="0" class="design1-form1-table2"></td>
																	<td sdval="0" class="design1-form1-table2"></td>
																	<td sdval="0" class="design1-form1-table2"></td>
															</tr>';
						} else {

							if(isset($silver_act_wt[$i])) {

							}
							else {
								continue;
							}

							$new_raw .='
													<tr id="designpost-'.$row_id.'-row-id-'.$i.'" >
													<input type="hidden" id="designpost-'.$row_id.'-row-table_id-'.$i.'"  name="row_id" value="0" class="form-control">
															<td class="design1-form1-table2">
																<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_act_wt-'.$i.'" name="silver_act_wt" value="'.$silver_act_wt[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																<input type="number" min="1" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_add_wt-'.$i.'" name="silver_add_wt" value="'.$silver_add_wt[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																	<input type="number" min="0"  id="designpost-'.$row_id.'-row-silver_wt-'.$i.'" name="silver_wt" value="'.$silver_wt[$i].'" class="form-control" style="width: 80px;">
															</td>
															<td sdval="0" class="design1-form1-table2">
																	<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_wt-'.$i.'" name="stone_wt" value="'.$stone_wt[$i].'" class="form-control" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<select name="stone_diamond_name[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_name-'.$i.'">
																		<option value="" ></option>';
																		$stone_diamond_name_array[0] = $stone_diamond_name[$i];
																			foreach($stone_data as $key => $value) {
																					$new_raw .='<option value="'.$value->stone_name.'" '. ( in_array($value->stone_name, $stone_diamond_name_array) ? ' Selected ' : ' ' )  .' >'.$value->stone_name.' </option>';
																			}
																			$new_raw .='
																		</select>
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																		<select name="stone_diamond_shape[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_shape-'.$i.'">
																			<option value="" ></option>';
																			$stone_diamond_shape_array[0] = $stone_diamond_shape[$i];
																				foreach($stoneshape_data as $key => $value){
																						$new_raw .='<option value="'.$value->shape_name.'" '. ( in_array($value->shape_name, $stone_diamond_shape_array) ? ' Selected ' : ' ' )  .' >'.$value->shape_name.' </option>';
																				}
																				$new_raw .='
																		</select>
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<input type="text" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_size-'.$i.'" name="stone_diamond_size" value="'.$stone_diamond_size[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2"><font color="#FF0000"></font>
																	<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_qty-'.$i.'" name="stone_diamond_qty" value="'.$stone_diamond_qty[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_weight-'.$i.'" name="stone_diamond_weight" value="'.$stone_diamond_weight[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_price-'.$i.'" name="stone_diamond_price" value="'.$stone_diamond_price[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_inc_margin-'.$i.'" name="stone_diamond_inc_margin" value="'.$stone_diamond_inc_margin[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#FAC090" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_amt-'.$i.'" name="stone_diamond_amt" value="'.$stone_diamond_amt[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-silver_amt-'.$i.'" name="silver_amt" value="'.$silver_amt[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')"   id="designpost-'.$row_id.'-row-labour_charge-'.$i.'" name="labour_charge" value="'.$labour_charge[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																<input type="number" min="0"  id="designpost-'.$row_id.'-row-labour-'.$i.'" name="labour" value="'.$labour[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-setting-'.$i.'" name="setting" value="'.$setting[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#93CDDD" class="design1-form1-table2">
																	<input type="text" id="designpost-'.$row_id.'-row-misc_item-'.$i.'" name="misc_item" value="'.$misc_item[$i].'" class="form-control " style="width: 80px;">
															</td>
															<td bgcolor="#93CDDD" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-misc_cost-'.$i.'" name="misc_cost" value="'.$misc_cost[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#B3A2C7" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_gp-'.$i.'" name="plating_gp" value="'.$plating_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#B3A2C7" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_rp-'.$i.'" name="plating_rp" value="'.$plating_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#C3D69B" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_ss-'.$i.'" name="total_cost_ss" value="'.$total_cost_ss[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#C3D69B" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_gp-'.$i.'" name="total_cost_gp" value="'.$total_cost_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#C3D69B" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_rp-'.$i.'" name="total_cost_rp" value="'.$total_cost_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#D99694" class="design1-form1-table2">
																<input type="number" min="0" id="designpost-'.$row_id.'-row-finding_charge-'.$i.'" name="finding_charge" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$finding_charge[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#D99694" class="design1-form1-table2">
																<input type="number" min="0" id="designpost-'.$row_id.'-row-value_add_per-'.$i.'" name="value_add_per" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$value_add_per[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#D99694" class="design1-form1-table2">
																<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_ss-'.$i.'" name="value_addition_ss"   value="'.$value_addition_ss[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#D99694" class="design1-form1-table2">
																<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_gp-'.$i.'" name="value_addition_gp"   value="'.$value_addition_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#D99694" class="design1-form1-table2">
																<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_rp-'.$i.'" name="value_addition_rp"  value="'.$value_addition_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#95B3D7" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_ss-'.$i.'" name="sale_price_ss" value="'.$sale_price_ss[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#95B3D7" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_gp-'.$i.'" name="sale_price_gp" value="'.$sale_price_gp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td bgcolor="#95B3D7" class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_rp-'.$i.'" name="sale_price_rp" value="'.$sale_price_rp[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2"><font color="#000000">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_1-'.$i.'" name="cost_change_1" value="'.$cost_change_1[$i].'" class="form-control number-inputs" style="width: 80px;"> </font>
															</td>
															<td class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_2-'.$i.'" name="cost_change_2" value="'.$cost_change_2[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																	<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_3-'.$i.'" name="cost_change_3" value="'.$cost_change_3[$i].'" class="form-control number-inputs" style="width: 80px;">
															</td>
															<td class="design1-form1-table2">
																	<a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData('.$row_id.', '.$i.')" class="btn btn-danger btn_space btn_size_1" ><span><i class="fa fa-trash btn_icon" ></i></span></a>
																	<a href="javascript:void(0)" title="Duplicate" onclick="duplicateData('.$row_id.', '.$i.')" class="btn btn-info btn_space btn_size_1" ><span><i class="fa fa-plus btn_icon" ></i></span></a>
															</td>
													</tr>';
						}


					}
				}

				$new_raw .= '
									</tbody>';


			}
		}

		return $new_raw;
	}

	public static function design2AddMoreData($action_type = 'add',$row_id = 0, $current_section = 0, $getData = [])
	{

				$erpnextDB = DB::connection("erpnext");
				$localdesignDB = DB::connection("localdesign");
				$query2 = $erpnextDB
								 ->table("tabGemstone")
								 ->select("stone_name");
				$stone_data = $query2->get();

				$query2 = $erpnextDB
								 ->table("tabStone Shape")
								 ->select("shape_name");
				$stoneshape_data = $query2->get();


				$i = $current_section;
				$new_raw = '';

				$temp_data = [];

				// echo "<pre>";
				// print_r($getData);
				// die;

				if($action_type == Config::get('constants.duplicate_design')) {

					$temp_data = [
						// "current_row" => 2,
						// "image" => '',
						// "image_type" => '',
						// "design" => '',

						"silver_act_wt" => json_encode($getData['silver_act_wt']),
						"silver_add_wt" => json_encode($getData['silver_add_wt']),
						"silver_wt" => json_encode($getData['silver_wt']),
						"stone_wt" => json_encode($getData['stone_wt']),
						"stone_diamond_name" => json_encode($getData['stone_diamond_name']),
						"stone_diamond_shape" => json_encode($getData['stone_diamond_shape']),
						"stone_diamond_size" => json_encode($getData['stone_diamond_size']),
						"stone_diamond_qty" => json_encode($getData['stone_diamond_qty']),
						"stone_diamond_weight" => json_encode($getData['stone_diamond_weight']),
						"stone_diamond_price" => json_encode($getData['stone_diamond_price']),
						"stone_diamond_inc_margin" => json_encode($getData['stone_diamond_inc_margin']),
						"stone_diamond_amt" => json_encode($getData['stone_diamond_amt']),
						"silver_amt" => json_encode($getData['silver_amt']),
						"labour_charge" => json_encode($getData['labour_charge']),
						"labour" => json_encode($getData['labour']),
						"setting" => json_encode($getData['setting']),
						"misc_item" => json_encode($getData['misc_item']),
						"misc_cost" => json_encode($getData['misc_cost']),
						"plating_gp" => json_encode($getData['plating_gp']),
						"plating_rp" => json_encode($getData['plating_rp']),
						"total_cost_ss" => json_encode($getData['total_cost_ss']),
						"total_cost_gp" => json_encode($getData['total_cost_gp']),
						"total_cost_rp" => json_encode($getData['total_cost_rp']),
						"finding_charge" => json_encode($getData['finding_charge']),
						"value_add_per" => json_encode($getData['value_add_per']),
						"value_addition_ss" => json_encode($getData['value_addition_ss']),
						"value_addition_gp" => json_encode($getData['value_addition_gp']),
						"value_addition_rp" => json_encode($getData['value_addition_rp']),
						"sale_price_ss" => json_encode($getData['sale_price_ss']),
						"sale_price_gp" => json_encode($getData['sale_price_gp']),
						"sale_price_rp" => json_encode($getData['sale_price_rp']),
						"cost_change_1" => json_encode($getData['cost_change_1']),
						"cost_change_2"=> json_encode($getData['cost_change_2']),
						"cost_change_3" => json_encode($getData['cost_change_3']),
					];


				}
				elseif($action_type == Config::get('constants.add_design')) {
					$temp_data = [
						// "current_row" => 2,
						// "image" => '',
						// "image_type" => '',
						// "design" => '',

						"silver_act_wt" => '[""]',
						"silver_add_wt" => '[""]',
						"silver_wt" => '[""]',
						"stone_wt" => '[""]',
						"stone_diamond_name" => '[""]',
						"stone_diamond_shape" => '[""]',
						"stone_diamond_size" => '[""]',
						"stone_diamond_qty" => '[""]',
						"stone_diamond_weight" => '[""]',
						"stone_diamond_price" => '[""]',
						"stone_diamond_inc_margin" => '[""]',
						"stone_diamond_amt" => '[""]',
						"silver_amt" => '[""]',
						"labour_charge" => '[""]',
						"labour" => '[""]',
						"setting" => '[""]',
						"misc_item" => '[""]',
						"misc_cost" => '[""]',
						"plating_gp" => '[""]',
						"plating_rp" => '[""]',
						"total_cost_ss" => '[""]',
						"total_cost_gp" => '[""]',
						"total_cost_rp" => '[""]',
						"finding_charge" => '[""]',
						"value_add_per" => '[""]',
						"value_addition_ss" => '[""]',
						"value_addition_gp" => '[""]',
						"value_addition_rp" => '[""]',
						"sale_price_ss" => '[""]',
						"sale_price_gp" => '[""]',
						"sale_price_rp" => '[""]',
						"cost_change_1" => '[""]',
						"cost_change_2"=> '[""]',
						"cost_change_3" => '[""]',
					];

				}

				$data = (object) $temp_data;


				$silver_act_wt = json_decode($data->silver_act_wt);
				$silver_add_wt = json_decode($data->silver_add_wt);
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
				$labour_charge = json_decode($data->labour_charge);
				$labour = json_decode($data->labour);
				$setting = json_decode($data->setting);
				$misc_item = json_decode($data->misc_item);
				$misc_cost = json_decode($data->misc_cost);
				$plating_gp = json_decode($data->plating_gp);
				$plating_rp = json_decode($data->plating_rp);
				$total_cost_ss = json_decode($data->total_cost_ss);
				$total_cost_gp = json_decode($data->total_cost_gp);
				$total_cost_rp = json_decode($data->total_cost_rp);
				$finding_charge = json_decode($data->finding_charge);
				$value_add_per = json_decode($data->value_add_per);
				$value_addition_ss = json_decode($data->value_addition_ss);
				$value_addition_gp = json_decode($data->value_addition_gp);
				$value_addition_rp = json_decode($data->value_addition_rp);
				$sale_price_ss = json_decode($data->sale_price_ss);
				$sale_price_gp = json_decode($data->sale_price_gp);
				$sale_price_rp = json_decode($data->sale_price_rp);
				$cost_change_1 = json_decode($data->cost_change_1);
				$cost_change_2 = json_decode($data->cost_change_2);
				$cost_change_3 = json_decode($data->cost_change_3);


				// echo "<pre>";
				// print_r($data);
				// die;



				$new_raw .='
										<tr id="designpost-'.$row_id.'-row-id-'.$i.'" >
										<input type="hidden" id="designpost-'.$row_id.'-row-table_id-'.$i.'"  name="row_id" value="0" class="form-control">
												<td class="design1-form1-table2">
													<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_act_wt-'.$i.'" name="silver_act_wt" value="'.$silver_act_wt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
													<input type="number" min="1" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-silver_add_wt-'.$i.'" name="silver_add_wt" value="'.$silver_add_wt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
														<input type="number" min="0"  id="designpost-'.$row_id.'-row-silver_wt-'.$i.'" name="silver_wt" value="'.$silver_wt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td sdval="0" class="design1-form1-table2">
														<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_wt-'.$i.'" name="stone_wt" value="'.$stone_wt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<select name="stone_diamond_name[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_name-'.$i.'">
															<option value="" ></option>';
															$stone_diamond_name_array[0] = $stone_diamond_name[0];
																foreach($stone_data as $key => $value) {
																		$new_raw .='<option value="'.$value->stone_name.'" '. ( in_array($value->stone_name, $stone_diamond_name_array) ? ' Selected ' : ' ' )  .' >'.$value->stone_name.' </option>';
																}
																$new_raw .='
															</select>
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
															<select name="stone_diamond_shape[]" class="form-control select2-lib-dropdown" style="width: 150px;"  id="designpost-'.$row_id.'-row-stone_diamond_shape-'.$i.'">
																<option value="" ></option>';
																$stone_diamond_shape_array[0] = $stone_diamond_shape[0];
																	foreach($stoneshape_data as $key => $value){
																			$new_raw .='<option value="'.$value->shape_name.'" '. ( in_array($value->shape_name, $stone_diamond_shape_array) ? ' Selected ' : ' ' )  .' >'.$value->shape_name.' </option>';
																	}
																	$new_raw .='
															</select>
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<input type="text" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_size-'.$i.'" name="stone_diamond_size" value="'.$stone_diamond_size[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2"><font color="#FF0000"></font>
														<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_qty-'.$i.'" name="stone_diamond_qty" value="'.$stone_diamond_qty[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_weight-'.$i.'" name="stone_diamond_weight" value="'.$stone_diamond_weight[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')" id="designpost-'.$row_id.'-row-stone_diamond_price-'.$i.'" name="stone_diamond_price" value="'.$stone_diamond_price[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_inc_margin-'.$i.'" name="stone_diamond_inc_margin" value="'.$stone_diamond_inc_margin[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#FAC090" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-stone_diamond_amt-'.$i.'" name="stone_diamond_amt" value="'.$stone_diamond_amt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-silver_amt-'.$i.'" name="silver_amt" value="'.$silver_amt[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
													<input type="number" min="0" onchange="performCalculation('.$row_id.', '.$i.')"   id="designpost-'.$row_id.'-row-labour_charge-'.$i.'" name="labour_charge" value="'.$labour_charge[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
													<input type="number" min="0"  id="designpost-'.$row_id.'-row-labour-'.$i.'" name="labour" value="'.$labour[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-setting-'.$i.'" name="setting" value="'.$setting[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#93CDDD" class="design1-form1-table2">
														<input type="text" id="designpost-'.$row_id.'-row-misc_item-'.$i.'" name="misc_item" value="'.$misc_item[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#93CDDD" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-misc_cost-'.$i.'" name="misc_cost" value="'.$misc_cost[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#B3A2C7" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_gp-'.$i.'" name="plating_gp" value="'.$plating_gp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#B3A2C7" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-plating_rp-'.$i.'" name="plating_rp" value="'.$plating_rp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#C3D69B" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_ss-'.$i.'" name="total_cost_ss" value="'.$total_cost_ss[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#C3D69B" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_gp-'.$i.'" name="total_cost_gp" value="'.$total_cost_gp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#C3D69B" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-total_cost_rp-'.$i.'" name="total_cost_rp" value="'.$total_cost_rp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#D99694" class="design1-form1-table2">
													<input type="number" min="0" id="designpost-'.$row_id.'-row-finding_charge-'.$i.'" name="finding_charge" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$finding_charge[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#D99694" class="design1-form1-table2">
													<input type="number" min="0" id="designpost-'.$row_id.'-row-value_add_per-'.$i.'" name="value_add_per" onchange="performCalculation('.$row_id.', '.$i.')"  value="'.$value_add_per[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#D99694" class="design1-form1-table2">
													<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_ss-'.$i.'" name="value_addition_ss"   value="'.$value_addition_ss[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#D99694" class="design1-form1-table2">
													<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_gp-'.$i.'" name="value_addition_gp"   value="'.$value_addition_gp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#D99694" class="design1-form1-table2">
													<input type="number" min="0" id="designpost-'.$row_id.'-row-value_addition_rp-'.$i.'" name="value_addition_rp"  value="'.$value_addition_rp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#95B3D7" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_ss-'.$i.'" name="sale_price_ss" value="'.$sale_price_ss[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#95B3D7" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_gp-'.$i.'" name="sale_price_gp" value="'.$sale_price_gp[0].'" class="form-control" style="width: 80px;">
												</td>
												<td bgcolor="#95B3D7" class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-sale_price_rp-'.$i.'" name="sale_price_rp" value="'.$sale_price_rp[0].'" class="form-control"style="width: 80px;">
												</td>
												<td class="design1-form1-table2"><font color="#000000">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_1-'.$i.'" name="cost_change_1" value="'.$cost_change_1[0].'" class="form-control" style="width: 80px;"> </font>
												</td>
												<td class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_2-'.$i.'" name="cost_change_2" value="'.$cost_change_2[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
														<input type="number" min="0" id="designpost-'.$row_id.'-row-cost_change_3-'.$i.'" name="cost_change_3" value="'.$cost_change_3[0].'" class="form-control" style="width: 80px;">
												</td>
												<td class="design1-form1-table2">
														<a href="javascript:void(0)" title="Delete" onclick="deleteMoreRowData('.$row_id.', '.$i.')" class="btn btn-danger btn_space btn_size_1" ><span><i class="fa fa-trash  btn_icon" ></i></span></a>
														<a href="javascript:void(0)" title="Duplicate" onclick="duplicateData('.$row_id.', '.$i.')" class="btn btn-info btn_space btn_size_1" ><span><i class="fa fa-plus btn_icon" ></i></span></a>
												</td>
										</tr>';

		return $new_raw;
	}

	public static function overTimeCalculation($base_salary = 0, $over_time = 0)
	{
		$check = 0;
		if($base_salary < 25000 && $over_time >= 1) {
			$check = 1;
		}
		elseif($base_salary >= 25000 && $base_salary < 35000 && $over_time >= 3) {
			$check = 1;
		}
		elseif($base_salary >= 35000 && $base_salary < 50000 && $over_time >= 6) {
			$check = 1;
		}
		elseif($base_salary >= 50000) {
			$check = 0;
		}
		return $check;
	}

	public static function getSalarySlipDetails($salary_slip_id = '')
	{
		$erpnextDB = DB::connection("erpnext");
		$query1 = $erpnextDB
								->table("tabSalary Detail")
								->where("parent", $salary_slip_id)
								->orderBy("idx", "ASC");
		$salary_slip_data = $query1->get();
		return $salary_slip_data;
	}

	// public static function empOvertimeDetails($emp_id = '', $month)
	// {
	// 	$erpnextDB = DB::connection("erpnext");
	// 	$query1 = $erpnextDB
	// 							->table("tabSalary Detail")
	// 							->where("parent", $salary_slip_id);
	// 	$salary_slip_data = $query1->get();
	// 	return $salary_slip_data;
	// }

	public static function empAttendanceDetails($emp_id = '', $month = 0, $year = 0, $company = '')
	{
		$erpnextDB = DB::connection("erpnext");

		$query_date = "$year-$month-01";
    $query_string  = "SELECT  generated_date,
															tabAttendance.employee,
															tabAttendance.employee_name,
															tabAttendance.status,
															tabAttendance.leave_type,
															tabAttendance.in_time,
															tabAttendance.out_time,
															tabHoliday.holiday_date,
															tabHoliday.description holiday_description,
															tabHoliday.weekly_off
											FROM
									    	(SELECT adddate('$query_date', @rownum := @rownum + 1) generated_date
													FROM tabEmployee
									    		JOIN (SELECT @rownum := -1) r LIMIT 31) temp
									    Left JOIN tabAttendance on date(tabAttendance.attendance_date) = generated_date
									    		AND tabAttendance.employee  = '$emp_id'
													AND tabAttendance.docstatus = 1
									    Left JOIN tabHoliday on tabHoliday.holiday_date = generated_date
									WHERE MONTH(generated_date) = $month AND YEAR(generated_date) = $year
									GROUP BY generated_date;";
    $empAttendance_data = $erpnextDB->select($query_string);

		// echo "<pre>";
		// print_r($empAttendance_data);
		// die;

		// $start_date = "$year-$month-01 08:00:00";
		// $end_date = "$year-$month-02 07:59:59";
    // $query_string  = "SELECT  generated_start_date,
		// 													date(generated_start_date) generated_date,
		// 													generated_end_date,
		// 													tabAttendance.employee,
		// 													tabAttendance.employee_name,
		// 													tabAttendance.status,
		// 													tabAttendance.leave_type,
		// 													tabHoliday.holiday_date,
		// 													tabHoliday.description holiday_description,
		// 													tabHoliday.weekly_off,
		// 													`tabEmployee Checkin`.time in_time,
		// 											    checkIn2.time out_time
		// 									FROM
		// 									    	(SELECT adddate('$start_date', @rownum := @rownum + 1) generated_start_date,
		// 									    			 adddate('$end_date', @rownum) generated_end_date
		// 													FROM tabEmployee
		// 									    		JOIN (SELECT @rownum := -1) r LIMIT 31) temp
		// 									Left JOIN tabAttendance on tabAttendance.attendance_date = date(generated_start_date)
		// 									    		AND tabAttendance.employee  = '$emp_id'
		// 								  LEFT JOIN `tabEmployee Checkin` ON `tabEmployee Checkin`.employee = tabAttendance.employee
		// 							          			 AND ( `tabEmployee Checkin`.log_type = 'IN' )
		// 							                AND ( `tabEmployee Checkin`.time BETWEEN generated_start_date AND generated_end_date )
		// 							    LEFT JOIN `tabEmployee Checkin` checkIn2 ON checkIn2.employee = tabAttendance.employee
		// 							          			AND ( checkIn2.log_type = 'OUT' )
		// 							                AND ( checkIn2.time BETWEEN generated_start_date AND generated_end_date )
		// 									Left JOIN tabHoliday on tabHoliday.holiday_date = date(generated_start_date)
		// 									WHERE MONTH(generated_start_date) = $month AND YEAR(generated_start_date) = $year
		// 									Group By generated_start_date";
    // $empAttendance_data = $erpnextDB->select($query_string);

		return $empAttendance_data;
	}



	public static function getAttendanceStatus($status = '', $leave_type = '')
	{
		$temp_status = "";

		if($status == "Present") {
			$temp_status = "P";
		} elseif ($status == "Absent") {
			$temp_status = "A";
		} elseif ($status == "Half Day") {
			$temp_status = "HD" . (isset($leave_type) ? "/". $leave_type : "");
		} elseif ($status == "On Leave") {
			$temp_status = "L" . (isset($leave_type) ? "/". $leave_type : "");
		}

		return $temp_status;
	}



	public static function getEmployeesOtDetailsAndLessHour($month = 0, $year = 0, $company = '', $employee = '')
	{
		$erpnextDB = DB::connection("erpnext");

		if($month == 0 && $year == 0) {
		}
		else {
			$month = date("m", time());
			$year = date("Y", time());
		}


		$auto_start_date = "$year-$month-01";
		$auto_end_date = "$year-$month-02";

		$allUnits = [
			"Pinkcity Jewelhouse Private Ltd-Mahapura"=>[
				"auto_start_date"=> $auto_start_date . " 07:00:00",
				"auto_end_date"=> $auto_end_date . " 06:59:59",
			],
			"Pinkcity Jewelhouse Private Limited- Unit 1"=>[
				"auto_start_date"=> $auto_start_date . " 08:00:00",
				"auto_end_date"=> $auto_end_date . " 07:59:59",
			],
			"Pinkcity Jewelhouse Private Limited-Unit 2"=>[
				"auto_start_date"=> $auto_start_date . " 08:00:00",
				"auto_end_date"=> $auto_end_date . " 07:59:59",
			],
		];

		$query_start_date = isset($allUnits[$company]['auto_start_date']) ? $allUnits[$company]['auto_start_date'] : $auto_start_date . " 08:00:00";
		$query_end_date = isset($allUnits[$company]['auto_end_date']) ? $allUnits[$company]['auto_end_date'] : $auto_end_date . " 07:59:00";

		$query_string  = "SELECT generated_start_date,
														 generated_end_date,
														 DATE(generated_start_date) start_date,
														 tabEmployee.employee,
														 tabEmployee.employee_name,
														 tabEmployee.department,
														IFNULL(`tabEmployee Checkin`.shift_start, CONCAT(DATE(generated_start_date), ' 09:30:00') ) shift_start,
														IFNULL(`tabEmployee Checkin`.shift_end, CONCAT(DATE(generated_start_date), ' 18:00:00') ) shift_end,
														 `tabEmployee Checkin`.time in_time,
														 checkIn2.time out_time,
														DATE(tabHoliday.holiday_date) holiday_date
									FROM
								(SELECT adddate('$query_start_date', @rownum := @rownum + 1) generated_start_date,
										 adddate('$query_end_date', @rownum) generated_end_date,
										 name AS emp_id,
										 employee_name,
										 department
									FROM tabEmployee
									JOIN (SELECT @rownum := -1) r
									LIMIT 31) temp
						 LEFT JOIN  tabEmployee ON tabEmployee.employee = '$employee'
						 LEFT JOIN tabHoliday on tabHoliday.holiday_date = DATE(generated_start_date)
						 LEFT JOIN `tabEmployee Checkin` ON `tabEmployee Checkin`.employee = tabEmployee.employee
											 AND ( `tabEmployee Checkin`.log_type = 'IN' )
											AND ( `tabEmployee Checkin`.time BETWEEN generated_start_date AND generated_end_date )
						 LEFT JOIN `tabEmployee Checkin` checkIn2 ON checkIn2.employee = tabEmployee.employee
											AND ( checkIn2.log_type = 'OUT' )
											AND ( checkIn2.time BETWEEN generated_start_date AND generated_end_date )
						WHERE MONTH(generated_start_date) = $month AND YEAR(generated_start_date) = $year
						Group By generated_start_date";
		$empOT_data = $erpnextDB->select($query_string);

		return $empOT_data;
	}


}
?>
