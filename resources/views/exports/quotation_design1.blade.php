<table>
  <tbody>
    <tr >
      <td colspan="2" align="center">
        Quotation No. :
      </td>
      <td colspan="2" align="center">
        <b>@if(isset($quotation_data->name)){{ $quotation_data->name }}@endif  </b>
      </td>
      <td></td>
      <td colspan="1" align="center">
        Created By :
      </td>
      <td colspan="2" align="center">
          <b > @if(isset($quotation_data->owner)){{ $quotation_data->owner }}@endif  </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Date :
      </td>
      <td colspan="1" align="center">
        <b >  @if(isset($quotation_data->transaction_date)){{ $quotation_data->transaction_date }}@endif </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Status :
      </td>
      <td colspan="2" align="center">
        <b >  @if(isset($quotation_data->status)){{ $quotation_data->status }}@endif </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Title :
      </td>
      <td colspan="2" align="center">
        <b >  @if(isset($quotation_data->title)){{ $quotation_data->title }}@endif </b >
      </td>
      <td></td>
      <td colspan="2" align="center">
        Conversion Rate ($1 in INR) :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->conversion_rate_inr)){{ $design_header_data->conversion_rate_inr }}@endif </b >
      </td>
      <td></td>
      <td  colspan="1" align="center">
        Company :
      </td>
      <td  colspan="3" align="center">
        <b > @if(isset($quotation_data->company)){{ $quotation_data->company }}@endif </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Customer Name :
      </td>
      <td colspan="2" align="center">
        <b > @if(isset($quotation_data->customer_name)){{ $quotation_data->customer_name }}@endif </b >
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        Gold Rate - oz :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->gold_rate)){{ $design_header_data->gold_rate }}@endif </b >
      </td>
      <td></td>
      <td></td>
      <td colspan="1" align="center">
        Silver Rate - oz
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->silver_rate)){{ $design_header_data->silver_rate }}@endif </b >
      </td>
      <td></td>
      <td colspan="2" align="center">
        Value Add % For Gold :
      </td>
      <td colspan="1" align="center">
        <b >  @if(isset($design_header_data->value_additionl_per_for_cost_1_gold)){{ $design_header_data->value_additionl_per_for_cost_1_gold }}@endif </b >
      </td>
      <td></td>
      <td colspan="2" align="center">
        Value Add% For Silver :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->value_additionl_per_for_cost_1_silver)){{ $design_header_data->value_additionl_per_for_cost_1_silver }}@endif </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Gold Loss(%) :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->loss_gold)){{ $design_header_data->loss_gold }}@endif </b >
      </td>
      <td></td>
      <td colspan="1" align="center">
        Silver Loss(%) :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->loss_silver)){{ $design_header_data->loss_silver }}@endif </b >
      </td>
      <td></td>
      <td colspan="2" align="center">
        White Gold Loss(%) :
      </td>
      <td colspan="1" align="center">
        <b > @if(isset($design_header_data->loss_white_gold)){{ $design_header_data->loss_white_gold }}@endif </b >
      </td>
    </tr>
  </tbody>

</table>





