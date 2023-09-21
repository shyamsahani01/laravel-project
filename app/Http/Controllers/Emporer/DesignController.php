<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class DesignController extends Controller
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
    $title = "Emporer Design - $this->emrDBName";

    $query = DB::connection($this->emrDB)
            ->table("DsgMst")
            ->select("DsgMst.*");

      if(!empty($request->design_start_date)){
          $query->whereDate('DmDsgDt', ">=", $request->design_start_date)
                ->orderBy("DmDsgDt", "ASC");
      }
      else {
        $query->orderBy("DmDsgDt", "DESC");
      }

      if(!empty($request->design_end_date)){
          $query->whereDate('DmDsgDt', "<=", $request->design_end_date);
      }

      if(!empty($request->order_no)){
          $query->whereRaw("CONCAT(OmTc, '/', OmYy, '/', OmChr, '/', OmNo) like '%$request->order_no%'");
      }

    if(!empty($request->design_code)){
        $query->where('DmCd', "like", "%".$request->design_code."%");
    }
    if(!empty($request->description)){
        $query->where('DmDesc', "like", "%".$request->description."%");
    }
    if(!empty($request->category)){
        $query->where('DmCtg', "like", "%".$request->category."%");
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $design_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['design_data'] = $design_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.emporer.design.list', $data );
  }

  public function designDetails(Request $request){

    $this->check_db($request);
    $title = "Emporer Design Details - $this->emrDBName";

    $design_details = DB::connection($this->emrDB)
            ->table("DsgMst")
            ->select("DsgMst.*")
            ->where("DmCd", $request->design_code)
            ->first();

    $design_bom_details = DB::connection($this->emrDB)
            ->table("DsgRm")
            ->select("DsgRm.*", "RmMst.RmDesc")
            ->where("DrCd", $request->design_code)
            ->leftJoin("RmMst", "RmMst.RmCd", "DsgRm.DrRmCd")
            ->orderBy("DrSr", "ASC")
            ->get();

    $design_lab_details = DB::connection($this->emrDB)
            ->table("DsgLab")
            ->select("DsgLab.*")
            ->where("DlDmIdNo", $design_details->DmIdNo)
            ->orderBy("DlSr", "ASC")
            ->get();

    $design_analysis_details = DB::connection($this->emrDB)
            ->table("DsgAna")
            ->select(DB::Raw("DsgAna.*,
                            (SELECT TOP 1 PDesc FROM Param WHERE PSCd = DsgAna.DaAnaCd ) AS description ") )
            ->where("DaDmIdNo", $design_details->DmIdNo)
            ->orderBy("DaAnaSr", "ASC")
            ->get();


      $data['title'] = $title;
      $data['design_details'] = $design_details;
      $data['design_bom_details'] = $design_bom_details;
      $data['design_lab_details'] = $design_lab_details;
      $data['design_analysis_details'] = $design_analysis_details;

      // Helper::LoginIpandTime($request->getClientIp());
      return view('admin.emporer.design.view', $data );
  }




}
