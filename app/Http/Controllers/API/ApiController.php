<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BomDetailsExcel;
use Storage;



class ApiController extends Controller
{

  public function __construct()
  {
    $this->erpnextDB = DB::connection('erpnext');
  }



  public function update_production_workflow_tree(Request $request)
  {

    if( $request->validate([
        'doc_name' => 'required',
        'production_workflow_tree' => 'required',
        ]) ) {
          $data = DB::connection('erpnext')
                  ->table('tabBag Order Details')
                  ->where('bag_order',  $request->doc_name )
                  ->where('production_workflow_tree',  $request->production_workflow_tree )
                  ->first();

          if(isset($data->name)) {
            // continue
            echo json_encode(["msg"=>"data already added", "status"=> false, "data"=>"",]);die;
          } else {
            $query_data = $this->erpnextDB
                  ->table('tabProduction Workflow')
                          // `tabProduction Workflow`.*,
                  ->select(DB::Raw('
                          `tabProduction Workflow`.modified_by,
                          `tabBag Order`.name as bag_order,
                          `tabProduction Order`.name as production_order,
                          `tabProduction Order`.order_no_plain as order_no,
                          `tabBag Order`.bag_order_qty,
                          `tabBag Order`.final_bag_order_qty,
                          `tabBag Order`.target_weight
                          '))
                  ->join("tabBag Order", "tabBag Order.name", "=", "tabProduction Workflow.parent")
                  ->join("tabProduction Order Track", "tabProduction Order Track.name", "=", "tabBag Order.order_no")
                  ->join("tabProduction Order", "tabProduction Order.name", "=", "tabProduction Order Track.production_order_series")
                  ->where('tabProduction Workflow.parent',  $request->doc_name )
                  ->where('tabProduction Workflow.production_workflow_tree',  $request->production_workflow_tree )
                  ->first();

            if(isset($query_data->bag_order)) {
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
                      ->table('tabBag Order Details')
                      ->where('name', 'like', '%' . $name ."%")
                      ->first();

                  if(empty($checkName)) {
                    $check = 1;
                  }
                }
                // generate unique name feild ================ end =============================

                // get last idx ================ end =============================
                $temp_query = $this->erpnextDB
                                  ->table('tabBag Order Details')
                                  ->select(DB::raw("IFNUll(MAX(idx), 0) as idx_no") )
                                  ->where('parent',  $request->production_workflow_tree )
                                  ->first();
                // get last idx ================ end =============================

              $data = $this->erpnextDB
              ->table('tabBag Order Details')
              ->insert(["name"=> $name,
                        "creation"=> date('Y-m-d h:i:s', time()),
                        "modified"=> date('Y-m-d h:i:s', time()),
                        "modified_by"=> $query_data->modified_by,
                        "owner"=> $query_data->modified_by,
                        "parent"=>$request->production_workflow_tree,
                        "docstatus"=>0,
                        "parentfield"=>"bag_order_details",
                        "parenttype"=>"Production Workflow Tree",
                        "idx"=>($temp_query->idx_no + 1),
                        "production_workflow_tree"=>$request->production_workflow_tree,
                        "bag_order"=>$query_data->bag_order,
                        "production_order"=>$query_data->production_order,
                        "order_no"=>$query_data->order_no,
                        "bag_order_qty"=>$query_data->bag_order_qty,
                        "final_bag_order_qty"=>$query_data->final_bag_order_qty,
                        "target_weight"=>$query_data->target_weight,
                      ]);

          $temp_query =  $this->erpnextDB
                          ->table('tabProduction Workflow Tree')
                          ->join("tabBag Order Details", "tabProduction Workflow Tree.name", "=", "tabBag Order Details.parent")
                          ->where('tabProduction Workflow Tree.name',  $request->production_workflow_tree )
                          ->groupBy('tabProduction Workflow Tree.name')
                          ->update([
                            "added_bag"=>DB::Raw(" ( SELECT COUNT(`tabBag Order Details`.name) FROM `tabBag Order Details`
                                                      WHERE production_workflow_tree = '$request->production_workflow_tree' ) ")
                          ]);


            echo json_encode(["msg"=>"data added successfully", "status"=> true, "data"=>$data,]);die;
          } else {
            echo json_encode(["msg"=>"no bag order found", "status"=> false, "data"=>"",]);die;
          }



          }
    }

  }




  public function getBomDetails(Request $request)
  {
    // "sudo mount -t cifs //192.168.2.5/MwPict /opt/lampp/htdocs/test -o user=jhs,password=jhs"


      // print_r("he222");
      // print_r($_REQUEST);
      // die;

    if( $request->validate([
        'emporer_bag_no' => 'required',
        // 'bag_no_year' => 'required',
        ]) ) {
          $explode_data = explode("/",$request->emporer_bag_no);
          if(!isset($explode_data[2])) {
            echo json_encode(["msg"=>"Bag No. not found", "status"=> false, "data"=>"",]);die;
          }
          $bag_no_year = $explode_data[0];
          $chr = $explode_data[1];
          $emporer_bag_no = $explode_data[2];


          $bag_data = DB::connection('Emr')
          // $bag_data = DB::connection('EmrSitapura')
                  ->table('Bag')
                  // ->where('BOdDmCd',  $request->emporer_bag_no )
                  ->where('BNo',  $emporer_bag_no )
                  ->whereRaw(" (BChr = '$chr' OR BOdChr = '$chr') ")
                  // ->where('BOdChr',  $chr)
                  ->where('BYy',  $bag_no_year )
                  ->get();
          $data['bag_data'] = $bag_data;





          if(count($bag_data) > 0) {

            // $bag_no_year = $bag_data[0]->BYy;
            // $chr = $bag_data[0]->BChr;
            // $emporer_bag_no = $bag_data[0]->BNo;

            $design_data = DB::connection('Emr')
                    ->table('OrdDsg')
                    ->where('OdNo',  $bag_data[0]->BOdNo )
                    ->where('OdSr',  $bag_data[0]->BOdSr )
                    ->where('OdDmCd',  $bag_data[0]->BOdDmCd )
                    ->get();
            $data['design_data'] = $design_data;

            $design_master_data = DB::connection('Emr')
                    ->table('DsgMst')
                    ->where('DmCd',  $bag_data[0]->BOdDmCd )
                    ->get();
            $data['design_master_data'] = $design_master_data;

            if(isset($design_master_data[0])) {
              $image_types = ["jpg", "JPG", "png", "PNG"];
              $image_src = "";
              $file_name = "";
              $check_image = 0;
              $file_name = 0;
              for ($i=0; $i <count($image_types) ; $i++) {
                if(file_exists("/opt/lampp/htdocs/test/3D/".$design_master_data[0]->DmCtg."/DM 3D ".$design_master_data[0]->DmCd.".$image_types[$i]")) {
                  $check_image = 1;
                  $image_src = "/opt/lampp/htdocs/test/3D/".$design_master_data[0]->DmCtg."/DM 3D ".$design_master_data[0]->DmCd.".$image_types[$i]";
                  $file_name = "DM 3D ".$design_master_data[0]->DmCd.".$image_types[$i]";
                }
                if(file_exists("/opt/lampp/htdocs/test/3D/".$design_master_data[0]->DmCtg."/".$design_master_data[0]->DmCd.".$image_types[$i]")) {
                  $check_image = 1;
                  $image_src = "/opt/lampp/htdocs/test/3D/".$design_master_data[0]->DmCtg."/".$design_master_data[0]->DmCd.".$image_types[$i]";
                  $file_name = $design_master_data[0]->DmCd.".$image_types[$i]";
                }
                if(file_exists("/opt/lampp/htdocs/test/LD/".$design_master_data[0]->DmCtg."/DM LD ".$design_master_data[0]->DmCd.".$image_types[$i]")) {
                  $check_image = 1;
                  $image_src = "/opt/lampp/htdocs/test/LD/".$design_master_data[0]->DmCtg."/DM LD ".$design_master_data[0]->DmCd.".$image_types[$i]";
                  $file_name = "DM LD ".$design_master_data[0]->DmCd.".$image_types[$i]";
                }
                if(file_exists("/opt/lampp/htdocs/test/LD/".$design_master_data[0]->DmCtg."/".$design_master_data[0]->DmCd.".$image_types[$i]")) {
                  $check_image = 1;
                  $image_src = "/opt/lampp/htdocs/test/LD/".$design_master_data[0]->DmCtg."/".$design_master_data[0]->DmCd.".$image_types[$i]";
                  $file_name = $design_master_data[0]->DmCd.".$image_types[$i]";
                }
              }

              $data['file_name'] = $file_name;
              $data['check_image'] = $check_image;
              if($check_image == 1) {
                Storage::put("public/emr/".$file_name, file_get_contents($image_src));
              }
            }



            $data['row_material_data'] = [];

            if(isset($design_data[0])) {
              $row_material_data = DB::connection('Emr')
                      ->table('OrdRm')
                      ->select('OrdRm.*', 'RmMst.RmDesc')
                      ->join('RmMst', 'RmMst.RmCd', '=', 'OrdRm.OrRmCd')
                      ->where('OrOdIdNo',  $design_data[0]->OdIdNo)
                      ->get();
              $data['row_material_data'] = $row_material_data;
            }

            $finish_good_data = DB::connection('Emr')
                    ->table('Fgd')
                    ->where('FdDmCd',  $bag_data[0]->BOdDmCd)
                    // ->where('FdYy',  $bag_no_year)
                    ->where('FdBYy',  $bag_no_year)
                    ->where('FdBNo',  $emporer_bag_no)
                    ->get();
            $data['finish_good_data'] = $finish_good_data;

            $data['finish_good_row_material_data']  =  [];

            if(isset($finish_good_data[0])) {
              $finish_good_row_material_data = DB::connection('Emr')
                      ->table('FgRm')
                      ->select('FgRm.*', 'RmMst.RmDesc')
                      ->join('RmMst', 'RmMst.RmCd', '=', 'FgRm.FrRmCd')
                      ->where('FrTc',  'FB')
                      // ->where('FrYy',  $bag_no_year)
                      ->where('FrSr',  $finish_good_data[0]->FdSr)
                      ->where('FrNo',  $finish_good_data[0]->FdNo)
                      ->where('FrCoCd',  $bag_data[0]->BCoCd)
                      ->get();
              $data['finish_good_row_material_data'] = $finish_good_row_material_data;
            }

            echo json_encode(["msg"=>"Bag found", "status"=> true, "data"=>$data,]);die;
          } else {
            echo json_encode(["msg"=>"Bag No. not found", "status"=> false, "data"=>"",]);die;
          }
      }
    }



  public function getBomDetailsExcel(Request $request)
  {
    // "sudo mount -t cifs //192.168.2.5/MwPict /opt/lampp/htdocs/test -o user=jhs,password=jhs"
    // "sudo mount -t cifs //192.168.5.88/MwPict /opt/lampp/htdocs/backup -o user=mahapura,password=mahapura"


    if( $request->validate([
        'id' => 'required',
        // 'bag_no_year' => 'required',
        ]) ) {
          $file_name = 'Bom Details List ';

          $erpnextDB = DB::connection("erpnext");

          $query = $erpnextDB
                        ->table("tabEmp Bag Data Child")
                        ->where("parent", $request->id);

          $bom_details_data = $query->get();

          if(empty($bom_details_data))  {
            die("BOM Details not found");
          }

          $file_name .=  "-". date('d-m-Y').'-'.time().'.xlsx';
          return Excel::download(new BomDetailsExcel($request), $file_name);
      }
    }

    public function get_last_po_item(Request $request)
    {
      // print_r($request->last_purchase_rate);
      // print_r($request->doc_name);
      // print_r($request->item_code);
      if( $request->validate([
          'doc_name' => 'required',
          'item_code' => 'required',
          // 'last_purchase_rate' => 'required',
          ]) ) {
            // $data = DB::connection('erpnext')
            //         ->table('tabPurchase Order Item AS poi')
            //         ->select('poi.*')
            //         ->leftJoin('tabPurchase Order AS po', "po.name", "poi.parent")
            //         ->where('po.docstatus',  1)
            //         ->where('po.name',  "!=", $request->doc_name )
            //         ->where('poi.item_code',  $request->item_code )
            //         ->where('poi.base_rate',  $request->last_purchase_rate )
            //         ->orderBy('po.transaction_date', "DESC")
            //         ->orderBy('po.name', "DESC")
            //         ->orderBy('poi.idx', "ASC")
            //         ->limit(1)
            //         ->get();
            $data = DB::connection('erpnext')
                    ->table('tabPurchase Invoice Item AS pii')
                    ->select('pii.*', 'pi.posting_date', 'pi.supplier')
                    ->leftJoin('tabPurchase Invoice AS pi', "pi.name", "pii.parent")
                    ->where('pi.docstatus',  1)
                    ->where('pi.name',  "!=", $request->doc_name )
                    ->where('pii.item_code',  $request->item_code )
                    // ->where('poi.base_rate',  $request->last_purchase_rate )
                    ->orderBy('pi.posting_date', "DESC")
                    ->orderBy('pi.name', "DESC")
                    ->orderBy('pii.idx', "ASC")
                    ->limit(5)
                    ->get();

            if(isset($data[0]->name)) {
              echo json_encode(["msg"=>"Last Purchase Order found", "status"=> true, "data"=>$data,]);die;
            } else {
              echo json_encode(["msg"=>"Last Purchase Order found", "status"=> false, "data"=>"",]);die;
            }
      }

    }



     public function getJobOpening(Request $request){

         // $data = DB::connection('erpnextLocal')
         $data = DB::connection('erpnext')
                 ->table('tabJob Opening')
                 ->select('name', "job_title", "designation", "department")
                 ->where('workflow_state',  "Approved by Management" )
                 ->where('job_status',  "Open" )
                 ->get();
         if(isset($data[0]->name)) {
           $this->jsonResponse("Job Opening is found.", true, $data);
         } else {
           $this->jsonResponse("Job Opening not found.", false, $data);
       }
    }

    public function getJobOpeningDetails(Request $request){

      $data = DB::connection('erpnext')
              ->table('tabJob Opening')
              ->where('job_title',  $request->job_title)
              ->first();
      if(isset($data->name)) {
        $this->jsonResponse("Job Opening Details is found.", true, $data);
      } else {
        $this->jsonResponse("Job Opening Details not found.", false, $data);
      }

     // if( $request->validate([
     //     'job_title' => 'required',
     //     ]) ) {
     //       $data = DB::connection('erpnext')
     //               ->table('tabJob Opening')
     //               ->where('job_title',  $request->job_title )
     //               ->first();
     //       if(isset($data->name)) {
     //         $this->jsonResponse("Job Opening Details is found.", true, $data);
     //       } else {
     //         $this->jsonResponse("Job Opening Details not found.", false, $data);
     //     }
     // }
    }



    public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
    {
      echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
      die;
    }


}
