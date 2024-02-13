<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\File;

define("barcodeTypeOrder", "Orders");
define("barcodeTypePW", "ProductionWorkflow");
define("design2D", "design2D");

class WebController extends Controller
{

     public function checkOrder(Request $request){

      if( $request->validate([
          'barcode' => 'required',
          'username' => 'required',
          ]) ) {
            $data = DB::connection('erpnext')
                    ->table('tabProduction Order Tracking')
                    ->where('order_no', 'like', '%' . $request->barcode ."%")
                    ->first();
            if(!empty($data)) {
              $this->jsonResponse("Orders is found.", true, $data, barcodeTypeOrder);
            } else {

              $data = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name', $request->barcode)
                    ->first();

                    if(!empty($data)) {
                      $this->jsonResponse("Production Workflow list are found.", true, $data, barcodeTypePW);
                    } else {

                      $data = DB::connection('erpnext')
                            ->table('tabDesign Library')
                            ->where('name', $request->barcode)
                            ->first();

                      if(!empty($data)) {
                        $this->jsonResponse("2D Design Data found.", true, $data, design2D);
                      } else {
                        $this->jsonResponse("Production Workflow  and Order not found.", false);
                    }
            }
          }
      }
    }


    public function getProductionWorkflowList(Request $request)
    {

      if( $request->validate([
        'barcode' => 'required',
        'username' => 'required',
        ]) ) {
          $order = DB::connection('erpnext')
                  ->table('tabProduction Order Tracking')
                  ->where('order_no', 'like', '%' . $request->barcode ."%")
                  ->first();

          if(!empty($order)) {
            $data = DB::connection('erpnext')
                  ->table('tabProduction Workflow')
                  ->where('parent',   $order->name)
                  ->orderBy("idx", "ASC")
                  ->get();

              if(!empty($data) && count($data) > 0) {
                $this->jsonResponse("Production Workflow list are found.", true, $data);
              } else {
                $this->jsonResponse("Production Workflow list not found.", false);
              }
          } else {
            $this->jsonResponse("Orders not found.", false);
          }
      }
    }


    public function getProductionWorkflowDetails(Request $request){

      if( $request->validate([
          'production_workflow_id' => 'required',
          'username' => 'required',
          ]) ) {
            $data = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name',  $request->production_workflow_id )
                    ->first();

            if(!empty($data)) {
              $this->jsonResponse("Production Workflow is found.", true, $data);
            } else {
              $this->jsonResponse("Production Workflow not found.", false);
            }
        }
    }

    public function getUserDetails(Request $request){

      if( $request->validate([
          'username' => 'required',
          ]) ) {
            $data = DB::connection('erpnext')
                    ->table('tabUser')
                    ->where('name',  $request->username )
                    ->first();

            if(!empty($data)) {
              $this->jsonResponse("User is found.", true, $data);
            } else {
              $this->jsonResponse("User not found.", false);
            }
      }
    }

    public function updateProductionWorkflowBarcode(Request $request){

      if( $request->validate([
          'production_workflow_id' => 'required',
          'username' => 'required',
          'new_barcode' => 'required',
          ]) ) {
            $data = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name',  $request->production_workflow_id )
                    ->update(['barcode'=>$request->new_barcode]);

            if($data) {
              $this->jsonResponse("Production Workflow is updated.", true, $data);
            } else {
              $this->jsonResponse("Production Workflow not updated.", false);
            }
      }
    }

    public function updateProductionWorkflowWeight(Request $request){

      if( $request->validate([
          'production_workflow_id' => 'required',
          'username' => 'required',
          'new_weight' => 'required',
          ]) ) {
            $data = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name',  $request->production_workflow_id )
                    ->update(['current_wt'=>$request->new_weight,
                              'modified'=>date('Y-m-d h:i:s', time()),
                              'modified_by'=>$request->username]);

            if($data) {
              $this->jsonResponse("Production Workflow is updated.", true, $data);
            } else {
              $this->jsonResponse("Production Workflow not updated.", false);
            }
      }
    }

