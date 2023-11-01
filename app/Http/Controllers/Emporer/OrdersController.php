<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Library\WebHelper;
// use Session;
// use App\Models\User;

class OrdersController extends Controller
{

  public function __construct(Type $foo = null)
  {
    $this->emrDB = "EmrMahapura";
    $this->emrDBName = "Mahapura";
  }


  public function check_db(Request $request){

    if(Auth::user()->emrDB == 'Sitapura') {
      $this->emrDB = "EmrSitapura";
      $this->emrDBName = "Sitapura";
    }

  }




  public function list(Request $request){

    $this->check_db($request);

    $title = "Emporer Orders - $this->emrDBName ";


    $query = DB::connection($this->emrDB)
            ->table("OrdMst")
            ->select(DB::raw("OrdMst.*, CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) order_no, CustMst.CmName") )
            ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd");

    if(!empty($request->order_start_date)){
        $query->whereDate('OmDt', ">=", $request->order_start_date);
    }
    if(!empty($request->order_end_date)){
        $query->whereDate('OmDt', "<=", $request->order_end_date);
    }

    // expected == export
    if(!empty($request->expected_order_start_date)){
        $query->whereDate('OmExpDelDt', ">=", $request->expected_order_start_date);
    }
    if(!empty($request->expected_order_end_date)){
        $query->whereDate('OmExpDelDt', "<=", $request->expected_order_end_date);
    }

    if(!empty($request->expected_order_start_date) || !empty($request->expected_order_end_date) ){
        $query->orderBy("OmExpDelDt", "DESC");
    }
    elseif(!empty($request->order_start_date) ) {
      $query->orderBy("OmDt", "ASC");
    }
    else {
      $query->orderBy("OmDt", "DESC");
    }

    if(!empty($request->customer_code)){
        $query->where('OrdMst.OmCmCd', $request->customer_code);
    }
    if(!empty($request->customer_name)){
        $query->where('CustMst.CmName', $request->customer_name);
    }
    if(!empty($request->purchase_order_no)){
        $query->where('OmPoNo',  "like", "%$request->purchase_order_no%");
    }
    if(!empty($request->order_no)){
        $query->whereRaw("CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) like '%$request->order_no%'");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $orders_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['orders_data'] = $orders_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.orders.list', $data );
  }


  public function ordersDetails(Request $request){

    $this->check_db($request);

    // $title = 'Emporer Orders Details ';
    $title = "Emporer Orders Details - $this->emrDBName ";


    $orders_details = DB::connection($this->emrDB)
            ->table("OrdMst")
            ->select(DB::raw("OrdMst.*, CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) order_no, CustMst.CmName") )
            ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd")
            // ->whereRaw("CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) =  '$request->order_no'")
            ->where("OrdMst.OmTc", $request->OmTc)
            ->where("OrdMst.OmYy", $request->OmYy)
            ->where("OrdMst.OmChr", $request->OmChr)
            ->where("OrdMst.OmNo", $request->OmNo)
            ->where("OrdMst.OmCoCd", $request->company_code)
            ->first();


    $orders_design_details = DB::connection($this->emrDB)
            ->table("OrdDsg")
            ->select("OrdDsg.*","DsgMst.DmCd", "DsgMst.DmCtg", "DsgMst.DmTcTyp")
            ->where("OdTc", $orders_details->OmTc)
            ->where("OdYy", $orders_details->OmYy)
            ->where("OdChr", $orders_details->OmChr)
            ->where("OdNo", $orders_details->OmNo)
            ->where("OdCoCd", $orders_details->OmCoCd)
            ->leftJoin("DsgMst", "DsgMst.DmCd" ,"OrdDsg.OdDmCd")
            ->orderBy("OdSr", "ASC")
            ->get();

    $orders_bag_details = DB::connection($this->emrDB)
            ->table("Bag")
            ->select(DB::raw("Bag.*, CONCAT(BYy, '/', BChr, '/', BNo) bag_no, DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp ") )
            ->where("BOdTc", $orders_details->OmTc)
            ->where("BOdYy", $orders_details->OmYy)
            ->where("BOdChr", $orders_details->OmChr)
            ->where("BOdNo", $orders_details->OmNo)
            ->where("BCoCd", $orders_details->OmCoCd)
            ->leftJoin("DsgMst", "DsgMst.DmCd" ,"Bag.BOdDmCd")
            ->orderBy("BOdSr", "ASC")
            ->get();

    // $orders_details = $query->first();

    $data['title'] = $title;
    $data['orders_details'] = $orders_details;
    $data['orders_design_details'] = $orders_design_details;
    $data['orders_bag_details'] = $orders_bag_details;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.orders.view', $data );
  }


  public function orderTracking(Request $request){

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.order_tracking.view');
  }


  public function orderTrackingCheckCustOrder(Request $request){

    // $title = 'Emporer Orders Details ';
    $this->emrDB = "EmrMahapura";

    // if($request->company_code == "PC") { $this->emrDB = "EmrMahapura"; }
    // elseif($request->company_code == "PJ" || $request->company_code == "PJ2") { $this->emrDB = "EmrSitapura"; }
    if($request->company_code == "Mahapura") { $this->emrDB = "EmrMahapura"; }
    elseif($request->company_code == "Sitapura") { $this->emrDB = "EmrSitapura"; }
    else { return json_encode(["msg"=>"Please select the company", "status"=>false, "data"=>[] ]); die; }

    $orders_details = DB::connection($this->emrDB)
            ->table("OrdMst")
            ->select(DB::raw("CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) order_no, OmCmCd,  OmCoCd, CustMst.CmName,
                              OmTc, OmYy, OmChr, OmNo, CustMst.CmName,
                              OrdMst.OmDt, OrdMst.OmIdNo, CONVERT(DATE, OrdMst.OmDt, 103) order_date") )
            ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd")
            ->where("OrdMst.OmCmCd", $request->customer_id)
            ->orderBy("OmDt", "DESC")
            ->limit(10)
            ->get();

    if(count($orders_details) > 0) {  return json_encode(["msg"=>"Order Found", "status"=>true, "data"=>$orders_details  ]); die;}
    else { return json_encode(["msg"=>"Order not found", "status"=>false, "data"=>[]  ]); die;}

  }

  public function orderTrackingDesigns(Request $request){

    // $title = 'Emporer Orders Details ';
    $this->emrDB = "EmrMahapura";

    if($request->OmCoCd == "PC") { $this->emrDB = "EmrMahapura"; }
    elseif($request->OmCoCd == "PJ" || $request->OmCoCd == "PJ2") { $this->emrDB = "EmrSitapura"; }

    $orders_design_details = DB::connection($this->emrDB)
            ->table("OrdDsg")
            ->select(DB::raw("OdTc, OdYy, OdChr, OdNo, OdSr, OdDmCd, OdDmSz, OdOrdQty, OdCoCd, OdIdNo,
                              DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp,
                              (SELECT Param.PDesc FROM Param WHERE DsgMst.DmCtg = Param.PMCd and Param.PTyp = 'DMCTG') category"))
            // ->where("OdTc", $request->OmTc)
            // ->where("OdYy", $request->OmYy)
            // ->where("OdChr", $request->OmChr)
            // ->where("OdNo", $request->OmNo)
            // ->where("OdCoCd", $request->OmCoCd)
            ->where("OdOmIdNo", $request->OmIdNo)
            // ->where("OdCoCd", $request->OmCoCd)
            ->leftJoin("DsgMst", "DsgMst.DmCd" ,"OrdDsg.OdDmCd")
            ->orderBy("OdSr", "ASC")
            ->get();

    if(count($orders_design_details) > 0) {  return json_encode(["msg"=>"Order Designs List", "status"=>true, "data"=>$orders_design_details  ]); die;}
    else { return json_encode(["msg"=>"Order Design not found", "status"=>false, "data"=>[]  ]); die;}

  }

  public function orderTrackingDesignsDetails(Request $request){

    // $title = 'Emporer Orders Details ';
    $this->emrDB = "EmrMahapura";

    if($request->OdCoCd == "PC") { $this->emrDB = "EmrMahapura"; }
    elseif($request->OdCoCd == "PJ" || $request->OdCoCd == "PJ2") { $this->emrDB = "EmrSitapura"; }

    $orders_design_details = DB::connection($this->emrDB)
            ->table("OrdDsg")
            ->select(DB::raw("OdTc, OdYy, OdChr, OdNo, OdSr, OdDmCd, OdDmSz, OdOrdQty, OdCoCd,
                              DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp,
                              (SELECT Param.PDesc FROM Param WHERE DsgMst.DmCtg = Param.PMCd and Param.PTyp = 'DMCTG') category,
                              (SELECT ISNULL(SUM(Bag.BQty), 0) FROM Bag WHERE BOdIdNo = $request->OdIdNo ) total_bag_qty,
                              ISNULL( ( SELECT SUM(max_max_BQty) FROM (
                                           SELECT SUM(max_BQty) max_max_BQty, BIdNo
                                          FROM ( SELECT MAX(Bag.BQty) max_BQty, BIdNo
                                                FROM Bag JOIN Fgd ON Fgd.FdBIdNo = Bag.BIdNo
                                                WHERE BOdIdNo = $request->OdIdNo GROUP BY Bag.BIdNo
                                                ) temp_bag
                                            GROUP BY BIdNo
                                            ) temp_temp_bag  ) , 0) total_fg_qty
                              "))

                  // SELECT SUM(max_BQty) , BIdNo
                  // FROM
                  // ( SELECT MAX(Bag.BQty) max_BQty, BIdNo
                  // FROM Bag LEFT JOIN Fgd ON Fgd.FdBIdNo = Bag.BIdNo
                  // WHERE BOdIdNo = 832628 GROUP BY Bag.BIdNo  ) temp_bag
                  // GROUP BY BIdNo

            // ->select(DB::raw("OdTc, OdYy, OdChr, OdNo, OdSr, OdDmCd, OdDmSz, OdOrdQty, OdCoCd,
            //                   DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp,
            //                   (SELECT Param.PDesc FROM Param WHERE DsgMst.DmCtg = Param.PMCd and Param.PTyp = 'DMCTG') category,
            //                   (SELECT SUM(Bag.BQty) FROM Bag WHERE BOdIdNo = $request->OdIdNo ) total_bag_qty,
            //                   (SELECT SUM(Fgd.FdQty) FROM Bag LEFT JOIN Fgd ON Fgd.FdBIdNo = Bag.BIdNo WHERE BOdIdNo = $request->OdIdNo ) total_fg_qty
            //                   "))
            // ->where("OdTc", $request->OdTc)
            // ->where("OdYy", $request->OdYy)
            // ->where("OdChr", $request->OdChr)
            // ->where("OdNo", $request->OdNo)
            // ->where("OdDmCd", $request->OdDmCd)
            ->where("OdIdNo", $request->OdIdNo)
            // ->where("OdCoCd", $request->OdCoCd)
            ->leftJoin("DsgMst", "DsgMst.DmCd" ,"OrdDsg.OdDmCd")
            ->orderBy("OdSr", "ASC")
            ->first();

    // $orders_design_bag_details = DB::connection($this->emrDB)
    //         ->table("OrdDsg")
    //         ->select(DB::raw("SUM()"))
    //         // ->where("OdTc", $request->OdTc)
    //         // ->where("OdYy", $request->OdYy)
    //         // ->where("OdChr", $request->OdChr)
    //         // ->where("OdNo", $request->OdNo)
    //         // ->where("OdDmCd", $request->OdDmCd)
    //         ->where("OdIdNo", $request->OdIdNo)
    //         // ->where("OdCoCd", $request->OdCoCd)
    //         ->leftJoin("Bag", "Bag.BOdIdNo" ,"OrdDsg.OdIdNo")
    //         ->orderBy("OdSr", "ASC")
    //         ->first();

    if(isset($orders_design_details->OdDmCd)) {
        if(WebHelper::get_emr_design_file_location_guest($orders_design_details->DmCtg, $orders_design_details->DmTcTyp, $orders_design_details->DmCd, "", $request->OdCoCd) != "") {
          $orders_design_details->file_url = WebHelper::get_emr_design_file_location_guest($orders_design_details->DmCtg, $orders_design_details->DmTcTyp, $orders_design_details->DmCd, "", $request->OdCoCd);
        }
        else { $orders_design_details->file_url = "/public/img/image-not-found.jpg";}
        return json_encode(["msg"=>"Order Designs Details Found", "status"=>true, "data"=>$orders_design_details  ]); die;}
    else { return json_encode(["msg"=>"Order Design Details not found", "status"=>false, "data"=>[]  ]); die;}

  }


  public function orderDesignsBagDetails(Request $request){

    $this->check_db($request);


    $design_bag_details = DB::connection($this->emrDB)
                        ->table("Bag")
                        ->select(DB::raw("Bag.*, CONCAT(BYy, '/', BChr, '/', BNo) bag_no, DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp ") )
                        ->where("BOdIdNo", $request->OdIdNo)
                        ->leftJoin("DsgMst", "DsgMst.DmCd" ,"Bag.BOdDmCd")
                        ->orderBy("BOdSr", "ASC")
                        ->get();

    $html_data = ""; $count=1;
    foreach ($design_bag_details as $key => $data) {
        $html_data .= "<tr style='text-align: center;'>
                        <td>".$count++."</td>
                        <td><a href=\"/emporer/bag/bagDetails?BIdNo=$data->BIdNo\"  style=\"color: green;\">$data->bag_no</td>
                        <td>$data->BOdDmCd</td>
                        <td>". round($data->BOpnQty, 4) ."</td>
                        <td>".date("D, d-m-Y",strtotime($data->BOpnDt))."</td>
                        <td>$data->BOpnLoc</td>
                        <td>$data->BLoc</td>
                        <td>". round($data->BQty, 4) ."</td>
                        <td>". round($data->BGrWt, 4) ."</td>
                      </tr>";
    }

    if(count($design_bag_details) > 0) {  return json_encode(["msg"=>"Bag Found", "status"=>true, "data"=>$design_bag_details, "html_data"=>$html_data  ]); die;}
    else { return json_encode(["msg"=>"Bag not found", "status"=>false, "data"=>[]  ]); die;}

  }


  public function setEmrDB(Request $request)
  {
    $user = DB::connection('localdesign')
            ->table('users')
            ->where('id',  Auth::user()->id )
            ->update(['emrDB'=> $request->emrDB ]);

    Auth::user()->emrDB   = $request->emrDB;

    if($request->segment(1) == 'emporer' && $request->segment(2) == 'design' ) {
      return redirect()->to('/emporer/design/list');
    }
    elseif($request->segment(1) == 'emporer' && $request->segment(2) == 'orders' ) {
      return redirect()->to('/emporer/orders/list');
    }
    else {
      return redirect()->back();
    }

  }



}
