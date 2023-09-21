<?php

namespace App\Http\Controllers\Jade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helper;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;

class JadePowerBiController extends Controller
{

  public function __construct(Type $foo = null)
  {
    // $this->erpnextDB = DB::connection('erpnext');
  }

  public function list(Request $request){

    $title = 'Jade Power Bi Report';

    $query = DB::connection("localdesign")
            ->table("jade_power_bi_report")
            ->orderBy("id", "DESC");

    if(!empty($request->show)){
      $pagination = $request->show;
    }else{
      $pagination = 2000;
    }

    $jade_report_data = $query->paginate($pagination);

    $data['title'] = $title;
    $data['jade_report_data'] = $jade_report_data;

    // Helper::LoginIpandTime($request->getClientIp());
    return view('admin.jade.powerBI.list', $data );
  }

  public function add(Request $request){

    $title = 'Add Power Bi Report';

    $query = DB::connection("localdesign")
            ->table("jade_power_bi_report")
            ->where("id", $request->id);

    $report_data = $query->first();

    $data['report_data'] = $report_data;

    $data['title'] = $title;

    return view('admin.jade.powerBI.add', $data );
  }


  public function add_data(Request $request){

    if (
        $request->validate([
            "report_name" => "required|string",
            "report_url" => "required|url",
            ])
    ) {
        $data = [];

        $data["report_name"] = $request->report_name;
        $data["report_url"] = $request->report_url;

      if($request->id == 0) {
            $data["created_at"] = date('Y-m-d h:i:s', time());
            $data["created_by"] = auth()->user()->email;
            $query = DB::connection("localdesign")
                        ->table("jade_power_bi_report")
                        ->insertGetId($data);
            $insert_id = $query;
            $msg = "Report successfully added";

        } else {
            $data["updated_at"] = date('Y-m-d h:i:s', time());
            $data["updated_by"] = auth()->user()->email;
            $query = DB::connection("localdesign")
                        ->table("jade_power_bi_report")
                        ->where('id',$request->id)
                        ->update($data);
            $insert_id = $request->id;
            $msg = "Report successfully updated";
        }


        if ($insert_id) {
            $this->jsonResponse($msg, true, $insert_id);
        } else {
            $this->jsonResponse("Report not updated.", false);
        }
    } else {
        $this->jsonResponse("Validation Error.", false);

    }
  }

  public function delete(Request $request)
  {

      $query = DB::connection("localdesign")
              ->table("jade_power_bi_report")
              ->where('id',$request->id)
              ->delete();

      // $this->jsonResponse("Report successfully deleted.", true, $request->id);

      Session::flash('message', 'Report successfully deleted.');
      Session::flash('alert-class', 'alert-success');
      return redirect("/jadePowerBiReport/list");

  }

  public function jsonResponse($msg = "", $status = false, $data = [])
  {
      echo json_encode(["msg"=>$msg, "status"=> $status, "data"=>$data]);
  }
}