    public function getItemsList(Request $request){

      if( $request->validate([
          'username' => 'required',
          ]) ) {

            $msg = "";
            $data = [];
            if($request->list_type == "bin_location") {
              $data = DB::connection('erpnext')
                      ->table('tabItem')
                      ->select(DB::Raw("item_code as name"))
                      ->whereRaw('item_code IS NOT NULL')
                      // ->limit(1000)
                      ->get();
              $msg = "Item Code list are found.";
            }
            if($request->list_type == "warehouse_name") {
              $data = DB::connection('erpnext')
                      ->table('tabWarehouse')
                      ->select(DB::Raw("warehouse_name as name"))
                      ->distinct()
                      // ->select("warehouse_name")
                      ->whereRaw('warehouse_name IS NOT NULL')
                      // ->limit(1000)
                      ->get();
              $msg = "Warehouse list are found.";
            }
            else {
              $data = DB::connection('erpnext')
                      ->table('tabItem')
                      ->select("name")
                      ->limit(1000)
                      ->get();
             $msg = "Item Code list are found.";
            }


            if(isset($data[0])) {
              $this->jsonResponse($msg, true, $data);
            } else {
              $this->jsonResponse("Item list not found.", false);
            }
      }
    }


    public function addProductionWorkflowDetails(Request $request){


      if( $request->validate([
          'order_barcode' => 'required',
          'barcode_type' => 'required',
          'current_wt' => 'required',
          'assigned_wt' => 'required',
          'to_dept' => 'required',
          'from_dept' => 'required',
          'item' => 'required',
          'product_detail' => 'required',
          'username' => 'required',
          "image" => 'required',
          ]) ) {

         $order_name ="";
          // for Order ============================================
          if($request->barcode_type == barcodeTypeOrder) {
              $order = DB::connection('erpnext')
                        ->table('tabProduction Order Tracking')
                        ->where('order_no', 'like', '%' . $request->order_barcode ."%")
                        ->first();
          if(empty($order)) {
              $this->jsonResponse("Orders not found.", false);
            }
            $order_name = $order->name;
          }
          else {
          // for Production Workflow ============================================
          $pw = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name',  $request->order_barcode )
                    ->first();

            if(empty($pw)) {
              $this->jsonResponse("Production Workflow not found.", false);
            }
            $order_name = $pw->parent;
          }

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
                  ->table('tabProduction Workflow')
                  ->where('name', 'like', '%' . $name ."%")
                  ->first();

              if(empty($checkName)) {
                $check = 1;
              }
            }
            // generate unique name feild ================ end =============================

            // upload image ================ end =============================
                $file_name = $request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->store('/public/uploads/productionWorkflow');
                $save_file = new File;
                $uploaded_file_name = str_replace("public/uploads/productionWorkflow/","",$file_path);
                $file_with_img = '<img  src="https://reports.pinkcityindia.com/storage/uploads/productionWorkflow/'.$uploaded_file_name.'" style="width: 100px !important; height: 30px !important;"  >';
            // upload image ================ end =============================


            // get last idx ================ end =============================
            $temp_query = DB::connection('erpnext')
                              ->table('tabProduction Workflow')
                              ->select(DB::raw("IFNUll(MAX(idx), 0) as idx_no") )
                              ->where('parent',  $order_name )
                              ->first();
            // get last idx ================ end =============================

            // generate barcode feild ================ end =============================
            $generatorPNG = new BarcodeGeneratorPNG();
            $barcode_gen = new BarcodeGeneratorHTML();
            $barcode = $barcode_gen->getBarcode($name, $generatorPNG::TYPE_CODE_128);
            $barcode .= "<div>$name</div>";

            $data = DB::connection('erpnext')
            ->table('tabProduction Workflow')
            ->insert(["name"=> $name,
                      "creation"=> date('Y-m-d h:i:s', time()),
                      "modified"=> date('Y-m-d h:i:s', time()),
                      "modified_by"=> $request->username,
                      "owner"=> $request->username,
                      "parent"=>$order_name,
                      "docstatus"=>0,
                      "parentfield"=>"production_workflow",
                      "parenttype"=>"Production Order Tracking",
                      "idx"=>($temp_query->idx_no + 1),
                      "date"=>date("Y-m-d", time()),
                      "product_detail"=>$request->product_detail,
                      "item"=>$request->item,
                      "from_dept"=>$request->from_dept,
                      "to_dept"=>$request->to_dept,
                      "assigned_wt"=>$request->assigned_wt,
                      "current_wt"=>$request->current_wt,
                      "barcode"=>$barcode,
                      // "wt_image"=>$uploaded_file_name,
                      "wt_image"=>$file_with_img,
                    ]);

                if(!empty($data)) {
                  $this->jsonResponse("Production Workflow is added.", true, $data);
                } else {
                  $this->jsonResponse("Production Workflow not added.", false);
                }

      }
      else {
        $this->jsonResponse("Validation Error", false, $request->validate->errors());
      }
    }

  public function getLastProductionWorkflowDetails(Request $request)
  {

    if( $request->validate([
      'barcode' => 'required',
      'barcode_type' => 'required',
      'username' => 'required',
      ]) ) {


        // for Order ============================================
        if($request->barcode_type == barcodeTypeOrder) {
          $order = DB::connection('erpnext')
                    ->table('tabProduction Order Tracking')
                    ->where('order_no', 'like', '%' . $request->barcode ."%")
                    ->first();

          if(!empty($order)) {
            $data = DB::connection('erpnext')
                  ->table('tabProduction Workflow')
                  ->where('parent',   $order->name)
                  ->orderBy("idx", "DESC")
                  ->limit(1)
                  ->first();

              if(!empty($data) ) {
                $this->jsonResponse("Production Workflow is found.", true, $data, $request->barcode_type);
              } else {
                $this->jsonResponse("Production Workflow not found.", false, [], $request->barcode_type);
              }
          } else {
            $this->jsonResponse("Orders not found.", false, [], $request->barcode_type);
          }
        }
        // for Production Workflow ============================================
        else {
          $pw = DB::connection('erpnext')
                    ->table('tabProduction Workflow')
                    ->where('name',  $request->barcode )
                    ->first();

          if(!empty($pw)) {
            $data = DB::connection('erpnext')
                  ->table('tabProduction Workflow')
                  ->where('parent',   $pw->parent)
                  ->orderBy("idx", "DESC")
                  ->limit(1)
                  ->first();

              if(!empty($data) ) {
                $this->jsonResponse("Production Workflow is found.", true, $data, $request->barcode_type);
              } else {
                $this->jsonResponse("Production Workflow not found.", false, [], $request->barcode_type);
              }
          } else {
            $this->jsonResponse("Orders not found.", false, $request->barcode_type);
          }
        }

    }
  }


  public function checkBinLocation(Request $request){

   if( $request->validate([
       'bin_location' => 'required',
       'username' => 'required',
       ]) ) {
         $data = DB::connection('erpnext')
                 ->table('tabWarehouse')
                 ->where('warehouse_name',  $request->bin_location )
                 ->limit(1)
                 ->get();
         if(isset($data[0]->warehouse_name)) {
           $this->jsonResponse("Bin Location is found.", true, $data);
         } else {
           $this->jsonResponse("Bin Location not found.", false, $data);
       }
   }
 }

