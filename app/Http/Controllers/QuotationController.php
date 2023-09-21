<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\erp\AttendanceRecords;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\File;
use App\Models\Employee;
use App\Exports\QuotationDesign1Export;
use App\Exports\QuotationDesign2Export;
use App\Library\AdminHelper;

class QuotationController extends Controller
{

    public function quotationList(Request $request)
    {

        $erpnextDB = DB::connection("erpnext");

        $query =$erpnextDB
                        ->table("tabQuotation")
                        // ->where("quoation_form_type", "Anna-EFB Network")
                        // ->orWhere("quoation_form_type", "Monica Vinader")
                        ->where(function($query2) {
                             $query2->where('quoation_form_type', "Anna-EFB Network")
                                   ->orWhere('quoation_form_type', "Monica Vinader");
                         })
                        // ->orderBy('modified', 'DESC');
                        ->orderBy('name', 'DESC');

        if(auth()->user()->role == "superadmin") {

        } else {
          $query->where("owner",  auth()->user()->email);
        }


        if(!empty($request->customer_name)){
              $query->where('customer_name', 'like', '%' . $request->customer_name. '%');
          }
        if(!empty($request->title)){
              $query->where('title', 'like', '%' . $request->title. '%');
          }

        // if(!empty($request->date)){
        //     $query->whereDate('transaction_date', $request->date);
        // }

        if(!empty($request->from)){
            $query->whereDate('transaction_date', ">=", $request->from);
        }

        if(!empty($request->to)){
            $query->whereDate('transaction_date', "<=", $request->to);
        }

        if(!empty($request->show)){
            $pagination = $request->show;
        }else{
            $pagination = 10;
        }
        $data = $request->all();
        $quotation_data = $query->paginate($pagination);

        return view("admin.quotation.list", [
                      "quotation_data" => $quotation_data,
                      "title" => "Quotation List",
        ]);
    }

    public function quotationDesign1Delete(Request $request)
    {

        $query = DB::connection("localdesign")
                ->table("quotation_design_1")
                ->where('id',$request->design_id)
                ->delete();

        $this->jsonResponse("Design successfully deleted.", true, $request->design_id);


    }

    public function quotationDelete(Request $request)
    {
      $erpnextDB = DB::connection("erpnext");

      $query =$erpnextDB
                ->table("tabQuotation")
                ->where('name',$request->quotation_id)
                ->delete();

          Session::flash('message', 'Quotation Deleted  Successfully.!');
          Session::flash('alert-class', 'alert-success');
          return redirect("quotation/list");
    }

    public function quotationDesign2Delete(Request $request)
    {

        $query = DB::connection("localdesign")
                ->table("quotation_design_2")
                ->where('id',$request->design_id)
                ->delete();

        $this->jsonResponse("Design successfully deleted.", true, $request->design_id);


    }

