<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Support\Facades\Auth;
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
      $this->emrDB = "EmrSeetapura";
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
            ->select(DB::raw("Bag.*, CONCAT(BYy, '/', BChr, '/', BNo) bag_no ") )
            ->where("BOdTc", $orders_details->OmTc)
            ->where("BOdYy", $orders_details->OmYy)
            ->where("BOdChr", $orders_details->OmChr)
            ->where("BOdNo", $orders_details->OmNo)
            ->where("BCoCd", $orders_details->OmCoCd)
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


  public function setEmrDB(Request $request)
  {
    $user = DB::connection('localdesign')
            ->table('users')
            ->where('id',  Auth::user()->id )
            ->update(['emrDB'=> $request->emrDB ]);

    Auth::user()->emrDB   = $request->emrDB;
    // Session::flash('message', 'User Emperor Database Successfully update.!');
    // Session::flash('alert-class', 'alert-success');
    // echo "hie11";
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

  public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
  {
    echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
    die;
  }


}