public function updateItemDetailsApi(Request $request){

   if( $request->validate( [
       'bin_location' => 'required',
       'item_code' => 'required',
       'username' => 'required',
       'new_qty' => 'required',
       ]) ) {


         $query_data_1 = DB::connection("erpnext")
                     ->table("tabLSP Stock Reconcliation")
                     ->where("item_code", $request->item_code)
                     ->where("warehouse", $request->bin_location)
                     ->first();

        if(isset($query_data_1->item_code)) { // update -----------
          $temp_data = [
                    'modified' => date('Y-m-d H:i:s', time()),
                    'modified_by' => $request->username,
                    'quantity' => $request->new_qty,
                  ];

          DB::connection("erpnext")
                     ->table("tabLSP Stock Reconcliation")
                     ->where("item_code", $request->item_code)
                     ->where("warehouse", $request->bin_location)
                     ->update($temp_data);

          $this->jsonResponse("Item Quantity is updated.", true);
        }
        else { //add new -----------
          // generate name dynamically --------------------------  start   ----------------------
          $name =  "";
          $last_no = 1;
          $query_data = DB::connection("erpnext")
                      ->table("tabLSP Stock Reconcliation")
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
          $name =  "LSR-" . date("y", time()) . "-" . sprintf('%05d', $last_no);

          // generate name dynamically --------------------------  end   ----------------------

      $temp_data = [
                'name' => $name,
                'creation' => date('Y-m-d H:i:s', time()),
                'modified' => date('Y-m-d H:i:s', time()),
                'modified_by' => $request->username,
                'owner' => $request->username,
                'docstatus' => 1,
                'idx' => 0,
                'user_name' => $request->username,
                'warehouse' => $request->bin_location,
                'item_code' => $request->item_code,
                'quantity' => $request->new_qty,
                'naming_series' => "LSR-.YY.-",
              ];

         DB::connection("erpnext")
                    ->table("tabLSP Stock Reconcliation")
                    ->insert($temp_data);
         $this->jsonResponse("Item Quantity is added.", true);

        }


   }

 }



 public function getUserAddedItemList(Request $request){

  if( $request->validate([
      'bin_location' => 'required',
      'username' => 'required',
      ]) ) {
        $data = DB::connection('erpnext')
                ->table('tabLSP Stock Reconcliation')
                ->where('warehouse',  $request->bin_location )
                // ->where(function($query) {
                //       $query->where('owner', $request->username)
                //             ->orWhere('modified_by', $request->username);
                //   })
                // ->whereRaw(" ( owner = '" .$request->username . "' OR modified_by = '" .$request->username . "' ) ")
                ->get();
        if(isset($data[0]->name)) {
          $this->jsonResponse("Item List is found.", true, $data);
        } else {
          $this->jsonResponse("Item List not found.", false, $data);
      }
  }
}


 public function getDesignInfo(Request $request){

  if( $request->validate([
      'barcode' => 'required',
      'username' => 'required',
      ]) ) {
        $data = DB::connection('erpnext')
                ->table('tabDesign Library')
                ->where('name',  $request->barcode )
                ->first();
        if(isset($data->name)) {
          $this->jsonResponse("2D Design is found.", true, $data);
        } else {
          $this->jsonResponse("2D Design not found.", false, $data);
      }
  }
}



 public function getJobOpening(Request $request){

     $data = DB::connection('erpnextLocal')
             ->table('tabJob Opening')
             ->select('name', "job_title", "designation", "department")
             ->where('workflow_state',  "Approved by Management" )
             ->where('status',  "Open" )
             ->get();
     if(isset($data[0]->name)) {
       $this->jsonResponse("Job Opening is found.", true, $data);
     } else {
       $this->jsonResponse("Job Opening not found.", false, $data);
   }
}