    public function quotationDesign1AddNewDesignFormRow(Request $request)
    {
      $new_raw = AdminHelper::design1RowFrom(Config::get('constants.add_design'), '', 0, $request->id);
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign1AddMoreData(Request $request)
    {
      $new_raw = AdminHelper::design1AddMoreData(Config::get('constants.add_design'), $request->row_id, $request->current_row, $request->all());
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign1AddMoreData2(Request $request)
    {
      $method_type = isset($request->method_type) ?  $request->method_type : 'add';

      // $new_raw = AdminHelper::design1AddMoreData2(Config::get('constants.add_design'), $request->row_id, $request->current_row, $request->all());
      $new_raw = AdminHelper::design1AddMoreData2($method_type, $request->row_id, $request->current_row, $request->all());
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign1DuplicateNewDesignFormRow(Request $request)
    {
      $new_raw = AdminHelper::design1RowFrom(Config::get('constants.duplicate_design'), '', $request->last_insert_id, $request->id);
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign1DuplicateMoreData(Request $request)
    {
      $new_raw = AdminHelper::design1AddMoreData(Config::get('constants.duplicate_design'), $request->row_id, $request->current_row, $request->all());
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign1Update(Request $request)
    {
        if (
            $request->validate([
                // "image" => "mimes:jpg,jpeg,png|max:2048",
                "product_type" => "nullable|string",
                "product_code" => "string|nullable",
                "their_code" => "nullable|string",
                "metal" => "required|string",
                "metal_type" => "required|string",
                "metal_weight_casting" => "numeric|required",
                "metal_weight_chain" => "numeric|nullable",
                "value_of_metal" => "numeric|nullable",

                "cost_1" => "numeric|nullable",
                "cost_2" => "numeric|nullable",
                "value_addition_cost_1" => "numeric|nullable",
                "ex_factory_price" => "numeric|nullable",
                "discount_per" => "numeric|nullable",
                "price_after_discount" => "numeric|nullable",
                // "stone_quoatrion_price" => "numeric|nullable",
                // "sale_price" => "numeric|nullable",


                "labour_type.*" => "string|nullable",
                "setting_charge.*" => "string|nullable",
                "plating_type.*" => "string|nullable",
                "square_value.*" => "numeric|nullable",
                "labour_value.*" => "numeric|nullable",

                "labour_value_cfp" => "numeric|nullable",
                "labour_value_chain_labour" => "numeric|nullable",
                "labour_value_total_setting" => "numeric|nullable",
                "labour_value_finding" => "numeric|nullable",
                "labour_value_packing" => "numeric|nullable",
                "labour_value_plating_casting" => "numeric|nullable",
                "labour_value_plating_chains" => "numeric|nullable",

                "plating_casting" => "string|nullable",
                "plating_casting_square_value" => "numeric|nullable",
                "plating_chains" => "string|nullable",
                "plating_chains_square_value" => "numeric|nullable",

                "stone_name.*" => "string|nullable",
                "stone_cut.*" => "string|nullable",
                "stone_shape.*" => "string|nullable",
                "stone_size_l.*" => "string|nullable",
                "stone_size_w.*" => "string|nullable",
                "stone_diamond_quality.*" => "string|nullable",
                "setting_type.*" => "string|nullable",
                "price_unit.*" => "string|nullable",
                "stone_qty.*" => "numeric|nullable",
                "stone_weight.*" => "numeric|nullable",
                "stone_value.*" => "numeric|nullable",
                "stone_value.*" => "numeric|nullable",
                "stone_value.*" => "numeric|nullable",
                "value_added_per.*" => "numeric|nullable",
                "stone_value_added.*" => "numeric|nullable",
                "sale_price.*" => "numeric|nullable",

            ])
        ) {
            $data = [];

            $data["quotation_design_type_id"] = 1; // for design 1

            $data["row_no"] = $request->row_no;
            $data["current_row_no"] = $request->current_row_no;
            $data["image"] = $request->image;
            $data["image_type"] = $request->image_type;;

            $data["quotation_table_id"] = $request->quotation_table_id;
            $data["product_type"] = $request->product_type;
            $data["product_code"] = $request->product_code;
            $data["their_code"] = $request->their_code;
            $data["metal_type"] = $request->metal_type;
            $data["metal"] = $request->metal;
            $data["metal_weight_casting"] = $request->metal_weight_casting;
            $data["metal_weight_chain"] = $request->metal_weight_chain;
            $data["value_of_metal"] = $request->value_of_metal;

            $data["cost_1"] = $request->cost_1;
            $data["cost_2"] = $request->cost_2;
            $data["value_addition_cost_1"] = $request->value_addition_cost_1;
            $data["ex_factory_price"] = $request->ex_factory_price;
            $data["discount_per"] = $request->discount_per;
            $data["price_after_discount"] = $request->price_after_discount;
            // $data["stone_quoatrion_price"] = $request->stone_quoatrion_price;
            // $data["sale_price"] = $request->sale_price;


            //json format data save
            $data["labour_type"] = json_encode($request->labour_type);
            $data["setting_charge"] = json_encode($request->setting_charge);
            $data["plating_type"] = json_encode($request->plating_type);
            $data["square_value"] = json_encode($request->square_value);
            $data["labour_value"] = json_encode($request->labour_value);

            $data["labour_value_cfp"] = $request->labour_value_cfp;
            $data["labour_value_chain_labour"] = $request->labour_value_chain_labour;
            $data["labour_value_total_setting"] = $request->labour_value_total_setting;
            $data["labour_value_finding"] = $request->labour_value_finding;
            $data["labour_value_packing"] = $request->labour_value_packing;
            $data["labour_value_plating_casting"] = $request->labour_value_plating_casting;
            $data["labour_value_plating_chains"] = $request->labour_value_plating_chains;

            $data["plating_casting"] = $request->plating_casting;
            $data["plating_casting_square_value"] = $request->plating_casting_square_value;
            $data["plating_chains"] = $request->plating_chains;
            $data["plating_chains_square_value"] = $request->plating_chains_square_value;

            $data["stone_name"] = json_encode($request->stone_name);
            $data["stone_cut"] = json_encode($request->stone_cut);
            $data["stone_shape"] = json_encode($request->stone_shape);
            $data["stone_size_l"] = json_encode($request->stone_size_l);
            $data["stone_size_w"] = json_encode($request->stone_size_w);
            $data["stone_diamond_quality"] = json_encode($request->stone_diamond_quality);
            $data["setting_type"] = json_encode($request->setting_type);
            $data["price_unit"] = json_encode($request->price_unit);
            $data["stone_qty"] = json_encode($request->stone_qty);
            $data["stone_weight"] = json_encode($request->stone_weight);
            $data["stone_value"] = json_encode($request->stone_value);
            $data["value_added_per"] = json_encode($request->value_added_per);
            $data["stone_value_added"] = json_encode($request->stone_value_added);
            $data["sale_price"] = json_encode($request->sale_price);


            if($request->id == 0) {
                $data["created_at"] = date('Y-m-d H:i:s', time());
                $data["created_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_1")
                            ->insertGetId($data);
                $insert_id = $query;
                $msg = "Design successfully added";

            } else {
                $data["updated_at"] = date('Y-m-d H:i:s', time());
                $data["updated_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_1")
                            ->where('id',$request->id)
                            ->update($data);
                $insert_id = $request->id;
                $msg = "Design successfully updated";
            }


            if ($insert_id) {
                $this->jsonResponse($msg, true, $insert_id);
            } else {
                $this->jsonResponse("Design not updated.", false);
            }
        } else {
            $this->jsonResponse("Validation Error.", false);

        }
    }

    public function quotationAdd(Request $request)
    {
        if (
            $request->validate([
                "quoation_form_type" => "required",
                "transaction_date" => "required",
                // "valid_till" => "required",
                // "order_type" => "required",
                "company" => "required",
                "status" => "required",
                "customer_name" => "required",
                "title" => "string|nullable",
            ])
        ) {

            $data = [];

            $insert_id = 0;

              if($request->id == '0') {

                // generate name dynamically --------------------------  start   ----------------------
                $name =  "";
                $last_no = 1;
                $query_data = DB::connection("erpnext")
                            ->table("tabQuotation")
                            ->select("name")
                            ->orderBy("name", "DESC")
                            ->first();
                if(isset($query_data->name)) {
                  $name_array = explode("-", $query_data->name);
                  if(is_array($name_array)) {
                    $last_no = (int) $name_array[count($name_array) - 1];
                    $last_no++;
                  }
                }
                $name =  "SAL-QTN-" . date("Y", time()) . "-" . sprintf('%05d', $last_no);

                // generate name dynamically --------------------------  end   ----------------------

              } else {

                    // echo "<br>hi22<br>";
                $name  = $request->id;
              }

            $data["name"] = $name;
            // $data["order_type"] = $request->order_type;
            // $data["valid_till"] = $request->valid_till;
            // $data["order_type"] = "";
            // $data["valid_till"] = "";
            $data["transaction_date"] = $request->transaction_date;
            $data["quotation_to"] = 'Customer';
            $data["naming_series"] = 'SAL-QTN-.YYYY.-';
            $data["title"] = $request->title;
            $data["customer_name"] = $request->customer_name;
            $data["company"] = $request->company;
            $data["status"] = $request->status;
            $data["idx"] = 0;
            $data["docstatus"] = 0;

            // put this data for update only
            $data["party_name"] = $request->customer_name;
            $data["currency"] = "INR";
            $data["conversion_rate"] = "1";
            $data["selling_price_list"] = "USD";
            $data["price_list_currency"] = "USD";
            $data["plc_conversion_rate"] = $request->conversion_rate_inr;


            $data["quoation_form_type"] = $request->quoation_form_type;




            if($request->id == '0') {

              $data["owner"] = auth()->user()->email;
              $data["creation"] = date('Y-m-d H:i:s', time());

              $erpnextDB = DB::connection("erpnext");

                $query = DB::connection("erpnext")
                            ->table("tabQuotation")
                            ->insert($data);
                $insert_id = $name;
                $msg = "Qautation successfully added.";
            } else {

              $data["modified"] = date('Y-m-d H:i:s', time());
              $data["modified_by"] = auth()->user()->email;

                $query = DB::connection("erpnext")
                            ->table("tabQuotation")
                            ->where('name',$request->id)
                            ->update($data);
                $insert_id = $request->id;
                $msg = "Qautation successfully updated.";
            }


            if ($insert_id) {
                $this->jsonResponse($msg, true, $insert_id);
            } else {
                $this->jsonResponse("Qautation not added.", false);
            }
        } else {
            $this->jsonResponse("Validation Error.", false, $validator->errors());

        }
    }

    public function jsonResponse($msg = "", $status = false, $data = [])
    {
        echo json_encode(["msg"=>$msg, "status"=> $status, "data"=>$data]);
    }

    public function quotationDesignExport(Request $request)
    {

      $quoation_form_type = 1;
      if($request->quoation_form_type == 'Anna-EFB Network') {

        $quoation_form_type = 1;

        $file_name = 'Design';
        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
        return Excel::download(new QuotationDesign1Export($request), $file_name);

       }
      elseif($request->quoation_form_type == 'Monica Vinader') {

        $quoation_form_type = 2;

        $file_name = 'Design';
        $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
        return Excel::download(new QuotationDesign2Export($request), $file_name);

       }
       else {
         return redirect('/quotation/list');
       }

    }

    public function get_3d_design_data(Request $request)
    {

        $query1 = DB::connection("erpnext")
                              ->table("tabDesign 3D Library")
                              ->limit(50);

        if(!empty($request->design_code)) {
            $query1->where('design_3d_code', 'like', '%' . $request->design_code. '%');
        }

        if(!empty($request->design_category)) {
            $query1->where('design_category', $request->design_category);
        }

        if(!empty($request->description)){
            $query1->where('design_3d_code_description', 'like', '%' . $request->description. '%');
        }

        $data = $query1->get();
        $this->jsonResponse("New Raw data.", true, $data);
    }

    public function get_2d_design_data(Request $request)
    {
        $query1 = DB::connection("erpnext")
                              ->table("tabDesign Library")
                              ->limit(50);
        if(!empty($request->design_code)) {
            $query1->where('design_code', 'like', '%' . $request->design_code. '%');
            // $query1->where('design_code',  $request->design_code);
        }
        if(!empty($request->product_category)) {
            // echo "hi22";
            $query1->where('product_category', $request->product_category);
        }
        if(!empty($request->description)){
            // echo "hi33";
            $query1->where('description', 'like', '%' . $request->description. '%');
        }
        $data = $query1->get();
        $this->jsonResponse("New Raw data.", true, $data);
    }

    public function getDesignImage(Request $request)
    {
        if($request->design_type == "3d") {
            $query1 = DB::connection("erpnext")
                            ->table("tabDesign 3D Library")
                            ->where('name', $request->design_unique_name);
            $data = $query1->first();
            if(isset($data->image)) {
                $file_url = 'https://erp.pinkcityindia.com'. $data->image;
                $image_src = file_get_contents($file_url);
                $file_name = basename($file_url);
                file_put_contents("storage/app/public/design_img/$file_name", $image_src);

                $this->jsonResponse("Image Successfully uploaded.", true, $file_name);
            }
            else {
                $this->jsonResponse("Unable to uploaded image.", false);
            }
        }

        elseif($request->design_type == "2d") {
            $query1 = DB::connection("erpnext")
                            ->table("tabDesign Library")
                            ->where('name', $request->design_unique_name);
            $data = $query1->first();
            if(isset($data->image)) {
                $file_url = 'https://erp.pinkcityindia.com'. $data->image;
                $image_src = file_get_contents($file_url);
                $file_name = basename($file_url);
                file_put_contents("storage/app/public/design_img/$file_name", $image_src);

                $this->jsonResponse("Image Successfully uploaded.", true, $file_name);
            }
            else {
                $this->jsonResponse("Unable to uploaded image.", false);
            }
        }
        elseif($request->design_type == "system") {
          $file_name = $request->file('image')->getClientOriginalName();
          $file_path = $request->file('image')->store('public/design_img');
          $save_file = new File;
          $uploaded_file_name = str_replace("public/design_img/","",$file_path);

          $this->jsonResponse("Image Successfully uploaded.", true, $uploaded_file_name);

        }
        else {
            $this->jsonResponse("Unable to uploaded image.", false);
        }
    }

    public function quotationDesign2AddNewDesignFormRow(Request $request)
    {

      $new_raw = AdminHelper::design2RowFrom(Config::get('constants.add_design'), '', 0, $request->id);
      $this->jsonResponse("New Raw data.", true, $new_raw);

    }

    public function quotationDesign2DuplicateNewDesignFormRow(Request $request)
    {
      $new_raw = AdminHelper::design2RowFrom(Config::get('constants.duplicate_design'), '', $request->last_insert_id, $request->id);
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign2AddMoreData(Request $request)
    {
      $new_raw = AdminHelper::design2AddMoreData(Config::get('constants.add_design'), $request->row_id, $request->current_row, $request->all());
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign2DuplicateMoreData(Request $request)
    {
      $new_raw = AdminHelper::design2AddMoreData(Config::get('constants.duplicate_design'), $request->row_id, $request->current_row, $request->all());
      $this->jsonResponse("New Raw data.", true, $new_raw);
    }

    public function quotationDesign2Update(Request $request)
    {
        if (
            $request->validate([
                "design" => "required|string",

                "silver_act_wt.*" => "nullable|numeric",
                "silver_add_wt.*" => "nullable|numeric",
                "silver_wt.*" => "nullable|numeric",
                "stone_wt.*" => "nullable|numeric",
                "stone_diamond_name.*" => "nullable|string",
                "stone_diamond_shape.*" => "nullable|string",
                "stone_diamond_size.*" => "nullable|string",
                "stone_diamond_qty.*" => "nullable|numeric",
                "stone_diamond_weight.*" => "nullable|numeric",
                "stone_diamond_price.*" => "nullable|numeric",
                "stone_diamond_inc_margin.*" => "nullable|numeric",
                "stone_diamond_amt.*" => "nullable|numeric",
                "silver_amt.*" => "nullable|numeric",
                "labour_charge.*" => "nullable|numeric",
                "labour.*" => "nullable|numeric",
                "setting.*" => "nullable|numeric",
                "misc_item.*" => "nullable|string",
                "misc_cost.*" => "nullable|numeric",
                "plating_gp.*" => "nullable|numeric",
                "plating_rp.*" => "nullable|numeric",
                "total_cost_ss.*" => "nullable|numeric",
                "total_cost_gp.*" => "nullable|numeric",
                "total_cost_rp.*" => "nullable|numeric",
                "finding_charge.*" => "nullable|numeric",
                "value_add_per.*" => "nullable|numeric",
                "value_addition_ss.*" => "nullable|numeric",
                "value_addition_gp.*" => "nullable|numeric",
                "value_addition_rp.*" => "nullable|numeric",
                "sale_price_ss.*" => "nullable|numeric",
                "sale_price_gp.*" => "nullable|numeric",
                "sale_price_rp.*" => "nullable|numeric",
                "cost_change_1.*" => "nullable|numeric",
                "cost_change_2.*" => "nullable|string",
                "cost_change_3.*" => "nullable|numeric",
           ])
        ) {
            $data = [];

            $data["quotation_design_type_id"] = 2; // for design 2

            $data["quotation_table_id"] = $request->quotation_table_id;
            $data["design"] = $request->design;
            $data["image"] = $request->image;
            $data["image_type"] = $request->image_type;
            $data["current_row"] = $request->current_row;

            //jeson format data save in database
            $data["silver_act_wt"] = json_encode($request->silver_act_wt);
            $data["silver_add_wt"] = json_encode($request->silver_add_wt);
            $data["silver_wt"] = json_encode($request->silver_wt);
            $data["stone_wt"] = json_encode($request->stone_wt);
            $data["stone_diamond_name"] = json_encode($request->stone_diamond_name);
            $data["stone_diamond_shape"] = json_encode($request->stone_diamond_shape);
            $data["stone_diamond_size"] = json_encode($request->stone_diamond_size);
            $data["stone_diamond_qty"] = json_encode($request->stone_diamond_qty);
            $data["stone_diamond_weight"] = json_encode($request->stone_diamond_weight);
            $data["stone_diamond_price"] = json_encode($request->stone_diamond_price);
            $data["stone_diamond_inc_margin"] = json_encode($request->stone_diamond_inc_margin);
            $data["stone_diamond_amt"] = json_encode($request->stone_diamond_amt);
            $data["silver_amt"] = json_encode($request->silver_amt);
            $data["labour_charge"] = json_encode($request->labour_charge);
            $data["labour"] = json_encode($request->labour);
            $data["setting"] = json_encode($request->setting);
            $data["misc_item"] = json_encode($request->misc_item);
            $data["misc_cost"] = json_encode($request->misc_cost);
            $data["plating_gp"] = json_encode($request->plating_gp);
            $data["plating_rp"] = json_encode($request->plating_rp);
            $data["total_cost_ss"] = json_encode($request->total_cost_ss);
            $data["total_cost_gp"] = json_encode($request->total_cost_gp);
            $data["total_cost_rp"] = json_encode($request->total_cost_rp);
            $data["finding_charge"] = json_encode($request->finding_charge);
            $data["value_add_per"] = json_encode($request->value_add_per);
            $data["value_addition_ss"] = json_encode($request->value_addition_ss);
            $data["value_addition_gp"] = json_encode($request->value_addition_gp);
            $data["value_addition_rp"] = json_encode($request->value_addition_rp);
            $data["sale_price_ss"] = json_encode($request->sale_price_ss);
            $data["sale_price_gp"] = json_encode($request->sale_price_gp);
            $data["sale_price_rp"] = json_encode($request->sale_price_rp);
            $data["cost_change_1"] = json_encode($request->cost_change_1);
            $data["cost_change_2"] = json_encode($request->cost_change_2);
            $data["cost_change_3"] = json_encode($request->cost_change_3);

            $insert_id = 0;

            if($request->id == 0) {
                $data["created_at"] = date('Y-m-d H:i:s', time());
                $data["created_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_2")
                            ->insertGetId($data);
                $insert_id = $query;
                $msg = "Design successfully added";

            } else {
                $data["updated_at"] = date('Y-m-d H:i:s', time());
                $data["updated_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_2")
                            ->where('id',$request->id)
                            ->update($data);
                $insert_id = $request->id;

                $msg = "Design successfully updated";
            }

            if ($insert_id) {
                $this->jsonResponse($msg, true, $insert_id);
            } else {
                $this->jsonResponse("Design not updated.", false);
            }
        } else {
            $this->jsonResponse("Validation Error.", false);
        }
    }

    public function quotationDesign2HeaderUpdate(Request $request)
    {
        if (
            $request->validate([
                "sliver_us_rate" => "required|numeric",
                "sliver_inr_rate" => "required|numeric",
                "currency_exchange_rate" => "required|numeric",
                "gold_us_rate" => "required|numeric",
                "silver_loss" => "required|numeric",
                "gold_18k" => "required|numeric",
                "gold_24k" => "required|numeric",
              ])
        ) {
            $data = [];
            $data["quotation_design_type_id"] = 2; // for design 2
            $data["quotation_table_id"] = $request->quotation_table_id;
            $data["sliver_us_rate"] = $request->sliver_us_rate;
            $data["sliver_inr_rate"] = $request->sliver_inr_rate;
            $data["currency_exchange_rate"] = $request->currency_exchange_rate;
            $data["gold_us_rate"] = $request->gold_us_rate;
            $data["silver_loss"] = $request->silver_loss;
            $data["gold_18k"] = $request->gold_18k;
            $data["gold_24k"] = $request->gold_24k;

            $insert_id = 0;

            if($request->id == 0) {
                $data["created_at"] = date('Y-m-d H:i:s', time());
                $data["created_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_header")
                            ->insertGetId($data);
                $insert_id = $query;

            } else {
                $data["updated_at"] = date('Y-m-d H:i:s', time());
                $data["updated_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_header")
                            ->where('id',$request->id)
                            ->update($data);
                $insert_id = $request->id;
            }

            if ($insert_id) {
                $this->jsonResponse("Header successfully added.", true, $insert_id);
            } else {
                $this->jsonResponse("Header not added.", false);
            }
        } else {
            $this->jsonResponse("Validation Error.", false);

        }
    }

    public function quotationDesignView(Request $request)
    {
      $erpnextDB = DB::connection("erpnext");
      $localdesignDB = DB::connection("localdesign");

      $quoation_form_type = 1;
      if($request->quoation_form_type == 'Anna-EFB Network') {

        $quoation_form_type = 1;

        $query = $erpnextDB
                          ->table("tabQuotation");
        $query->where('name', $request->quotation_id);
        $quotation_data = $query->first();

        $query1 = $localdesignDB
                              ->table("quotation_design_1");
        $query1->where('quotation_table_id', $request->quotation_id);
        $query1->orderBy('current_row_no', "ASC");
        $design_data = $query1->get();

       $query2 = $localdesignDB
                             ->table("quotation_design_header");
       $query2->where('quotation_table_id', $request->quotation_id);
       $design_header_data = $query2->first();

        return view("admin.quotation.design1.view", [
            "quotation_data" => $quotation_data,
            "design_data" => $design_data,
            "design_header_data" => $design_header_data,
            "title" => "View Design ",
        ]);

       }
      elseif($request->quoation_form_type == 'Monica Vinader') {

        $quoation_form_type = 2;

        $query = $erpnextDB
                          ->table("tabQuotation");
        $query->where('name', $request->quotation_id);
        $quotation_data = $query->first();


        $query1 = $localdesignDB
                              ->table("quotation_design_2");
        $query1->where('quotation_table_id', $request->quotation_id);
        $design_data = $query1->get();

        $query2 = $localdesignDB
                              ->table("quotation_design_header");
        $query2->where('quotation_table_id', $request->quotation_id);
        $design_header_data = $query2->first();

          return view("admin.quotation.design2.view", [
              "quotation_data" => $quotation_data,
              "design_data" => $design_data,
              "design_header_data" => $design_header_data,
              "title" => "Design ",
          ]);

       }
       else {
         return redirect('/quotation/list');
       }

    }

    public function quotationDesignEdit(Request $request)
    {
      $erpnextDB = DB::connection("erpnext");
      $localdesignDB = DB::connection("localdesign");

      $quoation_form_type = 1;
      if($request->quoation_form_type == 'Anna-EFB Network') {

        $quoation_form_type = 1;

        $query = $erpnextDB
                          ->table("tabQuotation");
        $query->where('name', $request->quotation_id);
        $quotation_data = $query->first();

        $query1 = $localdesignDB
                              ->table("quotation_design_1");
        $query1->where('quotation_table_id', $request->quotation_id);
        $query1->orderBy('current_row_no', "ASC");
        $design_data = $query1->get();

        $query2 = $localdesignDB
                  ->table("quotation_design_header");
        $query2->where('quotation_table_id', $request->quotation_id);
        $design_header_data = $query2->first();

        $query2 = $erpnextDB
                 ->table("tabStone Shape");
        $stone_shape_data = $query2->get();

        $query2 = $erpnextDB
                 ->table("tabStone Cut");
        $stone_cut_data = $query2->get();

        $query2 = $erpnextDB
                 ->table("tabSetting");
        $setting_data = $query2->get();


        $query2 = $erpnextDB
                    ->table("tabDesign 3D Library")
                    ->select('design_category')
                    ->distinct();
        $design_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabDesign Library")
                    ->select('product_category')
                    ->distinct();
        $product_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabSales Person")
                    ->select('sales_person_name')
                    ->distinct();
        $sales_person_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabCustomer")
                    ->select('customer_name')
                    ->distinct();
        $customer_data = $query2->get();

        return view("admin.quotation.design1.edit", [
            "quotation_data" => $quotation_data,
            "design_data" => $design_data,
            "design_header_data" => $design_header_data,
            "title" => "Edit Design Form",
            "stone_shape_data" => $stone_shape_data,
            "stone_cut_data" => $stone_cut_data,
            "setting_data" => $setting_data,
            "design_category_data" => $design_category_data,
            "product_category_data" => $product_category_data,
            "sales_person_data" => $sales_person_data,
            "customer_data" => $customer_data,
        ]);

       }
      elseif($request->quoation_form_type == 'Monica Vinader') {

        $quoation_form_type = 2;

        $query = $erpnextDB
                          ->table("tabQuotation");
        $query->where('name', $request->quotation_id);
        $quotation_data = $query->first();

        $query1 = $localdesignDB
                  ->table("quotation_design_2");
        $query1->where('quotation_table_id', $request->quotation_id);
        $design_data = $query1->get();

        $query2 = $localdesignDB
                  ->table("quotation_design_header");
        $query2->where('quotation_table_id', $request->quotation_id);
        $design_header_data = $query2->first();

        $query2 = $erpnextDB
                    ->table("tabDesign 3D Library")
                    ->select('design_category')
                    ->distinct();
        $design_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabDesign Library")
                    ->select('product_category')
                    ->distinct();
        $product_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabSales Person")
                    ->select('sales_person_name')
                    ->distinct();
        $sales_person_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabCustomer")
                    ->select('customer_name')
                    ->distinct();
        $customer_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabGemstone")
                    ->select('stone_name')
                    ->distinct();
        $stone_data = $query2->get();
        // print_r("$stone_data");
        // die;

        $query2 = $erpnextDB
                    ->table("tabStone Shape")
                    ->select('shape_name')
                    ->distinct();
        $stoneshape_data = $query2->get();

        return view("admin.quotation.design2.edit", [
            "quotation_data" => $quotation_data,
            "design_data" => $design_data,
            "design_header_data" => $design_header_data,
            "design_category_data" => $design_category_data,
            "product_category_data" => $product_category_data,
            "sales_person_data" => $sales_person_data,
            "customer_data" => $customer_data,
            "stone_data" => $stone_data,
            "stoneshape_data" => $stoneshape_data,
            "title" => "Edit Design ",
        ]);

       }
       else {
         return redirect('/quotation/list');
       }


    }

    public function quotationDesignAdd(Request $request)
    {
      $erpnextDB = DB::connection("erpnext");
      $localdesignDB = DB::connection("localdesign");

      $quoation_form_type = 1;
      if($request->quoation_form_type == 'Anna-EFB Network') {

        $quoation_form_type = 1;

        // $query = $erpnextDB
        //                   ->table("tabQuotation");
        // $query->where('name', $request->quotation_id);
        // $quotation_data = $query->first();
        //
        // $query1 = $localdesignDB
        //                       ->table("quotation_design_1");
        // $query1->where('quotation_table_id', $request->quotation_id);
        // $design_data = $query1->get();
        //
        // $query2 = $localdesignDB
        //           ->table("quotation_design_header");
        // $query2->where('quotation_table_id', $request->quotation_id);
        // $design_header_data = $query2->first();

        // $query2 = $erpnextDB
        //          ->table("tabStone Shape");
        // $stone_shape_data = $query2->get();
        //
        // $query2 = $erpnextDB
        //          ->table("tabStone Cut");
        // $stone_cut_data = $query2->get();
        //
        // $query2 = $erpnextDB
        //          ->table("tabSetting");
        // $setting_data = $query2->get();


        $query2 = $erpnextDB
                    ->table("tabDesign 3D Library")
                    ->select('design_category')
                    ->distinct();
        $design_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabDesign Library")
                    ->select('product_category')
                    ->distinct();
        $product_category_data = $query2->get();

        // $query2 = $erpnextDB
        //             ->table("tabSales Person")
        //             ->select('sales_person_name')
        //             ->distinct();
        // $sales_person_data = $query2->get();
        //
        // $query2 = $erpnextDB
        //             ->table("tabCustomer")
        //             ->select('customer_name')
        //             ->distinct();
        // $customer_data = $query2->get();

        return view("admin.quotation.design1.edit", [
            "quotation_data" => [],
            "design_data" => [],
            "design_header_data" => [],
            "title" => "Add Design Form",
            // "stone_shape_data" => $stone_shape_data,
            // "stone_cut_data" => $stone_cut_data,
            // "setting_data" => $setting_data,
            "design_category_data" => $design_category_data,
            "product_category_data" => $product_category_data,
            // "sales_person_data" => $sales_person_data,
            // "customer_data" => $customer_data,
        ]);

       }
      elseif($request->quoation_form_type == 'Monica Vinader') {

        $quoation_form_type = 2;

        // $query = $erpnextDB
        //                   ->table("tabQuotation");
        // $query->where('name', $request->quotation_id);
        // $quotation_data = $query->first();
        //
        // $query1 = $localdesignDB
        //           ->table("quotation_design_2");
        // $query1->where('quotation_table_id', $request->quotation_id);
        // $design_data = $query1->get();
        //
        // $query2 = $localdesignDB
        //           ->table("quotation_design_header");
        // $query2->where('quotation_table_id', $request->quotation_id);
        // $design_header_data = $query2->first();

        $query2 = $erpnextDB
                    ->table("tabDesign 3D Library")
                    ->select('design_category')
                    ->distinct();
        $design_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabDesign Library")
                    ->select('product_category')
                    ->distinct();
        $product_category_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabSales Person")
                    ->select('sales_person_name')
                    ->distinct();
        $sales_person_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabCustomer")
                    ->select('customer_name')
                    ->distinct();
        $customer_data = $query2->get();

        $query2 = $erpnextDB
                    ->table("tabGemstone")
                    ->select('stone_name')
                    ->distinct();
        $stone_data = $query2->get();
        // print_r("$stone_data");
        // die;

        $query2 = $erpnextDB
                    ->table("tabStone Shape")
                    ->select('shape_name')
                    ->distinct();
        $stoneshape_data = $query2->get();

        return view("admin.quotation.design2.edit", [
            "quotation_data" => [],
            "design_data" => [],
            "design_header_data" => [],
            "design_category_data" => $design_category_data,
            "product_category_data" => $product_category_data,
            "sales_person_data" => $sales_person_data,
            "customer_data" => $customer_data,
            "stone_data" => $stone_data,
            "stoneshape_data" => $stoneshape_data,
            "title" => "Add Design ",
        ]);

       }
       else {
         return redirect('/quotation/list');
       }


    }

    public function quotationDesign1HeaderUpdate(Request $request)
    {
        if (
            $request->validate([
                // "customer_name_header" => "required|string",
                "conversion_rate_inr" => "required|numeric",
                "gold_rate" => "required|numeric",
                "silver_rate" => "required|numeric",
                "loss_gold" => "required|numeric",
                "loss_silver" => "required|numeric",
                "loss_white_gold" => "required|numeric",
                // "value_additionl_per_for_cost_1" => "required|numeric",
                "value_additionl_per_for_cost_1_gold" => "required|numeric",
                "value_additionl_per_for_cost_1_silver" => "required|numeric",
              ])
        ) {
            $data = [];
            $data["quotation_design_type_id"] = 1;
            $data["quotation_table_id"] = $request->id;
            // $data["customer_name"] = $request->customer_name_header;
            $data["conversion_rate_inr"] = $request->conversion_rate_inr;
            $data["gold_rate"] = $request->gold_rate;
            $data["silver_rate"] = $request->silver_rate;
            $data["loss_gold"] = $request->loss_gold;
            $data["loss_silver"] = $request->loss_silver;
            $data["loss_white_gold"] = $request->loss_white_gold;
            $data["value_additionl_per_for_cost_1_gold"] = $request->value_additionl_per_for_cost_1_gold;
            $data["value_additionl_per_for_cost_1_silver"] = $request->value_additionl_per_for_cost_1_silver;

            if($request->quoation_header_id == '0') {
                $data["created_at"] = date('Y-m-d H:i:s', time());
                $data["created_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_header")
                            ->insertGetId($data);
                $insert_id = $query;
                $msg = "Quotation header successfully added";

            } else {
                $data["updated_at"] = date('Y-m-d H:i:s', time());
                $data["updated_by"] = auth()->user()->email;
                $query = DB::connection("localdesign")
                            ->table("quotation_design_header")
                            ->where('id',$request->quoation_header_id)
                            ->update($data);
                $insert_id = $request->quoation_header_id;
                $msg = "Quotation header successfully updated";
            }

            if ($insert_id) {
                $this->jsonResponse($msg, true, $insert_id);
            } else {
                $this->jsonResponse("Quotation header not updated", false);
            }
        } else {
            $this->jsonResponse("Validation Error.", false);

        }
    }

    public function getDataList(Request $request)
    {

            $results = [];

            if($request->type == 'customer_name') {


                      if(auth()->user()->role == "superadmin") {
                        $query = DB::connection('erpnext')
                                    ->table('tabCustomer')
                                    ->select(DB::raw("customer_name as id, customer_name as text") )
                                    ->orderBy('customer_name', "ASC");

                        if(!empty($request->search)){
                              $query->where('customer_name', 'like', '%' . $request->search. '%');
                          }
                      } else {

                        $query = DB::connection('erpnext')
                                    ->table('tabUser Permission')
                                    ->select(DB::raw("for_value as id, for_value as text") )
                                    ->where('allow', "Customer")
                                    ->where('user', auth()->user()->email)
                                    ->orderBy('for_value', "ASC");

                        if(!empty($request->search)){
                              $query->where('for_value', 'like', '%' . $request->search. '%');
                          }

                      }

                  // if(!empty($request->search)){
                  //       $query->where('customer_name', 'like', '%' . $request->search. '%');
                  //   }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'product_type') {
                $query = DB::connection('erpnext')
                            ->table('tabLabour Charge Detail')
                            ->select(DB::raw("product_type as id, product_type as text") )
                            ->groupBy('product_type')
                            ->orderBy('product_type', "ASC");

                  if(!empty($request->search)){
                        $query->where('product_type', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'check_product_type') {
              $query = DB::connection('erpnext')
                          ->table('tabLabour Charge Detail')
                          ->select(DB::raw("product_type as id, product_type as text") )
                          ->where('product_type', $request->product_type)
                          ->groupBy('product_type')
                          ->orderBy('product_type', "ASC");

              $results = $query->get();
              if(isset($results[0]->id)) {
                return json_encode(["status"=>true]);
              } else {
                return json_encode(["status"=>false]);
              }

            }
            if($request->type == 'metal_name') {
                $query = DB::connection('erpnext')
                            ->table('tabMetal Name')
                            ->select(DB::raw("metal_name as id, metal_name as text") )
                            ->where('metal_group', $request->metal_type)
                            ->orderBy('metal_name', "ASC");

                  // if(stripos("gold", $request->metal_type) !== false) {
                  //   $query->where('metal_name', 'like', '%' . $request->search. '%');
                  // }
                  if(stripos("silver", $request->metal_type) !== false) {
                    // only two feilds is need- told by abhishek
                    $query->whereRaw("( metal_name = 'Sterling Silver' OR
                                      metal_name = '999 Pure Silver' )");
                  }
                  if(stripos("gold", $request->metal_type) !== false) {
                    // don't show three and two stone gold- told by abhishek
                    $query->whereRaw("( metal_name NOT LIKE '%Three%' AND
                                        metal_name NOT LIKE '%Two%' AND
                                        metal_name != 'Gold' )");
                  }


                  if(!empty($request->search)){
                        $query->where('metal_name', 'like', '%' . $request->search. '%');
                    }
                  if(!empty($request->search)){
                        $query->where('metal_name', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'metal_type') {
                $query = DB::connection('erpnext')
                            ->table('tabMetal Name')
                            ->select(DB::raw("metal_group as id, metal_group as text") )
                            ->groupBy('metal_group')
                            ->orderBy('metal_group', "ASC")
                            ->where('metal_group', "!=", "Alloy");

                  if(!empty($request->search)){
                        $query->where('metal_name', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'setting_charge') {
                $query = DB::connection('erpnext')
                            ->table('tabSetting Charge Detail')
                            ->select(DB::raw("setting_type as id, setting_type as text") )
                            ->groupBy('setting_type')
                            ->orderBy('setting_type', "ASC");

                  if(!empty($request->search)){
                        $query->where('setting_type', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            // if($request->type == 'plating_type') {
            //     $query = DB::connection('erpnext')
            //                 ->table('tabPlating Charge Detail')
            //                 ->select(DB::raw("CONCAT(plating_thickness, ', ', product_type, ',',
            //                                          uom, ',', round(plating_charge_price, 2) ) as id,
            //                                   CONCAT(plating_thickness, ', ', product_type, ', ',
            //                                   uom, ',', round(plating_charge_price, 2) ) as text") )
            //                 // ->groupBy('setting_type')
            //                 ->where('plating_charge_price', ">", 0)
            //                 ->orderBy('plating_thickness', "ASC");
            //
            //       if(!empty($request->search)){
            //             $query->where('plating_thickness', 'like', '%' . $request->search. '%');
            //             $query->orWhere('product_type', 'like', '%' . $request->search. '%');
            //             $query->orWhere('uom', 'like', '%' . $request->search. '%');
            //         }
            //     $query->limit(50);
            //     $results = $query->get();
            // }
            if($request->type == 'plating_casting') {
                $query = DB::connection('erpnext')
                            ->table('tabPlating Charge Detail')
                            ->select(DB::raw("CONCAT(plating_thickness, ', ', product_type , ', ',
                                                     uom, ',', round(plating_charge_price, 2) ) as id,
                                              CONCAT(plating_thickness, ', ',  product_type , ', ',
                                              uom ) as text") )
                            // ->groupBy('setting_type')
                            ->where('plating_charge_price', ">", 0)
                            // ->where('product_type', "Non-Chain Product")
                            ->where(function ($query) {
                                      $query->where('product_type', "Non-Chain Product")
                                            ->orWhere('product_type', "Rhodium Product- Non Chain")
                                            ->orWhere('product_type', "Platinum  and Rhodium Product- Non Chain");
                                  })
                            ->orderBy('plating_thickness', "ASC");

                  if(!empty($request->search)){
                        $query->where('plating_thickness', 'like', '%' . $request->search. '%');
                        $query->orWhere('product_type', 'like', '%' . $request->search. '%');
                        $query->orWhere('uom', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'plating_chains') {
                $query = DB::connection('erpnext')
                            ->table('tabPlating Charge Detail')
                            ->select(DB::raw("CONCAT(plating_thickness, ', ',  product_type , ', ',
                                                     uom, ',', round(plating_charge_price, 2) ) as id,
                                              CONCAT(plating_thickness, ', ',  product_type , ', ',
                                              uom ) as text") )
                            // ->groupBy('setting_type')
                            ->where('plating_charge_price', ">", 0)
                            ->where('product_type', "Chain Product")
                            ->orderBy('plating_thickness', "ASC");

                  if(!empty($request->search)){
                        $query->where('plating_thickness', 'like', '%' . $request->search. '%');
                        $query->orWhere('product_type', 'like', '%' . $request->search. '%');
                        $query->orWhere('uom', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'stone_name') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("stone as id, stone as text") )
                            ->groupBy('stone')
                            ->orderBy('stone', "ASC");

                  if( !empty($request->search) ) {
                        $query->where('stone', 'like', '%' . $request->search. '%');
                    }

                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'stone_shape') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("shape as id, shape as text") )
                            ->groupBy('shape')
                            ->orderBy('shape', "ASC");

                  if(!empty($request->search))   {
                        $query->where('shape', 'like', '%' . $request->search. '%');
                  }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'stone_cut') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("cut as id, cut as text") )
                            ->groupBy('cut')
                            ->orderBy('cut', "ASC");

              if(!empty($request->search)) {
                    $query->where('cut', 'like', '%' . $request->search. '%');
                }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'stone_size_l') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("ROUND(length,2) as id, ROUND(length,2) as text") )
                            ->groupBy('length')
                            ->orderBy('length', "ASC");

                  if(!empty($request->search)){
                        $query->where('length', 'like', '%' . $request->search. '%');
                    }
                $query->limit(100);
                $results = $query->get();
            }
            if($request->type == 'stone_size_w') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("ROUND(width,2) as id, ROUND(width,2) as text") )
                            ->groupBy('width')
                            ->orderBy('width', "ASC");

                  if(!empty($request->search)){
                        $query->where('width', 'like', '%' . $request->search. '%');
                    }
                $query->limit(100);
                $results = $query->get();
            }
            if($request->type == 'stone_diamond_quality') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Quality')
                            ->select(DB::raw("quality as id, quality as text") )
                            ->orderBy('quality', "ASC");

                  if(!empty($request->search)){
                        $query->where('quality', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'setting_type') {
                $query = DB::connection('erpnext')
                            ->table('tabSetting')
                            ->select(DB::raw("setting_name as id, setting_name as text") )
                            ->orderBy('setting_name', "ASC");

                  if(!empty($request->search)){
                        $query->where('setting_name', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'price_unit') {
                $query = DB::connection('erpnext')
                            ->table('tabStone Price')
                            ->select(DB::raw("uom as id, uom as text") )
                            ->groupBy('uom')
                            ->orderBy('uom', "ASC");

                  if(!empty($request->search)){
                        $query->where('uom', 'like', '%' . $request->search. '%');
                    }
                $query->limit(50);
                $results = $query->get();
            }
            if($request->type == 'labour_type') {
              $query = DB::connection('erpnext')
                          ->table('tabPlating Charge Detail')
                          ->select(DB::raw("CONCAT('Plating Type - ', plating_thickness, ', ', product_type, ',',
                                                   uom, ',', round(plating_charge_price, 2) ) as id,
                                            CONCAT(plating_thickness, ', ', product_type, ', ',
                                            uom, ',', round(plating_charge_price, 2) ) as text") )
                          // ->groupBy('setting_type')
                          ->where('plating_charge_price', ">", 0)
                          ->orderBy('plating_thickness', "ASC");

                if(!empty($request->search)){
                      $query->where('plating_thickness', 'like', '%' . $request->search. '%');
                      $query->orWhere('product_type', 'like', '%' . $request->search. '%');
                      $query->orWhere('uom', 'like', '%' . $request->search. '%');
                  }
              $query->limit(50);
              // $results = $query->get();
              $results[0]['id'] = "Chain Labour";
              $results[0]['text'] = "Chain Labour";
              $results[1]['id'] = "CFP";
              $results[1]['text'] = "CFP";
              $results[2]['id'] = "Total Setting Charge";
              $results[2]['text'] = "Total Setting Charge";
              $results[3]['id'] = "Finding";
              $results[3]['text'] = "Finding";
              $results[4]['id'] = "Packing, PD and other Miss";
              $results[4]['text'] = "Packing, PD and other Miss";
              $results[5]['id'] = "Plating Type";
              $results[5]['text'] = "Plating Type";
              $results[5]['children'] = $query->get();
            }

            return json_encode(["results"=>$results]);

          }

    public function performLabourCalculation(Request $request)
    {

            $msg = "";
            $price = 0;
            $status = false;

            if($request->labour_type == 'CFP') {

              $msg = "CFP price";
              $status = true;

              if($request->metal_weight_casting > 0) {
                // $metal_weight_casting = $request->metal_weight_casting;

                $query_data = DB::connection('erpnext')
                            ->table('tabLabour Charge Detail')
                            ->select("price" )
                            ->where("product_type", $request->product_type )
                            ->where("metal", $request->metal_type )
                            // ->whereRaw(" $request->metal_weight_casting >= min_prd_weight  AND   $request->metal_weight_casting < max_prd_weight  " )
                            ->whereRaw(" $request->metal_weight_casting > min_prd_weight  AND   $request->metal_weight_casting <= max_prd_weight  " )
                            // ->whereRaw(" ( min_prd_weight >= $request->metal_weight_casting AND max_prd_weight < $request->metal_weight_casting  )" )
                            ->first();

                  if(isset($query_data->price)){
                        if($request->metal_weight_casting <= 2 ) {
                            $price = round($query_data->price, 2);
                        } else {
                          $price = round( ( $query_data->price * $request->metal_weight_casting ) , 2);
                        }

                  }
                }
            }
            if($request->labour_type == 'setting_charge') {
              if($request->setting_charge_value == "WAX") {
                $query_data = DB::connection('erpnext')
                            ->table('tabSetting Charge Detail')
                            ->where("stone", $request->stone_name )
                            ->first();

                  $msg = "Wax price";
                  $status = true;

                  if(isset($query_data->name)){
                      $query_data = (array) $query_data;
                      // if($request->stone_qty > 0  && $request->stone_qty <= 20) { $price = round($query_data['1_to_20_pcs'], 2) ; }
                      // if($request->stone_qty > 20  && $request->stone_qty <= 50) { $price = round($query_data['21_to_50_pcs'], 2); }
                      // if($request->stone_qty > 50  ) { $price = round($query_data['more_then_50_pcs'], 2); }
                      if($request->stone_qty > 0  && $request->stone_qty <= 20) { $price = round($query_data['1_to_20_pcs'], 2)  * $request->metal_weight_casting ; }
                      if($request->stone_qty > 20  && $request->stone_qty <= 50) { $price = round($query_data['21_to_50_pcs'], 2) * $request->metal_weight_casting; }
                      if($request->stone_qty > 50  ) { $price = round($query_data['more_then_50_pcs'], 2) * $request->metal_weight_casting; }
                  }
              }
              else {
                $query_data = DB::connection('erpnext')
                            ->table('tabSetting Charge Detail')
                            ->where("setting_type", $request->setting_charge_value )
                            ->first();

                  $msg = "Setting price";
                  $status = true;

                  // which one was greater that was be stone size
                  $stone_size = 0;
                  if($request->stone_size_l >= $request->stone_size_w ) { $stone_size = $request->stone_size_l * 100; }
                  else { $stone_size = $request->stone_size_w * 100; }

                  if(isset($query_data->name)){

                      $query_data = (array) $query_data;
                      if($stone_size > 0  && $stone_size <= 500) { $price = round($query_data['stone_size_upto_500mm'], 2) * $request->stone_qty; }
                      if($stone_size > 500  && $stone_size <= 1500) { $price = round($query_data['stone_size_upto_600_to_1500mm'], 2) * $request->stone_qty; }
                      if($stone_size > 1500  ) { $price = round($query_data['stone_size_more_then_1500mm'], 2) * $request->stone_qty; }
                  }
              }

            }

            return json_encode(["msg"=>$msg, "status"=>$status, "price"=>$price]);

          }

    public function performStoneCalculation(Request $request)
    {

            $msg = "Stone price";
            $price = 0;
            $weight = 0;
            $status = true;

            if($request->stone_qty > 0) {
              $query_data = DB::connection('erpnext')
                          ->table('tabStone Price')
                          ->where("stone", $request->stone_name )
                          ->where("cut", $request->stone_cut )
                          ->where("shape", $request->stone_shape )
                          ->where("length", $request->stone_size_l )
                          ->where("width", $request->stone_size_w )
                          ->where("quality", $request->stone_diamond_quality )
                          ->where("uom", $request->price_unit )
                          ->first();


                if( isset($query_data->price) ) {
                      $price = round($query_data->price, 2);
                      $weight = round($query_data->weight_per_pcs, 4);
                }
            }


            return json_encode(["msg"=>$msg, "status"=>$status, "price"=>$price, "weight"=>$weight]);

          }

}

?>
