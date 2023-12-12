<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class FinishGoodController extends Controller
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
    $title = "Emporer Finish Good - $this->emrDBName";

    $query = DB::connection($this->emrDB)
            ->table("Fg")
            ->select(DB::raw("Fg.*, CONCAT(FgTc, '/', FgYy, '/', FgChr, '/', FgNo) voucher_no,
                            (SELECT PDesc FROM Param WHERE PTyp = 'TC' and Param.PMCd = Fg.FgTc) type") );

    if(!empty($request->start_date)){
        $query->whereDate('FgDt', ">=", $request->start_date)
              ->orderBy("FgDt", "ASC");
    }
    else {
      $query->orderBy("FgDt", "DESC");
    }

    if(!empty($request->end_date)){
        $query->whereDate('FgDt', "<=", $request->end_date);
    }

    if(!empty($request->from_location)){
        $query->where('FgFrBLoc', "like", "%".$request->from_location."%");
    }
    if(!empty($request->to_location)){
        $query->where('FgToBLoc', "like", "%".$request->to_location."%");
    }
    if(!empty($request->transaction_type)){
        $query->where('FgTc', "like", "%".$request->transaction_type."%");
    }
    if(!empty($request->voucher_no)){
        $query->whereRaw("CONCAT(FgTc, '/', FgYy, '/', FgChr, '/', FgNo) like '%$request->voucher_no%'");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $finish_good_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['finish_good_data'] = $finish_good_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.fg.list', $data );
  }


  public function finishGoodDetails(Request $request){

    $this->check_db($request);
    $title = "Emporer Finish Good - $this->emrDBName";

    if($request->FgTc == "FB") {
      $title = "Emporer Finished Goods - Bag Details - $this->emrDBName";
      $fg_details = DB::connection($this->emrDB)
              ->table("Fg")
              ->select(DB::raw("Fg.*, CONCAT(FgTc, '/', FgYy, '/', FgChr, '/', FgNo) voucher_no ") )
              // ->where("Fg.FgTc", $request->FgTc)
              // ->where("Fg.FgYy", $request->FgYy)
              // ->where("Fg.FgChr", $request->FgChr)
              // ->where("Fg.FgNo", $request->FgNo)
              // ->where("Fg.FgCoCd", $request->company_code)
              ->where("Fg.FgIdNo", $request->FgIdNo)
              ->first();

      $fg_bag_list = DB::connection($this->emrDB)
              ->table("Fgd")
              ->select(DB::raw("Fgd.*, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no, CONCAT(FdPrdOdTc, '/', FdPrdOdYy, '/', FdPrdOdChr, '/', FdPrdOdNo) order_no") )
              // ->where("Fgd.FdTc", $request->FgTc)
              // ->where("Fgd.FdYy", $request->FgYy)
              // ->where("Fgd.FdChr", $request->FgChr)
              // ->where("Fgd.FdNo", $request->FgNo)
              // ->where("Fgd.FdCoCd", $request->company_code)
              ->where("Fgd.FdFgIdNo", $request->FgIdNo)
              ->orderBy("FdSr", "ASC")
              ->get();


      $fg_bag_raw_material_list = DB::connection($this->emrDB)
              ->table("FgRm")
              ->select(DB::raw("FgRm.*, FdBIdNo, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no") )
              ->join("Fgd", "Fgd.FdIdNo", "FgRm.FrFdIdNo")
              ->where("Fgd.FdFgIdNo", $request->FgIdNo)
              ->orderBy("FdBIdNo", "ASC")
              ->get();

        $data['title'] = $title;
        $data['fg_details'] = $fg_details;
        $data['fg_bag_list'] = $fg_bag_list;
        $data['fg_bag_raw_material_list'] = $fg_bag_raw_material_list;
        return view('admin.emporer.fg.fb_view', $data );
    }
    elseif($request->FgTc == "FWB") {
      $title = "Emporer FG - Bag Return Details - $this->emrDBName";
      $fg_details = DB::connection($this->emrDB)
              ->table("Fg")
              ->select(DB::raw("Fg.*, CONCAT(FgTc, '/', FgYy, '/', FgChr, '/', FgNo) voucher_no ") )
              // ->where("Fg.FgTc", $request->FgTc)
              // ->where("Fg.FgYy", $request->FgYy)
              // ->where("Fg.FgChr", $request->FgChr)
              // ->where("Fg.FgNo", $request->FgNo)
              // ->where("Fg.FgCoCd", $request->company_code)
              ->where("Fg.FgIdNo", $request->FgIdNo)
              ->first();

      $fg_bag_list = DB::connection($this->emrDB)
              ->table("Fgd")
              ->select(DB::raw("Fgd.*, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no, CONCAT(FdPrdOdTc, '/', FdPrdOdYy, '/', FdPrdOdChr, '/', FdPrdOdNo) order_no") )
              // ->where("Fgd.FdTc", $request->FgTc)
              // ->where("Fgd.FdYy", $request->FgYy)
              // ->where("Fgd.FdChr", $request->FgChr)
              // ->where("Fgd.FdNo", $request->FgNo)
              // ->where("Fgd.FdCoCd", $request->company_code)
              ->where("Fgd.FdFgIdNo", $request->FgIdNo)
              ->orderBy("FdSr", "ASC")
              ->get();

      $fg_bag_raw_material_list = DB::connection($this->emrDB)
              ->table("FgRm")
              ->select(DB::raw("FgRm.*, FdBIdNo, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no") )
              ->join("Fgd", "Fgd.FdIdNo", "FgRm.FrFdIdNo")
              ->where("Fgd.FdFgIdNo", $request->FgIdNo)
              ->orderBy("FdBIdNo", "ASC")
              ->get();

        $data['title'] = $title;
        $data['fg_details'] = $fg_details;
        $data['fg_bag_list'] = $fg_bag_list;
        $data['fg_bag_raw_material_list'] = $fg_bag_raw_material_list;
        return view('admin.emporer.fg.fwb_view', $data );
    }
    else {
      $title = "Emporer Finished Goods - Bag Details - $this->emrDBName";
      $fg_details = DB::connection($this->emrDB)
              ->table("Fg")
              ->select(DB::raw("Fg.*, CONCAT(FgTc, '/', FgYy, '/', FgChr, '/', FgNo) voucher_no ") )
              // ->where("Fg.FgTc", $request->FgTc)
              // ->where("Fg.FgYy", $request->FgYy)
              // ->where("Fg.FgChr", $request->FgChr)
              // ->where("Fg.FgNo", $request->FgNo)
              // ->where("Fg.FgCoCd", $request->company_code)
              ->where("Fg.FdBIdNo", $request->FgIdNo)
              ->first();

      $fg_bag_list = DB::connection($this->emrDB)
              ->table("Fgd")
              ->select(DB::raw("Fgd.*, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no, CONCAT(FdPrdOdTc, '/', FdPrdOdYy, '/', FdPrdOdChr, '/', FdPrdOdNo) order_no") )
              // ->where("Fgd.FdTc", $request->FgTc)
              // ->where("Fgd.FdYy", $request->FgYy)
              // ->where("Fgd.FdChr", $request->FgChr)
              // ->where("Fgd.FdNo", $request->FgNo)
              // ->where("Fgd.FdCoCd", $request->company_code)
              ->where("Fgd.FdFgIdNo", $request->FgIdNo)
              ->orderBy("FdSr", "ASC")
              ->get();

        $fg_bag_raw_material_list = DB::connection($this->emrDB)
                ->table("FgRm")
                ->select(DB::raw("FgRm.*, FdBIdNo, CONCAT(FdBYy, '/', FdBChr, '/', FdBNo) bag_no") )
                ->join("Fgd", "Fgd.FdIdNo", "FgRm.FrFdIdNo")
                ->where("Fgd.FdFgIdNo", $request->FgIdNo)
                ->orderBy("FdBIdNo", "ASC")
                ->get();

        $data['title'] = $title;
        $data['fg_details'] = $fg_details;
        $data['fg_bag_list'] = $fg_bag_list;
        $data['fg_bag_raw_material_list'] = $fg_bag_raw_material_list;

        return view('admin.emporer.fg.fwb_view', $data );
    }


      // Helper::LoginIpandTime($request->getClientIp());
      // return view('admin.emporer.transaction.view', $data );
  }


    public function getFgRawMaterial(Request $request){

      $this->check_db($request);

      $fg_bag_raw_material_list = DB::connection($this->emrDB)
              ->table("FgRm")
              ->select(DB::raw("FgRm.*, CONCAT(FrTc, '/', FrYy, '/', FrChr, '/', FrNo) voucher_no") )
              ->where("FgRm.FrFdIdNo", $request->FdIdNo)
              ->orderBy("FrSrNo", "ASC")
              ->get();

      $html_data = "";
      foreach ($fg_bag_raw_material_list as $key => $data) {
        $html_data .= "<tr style='text-align: center;'>
                        <td>$data->FrSrNo</td>
                        <td>$data->FrFrRmLoc</td>
                        <td> " .( ($data->FrFrRmDc == "C") ? "I" : ( ($data->FrFrRmDc == "D") ? "R" : "" ) ) ."</td>
                        <td class='parameter-desc' onclick=\"getParameterDescription('$data->FrRmCtg', 'table', this, 'raw_material_category')\">$data->FrRmCtg</td>
                        <td class='parameter-desc' onclick=\"getParameterDescription('$data->FrRmSCtg', 'table', this, 'raw_material_sub_category', '$data->FrRmCtg')\">$data->FrRmSCtg</td>
                        <td>$data->FrRmCd</td>
                        <td>$data->FrLotNo</td>
                        <td>". round($data->FrRmSz, 4) ."</td>
                        <td>". round($data->FRRMSZ2, 4)  ."</td>
                        <td>". round($data->FRRMSZ3, 4)  ."</td>
                        <td>". round($data->FrRmStkRt, 4)  ."</td>
                        <td>". round($data->FrRmQty, 4)  ."</td>
                        <td>". round($data->FrRmWt, 4)  ."</td>
                        <td class='parameter-desc' onclick=\"getParameterDescription('$data->FrToRmLocTyp', 'table', this, 'location_type')\">$data->FrToRmLocTyp</td>
                        <td>$data->FrToRmLoc</td>
                        <td>$data->ModUsr</td>
                        <td> " .( date('D, d-m-Y', strtotime($data->ModDt) ) . ' ' . $data->ModTime ) ."</td>
                      </tr>";
      }


      return json_encode(["msg"=>"Finish Good Raw Material Data", "status"=>true, "data"=>$fg_bag_raw_material_list , "html_data" => $html_data ]);

    }


    public function finishGoodBmList(Request $request){

      $this->check_db($request);
      $title = "Emporer Finish Good - Bag Movement - $this->emrDBName";

      $query = DB::connection($this->emrDB)
              ->table("Fm")
              ->select(DB::raw("Fm.*, CONCAT(FmTc, '/', FmYy, '/', FmChr, '/', FmNo) voucher_no,
                              (SELECT PDesc FROM Param WHERE PTyp = 'TC' and Param.PMCd = Fm.FmTc) type") );

      if(!empty($request->start_date)){
          $query->whereDate('FmDt', ">=", $request->start_date)
                ->orderBy("FmDt", "ASC");
      }
      else {
        $query->orderBy("FmDt", "DESC");
      }

      if(!empty($request->end_date)){
          $query->whereDate('FmDt', "<=", $request->end_date);
      }

      // if(!empty($request->from_location)){
      //     $query->where('FgFrBLoc', "like", "%".$request->from_location."%");
      // }
      // if(!empty($request->to_location)){
      //     $query->where('FgToBLoc', "like", "%".$request->to_location."%");
      // }
      // if(!empty($request->transaction_type)){
      //     $query->where('FmTc', "like", "%".$request->transaction_type."%");
      // }
      if(!empty($request->voucher_no)){
          $query->whereRaw("CONCAT(FmTc, '/', FmYy, '/', FmChr, '/', FmNo) like '%$request->voucher_no%'");
      }

      if(!empty($request->show)){
        $pagination = $request->show;
      }else{
        $pagination = 20;
      }

      $finish_good_data = $query->paginate($pagination);

      $data['title'] = $title;
      $data['finish_good_data'] = $finish_good_data;

      // Helper::LoginIpandTime($request->getClientIp());
      return view('admin.emporer.fg.bm_list', $data );
    }


    public function finishGoodBmDetails(Request $request){

      $this->check_db($request);
      $title = "Emporer Finish Good - Bag Movement $this->emrDBName";

      $fg_details = DB::connection($this->emrDB)
              ->table("Fm")
              ->select(DB::raw("Fm.*, CONCAT(FmTc, '/', FmYy, '/', FmChr, '/', FmNo) voucher_no ") )
              // ->where("Fm.FmTc", $request->FmTc)
              // ->where("Fm.FmYy", $request->FmYy)
              // ->where("Fm.FmChr", $request->FmChr)
              // ->where("Fm.FmNo", $request->FmNo)
              // ->where("Fm.FmCoCd", $request->company_code)
              ->where("Fm.FmIdNo", $request->FmIdNo)
              ->first();

      $fg_bag_list = DB::connection($this->emrDB)
              ->table("Fmd")
              ->select(DB::raw("Fmd.*, CONCAT(FmdBYy, '/', FmdBChr, '/', FmdBNo) bag_no, Bag.BOdDmCd, Bag.BOdSfx, Bag.BOdDmSz ") )
              ->leftJoin('Bag', function ($join) {
                    $join->on('Bag.BYy', '=', 'Fmd.FmdBYy')
                         // ->where('Bag.BChr', "=", 'Fmd.FmdBChr')
                         // ->where('Bag.BNo', "=", 'Fmd.FmdBNo')
                         // ->where('Bag.BCoCd', "=", 'Fmd.FmdCoCd');
                         ->whereRaw('Bag.BChr = Fmd.FmdBChr')
                         ->whereRaw('Bag.BNo = Fmd.FmdBNo')
                         ->whereRaw('Bag.BCoCd = Fmd.FmdCoCd')
                         ;
                })
              // ->where("Fmd.FmdTc", $request->FmTc)
              // ->where("Fmd.FmdYy", $request->FmYy)
              // ->where("Fmd.FmdChr", $request->FmChr)
              // ->where("Fmd.FmdNo", $request->FmNo)
              // ->where("Fmd.FmdCoCd", $request->company_code)
              ->where("Fmd.FmdFmIdNo", $request->FmIdNo)
              ->orderBy("FmdSr", "ASC")
              ->get();

        $data['title'] = $title;
        $data['fg_details'] = $fg_details;
        $data['fg_bag_list'] = $fg_bag_list;
        return view('admin.emporer.fg.fg_bm_view', $data );


    }




}