public function getJobOpeningDetails(Request $request){

 if( $request->validate([
     'job_title' => 'required',
     ]) ) {
       $data = DB::connection('erpnext')
               ->table('tabJob Opening')
               ->where('job_title',  $request->job_title )
               ->first();
       if(isset($data->name)) {
         $this->jsonResponse("Job Opening is found.", true, $data);
       } else {
         $this->jsonResponse("Job Opening not found.", false, $data);
     }
 }
}



  public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
  {
    echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
    die;
  }


  public function getImages(Request $request)
  {
    // if(file_exists("public/img/add.png"))
    // {
    //   print_r("hi11");
    // }
    // else {
    //   print_r("hi22");
    // }
    // if(file_exists("img/add.png"))
    // {
    //   print_r("hi33");
    // }
    // else {
    //   print_r("hi44");
    // }
    // if(file_exists("../public/img/add.png"))
    // {
    //   print_r("hi55");
    // }
    // else {
    //   print_r("hi66");
    // }
    // die;

     print_r("<pre>");
     print_r("<br>hi77<br>");

    $design_3d = DB::connection('erpnext')
              ->table('tabDesign 3D Library')
              ->whereDate('creation', "2022-09-14")
              ->orderBy('creation', "DESC")
              ->limit(6000)
              ->get();

      foreach ($design_3d as $key => $value) {

        if(strlen($value->image) > 0 ) {
          continue;
        }

        // design_3d_code
        $emr_data = DB::connection('Emr')
                  ->table('DsgMst')
                  // ->where('DmCd', "like", "%".$value->design_3d_code."%")
                  ->where('DmCd', $value->design_3d_code)
                  // ->where('DmCd', $value->name)
                  ->get();

        print_r("<br>3D Library <br>");
        print_r($value);
        print_r("<br>emr_data <br>");
        print_r($emr_data);
        print_r("<br>hi88<br>");
        if(count($emr_data) > 0 ) {
          print_r("<br>hi99<br>");
        }
        print_r("<br>hi1010<br>");

          foreach ($emr_data as $key => $value) {
            $file_loc = "test/3D/$value->DmCtg/";
            $file_name = "$value->DmTcTyp 3D $value->DmCd";

            $file_ext = [".jpg", ".jpeg", ".png", ".JPG", ".JPEG", ".PNG"];

            for ($i=0; $i <count($file_ext) ; $i++) {
              if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
              {
                print_r("<br>hi10#<br>");
                echo "<br>$file_loc$file_name$file_ext[$i]<br>";

                // copy("files/$file_name$file_ext[$i]", $file_loc . $file_name . $file_ext[$i]);
                copy($file_loc . $file_name . $file_ext[$i] , "files/$file_name$file_ext[$i]" );
              }
            }

            $file_loc = "test/LD/$value->DmCtg/";
            $file_name = "$value->DmTcTyp LD $value->DmCd";

            for ($i=0; $i <count($file_ext) ; $i++) {
              if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
              {
                print_r("<br>hi11#<br>");
                echo "<br>$file_loc$file_name$file_ext[$i]<br>";

                copy($file_loc . $file_name . $file_ext[$i] , "files/$file_name$file_ext[$i]" );
              }
            }

          }

      }

      print_r("<br>hi88<br>");

  }


  public function checkResmithOrder(Request $request){

   if( $request->validate([
       'barcode' => 'required',
       // 'username' => 'required',
       ]) ) {
         $data = DB::connection('erpnext')
                 ->table('tabQuotation')
                 ->where('name',  $request->barcode )
                 ->first();
         if(!empty($data)) {
           $this->jsonResponse("Quotation is found.", true, $data);
         } else {
            $this->jsonResponse("Quotation not found.", true);
         }
       }

 }


 public function uploadResmithProductVideo(Request $request){
   ini_set('max_execution_time', '1000000');

   // $this->jsonResponse("video is successfully uploaded.", true, ["res" => $_REQUEST, "file" => $_FILES] );

  if( $request->validate([
      // 'barcode' => 'required',
      // 'video' => 'size:5000000',
      ]) ) {

        // print_r($_REQUEST);
        // print_r($_FILES);


        // upload image ================ end =============================

        // $file = $request->file('video');
        //  $destinationPath = public_path('uploads/resmith');
         // $destinationPath = 'uploads/resmith';

         // $file->move($destinationPath,$file->getClientOriginalName());


      }

//       ini_set('post_max_size', '64MB');
// ini_set('upload_max_filesize', '64MB');

      // phpinfo();
              $file = $request->file('video');
              // dd($_FILES);
              // dd($file);



              // $file = $request->file('image');

      // //Display File Name
      // echo 'File Name: '.$file->getClientOriginalName();
      // echo '<br>';
      //
      // //Display File Extension
      // echo 'File Extension: '.$file->getClientOriginalExtension();
      // echo '<br>';
      //
      // //Display File Real Path
      // echo 'File Real Path: '.$file->getRealPath();
      // echo '<br>';
      //
      // //Display File Size
      // echo 'File Size: '.$file->getSize();
      // echo '<br>';
      //
      // //Display File Mime Type
      // echo 'File Mime Type: '.$file->getMimeType();

      //Move Uploaded File


      $destinationPath = 'public/uploads/resmith/';
      $file_name = $file->move($destinationPath,$file->getClientOriginalName());

      $file_path = "http://reports.pinkcityindia.com/$file_name";


                // // $file_name = $files->getClientOriginalName();
                // // print_r($file_name);
                // // dd($files);
                // $file_path = "";
                // $uploaded_file_name = "";
                // // print_r($file_name);
                // // print_r($file_path);
                // // dd($files);
                // // $save_file = new File;
                // $uploaded_file_name = str_replace("uploads/resmith/","",$file_path);
                //
                // // dd($files);
                //
                // $target_dir = "uploads/resmith/";
                // $target_file = $target_dir . basename($_FILES["video"]["name"]);
                //
                // move_uploaded_file($_FILES["video"]["tmp_name"], $target_file);



            // $this->jsonResponse("video is successfully uploaded.", true, ["file_path" => $file_path, "file_name" => $uploaded_file_name] );
            $this->jsonResponse("video is successfully uploaded.", true, ["file_path" => $file_path, "file_name" => $file_name, "res" => $_REQUEST, "file" => $_FILES] );

            if($file_path) {
              $this->jsonResponse("video is successfully uploaded.", true, $uploaded_file_name);
            } else {
               $this->jsonResponse("unable to upload video.", true);
            }

}




}