<table id="designtable" class="table table-striped table-responsive table-bordered" style="width:100%;">
  <thead id="designpost-thead-1">
    <colgroup span="28" width="85"></colgroup>
  	<tr>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 7px" height="47" align="center" valign=middle><p><b><font face="Calibri" color="#000000">S.No.</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 30px" align="center" valign=middle><b><font face="Calibri" color="#000000">Image</font></b></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 20px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Design Code/Product Code</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 10px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Their Code</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Product Type</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Metal Group</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Metal Varients</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Metal Weight Casting</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Metal Weight Chain</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Value of Metal ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">ROW</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 25px" colspan=2 align="center" valign=middle><p><b><font face="Calibri" color="#000000">Labour ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">ROW</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Name</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Shape</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Cut</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Setting Type</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Size (Length)</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Size (Width)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Qty</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Weigth</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone / Diamond Quality</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Price Unit</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Purchased Price (₹)</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Value Added %</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Sale Price (₹)</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Stone Value  ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Cost 1 ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Cost 2 ($)</font></b></p></td>
      <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Value Addition (Cost1) ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Ex-Factory Price ($)</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Discount %</font></b></p></td>
  		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; width: 15px" align="center" valign=middle><p><b><font face="Calibri" color="#000000">Price After Discount($)</font></b></p></td>
      <!-- <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000" align="center" valign=middle><b><font face="Calibri" color="#000000">Stone Quoatrion Price ($)</font></b></td> -->
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
        $stone_cut = json_decode($data->stone_cut);
        $stone_shape = json_decode($data->stone_shape);
        $setting_type = json_decode($data->setting_type);
        $stone_size_l = json_decode($data->stone_size_l);
        $stone_size_w = json_decode($data->stone_size_w);
        $stone_diamond_quality = json_decode($data->stone_diamond_quality);
        $setting_type = json_decode($data->setting_type);
        $price_unit = json_decode($data->price_unit);
        $stone_qty = json_decode($data->stone_qty);
        $stone_weight = json_decode($data->stone_weight);
        $stone_value = json_decode($data->stone_value);
        $value_added_per = json_decode($data->value_added_per);
        $sale_price = json_decode($data->sale_price);
        $stone_value_added = json_decode($data->stone_value_added);

        $id = 0;
        $k = 0; $l = 0; $m = 0;
        // $rowspan = ( count($labour_type) >=  count($stone_name) ? count($labour_type) :  count($stone_name) );
        // 7 because labour type is 7
        $max_row = 7;
        if(stripos("gold", $data->metal_type) !== false) { $max_row = 6; }
        elseif(stripos("silver", $data->metal_type) !== false) { $max_row = 7; }
        $rowspan = ( $max_row >=  count($stone_name) ? $max_row :  count($stone_name) );

        $row_id = $count;
        $id = $data->id;

          ?>


                 <tbody id="designpost-tbody-{{$row_id}}" class="designpost-tbody" >




                                    <tr>
                                        <td rowspan="{{$rowspan}}" align="center">{{$row_id}}</td>

                                        <td rowspan="{{$rowspan}}" align="center" >

                                            <span  >
                                            @if($data->image == "" || $data->image == NULL )
                                            @else
                                              <img src="{{public_path().'/storage/design_img/'. $data->image }}"  width="150" height="150">
                                            @endif
                                            </span>

                                        </td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->product_code )){{ $data->product_code }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->their_code )){{ $data->their_code }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->product_type )){{ $data->product_type }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->metal_type )){{ $data->metal_type }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->metal )){{ $data->metal }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->metal_weight_casting )){{ $data->metal_weight_casting }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->metal_weight_chain )){{ $data->metal_weight_chain }}@endif</td>
                                        <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->value_of_metal )){{ $data->value_of_metal }}@endif</td>


                                        @for($i=0; $i<1; $i++)
                                          @if($i == 1 ) @php break; @endphp @endif
                                          <td align="center" >1</td>
                                          <td align="center" >CFP</td>
                                          <td align="center" >@if(isset($data->labour_value_cfp)){{ $data->labour_value_cfp }}@endif</td>
                                        @endfor

                                        @for ($i=0; $i<count($stone_name); $i++)
                                          @if($i == 1 ) @php break; @endphp @endif
                                          <td align="center" >{{ $i+1 }}</td>
                                          <td align="center" >@if(isset($stone_name[$i])){{ $stone_name[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_shape[$i])){{ $stone_shape[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_cut[$i])){{ $stone_cut[$i] }}@endif</td>
                                          <td align="center" >@if(isset($setting_type[$i])){{ $setting_type[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_size_l[$i])){{ $stone_size_l[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_size_w[$i])){{ $stone_size_w[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_qty[$i])){{ $stone_qty[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_weight[$i])){{ $stone_weight[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_diamond_quality[$i])){{ $stone_diamond_quality[$i] }}@endif</td>
                                          <td align="center">@if(isset($price_unit[$i])){{ $price_unit[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_value[$i])){{ $stone_value[$i] }}@endif</td>
                                          <td align="center" >@if(isset($value_added_per[$i])){{ $value_added_per[$i] }}@endif</td>
                                          <td align="center" >@if(isset($sale_price[$i])){{ $sale_price[$i] }}@endif</td>
                                          <td align="center" >@if(isset($stone_value_added[$i])){{ $stone_value_added[$i] }}@endif</td>

                                      @endfor



                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->cost_1 )){{ $data->cost_1 }}@endif</td>
                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->cost_2 )){{ $data->cost_2 }}@endif</td>
                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->value_addition_cost_1 )){{ $data->value_addition_cost_1 }}@endif</td>
                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->ex_factory_price )){{ $data->ex_factory_price }}@endif</td>
                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->discount_per )){{ $data->discount_per }}@endif</td>
                                    <td rowspan="{{$rowspan}}" align="center" >@if(isset($data->price_after_discount )){{ $data->price_after_discount }}@endif</td>

                                    </tr>

                                    @for($i=1; $i< $rowspan  ; $i++)
                                    <tr>

                                      @if($i==1)
                                        <td align="center" >{{ $i+1 }}</td>
                                        <td align="center" >Chain Labour</td>
                                        <td align="center" >@if(isset($data->labour_value_chain_labour)){{ $data->labour_value_chain_labour }}@endif</td>
                                      @elseif($i==2)
                                        <td align="center" >{{ $i+1 }}</td>
                                        <td align="center" >Total Setting Charge</td>
                                        <td align="center" >@if(isset($data->labour_value_total_setting)){{ $data->labour_value_total_setting }}@endif</td>
                                      @elseif($i==3)
                                        <td align="center" >{{ $i+1 }}</td>
                                        <td align="center" >Finding</td>
                                        <td align="center" >@if(isset($data->labour_value_finding)){{ $data->labour_value_finding }}@endif</td>
                                      @elseif($i==4)
                                        <td align="center" >{{ $i+1 }}</td>
                                        <td align="center" >Packing, PD and other Miss.</td>
                                        <td align="center" >@if(isset($data->labour_value_packing)){{ $data->labour_value_packing }}@endif</td>
                                      @elseif($i==5)

                                          @if(stripos("gold", $data->metal_type) !== false)
                                            <td align="center" >{{ $i+1 }}</td>
                                            <td align="center" >Pen Plating</td>
                                            <td align="center" > @if(isset($data->labour_value_plating_casting)){{ $data->labour_value_plating_casting }}@endif</td>
                                          @elseif(stripos("silver", $data->metal_type) !== false)
                                            <td align="center" >{{ $i+1 }}</td>
                                            <td align="center" >
                                                Plating Casting Products
                                                <?php
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
                                                 ?>
                                                @if(isset($data->plating_casting)){{  " - " .$normal_string }}@endif
                                                @if(isset($data->plating_casting_square_value)){{  " - " .$data->plating_casting_square_value }}@endif

                                            </td>
                                            <td align="center" >  @if(isset($data->labour_value_plating_casting)){{ $data->labour_value_plating_casting }}@endif</td>
                                          @else
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                          @endif

                                        @elseif($i==6)
                                            @if(stripos("silver", $data->metal_type) !== false)
                                              <td align="center" >{{ $i+1 }}</td>
                                              <td align="center" >
                                                  Plating Chains
                                                  <?php
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
                                                   ?>
                                                  @if(isset($data->plating_chains)){{ " - " .$normal_string }}@endif
                                                  @if(isset($data->plating_chains_square_value)){{  " - " .$data->plating_casting_square_value }}@endif

                                              </td>
                                              <td align="center" >@if(isset($data->labour_value_plating_chains)){{ $data->labour_value_plating_chains }}@endif</td>
                                            @else
                                              <td ></td>
                                              <td ></td>
                                              <td ></td>
                                            @endif

                                      @else
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                      @endif

                                      @if(isset($stone_name[$i]))
                                        <td align="center" >{{ $i+1 }}</td>
                                        <td align="center" >@if(isset($stone_name[$i])){{ $stone_name[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_cut[$i])){{ $stone_cut[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_shape[$i])){{ $stone_shape[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_size_l[$i])){{ $stone_size_l[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_size_w[$i])){{ $stone_size_w[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_qty[$i])){{ $stone_qty[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_weight[$i])){{ $stone_weight[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_diamond_quality[$i])){{ $stone_diamond_quality[$i] }}@endif</td>
                                        <td align="center" >@if(isset($price_unit[$i])){{ $price_unit[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_value[$i])){{ $stone_value[$i] }}@endif</td>
                                        <td align="center" >@if(isset($value_added_per[$i])){{ $value_added_per[$i] }}@endif</td>
                                        <td align="center" >@if(isset($sale_price[$i])){{ $sale_price[$i] }}@endif</td>
                                        <td align="center" >@if(isset($stone_value_added[$i])){{ $stone_value_added[$i] }}@endif</td>

                                      @else
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                      @endif

                                    </tr>

                                    @endfor

</tbody>
<?php
}


}
?>
</table>
