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



    public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
    {
      echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
      die;
    }


}
