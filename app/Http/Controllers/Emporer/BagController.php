<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class BagController extends Controller
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
    $title = "Emporer Bag - $this->emrDBName";

    $query = DB::connection($this->emrDB)
            ->table("Bag")
            // ->select("Bag.*")
            ->select(DB::raw("Bag.*, CONCAT(BOdTc, '/', BOdYy, '/', BOdChr, '/', BOdNo) order_no, CONCAT(BYy, '/', BChr, '/', BNo) bag_no") );

    if(!empty($request->bag_open_start_date)){
        $query->whereDate('BOpnDt', ">=", $request->bag_open_start_date)
              ->orderBy("BOpnDt", "ASC");
    }
    else {
      $query->orderBy("BOpnDt", "DESC");
    }

    if(!empty($request->bag_open_end_date)){
        $query->whereDate('BOpnDt', "<=", $request->bag_open_end_date);
    }

    if(!empty($request->design_code)){
        $query->where('BOdDmCd', "like", "%".$request->design_code."%");
    }
    if(!empty($request->order_no)){
        $query->whereRaw("CONCAT(BOdTc, '/', BOdYy, '/', BOdChr, '/', BOdNo) like '%$request->order_no%'");
    }
    if(!empty($request->bag_no)){
        $query->whereRaw("CONCAT(BYy, '/', BChr, '/', BNo) like '%$request->bag_no%'");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $bag_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['bag_data'] = $bag_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.bag.list', $data );
  }

  public function bagDetails(Request $request){

    $this->check_db($request);
    $title = "Emporer Bag Details - $this->emrDBName";

    $bag_details = DB::connection($this->emrDB)
            ->table("Bag")
            ->select(DB::raw("Bag.*, CONCAT(BOdTc, '/', BOdYy, '/', BOdChr, '/', BOdNo) order_no, CONCAT(BYy, '/', BChr, '/', BNo) bag_no,
                              DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp") )
            // ->whereRaw("CONCAT(BYy, '/', BChr, '/', BNo) = '$request->bag_no'")
            ->where("Bag.BYy", $request->BYy)
            ->where("Bag.BChr", $request->BChr)
            ->where("Bag.BNo", $request->BNo)
            ->leftJoin("DsgMst", "DsgMst.DmCd" ,"Bag.BOdDmCd")
            // ->leftJoin('OrdMst', function ($join) {
            //     $join->on('OrdMst.OmTc', 'Bag.BOdTc')
            //          ->where('OrdMst.OmYy', 'Bag.BOdYy')
            //          ->where('OrdMst.OmChr', 'Bag.BOdChr')
            //          ->where('OrdMst.OmNo', "=", 'Bag.BOdNo');
            // })
            // ->leftJoin('OrdDsg', function ($join) {
            //     $join->on('OrdDsg.OdTc', 'Bag.BOdTc')
            //          ->where('OrdDsg.OdYy', 'Bag.BOdYy')
            //          ->where('OrdDsg.OdChr', 'Bag.BOdChr')
            //          ->where('OrdDsg.OdNo', 'Bag.BOdNo')
            //          ->where('OrdDsg.OdSr', 'Bag.BOdSr');
            // })
            // ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd")
            ->first();

    $bag_orders_details = DB::connection($this->emrDB)
            ->table("OrdMst")
            ->select(DB::raw("OrdMst.*, CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) order_no, CustMst.CmName") )
            ->leftJoin("CustMst", "CustMst.CmCd", "OrdMst.OmCmCd")
            ->where("OrdMst.OmTc", $bag_details->BOdTc)
            ->where("OrdMst.OmYy", $bag_details->BOdYy)
            ->where("OrdMst.OmChr", $bag_details->BOdChr)
            ->where("OrdMst.OmNo", $bag_details->BOdNo)
            ->where("OrdMst.OmCoCd", $bag_details->BCoCd)
            // ->whereRaw("CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) =  '$bag_details->order_no'")
            ->first();

    $bag_orders_design_details = DB::connection($this->emrDB)
            ->table("OrdDsg")
            ->select("OrdDsg.*")
            // ->whereRaw("CONCAT(OdTc, '/', OdYy, '/', OdChr, '/', OdNo) =  '$bag_details->order_no'")
            ->where("OrdDsg.OdTc", $bag_details->BOdTc)
            ->where("OrdDsg.OdYy", $bag_details->BOdYy)
            ->where("OrdDsg.OdChr", $bag_details->BOdChr)
            ->where("OrdDsg.OdNo", $bag_details->BOdNo)
            ->where("OrdDsg.OdSr", $bag_details->BOdSr)
            ->where("OrdDsg.OdCoCd", $bag_details->BCoCd)
            ->first();

    $bag_orders_bom_details = DB::connection($this->emrDB)
            ->table("OrdRm")
            ->select("OrdRm.*", "RmMst.RmDesc")
            ->leftJoin("RmMst", "RmMst.RmCd", "OrdRm.OrRmCd")
            ->where("OrdRm.OrTc", $bag_details->BOdTc)
            ->where("OrdRm.OrYy", $bag_details->BOdYy)
            ->where("OrdRm.OrChr", $bag_details->BOdChr)
            ->where("OrdRm.OrNo", $bag_details->BOdNo)
            ->where("OrdRm.OrSr", $bag_details->BOdSr)
            ->where("OrdRm.OrCoCd", $bag_details->BCoCd)
            ->orderBy("OrSrNo", "ASC")
            ->get();

    // $design_bom_details = DB::connection($this->emrDB)
    //         ->table("DsgRm")
    //         ->select("DsgRm.*", "RmMst.RmDesc")
    //         ->where("DrCd", $request->design_code)
    //         ->leftJoin("RmMst", "RmMst.RmCd", "DsgRm.DrRmCd")
    //         ->orderBy("DrSr", "ASC")
    //         ->get();
    //
    // $design_lab_details = DB::connection($this->emrDB)
    //         ->table("DsgLab")
    //         ->select("DsgLab.*")
    //         ->where("DlDmIdNo", $design_details->DmIdNo)
    //         ->orderBy("DlSr", "ASC")
    //         ->get();
    //
    // $design_analysis_details = DB::connection($this->emrDB)
    //         ->table("DsgAna")
    //         ->select(DB::Raw("DsgAna.*,
    //                         (SELECT TOP 1 PDesc FROM Param WHERE PSCd = DsgAna.DaAnaCd ) AS description ") )
    //         ->where("DaDmIdNo", $design_details->DmIdNo)
    //         ->orderBy("DaAnaSr", "ASC")
    //         ->get();


      $data['title'] = $title;
      $data['bag_details'] = $bag_details;
      $data['bag_orders_details'] = $bag_orders_details;
      $data['bag_orders_design_details'] = $bag_orders_design_details;
      $data['bag_orders_bom_details'] = $bag_orders_bom_details;
      // $data['design_bom_details'] = $design_bom_details;
      // $data['design_lab_details'] = $design_lab_details;
      // $data['design_analysis_details'] = $design_analysis_details;

      // Helper::LoginIpandTime($request->getClientIp());
      return view('admin.emporer.bag.view', $data );
  }



  public function transactionList(Request $request){

    $this->check_db($request);
    $title = "Emporer Transaction - $this->emrDBName";

    $query = DB::connection($this->emrDB)
            ->table("Txn")
            // ->select("Bag.*")
            ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no,
                            (SELECT PDesc FROM Param WHERE PTyp = 'TC' and Param.PMCd = Txn.TTc) type") );
            // ->leftJoin("Param", "Param.RmCd", "OrdRm.OrRmCd");

    if(!empty($request->transaction_start_date)){
        $query->whereDate('TDt', ">=", $request->transaction_start_date)
              ->orderBy("TDt", "ASC");
    }
    else {
      $query->orderBy("TDt", "DESC");
    }

    if(!empty($request->transaction_end_date)){
        $query->whereDate('TDt', "<=", $request->transaction_end_date);
    }

    if(!empty($request->from_location)){
        $query->where('TFrBLoc', "like", "%".$request->design_code."%");
    }
    if(!empty($request->to_location)){
        $query->where('TLsLoc', "like", "%".$request->design_code."%");
    }
    if(!empty($request->transaction_type)){
        $query->where('TTc', "like", "%".$request->transaction_type."%");
    }
    if(!empty($request->voucher_no)){
        $query->whereRaw("CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) like '%$request->voucher_no%'");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $bag_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['bag_transaction_data'] = $bag_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.transaction.list', $data );
  }




    public function transactionDetails(Request $request){

      $this->check_db($request);
      $title = "Emporer Transaction Details - $this->emrDBName";

      if($request->TTc == "DT") {
        $title = "Emporer Daily Transaction Details - $this->emrDBName";
        $bag_transaction_details = DB::connection($this->emrDB)
                ->table("Txn")
                ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
                ->where("Txn.TTc", $request->TTc)
                ->where("Txn.TYy", $request->TYy)
                ->where("Txn.TChr", $request->TChr)
                ->where("Txn.TNo", $request->TNo)
                ->where("Txn.TCoCd", $request->company_code)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
                ->where("Txnd.TdTc", $request->TTc)
                ->where("Txnd.TdYy", $request->TYy)
                ->where("Txnd.TdChr", $request->TChr)
                ->where("Txnd.TdNo", $request->TNo)
                ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->orderBy("TdSr", "ASC")
                ->orderBy("TdSrNo", "ASC")
                ->get();

          $data['title'] = $title;
          $data['bag_transaction_details'] = $bag_transaction_details;
          $data['transaction_bag_list'] = $transaction_bag_list;
          return view('admin.emporer.transaction.dt_view', $data );
      }
      elseif($request->TTc == "BS") {
        $title = "Emporer Bag Split Details - $this->emrDBName";
        $bag_transaction_details = DB::connection($this->emrDB)
                ->table("Txn")
                ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
                ->where("Txn.TTc", $request->TTc)
                ->where("Txn.TYy", $request->TYy)
                ->where("Txn.TChr", $request->TChr)
                ->where("Txn.TNo", $request->TNo)
                ->where("Txn.TCoCd", $request->company_code)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
                ->where("Txnd.TdTc", $request->TTc)
                ->where("Txnd.TdYy", $request->TYy)
                ->where("Txnd.TdChr", $request->TChr)
                ->where("Txnd.TdNo", $request->TNo)
                ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->orderBy("TdSr", "ASC")
                ->orderBy("TdSrNo", "ASC")
                ->get();

          $data['title'] = $title;
          $data['bag_transaction_details'] = $bag_transaction_details;
          $data['transaction_bag_list'] = $transaction_bag_list;
          return view('admin.emporer.transaction.bs_view', $data );
      }
      elseif($request->TTc == "REJ") {
        $title = "Emporer Bag Rejection Details - $this->emrDBName";
        $bag_transaction_details = DB::connection($this->emrDB)
                ->table("Txn")
                ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
                ->where("Txn.TTc", $request->TTc)
                ->where("Txn.TYy", $request->TYy)
                ->where("Txn.TChr", $request->TChr)
                ->where("Txn.TNo", $request->TNo)
                ->where("Txn.TCoCd", $request->company_code)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
                ->where("Txnd.TdTc", $request->TTc)
                ->where("Txnd.TdYy", $request->TYy)
                ->where("Txnd.TdChr", $request->TChr)
                ->where("Txnd.TdNo", $request->TNo)
                ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->orderBy("TdSr", "ASC")
                ->orderBy("TdSrNo", "ASC")
                ->get();

          $data['title'] = $title;
          $data['bag_transaction_details'] = $bag_transaction_details;
          $data['transaction_bag_list'] = $transaction_bag_list;
          return view('admin.emporer.transaction.rej_view', $data );
      }
      elseif($request->TTc == "MLT") {
        $title = "Emporer Bag Melting Details - $this->emrDBName";
        $bag_transaction_details = DB::connection($this->emrDB)
                ->table("Txn")
                ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
                ->where("Txn.TTc", $request->TTc)
                ->where("Txn.TYy", $request->TYy)
                ->where("Txn.TChr", $request->TChr)
                ->where("Txn.TNo", $request->TNo)
                ->where("Txn.TCoCd", $request->company_code)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
                ->where("Txnd.TdTc", $request->TTc)
                ->where("Txnd.TdYy", $request->TYy)
                ->where("Txnd.TdChr", $request->TChr)
                ->where("Txnd.TdNo", $request->TNo)
                ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->orderBy("TdSr", "ASC")
                ->orderBy("TdSrNo", "ASC")
                ->get();

          $data['title'] = $title;
          $data['bag_transaction_details'] = $bag_transaction_details;
          $data['transaction_bag_list'] = $transaction_bag_list;
          return view('admin.emporer.transaction.mlt_view', $data );
      }
      else {
        $bag_transaction_details = DB::connection($this->emrDB)
                ->table("Txn")
                ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
                ->where("Txn.TTc", $request->TTc)
                ->where("Txn.TYy", $request->TYy)
                ->where("Txn.TChr", $request->TChr)
                ->where("Txn.TNo", $request->TNo)
                ->where("Txn.TCoCd", $request->company_code)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
                ->where("Txnd.TdTc", $request->TTc)
                ->where("Txnd.TdYy", $request->TYy)
                ->where("Txnd.TdChr", $request->TChr)
                ->where("Txnd.TdNo", $request->TNo)
                ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->orderBy("TdSr", "ASC")
                ->orderBy("TdSrNo", "ASC")
                ->get();

          $data['title'] = $title;
          $data['bag_transaction_details'] = $bag_transaction_details;
          $data['transaction_bag_list'] = $transaction_bag_list;
          return view('admin.emporer.transaction.view', $data );
      }

      // $title = "Emporer  Transaction Details - $this->emrDBName";
      // $bag_transaction_details = DB::connection($this->emrDB)
      //         ->table("Txn")
      //         ->select(DB::raw("Txn.*, CONCAT(TTc, '/', TYy, '/', TChr, '/', TNo) voucher_no ") )
      //         ->where("Txn.TTc", $request->TTc)
      //         ->where("Txn.TYy", $request->TYy)
      //         ->where("Txn.TChr", $request->TChr)
      //         ->where("Txn.TNo", $request->TNo)
      //         ->where("Txn.TCoCd", $request->company_code)
      //         ->first();
      //
      // $transaction_bag_list = DB::connection($this->emrDB)
      //         ->table("Txnd")
      //         ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no") )
      //         ->where("Txnd.TdTc", $request->TTc)
      //         ->where("Txnd.TdYy", $request->TYy)
      //         ->where("Txnd.TdChr", $request->TChr)
      //         ->where("Txnd.TdNo", $request->TNo)
      //         ->where("Txnd.TdCoCd", $request->company_code)
      //         // ->orderBy("TdSrNo", "ASC")
      //         ->orderBy("TdSr", "ASC")
      //         ->orderBy("TdSrNo", "ASC")
      //         ->get();
      //
      //   $data['title'] = $title;
      //   $data['bag_transaction_details'] = $bag_transaction_details;
      //   $data['transaction_bag_list'] = $transaction_bag_list;


        // Helper::LoginIpandTime($request->getClientIp());
        return view('admin.emporer.transaction.view', $data );
    }





}
