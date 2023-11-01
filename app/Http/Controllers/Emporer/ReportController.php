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

class ReportController extends Controller
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




  public function whatIsWhere(Request $request){

    $this->check_db($request);

    $title = "Emporer - What Is Where - Orders - $this->emrDBName ";


    $query = DB::connection($this->emrDB)
            ->table("OrdDsg")
            // ->select(DB::raw("CONCAT(OmCoCd, '/', OmCmCd, '/', OmDt,  '/', OmExpDelDt, '/', OdTc, '/', OdYy, '/', OdChr, '/', OdNo) AS order_no,
            //                   SUM(OdOrdQty) as order_qty,
            //                   SUM((OdPrdQty - OdExpQty)) as bal_qty") )
            ->select(DB::raw("OdOmIdNo, MAX(OmCoCd) OmCoCd, MAX(OmCmCd) OmCmCd, MAX(OmDt) OmDt, MAX(OmExpDelDt) OmExpDelDt,
                              MAX(OmTc) OmTc, MAX(OmYy) OmYy, MAX(OmChr) OmChr, MAX(OmNo) OmNo,
                              MAX(CmName) CmName,
                              SUM(OdOrdQty) as order_qty,
                              SUM((OdPrdQty - OdExpQty)) as bal_qty") )
            // ->groupBy(DB::raw("CONCAT(OmCoCd, '/', OmCmCd, '/', OmDt,  '/', OmExpDelDt, '/', OdTc, '/', OdYy, '/', OdChr, '/', OdNo)"))
            ->groupBy("OdOmIdNo")
            ->whereRaw(" (OdPrdQty - OdExpQty) > 0 ")
            ->leftJoin("OrdMst", "OrdMst.OmIdNo", "OrdDsg.OdOmIdNo")
            ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd")
            ->orderBy("OdOmIdNo", "ASC");

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
        // $query->orderBy("OmExpDelDt", "DESC");
    }
    elseif(!empty($request->order_start_date) ) {
      // $query->orderBy("OmDt", "ASC");
    }
    else {
      // $query->orderBy("OmDt", "DESC");
    }

    if(!empty($request->customer_code)){
        $query->where('OrdMst.OmCmCd', $request->customer_code);
    }
    if(!empty($request->customer_name)){
        $query->where('CustMst.CmName', $request->customer_name);
    }
    if(!empty($request->company_code)){
        $query->where('OmCoCd',  "like", "$request->company_code");
    }
    if(!empty($request->company_code)){
        $query->where('OmCoCd',  "like", "$request->company_code");
    }
    if(!empty($request->year)){
        $query->where('OmYy',  "like", "$request->year");
    }
    if(!empty($request->order_type)){
        $query->where('OmChr',   "$request->order_type");
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
    return view('admin.emporer.report.what_is_where', $data );
  }


  public function whatIsWhereOrderData(Request $request){

    $this->check_db($request);

    $fg_bag_raw_material_list = DB::connection($this->emrDB)
            ->table("OrdDsg")
            ->select(DB::raw("OrdDsg.OdDmCd, MAX(DsgMst.DmDesc) DmDesc, Bag.BLoc , SUM(Bag.BQty) bag_qty") )
            ->leftJoin("Bag", "Bag.BOdIdNo", "OrdDsg.OdIdNo")
            ->leftJoin("DsgMst", "DsgMst.DmCd", "OrdDsg.OdDmCd")
            ->where("OrdDsg.OdOmIdNo", $request->OmIdNo)
            ->whereRaw(" Bag.BQty > 0 AND Bag.BIdNo not in ( SELECT IfBIdNo  FROM InvFgd )")
            ->groupBy("OrdDsg.OdDmCd", "Bag.BLoc")
            ->get();

    $html_data = ""; $count=1;
    foreach ($fg_bag_raw_material_list as $key => $data) {
      $html_data .= "<tr style='text-align: center;'>
                      <td>".$count++."</td>
                      <td><a href=\"/emporer/design/designDetails?design_code=$data->OdDmCd\"  style=\"color: green;\">$data->OdDmCd</td>
                      <td>$data->DmDesc</td>
                      <td>$data->BLoc</td>
                      <td>". round($data->bag_qty, 4) ."</td>
                    </tr>";
    }


    return json_encode(["msg"=>"Finish Good Raw Material Data", "status"=>true, "data"=>$fg_bag_raw_material_list , "html_data" => $html_data ]);

  }




}
