<?php

namespace App\Http\Controllers\Emporer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class ParameterController extends Controller
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
    $title = "Emporer Parameter - $this->emrDBName";

    $query = DB::connection($this->emrDB)
            ->table("Param")
            ->select(DB::Raw("Param.*, ( SELECT p2.PDesc FROM Param AS p2 WHERE p2.PMCd = Param.PTyp and p2.PTyp = 'PTYP' )  parameter_description") )
            ->orderBy("PMCd", "ASC");

    if(!empty($request->type)){
        $query->where('Param.PTyp', $request->type);
    }

    if(!empty($request->category)){
        $query->where('Param.PMCd', $request->category);
    }

    if(!empty($request->sub_category)){
        $query->where('Param.PSCd', $request->sub_category );
    }

    if(!empty($request->description)){
        $query->where('Param.PDesc', "like", "%".$request->description."%");
    }

    if($request->status == 'N'){
        $query->where('Param.PValidYn', 'N');
    }
    elseif($request->status == 'Y'){
        $query->where('Param.PValidYn', '!=', 'N');
    }

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 20;
    }

    $parameter_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['parameter_data'] = $parameter_data;

    return view('admin.emporer.parameter.list', $data );
  }



  public function getEmrParmeters(Request $request)
  {
    $this->check_db($request);

    if($request->type == "emr-design_category" ) {
      $query = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select(DB::raw("PMCd as id, CONCAT(PMCd, ' (', PDesc , ')' ) as text") )
                  // ->select(DB::raw("PMCd as id, PMCd as text") )
                  ->where('PTyp', "DMCTG")
                  ->orderBy('PMCd', "ASC")
                  ->limit(50);

        if(!empty($request->search)){
              // $query->where('PMCd', 'like' , "%". $request->search ."%");
              $query->whereRaw("( PMCd LIKE '%$request->search%' OR  PDesc LIKE '%$request->search%') ");
              // $query->orWhere('PDesc', 'like' , "%". $request->search ."%");
          }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }


    if($request->type == "emr-customer_name" ) {
      $query = DB::connection($this->emrDB)
                  ->table('CustMst')
                  ->select(DB::raw("CmName as id, CmName as text") )
                  ->distinct()
                  ->orderBy('CmName', "ASC")
                  ->limit(200);

      if(!empty($request->search)){
            $query->where('CmName', 'like' , "%". $request->search ."%");
        }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }

    if($request->type == "emr-customer_code" ) {
      $query = DB::connection($this->emrDB)
                  ->table('CustMst')
                  ->select(DB::raw("CmCd as id, CONCAT(CmCd, ' (', CmName , ')' ) as text") )
                  ->distinct()
                  ->orderBy('CmCd', "ASC")
                  ->limit(200);

      if(!empty($request->search)){
            $query->where('CmCd', 'like' , "%". $request->search ."%");
            $query->orWhere('CmName', 'like' , "%". $request->search ."%");
        }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }


    if($request->type == "emr-designer_code" ) {
      $query = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select(DB::raw("PSCd as id, CONCAT(PSCd, ' (', PDesc , ')' ) as text") )
                  ->where('PMCd', "2")
                  ->where('PTyp', "DAANACD")
                  ->orderBy('PMCd', "ASC")
                  ->limit(150);

        if(!empty($request->search)){
              // $query->where('PSCd', 'like' , "%". $request->search ."%");
              // $query->orWhere('PDesc', 'like' , "%". $request->search ."%");
              $query->whereRaw("( PMCd LIKE '%$request->search%' OR  PDesc LIKE '%$request->search%') ");
          }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }

    if($request->type == "emr-parameter_type" ) {
      $query = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select(DB::raw("PMCd as id, CONCAT(PMCd, ' (', PDesc , ')' ) as text") )
                  ->distinct()
                  ->where('PTyp', "PTYP")
                  ->orderBy('PMCd', "ASC")
                  ->limit(50);

        if(!empty($request->search)){
              // $query->where('PMCd', 'like' , "%". $request->search ."%");
              $query->whereRaw("( PMCd LIKE '%$request->search%' OR  PDesc LIKE '%$request->search%') ");
              // $query->orWhere('PDesc', 'like' , "%". $request->search ."%");
          }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }


    if($request->type == "emr-parameter_category" ) {
      $query = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select(DB::raw(" PMCd as id, PMCd as text") )
                  ->distinct()
                  ->orderBy('PMCd', "ASC")
                  ->limit(200);

        if(!empty($request->search)){
              // $query->where('PMCd', 'like' , "%". $request->search ."%");
              // $query->orWhere('PDesc', 'like' , "%". $request->search ."%");
              $query->whereRaw("( PMCd LIKE '%$request->search%' OR  PDesc LIKE '%$request->search%') ");
        }
        if(!empty($request->parameter_type)){
              $query->where('PTyp',  $request->parameter_type );
        }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }

    if($request->type == "emr-parameter_sub_category" ) {
      $query = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select(DB::raw("PSCd as id, PSCd as text") )
                  ->distinct()
                  ->orderBy('PSCd', "ASC")
                  ->limit(200);

      if(!empty($request->search)){
            // $query->where('PSCd', 'like', '%' . $request->search. '%');
            // $query->orWhere('PDesc', 'like' , "%". $request->search ."%");
            $query->whereRaw("( PMCd LIKE '%$request->search%' OR  PDesc LIKE '%$request->search%') ");
      }
      if(!empty($request->parameter_type)){
            $query->where('PTyp',  $request->parameter_type );
      }
      if(!empty($request->category)){
            $query->where('PMCd',  $request->category );
      }

      $results = $query->get();

      return json_encode(["results"=>$results]);
    }

  }


  public function getParameterDescription(Request $request)
  {

    $this->check_db($request);

    if($request->data == "" || $request->data == "-") {
      $this->jsonResponse("Description not found.", false);
    }


    if($request->data_type == "raw_material_category" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PMCd", $request->data)
                  ->where("PTyp", "RMCTG")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description RMCTG is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description RMCTG not found.", false);
      }
    }


    if($request->data_type == "raw_material_sub_category" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", $request->parent_data)
                  ->where("PTyp", "RMSCTG")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description RMSCTG $request->parent_data is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description RMSCTG $request->parent_data not found.", false);
      }
    }


    if($request->data_type == "setting_code" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", "SET")
                  ->where("PTyp", "LABSCD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description LABSCD SET is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description LABSCD SET not found.", false);
      }
    }


    if($request->data_type == "labour_main_code" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PMCd", $request->data)
                  ->where("PTyp", "LABMCD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description LABMCD is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description LABMCD not found.", false);
      }
    }

    if($request->data_type == "labour_sub_code" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", $request->parent_data)
                  ->where("PTyp", "LABSCD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description LABSCD $request->parent_data is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description LABSCD $request->parent_data not found.", false);
      }
    }


    if($request->data_type == "analysis_collection" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", 1)
                  ->where("PTyp", "DAANACD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description DAANACD 1 is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description DAANACD 1 not found.", false);
      }
    }


    if($request->data_type == "analysis_cad" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", 2)
                  ->where("PTyp", "DAANACD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description DAANACD 2 is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description DAANACD 2 not found.", false);
      }
    }


    if($request->data_type == "analysis_cr_app" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->where("PMCd", 3)
                  ->where("PTyp", "DAANACD")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description DAANACD 3 is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description DAANACD 3 not found.", false);
      }
    }

    if($request->data_type == "location_type" ) {
      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PMCd", $request->data)
                  ->where("PTyp", "LOCTYP")
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description LOCTYP is found.", true, $data);
      }
      else {
        $this->jsonResponse("Description LOCTYP  not found.", false);
      }
    }



      $data = DB::connection($this->emrDB)
                  ->table('Param')
                  ->select("PDesc")
                  ->where("PSCd", $request->data)
                  ->orderBy("ModDt", "ASC")
                  ->first();

      if(isset($data->PDesc)) {
        $this->jsonResponse("Description PSCd is found.", true, $data);
      } else {
        $data2 = DB::connection($this->emrDB)
                    ->table('Param')
                    ->select("PDesc")
                    ->where("PMCd", $request->data)
                    ->orderBy("ModDt", "ASC")
                    ->first();
                    if(isset($data2->PDesc)) {
                      $this->jsonResponse("Description PMCd is found.", true, $data2);
                    } else {
                      $this->jsonResponse("Description not found.", false);
                    }
      }
  }



  public function jsonResponse($mgs = "", $status = false, $data = [], $type="")
  {
    echo json_encode(["msg"=>$mgs, "status"=> $status, "data"=>$data, "type"=>$type]);
    die;
  }



}
