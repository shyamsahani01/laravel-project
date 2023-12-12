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
      $this->emrDB = "EmrSitapura";
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
            // ->where("Bag.BYy", $request->BYy)
            // ->where("Bag.BChr", $request->BChr)
            // ->where("Bag.BNo", $request->BNo)
            ->where("Bag.BIdNo", $request->BIdNo)
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
            // ->where("OrdMst.OmTc", $bag_details->BOdTc)
            // ->where("OrdMst.OmYy", $bag_details->BOdYy)
            // ->where("OrdMst.OmChr", $bag_details->BOdChr)
            // ->where("OrdMst.OmNo", $bag_details->BOdNo)
            // ->where("OrdMst.OmCoCd", $bag_details->BCoCd)
            ->where("OrdMst.OmIdNo", $bag_details->BOmIdNo)
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
            // ->where("OrdDsg.OdIdNo", $bag_details->BOdIdNo)
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

    $bag_transaction_details = DB::connection($this->emrDB)
                                  ->table("Txnd")
                                  ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no, CONCAT(TdTc, '/', TdYy, '/', TdChr, '/', TdNo) voucher_no") )
                                  // ->where("TdBYy", $request->BYy)
                                  // ->where("TdBChr", $request->BChr)
                                  // ->where("TdBNo", $request->BNo)
                                  // ->where("Txnd.TdCoCd", $request->company_code)
                                  ->where("Txnd.TdBIdNo", $request->BIdNo)
                                  ->orderBy("TdIdNo", "ASC")
                                  ->get();

    $fg_bag_list = DB::connection($this->emrDB)
            ->table("Fgd")
            ->select(DB::raw("Fgd.*, CONCAT(FdTc, '/', FdYy, '/', FdChr, '/', FdNo) voucher_no, Fg.FgFrBLoc, Fg.FgToBLoc") )
            ->leftJoin("Fg", "Fgd.FdFgIdNo", "=", "Fg.FgIdNo")
            // ->where("Fgd.FdBYy", $request->BYy)
            // ->where("Fgd.FdBChr", $request->BChr)
            // ->where("Fgd.FdBNo", $request->BNo)
            // ->where("Fgd.FdCoCd", $request->company_code)
            ->where("Fgd.FdBIdNo", $request->BIdNo)
            ->orderBy("FdSr", "ASC")
            ->get();

    // $fg_bag_list = DB::connection($this->emrDB)
    //         ->table("Fgd")
    //         ->select(DB::raw("Fgd.*, CONCAT(FdTc, '/', FdYy, '/', FdChr, '/', FdNo) voucher_no, Fg.FgFrBLoc, Fg.FgToBLoc") )
    //         ->leftJoin("Fg", "Fgd.FdFgIdNo", "=", "Fg.FgIdNo")
    //         // ->where("Fgd.FdBYy", $request->BYy)
    //         // ->where("Fgd.FdBChr", $request->BChr)
    //         // ->where("Fgd.FdBNo", $request->BNo)
    //         // ->where("Fgd.FdCoCd", $request->company_code)
    //         ->where("Fgd.FdBIdNo", $request->BIdNo)
    //         ->orderBy("FdSr", "ASC")
    //         ->get();

    $fg_bm_bag_list = DB::connection($this->emrDB)
            ->table("Fmd")
            ->select(DB::raw("Fmd.*, CONCAT(FmdTc, '/', FmdYy, '/', FmdChr, '/', FmdNo) voucher_no") )
            // ->where("Fmd.FmdBYy", $request->BYy)
            // ->where("Fmd.FmdBChr", $request->BChr)
            // ->where("Fmd.FmdBNo", $request->BNo)
            // ->where("Fmd.FmdCoCd", $request->company_code)
            ->where("Fmd.FmdBYy", $bag_details->BYy)
            ->where("Fmd.FmdBChr", $bag_details->BChr)
            ->where("Fmd.FmdBNo", $bag_details->BNo)
            ->where("Fmd.FmdCoCd", $bag_details->BCoCd)
            // ->where("Fmd.FmdBIdNo", $request->BIdNo)
            ->orderBy("FmdSr", "ASC")
            ->get();



      $data['title'] = $title;
      $data['bag_details'] = $bag_details;
      $data['bag_orders_details'] = $bag_orders_details;
      $data['bag_orders_design_details'] = $bag_orders_design_details;
      $data['bag_orders_bom_details'] = $bag_orders_bom_details;
      $data['bag_transaction_details'] = $bag_transaction_details;
      $data['fg_bag_list'] = $fg_bag_list;
      $data['fg_bm_bag_list'] = $fg_bm_bag_list;

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
        $query->where('TFrBLoc', "like", "%".$request->from_location."%");
    }
    if(!empty($request->to_location)){
        $query->where('TLsLoc', "like", "%".$request->to_location."%");
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
                // ->where("Txn.TTc", $request->TTc)
                // ->where("Txn.TYy", $request->TYy)
                // ->where("Txn.TChr", $request->TChr)
                // ->where("Txn.TNo", $request->TNo)
                // ->where("Txn.TCoCd", $request->company_code)
                ->where("Txn.TIdNo", $request->TIdNo)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no,
                                    (SELECT TOP 1 vPDesc FROM vParam WHERE Txnd.TdWrk = vParam.vPMCd
                                              AND vParam.vPTyp = 'WORK' AND Txnd.TdCoCd = vParam.vPCoCd) worker_name ") )
                // ->where("Txnd.TdTc", $request->TTc)
                // ->where("Txnd.TdYy", $request->TYy)
                // ->where("Txnd.TdChr", $request->TChr)
                // ->where("Txnd.TdNo", $request->TNo)
                // ->where("Txnd.TdCoCd", $request->company_code)
                ->where("Txnd.TdTIdNo", $request->TIdNo)
                // ->leftJoin('contacts', function ($join) {
                //     $join->on('users.id', '=', 'contacts.user_id')
                //          ->where('contacts.user_id', '>', 5);
                // })
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
                // ->where("Txn.TTc", $request->TTc)
                // ->where("Txn.TYy", $request->TYy)
                // ->where("Txn.TChr", $request->TChr)
                // ->where("Txn.TNo", $request->TNo)
                // ->where("Txn.TCoCd", $request->company_code)
                ->where("Txn.TIdNo", $request->TIdNo)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no,
                                    (SELECT TOP 1 vPDesc FROM vParam WHERE Txnd.TdWrk = vParam.vPMCd
                                              AND vParam.vPTyp = 'WORK' AND Txnd.TdCoCd = vParam.vPCoCd) worker_name ") )
                // ->where("Txnd.TdTc", $request->TTc)
                // ->where("Txnd.TdYy", $request->TYy)
                // ->where("Txnd.TdChr", $request->TChr)
                // ->where("Txnd.TdNo", $request->TNo)
                // ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->where("Txnd.TdTIdNo", $request->TIdNo)
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
                // ->where("Txn.TTc", $request->TTc)
                // ->where("Txn.TYy", $request->TYy)
                // ->where("Txn.TChr", $request->TChr)
                // ->where("Txn.TNo", $request->TNo)
                // ->where("Txn.TCoCd", $request->company_code)
                ->where("Txn.TIdNo", $request->TIdNo)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no,
                                    (SELECT TOP 1 vPDesc FROM vParam WHERE Txnd.TdByWrk = vParam.vPMCd
                                              AND vParam.vPTyp = 'WORK' AND Txnd.TdCoCd = vParam.vPCoCd) worker_name ") )
                // ->where("Txnd.TdTc", $request->TTc)
                // ->where("Txnd.TdYy", $request->TYy)
                // ->where("Txnd.TdChr", $request->TChr)
                // ->where("Txnd.TdNo", $request->TNo)
                // ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->where("Txnd.TdTIdNo", $request->TIdNo)
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
                // ->where("Txn.TTc", $request->TTc)
                // ->where("Txn.TYy", $request->TYy)
                // ->where("Txn.TChr", $request->TChr)
                // ->where("Txn.TNo", $request->TNo)
                // ->where("Txn.TCoCd", $request->company_code)
                ->where("Txn.TIdNo", $request->TIdNo)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no,
                                    (SELECT TOP 1 vPDesc FROM vParam WHERE Txnd.TdWrk = vParam.vPMCd
                                              AND vParam.vPTyp = 'WORK' AND Txnd.TdCoCd = vParam.vPCoCd) worker_name ") )
                // ->where("Txnd.TdTc", $request->TTc)
                // ->where("Txnd.TdYy", $request->TYy)
                // ->where("Txnd.TdChr", $request->TChr)
                // ->where("Txnd.TdNo", $request->TNo)
                // ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->where("Txnd.TdTIdNo", $request->TIdNo)
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
                // ->where("Txn.TTc", $request->TTc)
                // ->where("Txn.TYy", $request->TYy)
                // ->where("Txn.TChr", $request->TChr)
                // ->where("Txn.TNo", $request->TNo)
                // ->where("Txn.TCoCd", $request->company_code)
                ->where("Txn.TIdNo", $request->TIdNo)
                ->first();

        $transaction_bag_list = DB::connection($this->emrDB)
                ->table("Txnd")
                ->select(DB::raw("Txnd.*, CONCAT(TdBYy, '/', TdBChr, '/', TdBNo) bag_no ,
                                    (SELECT TOP 1 vPDesc FROM vParam WHERE Txnd.TdWrk = vParam.vPMCd
                                              AND vParam.vPTyp = 'WORK' AND Txnd.TdCoCd = vParam.vPCoCd) worker_name ") )
                // ->where("Txnd.TdTc", $request->TTc)
                // ->where("Txnd.TdYy", $request->TYy)
                // ->where("Txnd.TdChr", $request->TChr)
                // ->where("Txnd.TdNo", $request->TNo)
                // ->where("Txnd.TdCoCd", $request->company_code)
                // ->orderBy("TdSrNo", "ASC")
                ->where("Txnd.TdTIdNo", $request->TIdNo)
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
