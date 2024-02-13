<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BomDetailsExcel;
use Storage;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class EMRController extends Controller
{

  public function __construct()
  {
    $this->erpnextDB = DB::connection('erpnext');
  }



  public function update_design_bom_details(Request $request)
  {

    ini_set('max_execution_time', '1000000');

    $design_data = DB::connection('erpnext')
            ->table('tabDesign 3D Library')
            ->select('design_3d_code')
            ->orderBy('creation',  "DESC" )
            ->offset(0)
            ->limit(10000)
            ->get();

    echo "<pre>";
    foreach ($design_data as $key => $value) {
      print_r($value);

      $temp_query =  DB::connection('Emr')
                      ->table('DsgRm')
                      ->select(DB::Raw('DrSr idx,
                                        DrRmCtg category,
                                        DrRmSCtg sub_category,
                                        DrRmCd raw_material_code,
                                        DrLn1 length,
                                        DrLn2 width,
                                        DrQty quantity,
                                        DrWt weight,
                                        DrSetSCd setting,
                                        DrWsQty wax_setting,
                                        DrHsQty hand_setting,
                                        DrAlyCd alloy,
                                        DrMainMet main_metal,
                                        DrSubShp sshp,
                                        DrRmPtr rm_ptr,
                                        DrPrdQty production_quantity_new,
                                        DrPrdWt production_weight'))
                      ->where('DrCd',  $value->design_3d_code )
                      ->get();
      print_r($temp_query);

      if(count($temp_query) > 0) {
        $delete_bom_details = DB::connection('erpnext')
                              ->table('tabEMR Design BOM Details')
                              ->where('parent',  $value->design_3d_code )
                              ->delete();
      }

      foreach ($temp_query as $key2 => $value2) {

        $name = "";
          // generate unique name feild ================ start =============================
          $check = 0;
          $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
          while($check == 0) {
            $name = "";
            for($i=0; $i<10; $i++) {
              $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
            }

            $checkName = DB::connection('erpnext')
                ->table('tabEMR Design BOM Details')
                ->where('name',  $name )
                ->first();

            if(empty($checkName)) {
              $check = 1;
            }
          }
          // generate unique name feild ================ end =============================


        $data = DB::connection('erpnext')
        ->table('tabEMR Design BOM Details')
        ->insert(["name"=> $name,
                  "creation"=> date('Y-m-d h:i:s', time()),
                  "modified"=> date('Y-m-d h:i:s', time()),
                  "modified_by"=> "shyam.sunder@pinkcityindia.com",
                  "owner"=> "shyam.sunder@pinkcityindia.com",
                  "parent"=>$value->design_3d_code,
                  "docstatus"=>0,
                  "parentfield"=>"design_bom_details",
                  "parenttype"=>"Design 3D Library",
                  "idx"=>$value2->idx,
                  "category"=>$value2->category,
                  "sub_category"=>$value2->sub_category,
                  "raw_material_code"=>$value2->raw_material_code,
                  "length"=>$value2->length,
                  "width"=>$value2->width,
                  "quantity"=>$value2->quantity,
                  "weight"=>$value2->weight,
                  "setting"=>$value2->setting,
                  "wax_setting"=>$value2->wax_setting,
                  "hand_setting"=>$value2->hand_setting,
                  "alloy"=>$value2->alloy,
                  "main_metal"=>$value2->main_metal,
                  "sshp"=>$value2->sshp,
                  "rm_ptr"=>$value2->rm_ptr,
                  "production_quantity_new"=>$value2->production_quantity_new,
                  "production_weight"=>$value2->production_weight,
                  "design_code"=>$value->design_3d_code,
                ]);
              }
    }
  }

  public static function get_emr_design_file_location($design_category = '', $design_type = '', $design_code = '', $image_type = '', $db_type = 'mahapura')
	{
		$file_url = "";
		$folder = "mahapura";
		$file_ext = [".jpg", ".jpeg", ".png", ".JPG", ".JPEG", ".PNG"];

		if($db_type == 'sitapura') { $folder = "sitapura"; }

		if($image_type == '3D' || $image_type == '') {

			// $file_loc = "/var/www/vendorportal/public/emr/$folder/3D/$design_category/";
			$file_loc = "/var/www/vendorportal/public/emr/$folder/3D/$design_category/";
			$file_name = "$design_type 3D $design_code";

			for ($i=0; $i <count($file_ext) ; $i++) {
				if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
				{
						$file_url = "/emr/$folder/3D/$design_category/$file_name$file_ext[$i]";
						break;
				}
			}
		}

		if($image_type == 'LD' || $image_type == '') {

			$file_loc = "/var/www/vendorportal/public/emr/$folder/LD/$design_category/";
			$file_name = "$design_type LD $design_code";

			for ($i=0; $i <count($file_ext) ; $i++) {
				if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
				{
					$file_url = "/emr/$folder/LD/$design_category/$file_name$file_ext[$i]";
					break;
				}
			}

		}

		return $file_url;

	}

  public function getEMRDesigns(Request $request)
  {

    ini_set('max_execution_time', '1000000');

    // $db_name = "Emr";
    // $folder_name = "mahapura";
    $db_name = "EmrSitapura";
    $folder_name = "sitapura";
    $erp_table_name = "tabEMR Design 3D Library";


    // $design_data = DB::connection('erpnext')
    //         ->table('tabDesign 3D Library')
    //         ->select('design_3d_code')
    //         ->orderBy('creation',  "DESC" )
    //         ->offset(0)
    //         ->limit(10000)
    //         ->get();

    $design_data =  DB::connection($db_name)
                    ->table('DsgMst')
                    // ->select(DB::Raw('*'))

                    ->select(DB::Raw("DsgMst.*, DsgAna.DaAnaCd designer_code, Param.PDesc as designer_name"))
                    ->leftJoin('DsgAna', function ($join) {
                          $join->on('DsgAna.DaDmIdNo', '=', 'DsgMst.DmIdNo')
                               ->where('DsgAna.DaAnaSr', '2');
                      })
                    ->leftJoin('Param', function ($join) {
                          $join->on('Param.PSCd', '=', 'DsgAna.DaAnaCd')
                               ->where('Param.PMCd', '2');
                      })

                      // ->where('DmCd',  "BRS99657" )
                      ->orderBy('DmDsgDt',  "DESC" )
                    // ->offset(0)
                    ->limit(1000)
                    ->get();

    echo "<pre>";

    // print_r($design_data);
    foreach ($design_data as $key => $value) {
      print_r($value);
      print_r("<br>hi11<br>");

      $check_design = DB::connection('erpnext')
              ->table($erp_table_name)
              ->select('*')
              ->where('name',  $value->DmCd )
              ->get();

      $file_name  = "";
      if ($this->get_emr_design_file_location($value->DmCtg, $value->DmTcTyp, $value->DmCd, '', $folder_name) != "") {
        $file_name = "/files".$this->get_emr_design_file_location($value->DmCtg, $value->DmTcTyp, $value->DmCd, '', $folder_name);
      }

      print_r($this->get_emr_design_file_location($value->DmCtg, $value->DmTcTyp, $value->DmCd, '', $folder_name));
      print_r($file_name);
      print_r("<br>hi22<br>");

      if(isset($check_design[0]->name)) {
        $data = DB::connection('erpnext')
        ->table($erp_table_name)
        ->where('name', $value->DmCd)
        ->update([
                  // "name"=> $value->DmCd,
                  // "creation"=> date('Y-m-d h:i:s', time()),
                  // "modified"=> date('Y-m-d h:i:s', time()),
                  // "modified_by"=> "shyam.sunder@pinkcityindia.com",
                  // "owner"=> "shyam.sunder@pinkcityindia.com",
                  "created_by"=> "shyam.sunder@pinkcityindia.com",
                  // "parent"=>"",
                  // "docstatus"=>0,
                  // "parentfield"=>"design_bom_details",
                  // "parenttype"=>"Design 3D Library",
                  // "idx"=>"",
                  "image"=>$file_name,
                  "design_3d_code_description"=>$value->DmDesc,
                  "branch"=>($folder_name == "mahapura") ? "Mahapura" : "Sitapura",
                  "design_category"=>$value->DmCtg,
                  "design_3d_code"=>$value->DmCd,
                  "client_code"=>$value->DmCmCd,
                  "uom"=>$value->DmUom,
                  "cad_designer_name"=>$value->designer_name,
                  "quality_done_by"=>$value->DmDsgBy,
                  "design_date"=>date('Y-m-d', strtotime($value->DmDsgDt) ),
                ]);
      }
      else {



        $data = DB::connection('erpnext')
        ->table($erp_table_name)
        ->insert(["name"=> $value->DmCd,
                  "creation"=> date('Y-m-d h:i:s', time()),
                  "modified"=> date('Y-m-d h:i:s', time()),
                  "modified_by"=> "shyam.sunder@pinkcityindia.com",
                  "owner"=> "shyam.sunder@pinkcityindia.com",
                  "created_by"=> "shyam.sunder@pinkcityindia.com",
                  // "parent"=>"",
                  "docstatus"=>0,
                  // "parentfield"=>"design_bom_details",
                  // "parenttype"=>"Design 3D Library",
                  // "idx"=>"",
                  "image"=>$file_name,
                  "design_3d_code_description"=>$value->DmDesc,
                  "branch"=>($folder_name == "mahapura") ? "Mahapura" : "Sitapura",
                  "design_category"=>$value->DmCtg,
                  "design_3d_code"=>$value->DmCd,
                  "client_code"=>$value->DmCmCd,
                  "uom"=>$value->DmUom,
                  "cad_designer_name"=>$value->designer_name,
                  "quality_done_by"=>$value->DmDsgBy,
                  "design_date"=>date('Y-m-d', strtotime($value->DmDsgDt) ),
                ]);

      }

      // die;




      $temp_query =  DB::connection($db_name)
                      ->table('DsgRm')
                      ->select(DB::Raw('DrSr idx,
                                        DrRmCtg category,
                                        DrRmSCtg sub_category,
                                        DrRmCd raw_material_code,
                                        DrLn1 length,
                                        DrLn2 width,
                                        DrQty quantity,
                                        DrWt weight,
                                        DrSetSCd setting,
                                        DrWsQty wax_setting,
                                        DrHsQty hand_setting,
                                        DrAlyCd alloy,
                                        DrMainMet main_metal,
                                        DrSubShp sshp,
                                        DrRmPtr rm_ptr,
                                        DrPrdQty production_quantity_new,
                                        DrPrdWt production_weight'))
                      ->where('DrCd',  $value->DmCd )
                      ->get();
      print_r($temp_query);

      if(count($temp_query) > 0) {
        $delete_bom_details = DB::connection('erpnext')
                              ->table('tabEMR Design BOM Details')
                              ->where('parent',  $value->DmCd )
                              ->delete();
      }

      foreach ($temp_query as $key2 => $value2) {

        $name = "";
          // generate unique name feild ================ start =============================
          $check = 0;
          $allowed_char = "0123456789abcdefghijklmnopqrstuvwxyz";
          while($check == 0) {
            $name = "";
            for($i=0; $i<10; $i++) {
              $name .= $allowed_char[rand(0, strlen($allowed_char)-1)];
            }

            $checkName = DB::connection('erpnext')
                ->table('tabEMR Design BOM Details')
                ->where('name',  $name )
                ->first();

            if(empty($checkName)) {
              $check = 1;
            }
          }
          // generate unique name feild ================ end =============================


        $data = DB::connection('erpnext')
        ->table('tabEMR Design BOM Details')
        ->insert(["name"=> $name,
                  "creation"=> date('Y-m-d h:i:s', time()),
                  "modified"=> date('Y-m-d h:i:s', time()),
                  "modified_by"=> "shyam.sunder@pinkcityindia.com",
                  "owner"=> "shyam.sunder@pinkcityindia.com",
                  "parent"=>$value->DmCd,
                  "docstatus"=>0,
                  "parentfield"=>"design_bom_details",
                  "parenttype"=>"EMR Design 3D Library",
                  "idx"=>$value2->idx,
                  "category"=>$value2->category,
                  "sub_category"=>$value2->sub_category,
                  "raw_material_code"=>$value2->raw_material_code,
                  "length"=>$value2->length,
                  "width"=>$value2->width,
                  "quantity"=>$value2->quantity,
                  "weight"=>$value2->weight,
                  "setting"=>$value2->setting,
                  "wax_setting"=>$value2->wax_setting,
                  "hand_setting"=>$value2->hand_setting,
                  "alloy"=>$value2->alloy,
                  "main_metal"=>$value2->main_metal,
                  "sshp"=>$value2->sshp,
                  "rm_ptr"=>round($value2->rm_ptr,4),
                  "production_quantity_new"=>$value2->production_quantity_new,
                  "production_weight"=>$value2->production_weight,
                  "design_code"=>$value->DmCd,
                ]);
              }
    }
  }



    public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
    {
      echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
      die;
    }


}
