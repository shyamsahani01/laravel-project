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

class InvoiceController extends Controller
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

      // phpinfo();
      // die;

    $this->check_db($request);

    $title = "Emporer Invoice - $this->emrDBName ";


    $query = DB::connection($this->emrDB)
            ->table("InvHd")
            ->select(DB::raw("InvHd.*, CONCAT(InTc, '/', InYy, '/', InChr, '/', InNo) invoice_no, CustMst.CmName") )
            ->leftJoin("CustMst", "CustMst.CmCd", "InvHd.InCmCd");

    if(!empty($request->start_date)){
        $query->whereDate('InDt', ">=", $request->start_date)
              ->orderBy("InDt", "ASC");
              // ->orderBy("invoice_no", "ASC");
    }
    else {
      // $query->orderBy("InDt", "DESC");
      // $query->orderBy("InYy", "DESC");
      // $query->orderBy("InNo", "DESC");
      $query->orderBy("InIdNo", "DESC");
      // $query->orderBy("invoice_no", "DESC");
    }

    if(!empty($request->end_date)){
        $query->whereDate('InDt', "<=", $request->end_date);
    }

    if(!empty($request->company)){
        $query->where('InCoCd',  $request->company);
    }

    if(!empty($request->customer_code)){
        $query->where('InvHd.InCmCd', $request->customer_code);
    }
    if(!empty($request->customer_name)){
        $query->where('CustMst.CmName', $request->customer_name);
    }
    if(!empty($request->invoice_no)){
        $query->whereRaw("CONCAT(InTc, '/', InYy, '/', InChr, '/', InNo) like '%$request->invoice_no%'");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $invoice_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['invoice_data'] = $invoice_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.invoice.list', $data );
  }


  public function invoiceDetails(Request $request){

    $this->check_db($request);

    // $title = 'Emporer Orders Details ';
    $title = "Emporer Invoice Details - $this->emrDBName ";


    $invoice_details = DB::connection($this->emrDB)
            ->table("InvHd")
            ->select(DB::raw("InvHd.*, CONCAT(InTc, '/', InYy, '/', InChr, '/', InNo) invoice_no, CustMst.CmName") )
            ->leftJoin("CustMst", "CustMst.CmCd", "InvHd.InCmCd")
            ->where("InvHd.InIdNo", $request->InIdNo)
            ->first();


    $invoice_design_details = DB::connection($this->emrDB)
            ->table("InvDsg")
            // ->select("InvDsg.*", "OrdDsg.*", "OrdMst.*")
            ->select(DB::raw("InvDsg.*, OrdDsg.*, OrdMst.*, DsgMst.*") )
            ->leftJoin("DsgMst", "DsgMst.DmCd", "InvDsg.IdDmCd")
            ->leftJoin("OrdDsg", "OrdDsg.OdIdNo", "InvDsg.IdOdIdNo")
            ->leftJoin("OrdMst", "OrdMst.OmIdNo", "OrdDsg.OdOmIdNo")
            ->where("IdInIdNo", $request->InIdNo)
            ->orderBy("IdSr", "ASC")
            ->get();

    foreach ($invoice_design_details as $key => $value) {
      $invoice_design_details[$key]->bag_details = DB::connection($this->emrDB)
              ->table("Bag")
              ->select(DB::raw(" Bag.*, InvFgd.*") )
              // ->select(DB::raw(" CONCAT(BOdNo, ',') bag_no, SUM(BGrWt) sum_gross") )
              ->join("InvFgd", "InvFgd.IfBIdNo", "Bag.BIdNo")
              ->where("Bag.BOdIdNo", $value->OdIdNo)
              ->orderBy("BOdSr", "ASC")
              ->get();

      // $invoice_design_details[$key]->bag_details = DB::connection($this->emrDB)
      //         ->table("Bag")
      //         ->select(DB::raw("Bag.BNo, MAX(BGrWt) BGrWt") )
      //         ->join("Fgd", "Fgd.FdBIdNo", "Bag.BIdNo")
      //         ->where("Bag.BOdIdNo", $value->OdIdNo)
      //         ->groupBy("Bag.BNo")
      //         // ->orderBy("BOdSr", "ASC")
      //         ->get();


    $invoice_design_details[$key]->invoice_design_rm_details = DB::connection($this->emrDB)
            ->table("InvRm")
            ->select(DB::raw("InvRm.*") )
            ->where("InvRm.IrIdIdNo", $value->IdIdNo)
            ->orderBy("IrSrNo", "ASC")
            ->get();

    // $bag_fg_sum_details = DB::connection($this->emrDB)
    //         ->table("FgRm")
    //         ->select(DB::raw(" FgRm.FrRmCtg, SUM(FrRmWt) gross_wt") )
    //         ->join("Fgd", "FgRm.FrFdIdNo", "Fgd.FdIdNo")
    //         ->join("Bag", "Fgd.FdBIdNo", "Bag.BIdNo")
    //         ->Where("Fgd.FdChr", "FG")
    //         ->where("Bag.BOdIdNo", $value->OdIdNo)
    //         ->groupBy("FrRmCtg")
    //         ->get();

    // $bag_fg_rm_details = DB::connection($this->emrDB)
    //         ->table("FgRm")
    //         ->select(DB::raw(" MAX(FgRm.FrRmCtg) FrRmCtg, FgRm.FrRmCd, SUM(FrRmQty) qty, SUM(FrRmWt) gross_wt, MAX(RmMst.RmDesc) RmDesc") )
    //         ->join("RmMst", "FgRm.FrRmCd", "RmMst.RmCd")
    //         ->join("Fgd", "FgRm.FrFdIdNo", "Fgd.FdIdNo")
    //         ->join("Bag", "Fgd.FdBIdNo", "Bag.BIdNo")
    //         ->where("Bag.BOdIdNo", $value->OdIdNo)
    //         ->groupBy("FrRmCd")
    //         ->get();

    $bag_fg_rm_details = DB::connection($this->emrDB)
            ->table("InvRm")
            // ->select(DB::raw(" MAX(InvRm.IrRmCtg) IrRmCtg, MAX(InvRm.IrRmSCtg) IrRmSCtg, MAX(InvRm.IrRmSz) IrRmSz, InvRm.IrRmCd, SUM(IrRmQty) qty, SUM(IrRmIWt) gross_wt, MAX(RmMst.RmDesc) RmDesc") )
            ->select(DB::raw("InvRm.IrRmCtg, InvRm.IrRmSCtg, InvRm.IrRmSz, InvRm.IrRmCd, IrRmQty qty, IrRmIWt gross_wt, RmMst.RmDesc") )
            ->join("RmMst", "InvRm.IrRmCd", "RmMst.RmCd")
            // ->join("InvFgd", "InvRm.IrIdIdNo", "InvFgd.IfIdNo")
            // ->join("Bag", "InvFgd.IfBIdNo", "Bag.BIdNo")
            ->where("InvRm.IrIdIdNo", $value->IdIdNo)
            // ->groupBy("IrRmCd")
            ->get();

    $invoice_design_details[$key]->sum_gross_wt = 0;
    $invoice_design_details[$key]->gold_wt = 0;
    $invoice_design_details[$key]->silver_wt = 0;
    $invoice_design_details[$key]->other_wt = 0;

      $c = 1; $d = 1; $m = 3; $g_n = 1; $s_n = 1;
    $rm_data = [];
    foreach ($bag_fg_rm_details as $k2 => $v2) {
      if($v2->IrRmCtg == "C" || $v2->IrRmCtg == "D") {
        $invoice_design_details[$key]->sum_gross_wt += $v2->gross_wt/5;
      }
      else {
        $invoice_design_details[$key]->sum_gross_wt += $v2->gross_wt;
      }

      
      if($v2->IrRmCtg == "C") {
        $rm_data["colostone_$c"]['name'] = $v2->RmDesc;
        $rm_data["colostone_$c"]['code'] = $v2->IrRmCd;
        $rm_data["colostone_$c"]['qty'] = $v2->qty;
        $rm_data["colostone_$c"]['gross_wt'] = $v2->gross_wt;
        $c++; }
      elseif($v2->IrRmCtg == "D") {
        $rm_data["diamond_$d"]['name'] = $v2->RmDesc;
        $rm_data["diamond_$d"]['code'] = $v2->IrRmCd;

        $rm_data["diamond_$d"]['size'] = $v2->IrRmSCtg . " " . ($v2->IrRmSz > 0 ? round($v2->IrRmSz, 4) : '');
        $rm_data["diamond_$d"]['qty'] = $v2->qty;
        $rm_data["diamond_$d"]['gross_wt'] = $v2->gross_wt;
        $d++; }
      else {

         if($v2->IrRmCtg == "G") {
           $invoice_design_details[$key]->gold_wt += $v2->gross_wt;

            if($g_n > 1 )  { $rm_data["metal_1"]['name'] .= " \ " . $v2->RmDesc; $g_n++; }
            else { $rm_data["metal_1"]['name'] = $v2->RmDesc; $g_n++; }
          }
         if($v2->IrRmCtg == "S") {
           $invoice_design_details[$key]->silver_wt += $v2->gross_wt;

           if($s_n > 1 )  { $rm_data["metal_2"]['name'] .= " \ " . $v2->RmDesc; $s_n++; }
           else { $rm_data["metal_2"]['name'] = $v2->RmDesc; $s_n++; }
         }
         if($v2->IrRmCtg == "M") {
           $rm_data["metal_$m"]['name'] = $v2->RmDesc; $m++;
           $invoice_design_details[$key]->other_wt += $v2->gross_wt; }
       }
    }
    $invoice_design_details[$key]->rm_data = $rm_data;

    //

    // foreach ($bag_fg_sum_details as $k3 => $v3) {
    //   if($v3->FrRmCtg == "G") { $invoice_design_details[$key]->gold_wt = $v3->gross_wt; }
    //   if($v3->FrRmCtg == "S") { $invoice_design_details[$key]->silver_wt = $v3->gross_wt; }
    //   if($v3->FrRmCtg == "M") { $invoice_design_details[$key]->other_wt = $v3->gross_wt; }
    // }

    }

    // $orders_bag_details = DB::connection($this->emrDB)
    //         ->table("Bag")
    //         ->select(DB::raw("Bag.*, CONCAT(BYy, '/', BChr, '/', BNo) bag_no, DsgMst.DmCd, DsgMst.DmCtg, DsgMst.DmTcTyp ") )
    //         // ->where("BOdTc", $orders_details->OmTc)
    //         // ->where("BOdYy", $orders_details->OmYy)
    //         // ->where("BOdChr", $orders_details->OmChr)
    //         // ->where("BOdNo", $orders_details->OmNo)
    //         // ->where("BCoCd", $orders_details->OmCoCd)
    //         ->where("BOmIdNo", $request->OmIdNo)
    //         ->leftJoin("DsgMst", "DsgMst.DmCd" ,"Bag.BOdDmCd")
    //         ->orderBy("BOdSr", "ASC")
    //         ->get();

    // $orders_details = $query->first();

    $data['title'] = $title;
    $data['invoice_details'] = $invoice_details;
    $data['invoice_design_details'] = $invoice_design_details;
    // $data['orders_bag_details'] = $orders_bag_details;

    // echo "<pre>";
    // print_r(  $data);
    // die;


    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.invoice.view', $data );
  }







}
